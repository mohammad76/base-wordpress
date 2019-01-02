<?php

function generate_posts_args( $post_type = 'post', $posts_per_page = '', $order = 'DESC', $orderby = '', $page = '', $category = '', $search = '', $post = '' ) {
	$args = [
		'post_type'      => $post_type,
		'posts_per_page' => $posts_per_page,
		'paged'          => $page,
		'cat'            => $category,
		's'              => $search,
		'p'              => $post,
		'order'          => $order,
		'orderby'        => $orderby,
	];

	return $args;
}

function is_fa() {
	if ( ICL_LANGUAGE_CODE == 'fa' ) {
		return true;
	} else {
		return false;
	}
}

function get_excerpt($limit, $source = null){

	if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
	$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $limit);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
	$excerpt = $excerpt.'... ';
	return $excerpt;
}
if(!function_exists('dd')) {
	function dd( $data ) {
		echo '<pre>';
		var_dump( $data );
		echo '</pre>';
		die();
	}
}