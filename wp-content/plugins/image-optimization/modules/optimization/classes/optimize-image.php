<?php

namespace ImageOptimization\Modules\Optimization\Classes;

use ImageOptimization\Classes\File_System\{
	Exceptions\File_System_Operation_Error,
	File_System,
};
use ImageOptimization\Classes\File_Utils;
use ImageOptimization\Classes\Image\{
	Exceptions\Image_Backup_Creation_Error,
	Exceptions\Invalid_Image_Exception,
	Image,
	Image_Backup,
	Image_Conversion,
	Image_DB_Update,
	Image_Dimensions,
	Image_Meta,
	Image_Status,
	WP_Image_Meta
};
use ImageOptimization\Classes\Logger;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Classes\Exceptions\Quota_Exceeded_Error;
use ImageOptimization\Modules\Optimization\Classes\{
	Exceptions\Image_File_Already_Exists_Error,
	Exceptions\Image_Optimization_Error,
	Exceptions\Bulk_Token_Expired_Error,
	Exceptions\Image_Already_Optimized_Error,
};
use ImageOptimization\Modules\Connect\Classes\Exceptions\Connection_Error;
use ImageOptimization\Modules\Settings\Classes\Settings;
use Throwable;

use ImageOptimization\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The class is responsible for the optimization logic itself. It gets an image file, runs
 * backup process if needed, sends a file to the service, stores the result and updates image meta.
 *
 * This class is used by manual, bulk and on-upload optimization flows.
 */
class Optimize_Image {
	public const IMAGE_OPTIMIZE_ENDPOINT = 'image/optimize';

	protected ?Image $image;
	protected WP_Image_Meta $wp_meta;
	protected string $initiator;
	protected ?string $bulk_token;
	private string $current_image_path;
	private string $current_image_size;
	private bool $keep_backups;
	private array $current_size_duplicates;
	protected Image_Conversion $image_conversion;
	private bool $is_reoptimize;

	/**
	 * @throws Quota_Exceeded_Error|Connection_Error|Bulk_Token_Expired_Error|Image_File_Already_Exists_Error|Image_Optimization_Error
	 */
	public function optimize(): void {
		$sizes_enabled = Settings::get( Settings::CUSTOM_SIZES_OPTION_NAME );
		$sizes_exist = $this->wp_meta->get_size_keys();

		Logger::debug( "Start optimization of {$this->image->get_id()}" );

		foreach ( $sizes_exist as $size_exist ) {
			// If some image sizes optimization is disabled in settings, we check if the current one is still enabled
			if (
				'all' !== $sizes_enabled &&
				Image::SIZE_FULL !== $size_exist &&
				! in_array( $size_exist, $sizes_enabled, true )
			) {
				continue;
			}

			// Elementor editor generates thumbnails we don't need to optimize.
			if ( str_starts_with( $size_exist, 'elementor_' ) ) {
				continue;
			}

			$image_meta = new Image_Meta( $this->image->get_id() );

			// If the current size was already optimized -- ignore it.
			if ( ! $this->is_reoptimize && in_array( $size_exist, $image_meta->get_optimized_sizes(), true ) ) {
				Logger::debug( "Size `$size_exist` is already optimized" );

				continue;
			}

			if ( ! file_exists( $this->image->get_file_path( $size_exist ) ) ) {
				Logger::debug( "Can't access file for size `$size_exist`" );

				continue;
			}

			$this->current_image_size = $size_exist;
			$this->current_size_duplicates = $this->wp_meta->get_size_duplicates( $size_exist );
			$this->current_image_path = $this->image->get_file_path( $size_exist );

			$this->optimize_current_size();

			$this->current_image_size = '';
			$this->current_size_duplicates = [];
			$this->current_image_path = '';
		}

		$this->mark_as_optimized();

		if ( ! $this->keep_backups ) {
			Image_Backup::remove( $this->image->get_id() );
		}

		Logger::debug( "End optimization of {$this->image->get_id()}" );
	}

	private function optimize_current_size(): void {
		try {
			$original_path = $this->current_image_path;
			$response = $this->send_file();

			$optimized_size = (int) $response->optimizedSize; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$optimized_image_binary = base64_decode( $response->image, true ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode

			$this->replace_image_file( $optimized_image_binary );
			$this->update_attachment_meta( $optimized_size );

			if ( $original_path !== $this->current_image_path ) {
				$this->update_posts( $original_path, $this->current_image_path );
			}

			// This should only be updated after meta
			$this->update_attachment_post();
		} catch ( Image_Already_Optimized_Error $iao ) {
			// If we can't optimize it further, just update the meta
			$original_size = $this->wp_meta->get_file_size( $this->current_image_size )
				?? File_System::size( $this->image->get_file_path( $this->current_image_size ) );

			$this->update_attachment_meta( $original_size, true );
			$this->update_attachment_post( true );
		} catch ( Bulk_Token_Expired_Error | Quota_Exceeded_Error | Connection_Error | Image_File_Already_Exists_Error $e ) {
			throw $e;
		} catch ( Throwable $t ) {
			// In case of anything else
			throw new Image_Optimization_Error( esc_html( $t->getMessage() ) );
		}
	}

	private function send_file() {
		$connect_status = Plugin::instance()->modules_manager->get_modules( 'connect-manager' )->connect_instance->get_connect_status();
		$headers = [
			'access_token' => $connect_status->access_token ?? '',
		];

		if ( $this->bulk_token ) {
			$headers['x-elementor-bulk-token'] = $this->bulk_token;
		}

		$optimization_options = [
			'compression_level' => Settings::get( Settings::COMPRESSION_LEVEL_OPTION_NAME ),
			'convert_to_format' => $this->image_conversion->get_current_conversion_option(),
			'strip_exif' => Settings::get( Settings::STRIP_EXIF_METADATA_OPTION_NAME ),
		];

		if ( Settings::get( Settings::RESIZE_LARGER_IMAGES_OPTION_NAME ) ) {
			$optimization_options['resize'] = Settings::get( Settings::RESIZE_LARGER_IMAGES_SIZE_OPTION_NAME );
		}

		$image_key = wp_generate_password( 15, false );

		$response = Utils::get_api_client()->make_request(
			'POST',
			self::IMAGE_OPTIMIZE_ENDPOINT,
			[
				'initiator' => $this->initiator,
				'image_url' => $this->image->get_url( $this->current_image_size ),
				'image_key' => $image_key,
				'checksum' => md5_file( $this->current_image_path ),
				'attachment_id' => $this->image->get_id(),
				'attachment_parent_id' => Image::SIZE_FULL === $this->current_image_size ? 0 : $this->image->get_id(),
				'image_optimization_settings' => base64_encode( wp_json_encode( $optimization_options ) ), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
			],
			$headers,
			$this->current_image_path,
			'image'
		);

		if ( isset( $response->stats ) ) {
			Plugin::instance()->modules_manager->get_modules( 'connect-manager' )->connect_instance->update_usage_data( $response->stats );
		}

		if ( ! isset( $response->imageKey ) || $image_key !== $response->imageKey ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			Logger::error( "Image key must be $image_key, instead got $response->imageKey" );

			throw new Image_Optimization_Error( esc_html__( 'Service response is incorrect', 'image-optimization' ) );
		}

		$received_file_hash = md5( base64_decode( $response->image, true ) );

		if ( ! isset( $response->checksum ) || $received_file_hash !== $response->checksum ) {
			Logger::error( "Image key must be $response->checksum, instead calculated $received_file_hash" );

			throw new Image_Optimization_Error( esc_html__( 'Service response is incorrect', 'image-optimization' ) );
		}

		return $response;
	}

	/**
	 * @throws File_System_Operation_Error|Image_Backup_Creation_Error|Image_File_Already_Exists_Error
	 */
	private function replace_image_file( string $file_data ): void {
		$path = $this->current_image_path;

		// If we have backups disabled, we want to make sure we can download and save new file before we
		// remove an existing one.
		$tmp_path = File_Utils::replace_extension( $path, 'tmp' );

		File_System::put_contents( $tmp_path, $file_data );

		if ( $this->image_conversion->is_enabled() ) {
			$converted_path = File_Utils::replace_extension( $tmp_path, $this->image_conversion->get_current_file_extension() );
			$original_is_already_converted = strtolower( $path ) === strtolower( $converted_path );

			if ( ! $original_is_already_converted && File_System::exists( $converted_path ) ) {
				throw new Image_File_Already_Exists_Error();
			}

			// We want to keep both original as a fallback and optimized webp to prevent 404s
			if ( ! $original_is_already_converted ) {
				$this->keep_backups = true;

				( new Image_Meta( $this->image->get_id() ) )
					->set_image_backup_path( $this->current_image_size, $this->current_image_path )
					->save();
			}

			if ( $original_is_already_converted ) {
				Image_Backup::create( $this->image->get_id(), $this->current_image_size, $this->current_image_path );
			}

			File_System::move( $tmp_path, $converted_path, true );

			$path = $converted_path;
		} else {
			Image_Backup::create( $this->image->get_id(), $this->current_image_size, $this->current_image_path );

			File_System::move( $tmp_path, $path, true );
		}

		if ( Image::SIZE_FULL === $this->current_image_size ) {
			// Drop WP caches
			update_attached_file( $this->image->get_id(), $path );
		}

		// Updating to the correct value
		$this->current_image_path = $path;
	}

	/**
	 * Updates attachment records in the `wp_posts` table.
	 *
	 * @return void
	 */
	private function update_attachment_post( ?bool $is_fully_optimized = false ) {
		$update_query = [];

		if ( $this->image_conversion->is_enabled() && ! $is_fully_optimized ) {
			$attachment_object = $this->image->get_attachment_object();

			$update_query['guid'] = File_Utils::replace_extension(
				$attachment_object->guid,
				$this->image_conversion->get_current_file_extension()
			);

			$update_query['post_mime_type'] = $this->image_conversion->get_current_mime_type();
		}

		$update_query['post_modified'] = current_time( 'mysql' );
		$update_query['post_modified_gmt'] = current_time( 'mysql', true );

		$this->image->update_attachment( $update_query );
	}

	/**
	 * Updates attachment records in the `wp_postmeta` table.
	 *
	 * @param int $optimized_size
	 * @param bool|null $is_fully_optimized
	 *
	 * @return void
	 */
	private function update_attachment_meta( int $optimized_size, ?bool $is_fully_optimized = false ) {
		$meta = new Image_Meta( $this->image->get_id() );
		$dimensions = Image_Dimensions::get_by_path( $this->current_image_path );

		$sizes_to_update = [ $this->current_image_size, ...$this->current_size_duplicates ];

		foreach ( $sizes_to_update as $size ) {
			$meta
				->set_compression_level( Settings::get( Settings::COMPRESSION_LEVEL_OPTION_NAME ) )
				->add_optimized_size( $size )
				->add_original_data( $size, $this->wp_meta->get_size_data( $size ) );

			$this->wp_meta
				->set_width( $size, $dimensions->width )
				->set_height( $size, $dimensions->height )
				->set_file_size( $size, $optimized_size );

			if ( $this->image_conversion->is_enabled() && ! $is_fully_optimized ) {
				$this->wp_meta
					->set_file_path( $size, $this->current_image_path )
					->set_mime_type( $size, $this->image_conversion->get_current_mime_type() );
			}
		}

		$meta->save();
		$this->wp_meta->save();
	}

	/**
	 * If we change an image extension, we should walk through the wp_posts table and update all the
	 * hardcoded image links to prevent 404s.
	 *
	 * @param string $old_path Previous image path
	 * @param string $new_path Current image path
	 *
	 * @return void
	 */
	private function update_posts( string $old_path, string $new_path ) {
		Image_DB_Update::update_posts_table_urls(
			File_Utils::get_url_from_path( $old_path ),
			File_Utils::get_url_from_path( $new_path )
		);
	}

	/**
	 * Changes image status after all image sizes were optimized.
	 *
	 * @return void
	 */
	private function mark_as_optimized() {
		( new Image_Meta( $this->image->get_id() ) )
			->set_status( Image_Status::OPTIMIZED )
			->set_error_type( null )
			->save();
	}

	/**
	 * @throws Invalid_Image_Exception
	 */
	public function __construct( int $image_id, string $initiator, ?string $bulk_token = null, ?bool $is_reoptimize = false ) {
		$this->image = new Image( $image_id );
		$this->wp_meta = new WP_Image_Meta( $image_id, $this->image );
		$this->initiator = $initiator;
		$this->bulk_token = $bulk_token;
		$this->is_reoptimize = $is_reoptimize;
		$this->image_conversion = new Image_Conversion();
		$this->keep_backups = Settings::get( Settings::BACKUP_ORIGINAL_IMAGES_OPTION_NAME );
	}
}
