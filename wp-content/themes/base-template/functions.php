<?php
include 'inc/constants.php';
include 'inc/helpers.php';
include 'inc/autoloader.php';
include 'inc/ajax-requests/index.php';
include 'inc/shortcodes/index.php';
add_action('after_setup_theme','initializr::setup');
add_action( 'wp_enqueue_scripts', 'initializr::enqueue_style' );
add_action( 'wp_enqueue_scripts', 'initializr::enqueue_script' );
add_filter( 'login_errors', 'initializr::no_wordpress_errors' );
add_action('do_feed', 'initializr::fb_disable_feed', 1);
add_action('do_feed_rdf', 'initializr::fb_disable_feed', 1);
add_action('do_feed_rss', 'initializr::fb_disable_feed', 1);
add_action('do_feed_rss2', 'initializr::fb_disable_feed', 1);
add_action('do_feed_atom', 'initializr::fb_disable_feed', 1);
//add_action( 'rest_api_init', 'initializr::disable_rest_api', 1 );
remove_action( 'welcome_panel', 'wp_welcome_panel' );
add_filter( 'xmlrpc_enabled', '__return_false' );