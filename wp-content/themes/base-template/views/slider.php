<div class="slider-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
	                    <?php while (have_rows('slider','option')): the_row(); ?>
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?= get_row_index(); ?>" class="<?= (get_row_index()==1) ? 'active' : ''  ?>"></li>
	                    <?php endwhile; ?>
                    </ol>
                    <div class="carousel-inner">
	                    <?php while (have_rows('slider','option')): the_row(); ?>
                        <div class="carousel-item <?= (get_row_index()==1) ? 'active' : ''  ?>">
                            <img class="d-block w-100" src="<?php the_sub_field('img') ?>">
                            <?php if(get_sub_field('txt')): ?>
                            <div class="txt-img"><?php the_sub_field('txt') ?></div>
                            <?php endif; ?>
                        </div>
	                    <?php endwhile; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                       data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                       data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>