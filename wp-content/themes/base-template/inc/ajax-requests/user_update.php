<?php
function user_update() {
	$response = [
		'success' => false,
		'message' => __('Something Wrong','kaprina')
	];


	check_ajax_referer( 'change-user', 'nonce' );
	$first_name = _sanitize_text_fields($_POST['first_name']);
	$last_name = _sanitize_text_fields($_POST['last_name']);
	$url = _sanitize_text_fields($_POST['url']);
	$description = _sanitize_text_fields($_POST['description']);

	$user_data = wp_update_user(array(
		'ID' => get_current_user_id(),
		'first_name' => $first_name,
		'last_name' => $last_name,
		'user_url' => $url,
		'description' => $description,
	));
	if ( is_wp_error( $user_data ) ) {
		$response['message'] = __('Update Problem','kaprina');
		wp_send_json($response);
	} else {
		$response['message'] = __('Update completed successfully.','kaprina');
		$response['success'] = true;
		wp_send_json($response);
	}

}

add_action( 'wp_ajax_user_update', 'user_update' );
add_action( 'wp_ajax_nopriv_user_update', 'user_update' );
