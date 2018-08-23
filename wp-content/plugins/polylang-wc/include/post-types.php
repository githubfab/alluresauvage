<?php

/**
 * Fixes how post types and taxonomies are registered
 * Manages post types and taxonomies translations and synchronization
 *
 * @since 0.1
 */
class PLLWC_Post_Types {
	protected $permalinks; // WooCommerce permalinks option

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {
		$this->permalinks = get_option( 'woocommerce_permalinks' );

		add_filter( 'woocommerce_taxonomy_args_product_cat', array( $this, 'woocommerce_taxonomy_args_product_cat' ) );
		add_filter( 'woocommerce_taxonomy_args_product_tag', array( $this, 'woocommerce_taxonomy_args_product_tag' ) );
		add_filter( 'woocommerce_register_post_type_product', array( $this, 'woocommerce_register_post_type_product' ) );

		add_filter( 'pll_get_taxonomies', array( $this, 'translate_taxonomies' ), 10, 2 );
		add_filter( 'pll_copy_taxonomies', array( $this, 'copy_taxonomies' ), 10, 2 );
		add_filter( 'pll_get_post_types', array( $this, 'translate_types' ), 10, 2 );

		add_filter( 'woocommerce_variable_children_args', array( $this, 'variable_children_args' ) );
	}

	/**
	 * Disables the translation of the product category slug handled by WooCommerce as it does not play nice in multilingual context
	 *
	 * @since 0.1
	 *
	 * @param array $args arguments used to register the taxonomy
	 * @return array
	 */
	public function woocommerce_taxonomy_args_product_cat( $args ) {
		$args['rewrite']['slug'] = empty( $this->permalinks['category_base'] ) ? 'product-category' : $this->permalinks['category_base'];
		return $args;
	}

	/**
	 * Disables the translation of the product tag slug handled by WooCommerce as it does not play nice in multilingual context
	 *
	 * @since 0.1
	 *
	 * @param array $args arguments used to register the taxonomy
	 * @return array
	 */
	public function woocommerce_taxonomy_args_product_tag( $args ) {
		$args['rewrite']['slug'] = empty( $this->permalinks['tag_base'] ) ? 'product-tag' : $this->permalinks['tag_base'];
		return $args;
	}

	/**
	 * Disables the translation of the product slug handled by WooCommerce as it does not play nice in multilingual context
	 *
	 * @since 0.1
	 *
	 * @param array $args arguments used to register the post type
	 * @return array
	 */
	public function woocommerce_register_post_type_product( $args ) {
		$product_permalink = empty( $this->permalinks['product_base'] ) ? 'product' : $this->permalinks['product_base'];
		$args['rewrite'] = $product_permalink ? array( 'slug' => untrailingslashit( $product_permalink ), 'with_front' => false, 'feeds' => true ) : false;
		return $args;
	}

	/**
	 * Get taxonomies for which Polylang manages language and translations
	 *
	 * @since 0.1
	 *
	 * @return array list of taxonomy names
	 */
	static protected function get_translated_taxonomies() {
		// Attribute taxonomies
		$woo_taxonomies = wp_list_pluck( wc_get_attribute_taxonomies(), 'attribute_name' );
		foreach ( $woo_taxonomies as $key => $tax ) {
			$woo_taxonomies[ $key ] = 'pa_' . $tax;
		}

		// Add woocommerce core taxonomies to translate
		return array_merge( array( 'product_cat', 'product_tag' ), $woo_taxonomies );
	}

	/**
	 * Language and translation management for custom taxonomies
	 * All are hidden from Polylang settings
	 *
	 * @since 0.1
	 *
	 * @param array $taxonomies list of taxonomy names for which Polylang manages language and translations
	 * @param bool  $hide       true when displaying the list in Polylang settings
	 * @return array list of taxonomy names for which Polylang manages language and translations
	 */
	public function translate_taxonomies( $taxonomies, $hide ) {
		unset( $taxonomies['product_shipping_class'] ); // Untranslated but hidden from Polylang Settings
		return $hide ? array_diff( $taxonomies, self::get_translated_taxonomies() ) : array_merge( $taxonomies, self::get_translated_taxonomies() );
	}

	/**
	 * Adds taxonomies to the list of taxonomies to copy when creating a new translation
	 *
	 * @since 0.1
	 *
	 * @param array $taxonomies the list of taxonomies to copy or synchronize
	 * @param bool  $sync       true for sync, false for copy
	 * @return array the list of taxonomies to copy or synchronize
	 */
	public function copy_taxonomies( $taxonomies, $sync ) {
		return array_merge( $taxonomies, array( 'product_type', 'product_shipping_class', 'product_visibility' ), self::get_translated_taxonomies() );
	}

	/**
	 * Language and translation management for custom post types
	 *
	 * @since 0.1
	 *
	 * @param array $types list of post type names for which Polylang manages language and translations
	 * @param bool  $hide  true when displaying the list in Polylang settings
	 * @return array list of post type names for which Polylang manages language and translations
	 */
	public function translate_types( $types, $hide ) {
		$woo_types = array( 'product', 'product_variation', 'shop_order' );
		return $hide ? array_diff( $types, $woo_types ) : array_merge( $types, $woo_types );
	}

	/**
	 * Filter args used to get variable products children, to make sure that they are not filtered by the current language
	 *
	 * @since 0.7.3
	 *
	 * @param array $args Query arguments
	 * @return array
	 */
	public function variable_children_args( $args ) {
		$args['lang'] = '';
		return $args;
	}
}
