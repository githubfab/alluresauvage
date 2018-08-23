<?php

/**
 * A class to filter the REST API
 * Needs Polylang Pro 2.2.1 or later
 * Tested with the API v2 only ( WC 3.0 or later )
 *
 * @since 0.9
 */
class PLLWC_REST_API {

	/**
	 * Constructor
	 * Setups actions and filters
	 *
	 * @since 0.9
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'init' ), 20 ); // After Polylang
		add_filter( 'pll_rest_api_post_types', array( $this, 'post_types' ) );
		add_filter( 'pll_rest_api_taxonomies', array( $this, 'taxonomies' ) );
	}

	/**
	 * Init filters after Polylang REST API has been initialized
	 *
	 * @since 0.9
	 */
	public function init() {
		// Products and orders
		// No need to filter product variations
		add_filter( 'woocommerce_rest_shop_order_object_query', array( PLL()->rest_api->post, 'query' ), 10, 2 );
		add_filter( 'woocommerce_rest_product_object_query', array( PLL()->rest_api->post, 'query' ), 10, 2 );

		add_filter( 'woocommerce_rest_product_cat_query', array( PLL()->rest_api->term, 'query' ), 10, 2 );
		add_filter( 'woocommerce_rest_product_tag_query', array( PLL()->rest_api->term, 'query' ), 10, 2 );

		foreach ( wc_get_attribute_taxonomy_names() as $attribute ) {
			add_filter( "woocommerce_rest_{$attribute}_query", array( PLL()->rest_api->term, 'query' ), 10, 2 );
		}
	}

	/**
	 * Removes translations from the response when querying orders
	 *
	 * @since 0.9
	 *
	 * @param array $args
	 * @return array
	 */
	public function post_types( $args ) {
		$args['shop_order']['translations'] = false;
		return $args;
	}

	/**
	 * Adds language and translations in the response when querying product attributes terms
	 *
	 * @since 0.9
	 *
	 * @param array $args
	 * @return array
	 */
	public function taxonomies( $args ) {
		$args['product_attribute_term']['filters'] = false;
		return $args;
	}
}
