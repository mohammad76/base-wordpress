<?php $user = get_userdata(get_current_user_id()); ?>
<div class="user-panel-home">
	<ul>
		<li>
			<b class="title text-muted">نام و نام خانوادگی:</b>
			<b><?= $user->first_name ?> <?= $user->last_name ?></b>
		</li>
		<li>
			<b class="title text-muted">نام کاربری:</b>
			<b><?= $user->user_login  ?></b>
		</li>
		<li>
			<b class="title text-muted">ایمیل:</b>
			<b><?= $user->user_email  ?></b>
		</li>
		<li>
			<b class="title text-muted">تاریخ عضویت:</b>
			<b><?= jdate("d F Y",strtotime( $user->user_registered ) ) ?></b>
		</li>
	</ul>
</div>