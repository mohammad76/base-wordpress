<?php
// this is a sample of ajax handler
function user_register() {
	$response = [
		'success' => false,
		'message' => __('Something Wrong','kaprina')
	];
	check_ajax_referer( 'ajax-request', 'nonce' );
	$data = [
		'username' =>  sanitize_text_field( $_POST['username']),
		'email' =>  sanitize_text_field( $_POST['email']),
		'password' =>  sanitize_text_field( $_POST['password']),
		'repassword' =>  sanitize_text_field( $_POST['repassword']),
	];
	ajax_validate_input($data['username'] , 'empty' , 'username');
	ajax_validate_input($data['email'] , 'empty' , 'email');
	ajax_validate_input($data['password'] , 'empty' , 'password');
	ajax_validate_input($data['repassword'] , 'empty' , 'repassword');

	if(username_exists($data['username'])){
		$response['message'] = __('Please Enter Another Username.','kaprina');
		wp_send_json($response);
	}

	ajax_validate_input($data['email'] , 'email');
	if($data['password'] != $data['repassword']){
		$response['message'] = __('Passwords Not Equal.','kaprina');
		wp_send_json($response);
	}
	$user = wp_create_user( $data['username'], $data['password'] , $data['email'] );

	if ( is_wp_error( $user ) ) {
		$response['message'] = __('You are Already Registered.','kaprina');
		wp_send_json($response);
	}


	$response['message'] = __('Sign up successfully.','kaprina');
	$response['success'] = true;
	wp_send_json($response);
}

add_action( 'wp_ajax_user_register', 'user_register' );
add_action( 'wp_ajax_nopriv_user_register', 'user_register' );
