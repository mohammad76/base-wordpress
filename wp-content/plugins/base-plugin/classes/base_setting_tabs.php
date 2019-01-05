<?php

interface Base_Setting_Tabs{
	public function get_name();
	public function get_title();
	public function get_body();
	public function save_setting();
}