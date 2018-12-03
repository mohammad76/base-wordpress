<?php

class magic {

	public function generate_posts_args( $post_type = 'post', $posts_per_page = '', $order = 'DESC', $orderby = '', $page = '', $category = '', $search = '', $post = '' ) {
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


	}

	public static function is_fa() {
		if ( ICL_LANGUAGE_CODE == 'fa' ) {
			return true;
		} else {
			return false;
	}
	}

}