<?php

// include shortcodes here

$files = scandir(get_template_directory().'/inc/widgets');

foreach ($files as $file){
	if(stripos($file ,'.php') && $file != 'index.php'){
		include get_template_directory().'/inc/widgets/' .  $file;
	}
}