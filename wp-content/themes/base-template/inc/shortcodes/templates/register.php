<?php
if ( is_user_logged_in() ) {
	?>
	<script>
        window.location.replace("<?= home_url( '/' ) ?>");
	</script>
	<?php
	exit();
}
?>
<div class="register-box">
	<form action="<?php the_permalink() ?>">
		<div class="form-group">
			<label for="username">نام کاربری:</label>
			<input type="text" placeholder="نام کاربری خود را وارد کنید ..." class="form-control" id="username">
		</div>
		<div class="form-group">
			<label for="email">ایمیل:</label>
			<input type="email" placeholder="ایمیل خود را وارد کنید ..." class="form-control" id="email">
		</div>
		<div class="form-group">
			<label for="password">رمز عبور:</label>
			<input type="password" placeholder="رمز عبور خود را وارد کنید ..." class="form-control" id="password">
		</div>
		<div class="form-group">
			<label for="repassword">تکرار رمز عبور:</label>
			<input type="password" placeholder="تکرار رمز عبور خود را وارد کنید ..." class="form-control" id="repassword">
		</div>
		<div class="alert"></div>
		<button type="submit" id="register-btn" class="btn btn-primary">ثبت نام</button>
		<a href="<?= home_url('/login') ?>" class="btn btn-secondary">ورود</a>
	</form>
</div>

<script>
    jQuery('.alert').css('display', 'none');
    jQuery('#register-btn').on('click', function (e) {
        e.preventDefault();
        username = jQuery('#username').val();
        email = jQuery('#email').val();
        password = jQuery('#password').val();
        repassword = jQuery('#repassword').val();
        nonce = jQuery('meta[name=_nonce]').attr("content");
        action = 'user_register';
        jQuery.post("<?= admin_url( 'admin-ajax.php' ) ?>", {
            action,
            username,
            email,
            password,
            repassword,
            nonce
        }).done(function (data) {
            if (data.success) {
                jQuery('.alert').css('display', 'block').removeClass('alert-danger').addClass('alert-success').text(data.message);
                window.location.href = "<?= home_url( '/' ) ?>"
            } else {
                jQuery('.alert').css('display', 'block').removeClass('alert-success').addClass('alert-danger').text(data.message);
            }
        });
    });
</script>