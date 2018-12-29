<?php
$files = scandir(PLUGIN_INC_BP.'/frontend');

foreach ($files as $file){
	if(stripos($file ,'.php') && $file != 'index.php'){
		include PLUGIN_INC_BP.'/frontend/' .  $file;
	}
}