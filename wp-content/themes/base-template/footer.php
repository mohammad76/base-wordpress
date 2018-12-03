<div class="footer py-2">
    <div class="container">
        <div class="row">
           <div class="col-sm-4 py-5">
               <div class="d-inline-block " target="_blank">
	               <?php while (have_rows('socials','option')): the_row(); ?>
                       <a href="<?php the_sub_field('link') ?>">
			               <?php wp_get_attachment_image(get_field('logo','option'),'full') ?>
                       </a>
	               <?php endwhile; ?>
               </div>
           </div>
            <div class="col-sm-4 py-5 text-center">
                <p class="h4"><i class="fas text-primary fa-phone"></i>
                     <?php the_field('tel','option') ?></p>
                <p class="h4"><i class="fas text-primary fa-envelope"></i>

	                <?php the_field('mail','option') ?></p>
            </div>
            <div class="col-sm-4">
                <div class="footer-logo">
                    <img src="<?php the_field('footer_logo','option') ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-copy text-center">
    <div class="container">
        <div class="row py-3">
            <div class="col-12">

                <span>کلیه حقوق مادی و معنوی این سایت متعلق به <?php bloginfo('title') ?> می باشد.</span>

            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>
