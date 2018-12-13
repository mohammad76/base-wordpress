<?php
// this is a sample of ajax handler
function get_site_info(){
	$info = [
		'title' => get_bloginfo('name'),
		'site' => get_bloginfo('url'),
		'current_time' => current_time('mysql'),
		'is_rtl' => is_rtl(),
		'wp_version' => get_bloginfo('version'),
		'is_woocommerce' => class_exists( 'WooCommerce' ),
	];
	echo json_encode($info);
	wp_die();
}

add_action( 'wp_ajax_get_site_info', 'get_site_info' );
add_action( 'wp_ajax_nopriv_get_site_info', 'get_site_info' );
