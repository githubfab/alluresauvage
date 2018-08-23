<?php

/**
 * Manages the synchronization of the stock between translations of the same product
 *
 * @since 0.1
 */
class PLLWC_Stock {

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {
		add_action( 'woocommerce_product_set_stock', array( $this, 'set_stock' ) );
		add_action( 'woocommerce_variation_set_stock', array( $this, 'set_stock' ) );
	}

	/**
	 * Synchronize stock across produc translations
	 *
	 * @since 0.9
	 *
	 * @param object $product
	 */
	public function set_stock( $product ) {
		static $avoid_recursion = array();

		$id = $product->get_id();
		$qty = $product->get_stock_quantity();

		// To avoid recursiion, we make sure that the couple product id + stock quantity is set only once.
		if ( empty( $avoid_recursion[ $id ][ $qty ] ) ) {
			$tr_ids = pll_get_post_translations( $id );

			foreach ( $tr_ids as $tr_id ) {
				if ( $tr_id !== $id ) {
					$avoid_recursion[ $id ][ $qty ] = true;
					wc_update_product_stock( $tr_id, $qty );
				}
			}
		}
	}
}
