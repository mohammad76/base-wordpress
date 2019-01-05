<?php

class Base_Admin_Pages {
	public function __construct() {
		do_action('base_plugin_add_setting_tab');
		add_action( 'admin_menu', function () {
			add_menu_page(
				__( 'افزونه پیشفرض', 'kaprina' ),
				'افزونه پیشفرض',
				'manage_options',
				'base_plugin',
				[ $this, 'admin_setting_tabs' ],
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
		$tabs = apply_filters( 'base-admin-setting-tabs', array(
			'main',
			'maintwo'
		) );

		return $tabs;
	}

	public function admin_setting_tabs() {
		$tabs = $this->get_setting_tabs();
		$current_tab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'main';
		if ( !in_array( $current_tab, $tabs ) ) {
			echo 'error: tab not exist';
			return;
		}
		$html = '<h2 class="nav-tab-wrapper">';
		$class_name = [];
		foreach ( $tabs as $tab ) {
			$class_name[$tab] = 'base_setting_tab_' . $tab;
			if ( class_exists( $class_name[$tab] ) ) {
				$instance_class = new  $class_name[$tab];
				$class                         = ( $current_tab == $instance_class->get_name() ) ? 'nav-tab-active' : '';
				$html                          .= '<a class="nav-tab ' . $class . '" href="?page=base_plugin&tab=' . $instance_class->get_name() . '">' . $instance_class->get_title() . '</a>';

			}
		}
		$html .= '</h2>';
		echo $html;

		if ( class_exists( $class_name[$current_tab] ) ) {
			$instance_class = new  $class_name[$current_tab];
			if(isset($_POST['submit'])){
				$instance_class->save_setting();
			}

			$instance_class->get_body();
		} else {
			echo 'not found';
		}
	}
}