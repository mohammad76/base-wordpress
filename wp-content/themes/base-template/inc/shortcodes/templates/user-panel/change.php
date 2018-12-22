<?php $user = get_userdata(get_current_user_id()); ?>
<div class="user-panel-change">
	<form  action="<?= get_the_permalink() ?>" method="post">
		<input type="hidden" id="nonce-update" name="_nonce" value="<?= wp_create_nonce('change-user') ?>">
		<div class="form-group">
			<label for="fname">نام:</label>
			<input type="text" name="fname" value="<?= $user->first_name ?>" class="form-control" id="fname">
		</div>
		<div class="form-group">
			<label for="lname">نام خانوادگی:</label>
			<input type="text" name="lname" value="<?= $user->last_name ?>" class="form-control" id="lname">
		</div>
		<div class="form-group">
			<label  for="email">ایمیل:</label>
			<input type="email" disabled name="email" value="<?= $user->user_email ?>" class="form-control" id="email">
		</div>
		<div class="form-group">
			<label for="url">وبسایت:</label>
			<input type="text" name="url" placeholder="<?= home_url() ?>" value="<?= $user->user_url ?>" class="form-control" id="url">
		</div>
		<div class="form-group">
			<label for="lname">درباره من:</label>
			<textarea name="description" id="description" class="form-control" rows="5" placeholder="مختصری درباره خودتان بنویسید."><?= $user->description ?></textarea>
		</div>
		<div class="alert alert-update"></div>
		<input type="submit" name="change-user" id="change-user" value="ثبت تغییرات" class="btn mt-2 p-2 w-100 d-block btn-primary">
	</form>

</div>

<script>
    jQuery('.alert-update').css('display', 'none');
    jQuery('#change-user').on('click', function (e) {
        e.preventDefault();
        jQuery(this).val('در حال بروزرسانی ...').prop('disabled', true);
        self = jQuery(this);
        first_name = jQuery('#fname').val();
        last_name = jQuery('#lname').val();
        description = jQuery('#description').val();
        url = jQuery('#url').val();
        nonce = jQuery('#nonce-update').val();
        action = 'user_update';
        jQuery.post("<?= admin_url( 'admin-ajax.php' ) ?>", {
            action,
            first_name,
            last_name,
            url,
            description,
            nonce
        }).done(function (data) {
            if (data.success) {
                jQuery('.alert-update').css('display', 'block').removeClass('alert-danger').addClass('alert-success').text(data.message);
                window.location.reload();
                self.val('ثبت تغییرات').prop('disabled', false);
            } else {
                jQuery('.alert-update').css('display', 'block').removeClass('alert-success').addClass('alert-danger').text(data.message);
                self.val('ثبت تغییرات').prop('disabled', false);
            }
        });
    });
</script>