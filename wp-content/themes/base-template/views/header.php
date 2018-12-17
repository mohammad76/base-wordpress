<div class="header-section py-2">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-12 col-md-2">
				<img src="<?= THEME_URL ?>/assets/images/logo.png" alt="<?php bloginfo('name') ?>" title="<?php bloginfo('name') ?>">
			</div>
			<div class="col-12 col-md-5 my-5 text-left">
				<?php get_template_part('components/search-form') ?>
				<?php get_template_part('components/socials') ?>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
                <?php get_template_part('components/navbar') ?>
			</div>
		</div>
	</div>
</div>