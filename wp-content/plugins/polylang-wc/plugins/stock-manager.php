<?php

/**
 * Manages compatibility with:
 * WooCommerce Stock Manager, version tested: 1.1.6
 * WooCommerce Bulk Stock Management, version tested: 2.2.9
 *
 * @since 0.5
 */
class PLLWC_Stock_Manager {

	/**
	 * Constructor
	 *
	 * @since 0.5
	 */
	public function __construct() {
		add_action( 'parse_query', array( $this, 'parse_query' ), 20 );
		add_action( 'update_post_meta', array( $this, 'update_post_metadata' ), 10, 4 );
	}

	/**
	 * Returns true if the query is filtered by a language
	 * Or includes a translated taxonomy
	 *
	 * @since 0.9
	 *
	 * @param object $qvars Query vars
	 * @return bool
	 */
	public function is_language_in_query( $qvars ) {
		if ( isset( $qvars['tax_query'] ) ) {
			foreach ( $qvars['tax_query'] as $tax_query ) {
				if ( isset( $tax_query['taxonomy'] ) && ( 'language' === $tax_query['taxonomy'] || pll_is_translated_taxonomy( $tax_query['taxonomy'] ) ) ) {
					return true;
				}
			}
		}

		if ( ! empty( $qvars['lang'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns true if the query includes the product post type
	 *
	 * @since 0.9
	 *
	 * @param object $qvars Query vars
	 * @return bool
	 */
	public function is_product_in_query( $qvars ) {
		$product_types = array( 'product', 'product_variation' );
		return isset( $qvars['post_type'] ) && ( in_array( $qvars['post_type'], $product_types ) || ( is_array( $qvars['post_type'] ) && array_intersect( $qvars['post_type'], $product_types ) ) );
	}

	/**
	 * Make sure that products are displayed in only one language (even when the admin languages filter requests all languages)
	 * to avoid conflicts if inconsistent information would be given for products translations
	 *
	 * @since 0.3.2
	 *
	 * @param object $query
	 */
	public function parse_query( $query ) {
		$qvars = $query->query_vars;

		if ( ! $this->is_language_in_query( $qvars ) && $this->is_product_in_query( $qvars ) ) {
			$query->query_vars['lang'] = PLLWC_Admin::get_preferred_language();
		}
	}

	/**
	 * Synchronize custom fields across translations on the WooCommerce Stock Manager page
	 *
	 * @since 0.3.2
	 *
	 * @param null  $null
	 * @param int   $object_id
	 * @param int   $key
	 * @param array $value
	 * @return null
	 */
	public function update_post_metadata( $null, $object_id, $key, $value ) {
		static $avoid_recursion = false;

		if ( $avoid_recursion ) {
			return $null;
		}

		$avoid_recursion = true;

		$to_copy = array(
			'_manage_stock',
			'_stock_status',
			'_backorders',
			'_stock',
			'_weight',
			'_regular_price',
			'_sale_price',
			'_sale_price_dates_from',
			'_sale_price_dates_to',
			'_price',
		);

		foreach ( pll_languages_list() as $lang ) {
			$to = pll_get_post( $object_id, $lang );
			if ( $to != $object_id ) {
				update_post_meta( $to, $key, $value );
			}
		}

		$avoid_recursion = false;
		return $null;
	}
}
