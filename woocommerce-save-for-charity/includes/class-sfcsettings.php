<?php
/**
 * Settings class
 *
 * @package woocommerce-save-for-charity
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SFCSettings' ) ) {
	/**
	 * Save for Charity Settings class
	 *
	 * @class SFCSettings
	 */
	class SFCSettings {
		/**
		 * The single instance of the class
		 *
		 * @var SFCSettings|null
		 */
		protected static ?SFCSettings $_instance = null;

		/**
		 * Save for Charity Settings
		 *
		 * Uses the Singleton pattern to load 1 instance of this class at maximum
		 *
		 * @static
		 * @return SFCSettings
		 */
		public static function instance(): SFCSettings {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * SFCSettings constructor.
		 */
		public function __construct() {
			$this->actions_and_filters();
		}

		/**
		 * Add actions and filters.
		 */
		public function actions_and_filters() {
			add_action( 'admin_menu', array( $this, 'add_menu_page' ), 99 );
			add_action( 'admin_init', array( $this, 'register_settings' ) );
		}

		/**
		 * Add Save for Charity Settings menu page.
		 */
		public function add_menu_page() {
			add_menu_page(
				esc_html__( 'Save for Charity', 'woocommerce-save-for-charity' ),
				esc_html__( 'Save for Charity', 'woocommerce-save-for-charity' ),
				'edit_plugins',
				'woo_sfc_admin_menu',
				null,
				'dashicons-money-alt',
				56
			);
			add_submenu_page(
				'woo_sfc_admin_menu',
				esc_html__( 'Save for Charity Dashboard', 'woocommerce-save-for-charity' ),
				esc_html__( 'Dashboard', 'woocommerce-save-for-charity' ),
				'edit_plugins',
				'woo_sfc_admin_menu',
				array( $this, 'woo_sfc_admin_menu_dashboard_callback' )
			);
		}

		/**
		 * Register Save for Charity Settings.
		 */
		public function register_settings() {
			register_setting(
				'woo_sfc_settings',
				'woo_sfc_settings',
				array( $this, 'woo_sfc_settings_validate' )
			);

			add_settings_section(
				'counter_settings',
				__( 'Counter settings', 'woocommerce-save-for-charity' ),
				array( $this, 'woo_sfc_counter_settings_callback' ),
				'woo_sfc_settings'
			);

			add_settings_field(
				'woo_sfc_total_saved_for_charity',
				__( 'Amount saved for charity', 'woocommerce-save-for-charity' ),
				array( $this, 'woo_sfc_total_saved_for_charity_renderer' ),
				'woo_sfc_settings',
				'counter_settings'
			);

			add_settings_field(
				'woo_sfc_charity_save_percentage',
				__( 'How many percent to save for charity per order', 'woocommerce-save-for-charity' ),
				array( $this, 'woo_sfc_charity_save_percentage_renderer' ),
				'woo_sfc_settings',
				'counter_settings'
			);
		}

		/**
		 * Validate Save for Charity settings.
		 *
		 * @param $input
		 *
		 * @return array
		 */
		public function woo_sfc_settings_validate( $input ): array {
			$output['woo_sfc_total_saved_for_charity'] = floatval( $input['woo_sfc_total_saved_for_charity'] );
			$output['woo_sfc_charity_save_percentage'] = absint( $input['woo_sfc_charity_save_percentage'] );

			return $output;
		}

		/**
		 * Render Percentage of order to save setting.
		 */
		public function woo_sfc_charity_save_percentage_renderer() {
			$options = get_option( 'woo_sfc_settings' ); ?>
			<p><?php echo esc_html( __( 'Percentage of each order to save for charity', 'woocommerce-save-for-charity' ) ); ?></p>
			<input type='number' name='woo_sfc_settings[woo_sfc_charity_save_percentage]'
			       value="<?php echo esc_attr( $options['woo_sfc_charity_save_percentage'] ); ?>">
			<?php
		}

		/**
		 * Render Total saved for charity setting.
		 */
		public function woo_sfc_total_saved_for_charity_renderer() {
			$options = get_option( 'woo_sfc_settings' );
			?>
			<p><?php echo esc_html( __( 'The total amount of money saved for charity.', 'woocommerce-save-for-charity' ) ); ?></p>
			<input type='number' name='woo_sfc_settings[woo_sfc_total_saved_for_charity]'
			       value="<?php echo esc_attr( $options['woo_sfc_total_saved_for_charity'] ); ?>">
			<?php
		}

		/**
		 * Render the section title of Save for Charity settings.
		 */
		public function woo_sfc_counter_settings_callback() {
			echo esc_html( __( 'Save for Charity settings', 'woocommerce-save-for-charity' ) );
		}

		/**
		 * Admin menu dashboard callback.
		 */
		public function woo_sfc_admin_menu_dashboard_callback() {
			include_once WOO_SFC_ABSPATH . 'views/sfc-admin-dashboard-view.php';
		}
	}
}
