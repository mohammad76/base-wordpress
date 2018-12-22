<nav class="navbar p-0">
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<button class="menu-toggle textleft d-block d-lg-none" aria-controls="primary-menu" aria-expanded="false">
			<span><i class="fa fa-bars" aria-hidden="true"></i></span>
		</button>
		<div id="wp-menu">
			<a href="javascript:void(0)" class="closebtn">×</a>
			<?php
			$menu = wp_nav_menu(
				array(
					'menu_id' => 'primary_menu',
					'echo' => false,
					'fallback_cb' => '__return_false'
				)
			);

			if (!empty($menu)) {
				echo $menu;
			} else {
				echo "<div class='menu-not-exist'> " . _e('Menu not Selected','kaprina') . " !!!</div>";
			}
			?>
		</div>
	</nav><!-- #site-navigation -->