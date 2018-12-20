<?php
// this is a sample of ajax handler
function user_register() {
	$response = [
		'success' => false,
		'message' => 'درحال حاضر مشکلی بیش آمده است.'
	];
	check_ajax_referer( 'ajax-request', 'nonce' );
	$data = [
		'username' =>  sanitize_text_field( $_POST['username']),
		'email' =>  sanitize_text_field( $_POST['email']),
		'password' =>  sanitize_text_field( $_POST['password']),
		'repassword' =>  sanitize_text_field( $_POST['repassword']),
	];
	if ( empty( $data['username'] ) || empty( $data['email'] ) || empty( $data['password'] ) || empty( $data['repassword'] ) ) {
		$response['message'] = 'لطفا فیلد ها را تکمیل کنید';
		wp_send_json($response);
	}
	if(username_exists($data['username'])){
		$response['message'] = 'لطفا نام کاربری دیگری انتخاب کنید.';
		wp_send_json($response);
	}
	if(!filter_var($data['email'] , FILTER_VALIDATE_EMAIL)){
		$response['message'] = 'لطفا یک ایمیل معتبر وارد کنید.';
		wp_send_json($response);
	}
	if($data['password'] != $data['repassword']){
		$response['message'] = 'تکرار کلمه عبور یکسان نیست.';
		wp_send_json($response);
	}
	$user = wp_create_user( $data['username'], $data['password'] , $data['email'] );

	if ( is_wp_error( $user ) ) {
		$response['message'] = 'شما قبلا ثبت نام کرده اید.';
		wp_send_json($response);
	}


	$response['message'] = 'عضویت با موفقیت انجام شد.';
	$response['success'] = true;
	wp_send_json($response);
}

add_action( 'wp_ajax_user_register', 'user_register' );
add_action( 'wp_ajax_nopriv_user_register', 'user_register' );
