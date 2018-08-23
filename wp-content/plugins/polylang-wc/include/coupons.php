<?php

/**
 * Manages the coupons
 *
 * @since 0.9
 */
class PLLWC_Coupons {

	/**
	 * Constructor
	 *
	 * @since 0.9
	 */
	public function __construct() {
		add_action( 'woocommerce_coupon_loaded', array( $this, 'coupon_loaded' ) );
	}

	/**
	 * Translates products and categories restrictions in coupons
	 *
	 * @since 0.3.6
	 *
	 * @param object $data Coupon properties
	 */
	public function coupon_loaded( $data ) {
		// Test pll_current_language() not to break the Coupons admin page when the admin language filter shows all languages
		if ( pll_current_language() ) {
			// We must remove false from the array (in case there is an untranslated product or category) otherwise WooCommerce get lost
			// FIXME Backward compatibility with WC < 2.7
			if ( version_compare( WC()->version, '2.7', '<' ) ) {
				$data->product_ids = array_diff( array_map( 'pll_get_post', $data->product_ids ), array( false ) );
				$data->exclude_product_ids = array_diff( array_map( 'pll_get_post', $data->exclude_product_ids ), array( false ) );
				$data->product_categories = array_diff( array_map( 'pll_get_term', $data->product_categories ), array( false ) );
				$data->exclude_product_categories = array_diff( array_map( 'pll_get_term', $data->exclude_product_categories ), array( false ) );
			} else {
				$data->set_product_ids( array_diff( array_map( 'pll_get_post', $data->get_product_ids() ), array( false ) ) );
				$data->set_excluded_product_ids( array_diff( array_map( 'pll_get_post', $data->get_excluded_product_ids() ), array( false ) ) );
				$data->set_product_categories( array_diff( array_map( 'pll_get_term', $data->get_product_categories() ), array( false ) ) );
				$data->set_excluded_product_categories( array_diff( array_map( 'pll_get_term', $data->get_excluded_product_categories() ), array( false ) ) );
			}
		}
	}
}
