<div class="user-panel-comments">
	<ul>
		<?php
		$args = array(
			'user_id' => get_current_user_id()
		);

		// The Query
		$comments_query = new WP_Comment_Query;
		$comments = $comments_query->query( $args );

		// Comment Loop
		if ( $comments ) {
			foreach ( $comments as $comment ) { ?>
				<li>
					<div class="comment-bubble"><?= $comment->comment_content ?></div>
					<p class="small mr-1 mt-1">ارسال شده در <a href="<?= get_the_permalink($comment->comment_post_ID) ?>" target="_blank"><?= get_the_title($comment->comment_post_ID) ?></a> در تاریخ <?= parsidate("d F Y",$comment->comment_date) ?></p>
				</li>
			<?php }
		} else {
			echo 'شما نظر ثبت شده ایی ندارید.';
		}
		?>

	</ul>
</div>