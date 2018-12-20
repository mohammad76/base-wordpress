<?php

// include ajax handlers here

$files = scandir(get_template_directory().'/inc/ajax-requests');

foreach ($files as $file){
		if(stripos($file ,'.php') && $file != 'index.php'){
			include get_template_directory().'/inc/ajax-requests/' .  $file;
		}
}