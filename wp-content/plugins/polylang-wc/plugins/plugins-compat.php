<?php

/**
 * Manages compatibility with 3rd party plugins ( and themes )
 * This class is available as soon as the plugin is loaded
 *
 * @since 0.3.2
 */
class PLLWC_Plugins_Compat {
	static protected $instance; // For singleton

	/**
	 * Constructor
	 *
	 * @since 0.3.2
	 */
	protected function __construct() {
		add_action( 'pllwc_init', array( $this, 'init' ) );
	}

	/**
	 * Init fired only if Polylang for WooCommerce object is initialized
	 *
	 * @since 3.2
	 */
	public function init() {
		if ( is_admin() ) {
			// WooCommerce Stock Manager + WooCommerce Bulk Stock Management
			if ( isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'stock-manager', 'woocommerce-bulk-stock-management' ) ) ) {
				$this->stock_manager = new PLLWC_Stock_Manager();
			}

			if ( class_exists( 'WC_Dynamic_Pricing' ) ) {
				$this->dynamic_pricing = new PLLWC_Dynamic_Pricing();
			}
		}

		if ( class_exists( 'WC_Subscriptions' ) ) {
			$this->subscriptions = new PLLWC_Subscriptions();
		}

		if ( class_exists( 'WC_Table_Rate_Shipping' ) ) {
			$this->table_rate_shipping = new PLLWC_Table_Rate_Shipping();
		}

		if ( class_exists( 'WC_Shipment_Tracking' ) ) {
			$this->shipment_tracking = new PLLWC_Shipment_Tracking();
		}

		if ( class_exists( 'WC_Bookings' ) ) {
			$this->bookings = new PLLWC_Bookings();
		}

		if ( class_exists( 'WC_Stripe' ) ) {
			$this->stripe = new PLLWC_Stripe();
		}

		if ( class_exists( 'Follow_Up_Emails' ) ) {
			$this->fue = new PLLWC_Follow_Up_Emails();
		}

		if ( defined( 'YITH_WCAS' ) ) {
			$this->yith_wcas = new PLLWC_Yith_WCAS();
		}
	}

	/**
	 * Access to the single instance of the class
	 *
	 * @since 0.3.2
	 *
	 * @return object
	 */
	static public function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
