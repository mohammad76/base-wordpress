<div class="sidebar-section">
	<?php while (have_rows('sidebar_banners','option')): the_row(); ?>
        <a href="<?php the_sub_field('link') ?>">
            <div class="banners">
                <img src="<?php the_sub_field('img') ?>" alt="ads">
                <div class="txt-img"><?php the_sub_field('title') ?></div>
            </div>
        </a>
	<?php endwhile; ?>
</div>