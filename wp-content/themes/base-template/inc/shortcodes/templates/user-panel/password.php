<div class="user-panel-password">
    <div class="alert alert-password"></div>
    <form action="<?= get_the_permalink() ?>" method="post">
        <div class="form-row">
            <input type="hidden" id="nonce-password" name="_nonce" value="<?= wp_create_nonce('change-password') ?>">
            <div class="col">
                <label for="inputEmail4">رمز عبور جدید:</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="col">
                <label for="inputEmail4">تکرار رمز عبور جدید:</label>
                <input type="password" name="repassword" id="repassword" class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="col-12">
                <input id="change-password" name="change-password" class="btn mt-2 p-2 w-100 d-block btn-primary" type="submit" value="تغییر رمز عبور">
            </div>
        </div>
    </form>
</div>
<script>
    jQuery('.alert').css('display', 'none');
    jQuery('#change-password').on('click', function (e) {
        e.preventDefault();
        jQuery(this).val('در حال ارسال ...').prop('disabled', true);
        self = jQuery(this);
        password = jQuery('#password').val();
        repassword = jQuery('#repassword').val();
        nonce = jQuery('#nonce-password').val();
        action = 'user_change_password';
        jQuery.post("<?= admin_url( 'admin-ajax.php' ) ?>", {
            action,
            password,
            repassword,
            password,
            nonce
        }).done(function (data) {
            if (data.success) {
                jQuery('.alert-password').css('display', 'block').removeClass('alert-danger').addClass('alert-success').text(data.message);
                self.val('تغییر رمز عبور').prop('disabled', false);
            } else {
                jQuery('.alert-password').css('display', 'block').removeClass('alert-success').addClass('alert-danger').text(data.message);
                self.val('تغییر رمز عبور').prop('disabled', false);
            }
        });
    });
</script>