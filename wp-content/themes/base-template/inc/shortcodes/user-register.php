<?php
add_shortcode('user-register' , function (){

	ob_start();
	include get_template_directory() . '/inc/shortcodes/templates/register.php';
	$tpl = ob_get_clean();
	return $tpl;
});

