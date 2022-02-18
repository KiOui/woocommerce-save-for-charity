<?php
/**
 * Admin Dashboard View.
 *
 * @package woocommerce-save-for-charity
 */

?>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Save for Charity Dashboard', 'woocommerce-save-for-charity' ); ?></h1>
	<hr class="wp-header-end">
	<p><?php esc_html_e( 'Save for Charity settings', 'woocommerce-save-for-charity' ); ?></p>
	<form action='options.php' method='post'>
		<?php
		settings_fields( 'woo_sfc_settings' );
		do_settings_sections( 'woo_sfc_settings' );
		submit_button();
		?>
	</form>
</div>
