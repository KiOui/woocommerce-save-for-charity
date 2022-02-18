<?php
/**
 * Shortcode class
 *
 * @package woocommerce-save-for-charity
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SFCShortcode' ) ) {
	/**
	 * Save for Charity Shortcode Class
	 *
	 * @class SFCShortcode
	 */
	class SFCShortcode {

		private float $total_saved;

		/**
		 * SFCShortcode constructor.
		 */
		public function __construct() {
			$this->total_saved = get_option( 'woo_sfc_settings' )['woo_sfc_total_saved_for_charity'] ? floatval( get_option( 'woo_sfc_settings' )['woo_sfc_total_saved_for_charity'] ) : 0.0;
		}

		/**
		 * Get the contents of the shortcode.
		 *
		 * @return string
		 */
		public function do_shortcode(): string {
			ob_start();
			echo wc_price( number_format($this->total_saved,2) );
			$ob_content = ob_get_contents();
			ob_end_clean();

			return ( $ob_content ? $ob_content : '' );
		}
	}
}
