<?php

// include shortcodes here

$files = scandir(get_template_directory().'/inc/shortcodes');

foreach ($files as $file){
	if(stripos($file ,'.php') && $file != 'index.php'){
		include get_template_directory().'/inc/shortcodes/' .  $file;
	}
}