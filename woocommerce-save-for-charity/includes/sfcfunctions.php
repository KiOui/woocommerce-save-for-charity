<?php
/**
 * Functions file
 *
 * @package woocommerce-save-for-charity
 */

if ( ! function_exists( 'sfc_increase_total_saved_for_charity' ) ) {
	/**
	 * After order completion, increase the total saved for charity.
	 *
	 * @param int $order_id the order id.
	 *
	 * @return void
	 */
	function sfc_increase_total_saved_for_charity( int $order_id ): void {
		$order = wc_get_order( $order_id );
		$order_total = $order->get_total();
		$settings = get_option( 'woo_sfc_settings' );
		$saved_until_now = isset( $settings['woo_sfc_total_saved_for_charity'] ) ? floatval( $settings['woo_sfc_total_saved_for_charity'] ) : 0.0;
		$save_percentage = isset( $settings['woo_sfc_charity_save_percentage'] ) ? absint( $settings['woo_sfc_charity_save_percentage'] ) : 0;
		$order_save_for_charity = $order_total * $save_percentage / 100;
		$order->update_meta_data( '_sfc_saved_for_charity', number_format( $order_save_for_charity, 2 ) );
		$order->save();
		$settings['woo_sfc_total_saved_for_charity'] = number_format( floatval( $saved_until_now + $order_save_for_charity ), 2 );
		update_option( 'woo_sfc_settings', $settings );
	}
}
