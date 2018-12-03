<?php get_header(); ?>
<?php if(have_posts()): the_post() ?>
	<?php get_template_part('views/navbar') ?>
	<?php get_template_part( 'views/slider' ) ?>




	<div class="container">
		<div class="row py-4">
			<div class="col-12 text-center">
                <h1><?php the_title() ?></h1>
            </div>
            <div class="col-12">
	            <?php the_content() ?>
            </div>
		</div>
	</div>

<?php endif; ?>
<?php get_footer(); ?>
