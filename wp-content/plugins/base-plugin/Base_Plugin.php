<?php
/**
 * Plugin Name: Base Plugin
 * Version: 1.0.0
 * Plugin URI: http://tebta.com/
 * Description: this is a simple plugin for design other plugin.
 * Author: Mohammad Abdi
 * Author URI: http://mabdi.ir/
 * Text Domain: tebta
 * Domain Path: tebta
 */


defined( 'ABSPATH' ) || exit( '403 Access Denied' );
include plugin_dir_path( __FILE__ ) . '/helpers.php';

final class Base_Plugin {

	private static $instance;
	public static function getInstance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
		$this->constants();
		spl_autoload_register( [ $this, 'autoloader' ] );
		register_activation_hook( PLUGIN_NAME_WITH_PATH_BP, [ $this, 'activation' ] );
		register_deactivation_hook( PLUGIN_NAME_WITH_PATH_BP, [ $this, 'deactivation' ] );

		if ( is_admin() ) {
			new Base_Admin_Pages();

		} else {

		}
	}

	public function activation() {

	}

	public function deactivation() {

	}

	private function __clone() {
	}

	private function __wakeup() {
	}

	public function autoloader( $class ) {
		$class_path = PLUGIN_CLASSES_DIR_BP . strtolower( $class ) . '.php';
		if ( file_exists( $class_path ) && is_readable( $class_path ) ) {
			include $class_path;
		}
	}

	private function constants() {

		define( 'PLUGIN_DIR_BP', plugin_dir_path( __FILE__ ) );
		define( 'PLUGIN_NAME_WITH_PATH_BP', __FILE__ );
		define( 'PLUGIN_URL_BP', plugin_dir_url( __FILE__ ) );
		define( 'PLUGIN_ASSET_URL_BP', trailingslashit( PLUGIN_URL_BP . 'assets' ) );
		define( 'PLUGIN_INC_BP', trailingslashit( PLUGIN_DIR_BP . 'inc' ) );
		define( 'PLUGIN_Templates_DIR_BP', trailingslashit( PLUGIN_DIR_BP . 'templates' ) );
		define( 'PLUGIN_CLASSES_DIR_BP', trailingslashit( PLUGIN_DIR_BP . 'classes' ) );
	}
}

Base_Plugin::getInstance();