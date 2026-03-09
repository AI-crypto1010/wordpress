<?php ! defined( 'ABSPATH' ) AND exit;

/**
 * WP_SCSS_Compiler
 *
 * Class providing integration between WordPress and PHP SCSS Compiler by @leafo
 *
 * @author Roman Nazarkin <roman@nazarkin.su>
 * @uses PixScssPhp\ScssPhp
 * @license GNU GPLv3
 */

// load required class
require_once __DIR__ . '/scssphp/scss.inc.php';

// add on init to support theme customizer in v3.4
add_action( 'init', array( 'WP_SCSS_Compiler', 'instance' ) );

class WP_SCSS_Compiler {

	/**
	 * @static
	 * @var    \WP_SCSS_Compiler Reusable object instance.
	 */
	protected static $instance = null;


	/**
	 * Constructor
	 */
	public function __construct() {
		// every CSS file URL gets passed through this filter
		// add_filter( 'style_loader_src', array( $this, 'parse_stylesheet' ), 100000, 2 );

		// editor stylesheet URLs are concatenated and run through this filter
		add_filter( 'mce_css', array( $this, 'parse_editor_stylesheets' ), 100000 );
	}


	/**
	 * Creates a new instance. Called on 'after_setup_theme'.
	 * May be used to access class methods from outside.
	 *
	 * @see    __construct()
	 * @static
	 * @return \WP_SCSS_Compiler
	 */
	public static function instance() {
		null === self:: $instance AND self:: $instance = new self;

		return self:: $instance;
	}


	/**
	 * Compile editor stylesheets registered via add_editor_style()
	 *
	 * @param  string $mce_css Comma separated list of CSS file URLs
	 *
	 * @return string $mce_css New comma separated list of CSS file URLs
	 */
	public function parse_editor_stylesheets( $mce_css ) {

		// extract CSS file URLs
		$style_sheets = explode( ',', $mce_css );

		if ( count( $style_sheets ) ) {
			$compiled_css = array();

			// loop through editor styles, any .less files will be compiled and the compiled URL returned
			foreach ( $style_sheets as $style_sheet ) {
				$compiled_css[] = $this->parse_stylesheet( $style_sheet, $this->url_to_handle( $style_sheet ) );
			}

			$mce_css = implode( ',', $compiled_css );
		}

		// return new URLs
		return $mce_css;
	}


	/**
	 * Compile the SCSS stylesheet and return the href of the compiled file
	 *
	 * @param  string $src    Source URL of the file to be parsed
	 * @param  string $handle An identifier for the file used to create the file name in the cache
	 *
	 * @return string         URL of the compiled stylesheet
	 */
	public function parse_stylesheet( $src, $handle ) {

			// skip non-scss files
			if ( ! preg_match( '/\.scss(\.php)?$/', preg_replace( '/\?.*$/', '', $src ) ) ) {
				return $src;
			}

			// skip compilation if special header are sent
			$headers = getallheaders();
			if ( defined( 'WPH_DEV_ENV' ) && isset( $headers['X-Skip-SCSS-Recompilation'] ) ) {
				return $src;
			}

			// match the URL schemes between WP_CONTENT_URL and $src,
			// so the str_replace further down will work
			$src_scheme            = parse_url( $src, PHP_URL_SCHEME );
			$wp_content_url_scheme = parse_url( WP_CONTENT_URL, PHP_URL_SCHEME );
			if ( $src_scheme != $wp_content_url_scheme ) {
				$src = set_url_scheme( $src, $wp_content_url_scheme );
			}

			// get file path from $src
			// prevent non-existent index warning when using list() & explode()
			if ( ! strstr( $src, '?' ) ) {
				$scss_path    = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $src );
				$query_string = '';
			} else {
				list( $scss_path, $query_string ) = explode( '?', str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $src ) );
				$query_string = '?' . $query_string;
			}

			// start working
			try {
				$output_path = $this->get_output_path( $handle );
				$scss        = new PixScssPhp\ScssPhp\Compiler();
				$scss->setVariables( apply_filters( 'pix_wp_scss_variables', array(), $handle ) );
				$scss->setImportPaths( apply_filters( 'wp_scss_import_dirs', array( dirname( $scss_path ) ), $handle ) );
				$scss->setFormatter( apply_filters( 'wp_scss_formatter', 'PixScssPhp\ScssPhp\Formatter\Compressed', $handle ) );

				// allow devs to mess around with the scss object configuration
				do_action_ref_array( 'wp_scss_instance', array( &$scss, $handle ) );

				// check if file should be compiled again
				if ( $this->should_be_recompiled( $output_path, $scss, $last_change ) ) {
					$this->compile_file( $scss_path, $output_path, $scss );
					$last_change = time();
				}

			} catch ( Exception $e ) {
				update_option('pixfort_theme_options_notice', $e->getMessage());
				// wp_die( $e->getMessage() );
			}

			// build final url and restore original url scheme
			$output_url = set_url_scheme( $this->get_output_url( $handle ), $src_scheme ) . $query_string;

			// finally add query arg with time of latest change of file
			return add_query_arg( 'ver', $last_change, $output_url );
		}


	/**
	 * Creates cache directory(if non-exists) and provides path for specified handle
	 *
	 * @param $handle
	 *
	 * @return string
	 */
	private function get_output_path( $handle ) {
		$upload_dir = wp_upload_dir();
		$dir        = apply_filters( 'wp_scss_cache_path', path_join( $upload_dir['basedir'], 'wp-scss-cache' ) );

		if ( ! is_dir( $dir ) ) {
			@wp_mkdir_p( $dir );
		}

		if ( ! is_readable( $dir ) || ! is_writable( $dir ) ) {
			@chmod( $dir, 0755 );
		}

		$handle_filename = sanitize_key( basename( $handle ) ) . '.css';

		return path_join( $dir, $handle_filename );
	}


	/**
	 * Returns URL of an cached file of a specified handle
	 *
	 * @param $handle
	 *
	 * @return string
	 */
	private function get_output_url( $handle ) {
		$upload_dir      = wp_upload_dir();
		$dir             = apply_filters( 'wp_scss_cache_url', path_join( $upload_dir['baseurl'], 'wp-scss-cache' ) );
		$handle_filename = sanitize_key( basename( $handle ) ) . '.css';

		return path_join( $dir, $handle_filename );
	}


	/**
	 * Check whether provided file should be recompiled
	 *
	 * @param $output_path string destination file
	 * @param $scss        PixScssPhp\ScssPhp\Compiler the instance of an compiler
	 *
	 * @return bool
	 */
	private function should_be_recompiled( $output_path, &$scss, &$last_change ) {

		$cache_data = $this->get_cache_data( $output_path );

		// should be compiled if no data exists for this file
		if ( ! is_file( $output_path ) || $cache_data === false ) {
			return true;
		}

		// should be recompiled if some of processed files are changed
		$mtime = filemtime( $output_path );
		foreach ( $cache_data['imports'] as $import => $originalMtime ) {
			$currentMtime = filemtime( $import );
			if ( $currentMtime !== $originalMtime || $currentMtime > $mtime ) {
				return true;
			}
		}

		// should be recompiled if instance was changed (for example, variables was updated)
		$instance_crc = crc32( serialize( $scss ) );
		if ( $instance_crc !== $cache_data['instance'] ) {
			return true;
		}

		$last_change = $cache_data['creation_time'];

		return false;
	}


	/**
	 * Compiles file and saves its data to cache
	 *
	 * @param $scss_path   string source path
	 * @param $output_path string destination path
	 * @param $scss        PixScssPhp\ScssPhp\Compiler instance
	 */
	private function compile_file( $scss_path, $output_path, &$scss ) {
		$instance_dump = crc32( serialize( $scss ) );

		$start   = microtime( true );
		$relative_path = $this->get_relative_scss_path( $scss_path );
		$content = pixGetFileContents( $relative_path );
		$css     = $scss->compile( $content, $scss_path );
		$elapsed = round( ( microtime( true ) - $start ), 4 );

		$v   = PixScssPhp\ScssPhp\Version::VERSION;
		$t   = date( 'r' );
		$css = "/* compiled by wp scssphp $v on $t ({$elapsed}s) */\n\n" . $css;

		// if ( ! defined( 'FS_METHOD' ) ) define( 'FS_METHOD', 'direct' );
		//
		// global $wp_filesystem;
		// $wp_filesystem->put_contents( $output_path, $css );
		file_put_contents( $output_path, $css );
		$this->save_cache_data( $output_path,
			array(
				'creation_time' => time(),
				'imports'       => $scss->getParsedFiles(),
				'instance'      => $instance_dump
			) );
	}

	/**
	 * Build plugin-relative path from an absolute SCSS path.
	 *
	 * @param string $scss_path Absolute source path.
	 *
	 * @return string
	 */
	private function get_relative_scss_path( $scss_path ) {
		$normalized_scss_path = $this->normalize_filesystem_path( $scss_path );
		$real_scss_path       = realpath( $scss_path );
		if ( $real_scss_path !== false ) {
			$normalized_scss_path = $this->normalize_filesystem_path( $real_scss_path );
		}

		$plugin_base_path = $this->normalize_filesystem_path( PIXFORT_PLUGIN_DIR );
		$real_plugin_base = realpath( PIXFORT_PLUGIN_DIR );
		if ( $real_plugin_base !== false ) {
			$plugin_base_path = $this->normalize_filesystem_path( $real_plugin_base );
		}

		if ( $plugin_base_path !== '' && strpos( $normalized_scss_path, $plugin_base_path . '/' ) === 0 ) {
			return ltrim( substr( $normalized_scss_path, strlen( $plugin_base_path ) ), '/' );
		}

		// Fallback for symlinked installs where prefixes differ but plugin segment is stable.
		$plugin_slug = basename( rtrim( PIXFORT_PLUGIN_DIR, '/\\' ) );
		$marker      = '/plugins/' . $plugin_slug . '/';
		$marker_pos  = strpos( $normalized_scss_path, $marker );
		if ( $marker_pos !== false ) {
			return ltrim( substr( $normalized_scss_path, $marker_pos + strlen( $marker ) ), '/' );
		}

		// Last resort keeps behaviour deterministic without absolute path leakage.
		return ltrim( basename( $normalized_scss_path ), '/' );
	}

	/**
	 * Normalize file system paths for consistent comparison.
	 *
	 * @param string $path Any path.
	 *
	 * @return string
	 */
	private function normalize_filesystem_path( $path ) {
		if ( ! is_string( $path ) || $path === '' ) {
			return '';
		}

		$path = str_replace( '\\', '/', $path );
		$path = preg_replace( '#/+#', '/', $path );

		return rtrim( $path, '/' );
	}


	/**
	 * Retrieves parsed cache data for specified file
	 *
	 * @param $path
	 *
	 * @return bool|mixed
	 */
	private function get_cache_data( $path ) {
		$caches = get_option( 'wp_scss_cached_files', array() );
		$key    = crc32( $path );

		return ( isset( $caches[ $key ] ) ) ? $caches[ $key ] : false;
	}


	/**
	 * Update parsed cache data for specified file
	 *
	 * @param $path
	 * @param $data
	 *
	 * @return bool
	 */
	private function save_cache_data( $path, $data ) {
		$caches         = get_option( 'wp_scss_cached_files', array() );
		$key            = crc32( $path );
		$caches[ $key ] = $data;

		return update_option( 'wp_scss_cached_files', $caches );
	}


	/**
	 * Get a nice handle to use for the compiled CSS file name
	 *
	 * @param  string $url File URL to generate a handle from
	 *
	 * @return string $url Sanitized string to use for handle
	 */
	private function url_to_handle( $url ) {

		$url = parse_url( $url );
		$url = str_replace( '.scss', '', basename( $url['path'] ) );
		$url = str_replace( '/', '-', $url );

		return sanitize_key( $url );
	}
}
