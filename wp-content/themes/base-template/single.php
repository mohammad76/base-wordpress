<?php get_header(); ?>
<?php if ( have_posts() ):
	the_post() ?>
	<?php get_template_part( 'views/navbar' ) ?>


    <div class="container">
        <div class="row">
			<?php if ( get_post_type() == 'product' ): ?>
				<?php the_content() ?>
			<?php elseif ( get_post_type() == 'post' ): ?>
                <div class="col-12 col-md-9">
                    <div class="box-news pb-5">
                        <h1><?php the_title() ?></h1>
						<div class="thumb">
							<?php the_post_thumbnail( 'full' ) ?>
                        </div>
                        <div class="body-post">
							<?php the_content() ?>
                        </div>
                    </div>

                    <div class="box-news">
                        <div class="h1"><?= __('Comments' , 'tebta') ?></div>
                        <div class="body-post">
							<?php comments_template(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
					<?php get_template_part('sidebar') ?>
                </div>

			<?php endif; ?>
        </div>
    </div>
<?php endif; ?>


<?php get_footer(); ?>
