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

function get_excerpt( $limit, $source = null ) {

	if ( $source == "content" ? ( $excerpt = get_the_content() ) : ( $excerpt = get_the_excerpt() ) ) {
		;
	}
	$excerpt = preg_replace( " (\[.*?\])", '', $excerpt );
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = strip_tags( $excerpt );
	$excerpt = substr( $excerpt, 0, $limit );
	$excerpt = substr( $excerpt, 0, strripos( $excerpt, " " ) );
	$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
	$excerpt = $excerpt . '... ';

	return $excerpt;
}

if ( ! function_exists( 'dd' ) ) {
	function dd( $data ) {
		echo '<pre>';
		var_dump( $data );
		echo '</pre>';
		die();
	}
}

function file_size_format( $bytes ) {
	if ( $bytes >= 1073741824 ) {
		$bytes = number_format( $bytes / 1073741824, 2 ) . ' GB';
	} elseif ( $bytes >= 1048576 ) {
		$bytes = number_format( $bytes / 1048576, 2 ) . ' MB';
	} elseif ( $bytes >= 1024 ) {
		$bytes = number_format( $bytes / 1024, 2 ) . ' KB';
	} elseif ( $bytes > 1 ) {
		$bytes = $bytes . ' bytes';
	} elseif ( $bytes == 1 ) {
		$bytes = $bytes . ' byte';
	} else {
		$bytes = '0 bytes';
	}

	return $bytes;
}

function get_time_ago( $datetime, $full = false ) {
	$now  = new DateTime;
	$ago  = new DateTime( $datetime );
	$diff = $now->diff( $ago );

	$diff->w = floor( $diff->d / 7 );
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'سال',
		'm' => 'ماه',
		'w' => 'هفته',
		'd' => 'روز',
		'h' => 'ساعت',
		'i' => 'دقیقه',
		's' => 'ثانیه',
	);
	foreach ( $string as $k => &$v ) {
		if ( $diff->$k ) {
			$v = $diff->$k . ' ' . $v . ( $diff->$k > 1 ? 's' : '' );
		} else {
			unset( $string[ $k ] );
		}
	}

	if ( ! $full ) {
		$string = array_slice( $string, 0, 1 );
	}

	return $string ? implode( ', ', $string ) . ' پیش' : 'هم اکنون';
}

function ajax_validate_input( $input, $type , $name = 'Field' ) {

	$response = [
		'success' => false,
		'message' => __( 'Something Wrong', 'kaprina' )
	];
	$input = sanitize_text_field($input);

	switch ( $type ) {
		case 'email':
			if ( ! filter_var( $input, FILTER_VALIDATE_EMAIL ) || !check_email_domain($input)) {
				$response['message'] = __( 'Email Address is invalid', 'kaprina' );
				wp_send_json( $response );
			}
			break;
		case 'phone':
			$zero = substr($input, 0, 1);
			if(!is_numeric($input) || strlen((string) $input) != 11 || $zero != 0 ){
				$response['message'] = __( 'Phone Number is invalid', 'kaprina' );
				wp_send_json( $response );
			}
			break;
		case 'string':
			if(!is_string($input)){
				$response['message'] = __( "$name is Not String", 'kaprina' );
				wp_send_json( $response );
			}
			break;
		case 'number':
			if(!is_numeric($input)){
				$response['message'] = __( "$name is Not Number", 'kaprina' );
				wp_send_json( $response );
			}
			break;
		case 'empty':
			if(empty($input)){
				$response['message'] = __( "$name is Required", 'kaprina' );
				wp_send_json( $response );
			}
			break;
	}
	return true;
}

if(!function_exists('check_email_domain')){
	function check_email_domain($email) {
		//Get host name from email and check if it is valid
		$email_host = explode("@", $email);
		//Add a dot to the end of the host name to make a fully qualified domain name and get last array element because an escaped @ is allowed in the local part (RFC 5322)
		$host = end($email_host) . ".";
		//Convert to ascii (http://us.php.net/manual/en/function.idn-to-ascii.php)
		return checkdnsrr(idn_to_ascii($host), "MX"); //(bool)
	}
}