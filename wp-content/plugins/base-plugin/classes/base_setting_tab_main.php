<?php

class Base_Setting_Tab_Main implements Base_Setting_Tabs {

	public function get_name() {
		return 'main';
	}

	public function get_title() {
		return 'منو اصلی';
	}

	public function get_body() {
		include PLUGIN_Templates_DIR_BP . '/admin/admin-setting-tab-main.php';
	}

	public function save_setting() {
		echo 'saved';
	}
}
