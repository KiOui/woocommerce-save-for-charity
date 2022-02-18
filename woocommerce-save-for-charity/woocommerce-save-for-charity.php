<?php
/**
 * Plugin Name: WooCommerce Save For Charity
 * Description: Save a percentage of your WooCommerce orders for charity.
 * Plugin URI: https://github.com/KiOui/woocommerce-save-for-charity
 * Version: 0.0.1
 * Author: Lars van Rhijn
 * Author URI: https://larsvanrhijn.nl/
 * Text Domain: woocommerce-save-for-charity
 * Domain Path: /languages/
 *
 * @package woocommerce-save-for-charity
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WOO_SFC_PLUGIN_FILE' ) ) {
	define( 'WOO_SFC_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'WOO_SFC_PLUGIN_URI' ) ) {
	define( 'WOO_SFC_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if (is_plugin_active('woocommerce/woocommerce.php')) {
	include_once dirname( __FILE__ ) . '/includes/class-sfccore.php';
	$GLOBALS['WOO_SFC_CORE'] = SFCCore::instance();
} else {
	function wbv_admin_notice_woocommerce_inactive()
	{
		if (is_admin() && current_user_can('edit_plugins')) {
			echo '<div class="notice notice-error"><p>' . __('Woocommerce Save for Charity requires WooCommerce to be active. Please activate WooCommerce to use WooCommerce Save for Charity.') . '</p></div>';
		}
	}
	add_action('admin_notices', 'wbv_admin_notice_woocommerce_inactive');
}
