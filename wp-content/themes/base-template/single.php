<?php get_header(); ?>
<?php get_template_part( 'views/top-bar' ) ?>
<?php get_template_part( 'views/header' ) ?>
<?php if ( have_posts() ): the_post() ?>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="box-post-single">
                    <div class="title-box-post-single mb-3">
                        <h1><?php the_title() ?></h1>
                    </div>
                   <div class="text-center">
	                   <?php the_post_thumbnail('full') ?>
                   </div>
					<?php the_content() ?>
                </div>
            </div>
            <div class="col-md">
                <div class="box-sidebar">
                    <div class="title-box-sidebar">
                        آخرین مقالات
                    </div>
                    <ul class="related-posts">
						<?php
						$the_query = new WP_Query( generate_posts_args( 'post', 4 ) ); ?>
						<?php if ( $the_query->have_posts() ) : ?>
							<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <li class="related-posts-item">
                                    <div class="row no-gutters">
                                        <div class="col-12 col-md-3">
                                            <a href="<?php the_permalink() ?>">
												<?php the_post_thumbnail( 'thumbnail' ,['class'=>'py-md-2'] ) ?>
                                            </a>
                                        </div>
                                        <div class="col-md">
                                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                            <div class="detail-wrapper-time">
                                                <i class="icon-clock-icon"></i>
                                                <span><?= get_the_date() ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
							<?php endwhile; ?>

							<?php wp_reset_postdata(); ?>
						<?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
<?php get_footer(); ?>
