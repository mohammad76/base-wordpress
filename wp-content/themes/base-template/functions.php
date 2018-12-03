<?php
include 'inc/constants.php';
include 'inc/autoloader.php';
add_action('after_setup_theme','initializr::setup');
add_action( 'wp_enqueue_scripts', 'initializr::enqueue_style' );
add_action( 'wp_enqueue_scripts', 'initializr::enqueue_script' );


if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'تنظیمات قالب',
		'menu_title'	=> 'تنظیمات قالب',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

}

function get_excerpt($limit, $source = null){

	if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
	$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $limit);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
	$excerpt = $excerpt.'... ';
	return $excerpt;
}

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
    global $wp_meta_boxes;

    wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'custom_dashboard_help');
}

function custom_dashboard_help() {
    echo '<p>از شما متشکریم که ما را انتخاب کردید. برای ارسال ایمیل از <a href="mailto:support@tebta.com">اینجا</a> اقدام کنید. همواره می توانید برای پشتیبانی و ارتباط با از <a href="http://web.tebta.com/" target="_blank">وبسایت ما</a> اقدام کنید.</p>';
}

// add a link to the WP Toolbar
function custom_toolbar_link($wp_admin_bar) {
    $args = array(
        'id' => 'tebta',
        'title' => 'مرکز فناوری تبتا',
        'href' => 'http://tebta.com',
        'meta' => array(
            'class' => 'tebta',
            'title' => 'طراحی سایت ، سئو و بهینه سازی'
        )
    );
    $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'custom_toolbar_link', 999);