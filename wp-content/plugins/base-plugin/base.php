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

define( 'PLUGIN_DIR_BP', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL_BP', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN_ASSET_URL_BP', trailingslashit( PLUGIN_URL_BP . 'assets' ) );
define( 'PLUGIN_Templates_DIR_BP', trailingslashit( PLUGIN_DIR_BP . 'templates' ) );
