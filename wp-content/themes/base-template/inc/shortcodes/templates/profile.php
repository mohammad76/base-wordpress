<?php
$user_panel_home_path = get_template_directory() .'/inc/shortcodes/templates/user-panel/home.php';
$user_panel_change_path = get_template_directory() .'/inc/shortcodes/templates/user-panel/change.php';
$user_panel_password_path = get_template_directory() .'/inc/shortcodes/templates/user-panel/password.php';
$user_panel_comments_path = get_template_directory() .'/inc/shortcodes/templates/user-panel/comments.php';
if ( !is_user_logged_in() ) {
	?>
	<script>
        window.location.replace("<?= home_url( '/' ) ?>");
	</script>
	<?php
	exit();
}
?>
<div class="profile-section">
	<div class="row">
		<div class="col-3">
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><?php _e('User Profile','kaprina'); ?></a>
				<a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><?php _e('Edit information','kaprina'); ?></a>
				<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><?php _e('Change Password','kaprina'); ?></a>
				<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><?php _e('Comments','kaprina'); ?></a>
			</div>
		</div>
		<div class="col-9">
			<div class="box-profile">
				<div class="title-profile">
					<h3><?php _e('Your Profile' , 'kaprina'); ?></h3>
				</div>
				<div class="tab-content" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
						<?php
						if(file_exists($user_panel_home_path) && is_readable($user_panel_home_path)){
							include $user_panel_home_path;
						}
						?>
					</div>
					<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
						<?php
						if(file_exists($user_panel_change_path) && is_readable($user_panel_change_path)){
							include $user_panel_change_path;
						}
						?>
					</div>
					<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
						<?php
						if(file_exists($user_panel_password_path) && is_readable($user_panel_password_path)){
							include $user_panel_password_path;
						}
						?>
					</div>
					<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
						<?php
						if(file_exists($user_panel_comments_path) && is_readable($user_panel_comments_path)){
							include $user_panel_comments_path;
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

