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
<div class="login-box">
    <form action="<?php the_permalink() ?>">
        <div class="form-group">
            <label for="email">ایمیل:</label>
            <input type="email" placeholder="ایمیل خود را وارد کنید ..." class="form-control" id="username">
        </div>
        <div class="form-group">
            <label for="pwd">رمز عبور:</label>
            <input type="password" placeholder="رمز عبور خود را وارد کنید ..." class="form-control" id="password">
        </div>
        <div class="form-group form-check">
            <label class="form-check-label">
                <input class="form-check-input" id="remember" type="checkbox"> مرا بخاطر بسپار
            </label>
        </div>
        <div class="alert"></div>
        <button type="submit" id="login-btn" class="btn btn-primary">ورود</button>
        <a href="<?= home_url('/register') ?>" class="btn btn-secondary">ثبت نام</a>
    </form>
</div>

<script>
    jQuery('.alert').css('display', 'none');
    jQuery('#login-btn').on('click', function (e) {
        e.preventDefault();
        username = jQuery('#username').val();
        password = jQuery('#password').val();
        remember = jQuery('#remember').val();
        nonce = jQuery('meta[name=_nonce]').attr("content");
        action = 'user_login';
        jQuery.post("<?= admin_url( 'admin-ajax.php' ) ?>", {
            action,
            username,
            password,
            nonce,
            remember
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