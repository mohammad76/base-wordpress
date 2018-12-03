<?php get_header(); ?>
<?php get_template_part('views/navbar') ?>
<?php get_template_part('views/slider') ?>

    <div class="body-section my-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="title-box mb-4">اخبار کانون</div>
                        </div>
                        <div class="col-12">
							<?php
							if ( have_posts() ) {
								while ( have_posts() ) : the_post();
									?>
                                    <div class="box-news">
                                        <div class="row">
                                            <div class="col-sm-4 p-0">
												<?php the_post_thumbnail(); ?>
                                                <!--                                                <img src="--><?//= THEME_URL ?><!--/assets/images/khabar.png" alt="ads">-->
                                            </div>
                                            <div class="col-sm-8 p-3">
                                                <a href="<?php the_permalink() ?>"><h3><?php the_title() ?></h3></a>
                                                <div class="text-justify">
													<?php the_excerpt(); ?>
                                                </div>
                                                <a href="<?php the_permalink() ?>" class="d-block btnmore float-left">بیشتر</a>
                                            </div>
                                        </div>
                                    </div>
								<?php
								endwhile;
							}
							wp_reset_postdata();
							?>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
	                <?php get_template_part('sidebar') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-about py-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 py-3">
                    <h2><?php the_field('about_title','option') ?></h2>
                    <div class="text-justify">
	                    <?php the_field('about_txt','option') ?>
                    </div>
                </div>
                <div class="col-sm p-0">
                    <img src="<?php the_field('about_img','option') ?>" alt="ads">
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>