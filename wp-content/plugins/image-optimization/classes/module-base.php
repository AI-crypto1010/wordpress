<?php

namespace ImageOptimization\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Module Base.
 *
 * An abstract class providing the properties and methods needed to
 * manage and handle modules in inheriting classes.
 *
 * @abstract
 */
abstract class Module_Base {

	/**
	 * Module class reflection.
	 *
	 * Holds the information about a class.
	 * @access private
	 *
	 * @var \ReflectionClass
	 */
	private $reflection = null;

	/**
	 * Module routes.
	 *
	 * Holds the module registered routes.
	 * @access public
	 *
	 * @var array
	 */
	public $routes = [];

	/**
	 * Module components.
	 *
	 * Holds the module components.
	 * @access private
	 *
	 * @var array
	 */
	private $components = [];

	/**
	 * Module instance.
	 *
	 * Holds the module instance.
	 * @access protected
	 *
	 * @var Module_Base[]
	 */
	protected static $_instances = [];

	/**
	 * Get module name.
	 *
	 * Retrieve the module name.
	 * @access public
	 * @abstract
	 *
	 * @return string Module name.
	 */
	abstract public function get_name();

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the module class is loaded or can be loaded.
	 * @access public
	 * @static
	 *
	 * @return Module_Base An instance of the class.
	 */
	public static function instance() {
		$class_name = static::class_name();

		if ( empty( static::$_instances[ $class_name ] ) ) {
			static::$_instances[ $class_name ] = new static(); // @codeCoverageIgnore
		}

		return static::$_instances[ $class_name ];
	}

	/**
	 * is_active
	 * @access public
	 * @static
	 * @return bool
	 */
	public static function is_active() {
		return true;
	}

	/**
	 * Class name.
	 *
	 * Retrieve the name of the class.
	 * @access public
	 * @static
	 */
	public static function class_name() {
		return get_called_class();
	}

	/**
	 * Clone.
	 *
	 * Disable class cloning and throw an error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object. Therefore, we don't want the object to be cloned.
	 *
	 * @access public
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'image-optimization' ), '1.0.0' ); // @codeCoverageIgnore
	}

	/**
	 * Wakeup.
	 *
	 * Disable unserializing of the class.
	 * @access public
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'image-optimization' ), '1.0.0' ); // @codeCoverageIgnore
	}

	/**
	 * @access public
	 */
	public function get_reflection() {
		if ( null === $this->reflection ) {
			try {
				$this->reflection = new \ReflectionClass( $this );
			} catch ( \ReflectionException $e ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( $e->getMessage() );
				}
			}
		}

		return $this->reflection;
	}

	/**
	 * Add module component.
	 *
	 * Add new component to the current module.
	 * @access public
	 *
	 * @param string $id       Component ID.
	 * @param mixed  $instance An instance of the component.
	 */
	public function add_component( string $id, $instance ) {
		$this->components[ $id ] = $instance;
	}

	/**
	 * Add module route.
	 *
	 * Add new route to the current module.
	 * @access public
	 *
	 * @param string $id       Route ID.
	 * @param mixed  $instance An instance of the route.
	 */
	public function add_route( string $id, $instance ) {
		$this->routes[ $id ] = $instance;
	}

	/**
	 * @access public
	 * @return string[]
	 */
	public function get_components(): array {
		return $this->components;
	}

	/**
	 * Get module component.
	 *
	 * Retrieve the module component.
	 * @access public
	 *
	 * @param string $id Component ID.
	 *
	 * @return mixed An instance of the component, or `false` if the component
	 *               doesn't exist.
	 * @codeCoverageIgnore
	 */
	public function get_component( string $id ) {
		if ( isset( $this->components[ $id ] ) ) {
			return $this->components[ $id ];
		}

		return false;
	}

	/**
	 * Retrieve the namespace of the class
	 *
	 * @access public
	 * @static
	 */
	public static function namespace_name() {
		$class_name = static::class_name();
		return substr( $class_name, 0, strrpos( $class_name, '\\' ) );
	}


	/**
	 * Get assets url.
	 *
	 * @param string $file_name
	 * @param string $file_extension
	 * @param string $relative_url Optional. Default is null.
	 *
	 * @return string
	 */
	final protected function get_assets_url( $file_name, $file_extension, $relative_url = null ): string {
		static $is_test_mode = null;

		if ( null === $is_test_mode ) {
			$is_test_mode = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
		}

		if ( ! $relative_url ) {
			$relative_url = $this->get_assets_relative_url();
		}

		$url = $this->get_assets_base_url() . $relative_url . $file_name;

		return $url . '.' . $file_extension;
	}

	/**
	 * Get js assets url
	 *
	 * @param string $file_name
	 * @param string $relative_url Optional. Default is null.
	 * @param string $add_min_suffix Optional. Default is 'default'.
	 *
	 * @return string
	 */
	final protected function get_js_assets_url( $file_name, $relative_url = null, $add_min_suffix = 'default' ): string {
		return $this->get_assets_url( $file_name, 'js', $relative_url, $add_min_suffix );
	}

	/**
	 * Get css assets url
	 *
	 * @param string $file_name
	 * @param string $relative_url         Optional. Default is null.
	 * @param string $add_min_suffix       Optional. Default is 'default'.
	 * @param bool   $add_direction_suffix Optional. Default is `false`
	 *
	 * @return string
	 */
	final protected function get_css_assets_url( $file_name, $relative_url = null, $add_min_suffix = 'default', $add_direction_suffix = false ): string {
		static $direction_suffix = null;

		if ( ! $direction_suffix ) {
			$direction_suffix = is_rtl() ? '-rtl' : '';
		}

		if ( $add_direction_suffix ) {
			$file_name .= $direction_suffix;
		}

		return $this->get_assets_url( $file_name, 'css', $relative_url, $add_min_suffix );
	}

	/**
	 * Get assets base url
	 *
	 * @return string
	 */
	protected function get_assets_base_url(): string {
		return IMAGE_OPTIMIZATION_URL;
	}

	/**
	 * Get assets relative url
	 *
	 * @return string
	 */
	protected function get_assets_relative_url(): string {
		return 'assets/build/';
	}

	public static function routes_list(): array {
		return [];
	}

	public static function component_list(): array {
		return [];
	}

	/**
	 * Adds an array of components.
	 * Assumes namespace structure contains `\Components\`
	 */
	public function register_components() {
		$namespace = static::namespace_name();
		$components_ids = static::component_list();

		foreach ( $components_ids as $component_id ) {
			$class_name = $namespace . '\\Components\\' . $component_id;
			$this->add_component( $component_id, new $class_name() );
		}
	}

	/**
	 * Adds an array of routes.
	 * Assumes namespace structure contains `\Rest\`
	 */
	public function register_routes() {
		$namespace = static::namespace_name();
		$routes_ids = static::routes_list();

		foreach ( $routes_ids as $route_id ) {
			$class_name = $namespace . '\\Rest\\' . $route_id;
			$this->add_route( $route_id, new $class_name() );
		}
	}
}
