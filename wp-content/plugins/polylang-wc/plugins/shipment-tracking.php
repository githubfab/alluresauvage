<?php

/**
 * Manages compatibility with WooCommerce Shipment Tracking
 * Version tested: 1.6.3
 *
 * @since 0.6
 */
class PLLWC_Shipment_Tracking {

	/**
	 * Constructor
	 *
	 * @since 0.6
	 */
	public function __construct() {
		add_action( 'pllwc_email_reload_text_domains', array( $this, 'email_reload_text_domains' ) );
	}

	/**
	 * Reload Shipment Tracking translations in emails
	 *
	 * @since 0.6
	 *
	 * @param object $language
	 */
	public function email_reload_text_domains( $language ) {
		unload_textdomain( 'woocommerce-shipment-tracking' );
		WC_Shipment_Tracking_Actions::get_instance()->load_plugin_textdomain();
	}
}
