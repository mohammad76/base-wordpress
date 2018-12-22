<?php

class initializr {
	public static function setup() {
		load_theme_textdomain( 'kaprina', get_template_directory() . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );


		register_nav_menus( [
			'primary_menu' => __( 'Primary Menu', 'kaprina' ),
		] );

		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page( array(
				'page_title' => 'تنظیمات قالب',
				'menu_title' => 'تنظیمات قالب',
				'menu_slug'  => 'theme-general-settings',
				'capability' => 'edit_posts',
				'redirect'   => false
			) );
		}

		add_action( 'wp_dashboard_setup', 'my_custom_dashboard_widgets' );

		function my_custom_dashboard_widgets() {
			global $wp_meta_boxes;

			wp_add_dashboard_widget( 'custom_help_widget', 'Theme Support', 'custom_dashboard_help' );
		}

		function custom_dashboard_help() {
			echo '<p>از شما متشکریم که ما را انتخاب کردید. برای ارسال ایمیل از <a href="mailto:support@kaprinaco.com">اینجا</a> اقدام کنید. همواره می توانید برای پشتیبانی و ارتباط با از <a href="http://kaprinaco.com/" target="_blank">وبسایت ما</a> اقدام کنید.</p>';
		}

		// add our company link to wordpress toolbar
		function company_link( $wp_admin_bar ) {
			$args = array(
				'id'    => 'company_link',
				'title' => 'مرکز فناوری کاپرینا',
				'href'  => 'http://kaprinaco.com',
				'meta'  => array(
					'class' => 'company_link',
					'title' => 'طراحی سایت ، سئو و بهینه سازی'
				)
			);
			$wp_admin_bar->add_node( $args );
		}

		add_action( 'admin_bar_menu', 'company_link', 999 );
	}

	public static function enqueue_style() {
		wp_enqueue_style( 'bootstrap', THEME_URL . '/assets/css/bootstrap.css' );
		wp_enqueue_style( 'bootstrap-rtl', THEME_URL . '/assets/css/bootstrap-rtl.css' );
		wp_enqueue_style( 'font-awesome', THEME_URL . '/assets/css/fontawesome5.css' );
		wp_enqueue_style( 'style', get_stylesheet_uri(), array(), filemtime( get_theme_file_path( '/style.css' ) ) );

		if ( is_front_page() ) {
			/*wp_enqueue_style( 'slick', THEME_URL . '/assets/css/slick.css' );
			wp_enqueue_style( 'slick-theme', THEME_URL . '/assets/css/slick-theme.css' );*/
		}
	}

	public static function enqueue_script() {
		wp_enqueue_script( 'bootstrap-js', THEME_URL . '/assets/js/bootstrap.js', array( 'jquery' ), false, true );

		if ( is_front_page() ) {
//			wp_enqueue_script( 'slick-js', THEME_URL . '/assets/js/slick.js',array('jquery'),false,true);
		}
		wp_enqueue_script( 'custom-js', THEME_URL . '/assets/js/custom-script.js', array( 'jquery' ),
			filemtime( get_theme_file_path( '/assets/js/custom-script.js' ) ), true );
		wp_localize_script( 'custom-js', 'baseInfo', [
			'ajax_url'       => admin_url( 'admin-ajax.php' ),
			'title'          => get_bloginfo( 'name' ),
			'site'           => get_bloginfo( 'url' ),
			'current_time'   => current_time( 'mysql' ),
			'is_rtl'         => is_rtl(),
			'wp_version'     => get_bloginfo( 'version' ),
			'is_woocommerce' => class_exists( 'WooCommerce' ),
		] );
	}

	public static function no_wordpress_errors() {
		return 'Something is wrong!';
	}

	public static function fb_disable_feed() {
		wp_die( __( 'No feed available,please visit our <a href="' . get_bloginfo( 'url' ) . '">homepage</a>!' ) );
	}

}