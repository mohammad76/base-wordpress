<?php
// this is a sample of ajax handler
function user_login() {
	$response = [
		'success' => false,
		'message' => 'درحال حاضر مشکلی بیش آمده است.'
	];


	check_ajax_referer( 'ajax-request', 'nonce' );
	$credentials = [
		'user_login' =>  sanitize_text_field( $_POST['username']),
		'user_password' =>  sanitize_text_field( $_POST['password']),
		'remember' =>  $_POST['remember'],
	];
	if ( empty( $credentials['user_login'] ) || empty( $credentials['user_password'] ) ) {
		$response['message'] = 'لطفا فیلد ها را تکمیل کنید';
		wp_send_json($response);
	}
	if ( !empty($credentials['remember']) )
		$credentials['remember'] = true;
	else
		$credentials['remember'] = false;


	$user = wp_signon( $credentials, false );

	if ( is_wp_error( $user ) ) {
		$response['message'] = 'اطلاعات وارد شده صحیح نمی باشد.';
		wp_send_json($response);
	}


	$response['message'] = 'ورود به سایت با موفقیت انجام شد.';
	$response['success'] = true;
	wp_send_json($response);
}

add_action( 'wp_ajax_user_login', 'user_login' );
add_action( 'wp_ajax_nopriv_user_login', 'user_login' );
