<?php
function user_change_password() {
	$response = [
		'success' => false,
		'message' => __('Something Wrong','kaprina')
	];


	check_ajax_referer( 'change-password', 'nonce' );
	$password = _sanitize_text_fields($_POST['password']);
	$repassword = _sanitize_text_fields($_POST['repassword']);
	if(empty($password) || empty($repassword)){
		$response['message'] = __('Please Complete All Fields.' ,'kaprina');
		wp_send_json($response);
	}
	if($password != $repassword){
		$response['message'] = __('Passwords Not Equal.','kaprina');
		wp_send_json($response);
	}

	wp_set_password($password , get_current_user_id());
	$response['message'] =  __('Password change successfully.','kaprina');
	$response['success'] = true;
	wp_send_json($response);
}

add_action( 'wp_ajax_user_change_password', 'user_change_password' );
add_action( 'wp_ajax_nopriv_user_change_password', 'user_change_password' );
