<?php get_header(); ?>
<?php get_template_part('views/top-bar') ?>
<?php get_template_part('views/header') ?>
<?php if(have_posts()): the_post() ?>

<div class="container">
	<div class="row">
	       <div class="col-12">
		       <?php the_content() ?>
           </div>
    </div>

</div>
<?php endif; ?>
<?php get_footer(); ?>
