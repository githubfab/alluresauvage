<?php

/**
 * A class to export languages and translations of products in CSV files
 *
 * @since 0.8
 */
class PLLWC_Export {

	/**
	 * Constructor
	 *
	 * @since 0.8
	 */
	public function __construct() {
		add_filter( 'woocommerce_product_export_product_default_columns', array( $this, 'default_columns' ) );
		add_filter( 'woocommerce_product_export_row_data', array( $this, 'row_data' ), 10, 2 );
	}

	/**
	 * Add language and translation group to default columns
	 *
	 * @since 0.8
	 *
	 * @param array $columns
	 * @return array
	 */
	public function default_columns( $columns ) {
		return array_merge( $columns, array(
			'language'     => __( 'Language', 'polylang' ),
			'translations' => __( 'Translation group', 'polylang-wc' ),
		) );
	}

	/**
	 * Export the product language and translation group
	 *
	 * @since 0.8
	 *
	 * @param array  $row     Data exported in a CSV row
	 * @param object $product Product
	 * @return array
	 */
	public function row_data( $row, $product ) {
		if ( isset( $row['language'] ) ) {
			$row['language'] = pll_get_post_language( $product->get_id() );
		}

		if ( isset( $row['translations'] ) ) {
			$term = PLL()->model->post->get_object_term( $product->get_id(), 'post_translations' );
			if ( ! empty( $term ) ) {
				$row['translations'] = $term->name;
			}
		}
		return $row;
	}
}
