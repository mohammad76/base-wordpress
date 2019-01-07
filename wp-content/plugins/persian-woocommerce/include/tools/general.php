<?php

function woocommerce_checkout_state_dropdown_fix() {

	if ( function_exists( 'is_checkout' ) && ! is_checkout() ) {
		return false;
	}

	?>
    <script>
		jQuery(function () {
			// Snippets.ir
			jQuery('#billing_country').trigger('change');
			jQuery('#billing_state_field').removeClass('woocommerce-invalid');
		});
    </script>
	<?php
}

if ( PW()->get_options( 'fix_load_states' ) != 'no' ) {
	add_action( 'wp_footer', 'woocommerce_checkout_state_dropdown_fix', 50 );
}

