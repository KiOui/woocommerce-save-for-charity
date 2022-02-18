<?php
/**
 * Core class
 *
 * @package woocommerce-save-for-charity
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SFCCore' ) ) {
	/**
	 * Save For Charity Core class
	 *
	 * @class SFCCore
	 */
	class SFCCore {
		/**
		 * The single instance of the class.
		 *
		 * @var SFCCore|null
		 */
		protected static ?SFCCore $_instance = null;

		/**
		 * Save for Charity Core.
		 *
		 * Uses the Singleton pattern to load 1 instance of this class at maximum
		 *
		 * @static
		 * @return SFCCore
		 */
		public static function instance(): SFCCore {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Constructor.
		 */
		private function __construct() {
			$this->define_constants();
			$this->init_hooks();
			$this->actions_and_filters();
			$this->add_shortcodes();
		}

		/**
		 * Initialise Save for Charity Core.
		 */
		public function init() {
			$this->initialise_localisation();
			do_action( 'save_for_charity_init' );
		}

		/**
		 * Initialise the localisation of the plugin.
		 */
		private function initialise_localisation() {
			load_plugin_textdomain( 'woocommerce-save-for-charity', false, plugin_basename( dirname( WOO_SFC_PLUGIN_FILE ) ) . '/languages/' );
		}

		/**
		 * Define constants of the plugin.
		 */
		private function define_constants() {
			$this->define( 'WOO_SFC_ABSPATH', dirname( WOO_SFC_PLUGIN_FILE ) . '/' );
			$this->define( 'WOO_SFC_FULLNAME', 'woocommerce-save-for-charity' );
		}

		/**
		 * Define if not already set.
		 *
		 * @param string $name the name.
		 * @param string $value the value.
		 */
		private static function define( string $name, string $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Initialise activation and deactivation hooks.
		 */
		private function init_hooks() {
			register_activation_hook( WOO_SFC_PLUGIN_FILE, array( $this, 'activation' ) );
			register_deactivation_hook( WOO_SFC_PLUGIN_FILE, array( $this, 'deactivation' ) );
		}

		/**
		 * Activation hook call.
		 */
		public function activation() {
		}

		/**
		 * Deactivation hook call.
		 */
		public function deactivation() {
		}

		/**
		 * Add actions and filters.
		 */
		private function actions_and_filters() {
			include_once WOO_SFC_ABSPATH . 'includes/sfcfunctions.php';
			include_once WOO_SFC_ABSPATH . 'includes/class-sfcsettings.php';

			add_action( 'init', array( $this, 'init' ) );
			add_action( 'woocommerce_pre_payment_complete', 'sfc_increase_total_saved_for_charity' );
			SFCSettings::instance();
		}

		/**
		 * Add shortcodes.
		 */
		private function add_shortcodes() {
			add_shortcode( 'woo-sfc-counter', array( $this, 'do_shortcode' ) );
		}

		/**
		 * Print the WooCommerce Save for Charity shortcode.
		 *
		 * @param $atts array the attributes
		 *
		 * @return string
		 */
		public function do_shortcode( $atts ): string {
			if ( gettype( $atts ) != 'array' ) {
				$atts = array();
			}
			include_once WOO_SFC_ABSPATH . 'includes/class-sfcshortcode.php';
			$shortcode = new SFCShortcode( $atts );

			return $shortcode->do_shortcode();
		}
	}
}
