<?php get_header(); ?>
<?php if(have_posts()): the_post() ?>

<div class="container">
	<div class="row">
        <div class="col-6">
	        <?php the_content() ?>
        </div>
    </div>

</div>
<?php endif; ?>
<?php get_footer(); ?>
