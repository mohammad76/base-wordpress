<?php

class Base_Admin_Pages{
	public function __construct() {
		add_action( 'admin_menu', function () {
			add_menu_page(
				__( 'افزونه پیشفرض', 'kaprina' ),
				'افزونه پیشفرض',
				'manage_options',
				'base_plugin',
				[$this,'admin_setting_tabs'],
				''
			);
			add_submenu_page(
				'base_plugin',
				'داشبورد',
				'داشبورد',
				'manage_options',
				'base_plugin'
			);
		} );
	}
	public function get_setting_tabs() {
		$tabs = array(
			'main'   => __( 'تب اول', 'kaprina' ),
			'setting' => __( 'تب دوم', 'kaprina' )
		);

		return $tabs;
	}
	public function page_tabs( $current = 'main' ) {
		$tabs = $this->get_setting_tabs();
		$html = '<h2 class="nav-tab-wrapper">';
		foreach ( $tabs as $tab => $name ) {
			$class = ( $tab == $current ) ? 'nav-tab-active' : '';
			$html  .= '<a class="nav-tab ' . $class . '" href="?page=base_plugin&tab=' . $tab . '">' . $name . '</a>';
		}
		$html .= '</h2>';
		echo $html;
	}
	public function admin_setting_tabs(  ) {
		$secure_tabs = $this->get_setting_tabs();
		$tab         = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'main';
		$this->page_tabs( $tab );
		$path = PLUGIN_DIR_BP . '/templates/admin/admin-setting-tab-' . $tab . '.php';
		if ( array_key_exists( $tab, $secure_tabs ) && is_readable( $path ) && file_exists( $path ) ) {
			include $path;
		} else {
			echo 'not found';
		}
	}
}