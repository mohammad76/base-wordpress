<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <span><?php the_field('top-txt-1','option') ?></span>
            </div>
            <div class="col-sm-9 text-left">
                <span><?php the_field('top-txt-2','option') ?></span>
            </div>
        </div>
    </div>
</div>
<div class="header-section py-3">
    <div class="container">
        <div class="row">
            <div class="col-6 push-3 push-sm-0 col-sm-2">
              <?= wp_get_attachment_image(get_field('logo','option'),'full') ?>
            </div>
            <div class="col-12 col-sm-10 mt-2 mt-sm-5">
                <div class="row">
                    <div class="col-12 text-left">
                        <div class="d-inline-block ">
                            <?php while (have_rows('socials','option')): the_row(); ?>
                            <a href="<?php the_sub_field('link') ?>">
	                            <?php wp_get_attachment_image(get_field('logo','option'),'full') ?>
                            </a>
                            <?php endwhile; ?>
                        </div>
                        <form role="search" method="get" class="d-sm-inline-block" action="<?= home_url() ?>"
                              id="searchform">
                            <div class="input-group ">
                                <input type="text" class="form-control" name="s" id="s" placeholder="جستجو کنید ..."
                                       aria-label="" aria-describedby="basic-addon1">
                                <div class="input-group-prepend">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="col-12">
                        <nav class="navbar navbar-expand-lg p-0">
                            <nav id="site-navigation" class="main-navigation" role="navigation">
                                <button class="menu-toggle d-block d-md-none" onclick="openNav()"
                                        aria-controls="primary-menu"
                                        aria-expanded="false">
                                    <span><i class="fa fa-bars" aria-hidden="true"></i></span>

                                </button>
                                <div id="wp-menu">
                                    <a href="javascript:void(0)" class="closebtn d-block d-md-none"
                                       onclick="closeNav()">&times;</a>
									<?php wp_nav_menu( array(
										'theme_location' => 'primary',
										'menu_id'        => 'primary-menu'
									) ); ?>
                                </div>
                            </nav><!-- #site-navigation -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>