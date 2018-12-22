<?php
add_shortcode('user-profile' , function (){

	ob_start();
	include get_template_directory() . '/inc/shortcodes/templates/profile.php';
	$tpl = ob_get_clean();
	return $tpl;
});

