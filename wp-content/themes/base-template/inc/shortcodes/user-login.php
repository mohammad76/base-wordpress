<?php
add_shortcode('user-login' , function (){

	ob_start();
	include get_template_directory() . '/inc/shortcodes/templates/login.php';
	$tpl = ob_get_clean();
	return $tpl;
});

