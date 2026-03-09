<?php

namespace ImageOptimization\Modules\Core\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Conflicts {
	private array $conflicting_plugins;

	private const CONFLICTING_PLUGINS = [
		'imagify/imagify.php' => 'Imagify',
		'optimole-wp/optimole-wp.php' => 'Image optimization service by Optimole',
		'ewww-image-optimizer/ewww-image-optimizer.php' => 'EWWW Image Optimizer',
		'ewww-image-optimizer-cloud/ewww-image-optimizer-cloud.php' => 'EWWW Image Optimizer Cloud',
		'kraken-image-optimizer/kraken.php' => 'Kraken Image Optimizer',
		'shortpixel-image-optimiser/wp-shortpixel.php' => 'ShortPixel Image Optimizer',
		'wp-smushit/wp-smush.php' => 'Smush',
		'wp-smush-pro/wp-smush.php' => 'Smush PRO',
		'tiny-compress-images/tiny-compress-images.php' => 'TinyPNG - JPEG, PNG & WebP image compression',
	];

	public function render_notice(): void {
		$conflicting_plugins_names = $this->conflicting_plugins;

		?>
		<div class="notice notice-warning image-optimizer__notice image-optimizer__notice--warning">
			<p>
				<b>
					<?php esc_html_e(
						'Image optimizer has detected multiple active image optimization plugins.',
						'image-optimization'
					); ?>
				</b>

				<span>
					<?php esc_html_e(
						'Having more than one may result in unexpected results.',
						'image-optimization'
					); ?>
				</span>
			</p>

			<form action="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" method="post" style="margin:0.5em 0;padding:2px">
				<span style="margin-inline-end: 8px;"><?php echo esc_html( join( ', ', $conflicting_plugins_names ) ); ?></span>

				<input type="hidden" name="action" value="deactivate-selected">

				<?php foreach ( array_keys( $this->conflicting_plugins ) as $plugin ) { ?>
					<input type="hidden" name="checked[]" value="<?php echo esc_attr( $plugin ); ?>">
				<?php } ?>

				<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'bulk-plugins' ) ); ?>">

				<input type="submit"
							style="border:none;background-color:transparent;text-decoration:underline;cursor:pointer;font-size:13px;color:#135e96;"
							value="<?php esc_html_e( 'Deactivate All', 'image-optimization' ); ?>">
			</form>
		</div>
		<?php
	}

	public function get_conflicting_plugins(): array {
		$plugins = get_option( 'active_plugins' );
		$conflicting_plugins_file_names = array_keys( self::CONFLICTING_PLUGINS );
		$output = [];

		foreach ( $plugins as $plugin_file_name ) {
			if ( in_array( $plugin_file_name, $conflicting_plugins_file_names, true ) ) {
				$output[ $plugin_file_name ] = self::CONFLICTING_PLUGINS[ $plugin_file_name ];
			}
		}

		return $output;
	}

	public function __construct() {
		$this->conflicting_plugins = $this->get_conflicting_plugins();

		if ( ! empty( $this->conflicting_plugins ) ) {
			add_action( 'admin_notices', [ $this, 'render_notice' ] );
		}
	}
}
