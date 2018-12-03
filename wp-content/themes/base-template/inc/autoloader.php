<?php

class Autoloader{


	public function __construct() {
		spl_autoload_register(array($this,'autoload'));
	}

	public function autoload($class_name) {
		$file_path = $this->class_path_generator($class_name);
		if (is_readable($file_path) && file_exists($file_path)){
			include $file_path;
		}
	}

	public function class_path_generator($class_name) {
		$file_path = THEME_PATH.'/inc/classes/'.$class_name.'.php';
		return $file_path;
	}

}

$auto = new Autoloader();