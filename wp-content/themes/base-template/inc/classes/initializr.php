<?php

class initializr {
	public static function setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menu('primary',__( 'منو اصلی' ));

	}

	public static function enqueue_style() {
		wp_enqueue_style( 'bootstrap', THEME_URL . '/assets/css/bootstrap.css' );
		wp_enqueue_style( 'bootstrap-rtl', THEME_URL . '/assets/css/bootstrap-rtl.css' );
		wp_enqueue_style( 'font-awesome', THEME_URL . '/assets/css/fontawesome5.css' );
		wp_enqueue_style( 'plugin', THEME_URL . '/assets/css/plugins.css' );
			wp_enqueue_style( 'style', get_stylesheet_uri() );
			wp_enqueue_style( 'style', THEME_URL . '/ltr.css' );
		if ( is_front_page() ) {
			wp_enqueue_style( 'slick', THEME_URL . '/assets/css/slick.css' );
			wp_enqueue_style( 'slick-theme', THEME_URL . '/assets/css/slick-theme.css' );
		}
	}

	public static function enqueue_script() {
		wp_enqueue_script( 'bootstrap-js', THEME_URL . '/assets/js/bootstrap.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'custom-js', THEME_URL . '/assets/js/custom-script.js', array( 'jquery' ), false, true );


		if ( is_front_page() ) {
//			wp_enqueue_script( 'slick-js', THEME_URL . '/assets/js/slick.js',array('jquery'),false,true);
		}
	}
}