<?php

class Base_Setting_Tab_MainTwo implements Base_Setting_Tabs {

	public function get_name() {
		return 'maintwo';
	}

	public function get_title() {
		return 'منو دوم';
	}

	public function get_body() {
		include PLUGIN_Templates_DIR_BP . '/admin/admin-setting-tab-maintwo.php';
	}

	public function save_setting() {
		echo 'yuhooooo';
	}
}
