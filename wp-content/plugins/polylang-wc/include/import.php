<?php

/**
 * A class to import languages and translations of products from CSV files
 *
 * @since 0.8
 */
class PLLWC_Import {

	/**
	 * Constructor
	 *
	 * @since 0.8
	 */
	public function __construct() {
		add_filter( 'woocommerce_csv_product_import_mapping_default_columns', array( $this, 'default_columns' ) );
		add_filter( 'woocommerce_csv_product_import_mapping_options', array( $this, 'mapping_options' ), 1 );
		add_action( 'woocommerce_product_import_inserted_product_object', array( $this, 'inserted_product_object' ), 10, 2 );

		add_action( 'woocommerce_product_importer_before_set_parsed_data', array( $this, 'before_set_parsed_data' ), 10, 2 );
		add_action( 'woocommerce_product_import_before_import', array( $this, 'set_language' ) );
		add_action( 'woocommerce_product_import_before_process_item', array( $this, 'set_language' ) );
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
			__( 'Language', 'polylang' )             => 'language',
			__( 'Translation group', 'polylang-wc' ) => 'translations',
		) );
	}

	/**
	 * Add language and translation group to mapping options
	 * Between "Description" and "Date sale price starts"
	 *
	 * @since 0.8
	 *
	 * @param array $options
	 * @return array
	 */
	public function mapping_options( $options ) {
		if ( $n = array_search( 'price', array_keys( $options ) ) ) {
			$end = array_slice( $options, $n );
			$options = array_slice( $options, 0, $n );
		}

		$options = array_merge( $options, array(
			'language'     => __( 'Language', 'polylang' ),
			'translations' => __( 'Translation group', 'polylang-wc' ),
		) );

		return isset( $end ) ? array_merge( $options, $end ) : $options;
	}

	/**
	 * Import language and translation group
	 *
	 * @since 0.8
	 *
	 * @param object $object Product object
	 * @param array  $data   Data in a row of the CSV file
	 */
	public function inserted_product_object( $object, $data ) {
		$id = $object->get_id();

		if ( isset( $data['language'] ) && $language = PLL()->model->get_language( $data['language'] ) ) {
			if ( isset( $data['translations'] ) ) {
				$this->set_translation_group( $id, $data );
			}

			// Shared slug
			if ( ! empty( $data['name'] ) ) {
				$object->set_slug( $data['name'] ); // WooCommerce keeps the slug empty in the product object
				$object->save();
			}

			// Taxonomies
			$this->fix_taxonomies_language( $id, $language );
		}
	}

	/**
	 * Assigns translations group
	 *
	 * @since 0.8
	 *
	 * @param int   $id   Product id
	 * @param array $data Data in a row of the CSV file
	 */
	public function set_translation_group( $id, $data ) {
		$taxonomy = 'post_translations';
		$group = $data['translations'];
		$term = get_term_by( 'name', $group, $taxonomy );

		if ( empty( $term ) ) {
			$translations[ $data['language'] ] = $id;
			$term = wp_insert_term( $group, $taxonomy, array( 'description' => serialize( $translations ) ) );
			if ( ! is_wp_error( $term ) ) {
				wp_set_object_terms( $id, $term['term_id'], $taxonomy );
			}
		} else {
			$translations = unserialize( $term->description );
			$translations[ $data['language'] ] = $id;
			pll_save_post_translations( $translations );
		}
	}

	/**
	 * Check if the product taxonomies are in the correct language
	 * Fix them if it's not the case
	 * FIXME: This is almost the exact copy of the end of the code of PLL_Admin_Filters_Post::save_language()
	 *
	 * @since 0.8
	 *
	 * @param int    $post_id
	 * @param object $language
	 */
	public function fix_taxonomies_language( $post_id, $language ) {
		foreach ( PLL()->model->get_translated_taxonomies() as $tax ) {
			$terms = get_the_terms( $post_id, $tax );

			if ( is_array( $terms ) ) {
				$newterms = array();
				foreach ( $terms as $term ) {
					// Check if the term is in the correct language or if a translation exist ( mainly for default category )
					if ( $newterm = PLL()->model->term->get( $term->term_id, $language ) ) {
						$newterms[] = (int) $newterm;
					}

					// Or choose the correct language for tags ( initially defined by name )
					elseif ( $newterm = PLL()->model->term_exists( $term->name, $tax, $term->parent, $language ) ) {
						$newterms[] = (int) $newterm; // Cast is important otherwise we get 'numeric' tags
					}

					else {
						// Worst hack ever, for shared slug
						$_POST['term_lang_choice'] = $language->slug;
						$_REQUEST['_pll_nonce'] = wp_create_nonce( 'pll_language' );

						// Update language (and slug if shared slug is active)
						$slug = sanitize_title( $term->name );
						if ( $term->slug !== $slug && pll_get_term( $term->term_id ) !== $language->slug ) {
							pll_set_term_language( $term->term_id, $language->slug );
							wp_update_term( $term->term_id, $tax, array( 'slug' => $slug ) );
							$newterms[] = $term->term_id;
						}

						// Or create the term in the correct language
						elseif ( ! is_wp_error( $term_info = wp_insert_term( $term->name, $tax ) ) ) {
							$newterms[] = (int) $term_info['term_id'];
						}
					}
				}

				wp_set_object_terms( $post_id, $newterms, $tax );
			}
		}
	}

	/**
	 * Setups filters for the import ( first action used during the import )
	 * Sets the preferred language when parsing data for terms to be created in the right language
	 *
	 * @since 0.8
	 *
	 * @param array $row         Row values
	 * @param array $mapped_keys Mapped keys
	 */
	public function before_set_parsed_data( $row, $mapped_keys ) {
		// Add filters which must be used only during the import
		add_filter( 'get_terms_args', array( $this, 'get_terms_args' ), 5 ); // Before Polylang
		add_filter( 'pllwc_copy_post_metas', array( $this, 'copy_post_metas' ) );
		add_filter( 'woocommerce_get_product_id_by_sku', array( $this, 'get_product_id_by_sku' ), 10, 2 );
		add_filter( 'pllwc_language_for_unique_sku', array( $this, 'language_for_unique_sku' ) );

		add_filter( 'pllwc_copy_post_metas', '__return_empty_array', 999 ); // Avoids _children, _crosssell_ids, etc.. to be wrongly overwritten.
		add_filter( 'pll_copy_taxonomies', '__return_empty_array', 999 ); // Avoids mess when attributes terms are assigned.

		// Preferred language for terms
		$col = array_search( 'language', $mapped_keys );
		if ( ! empty( $col ) && ! empty( $row[ $col ] ) && $language = PLL()->model->get_language( $row[ $col ] ) ) {
			PLL()->pref_lang = $language;
		}
	}

	/**
	 * Saves the language of the current item being imported for future use
	 *
	 * @since 0.8
	 *
	 * @param array $data Data in a row of the CSV file
	 */
	public function set_language( $data ) {
		if ( isset( $data['language'] ) && $language = PLL()->model->get_language( $data['language'] ) ) {
			PLL()->pref_lang = $language;
		}
	}

	/**
	 * Filters get_terms according to the language of the current item
	 * This allows get_term_by (slug or name) to return the term in the correct language.
	 *
	 * @since 0.8
	 *
	 * @param array $args
	 * @return array
	 */
	public function get_terms_args( $args ) {
		if ( ! empty( PLL()->pref_lang ) ) {
			$args['lang'] = PLL()->pref_lang->slug;
		}
		return $args;
	}

	/**
	 * Stop synchronizing the product attributes during the import
	 * as it causes is_variation to be set to 0 for all products but one
	 *
	 * @since 0.8
	 *
	 * @param array $to_copy Custom fields to copy
	 * @return array
	 */
	public function copy_post_metas( $to_copy ) {
		unset( $to_copy['_product_attributes'] );
		return $to_copy;
	}

	/**
	 * When searching a product id by sku, returns the product id in the current language
	 *
	 * @since 0.9
	 *
	 * @param int    $product_id
	 * @param string $sku
	 * @return int
	 */
	public function get_product_id_by_sku( $product_id, $sku ) {
		global $wpdb;

		if ( $sku && ! empty( PLL()->pref_lang ) ) {
			$sql  = "SELECT posts.ID FROM {$wpdb->posts} AS posts";
			$sql .= " LEFT JOIN {$wpdb->postmeta} AS postmeta ON ( posts.ID = postmeta.post_id )";
			$sql .= PLL()->model->post->join_clause( 'posts' );
			$sql .= " WHERE posts.post_type IN ( 'product', 'product_variation' )";
			$sql .= PLL()->model->post->where_clause( PLL()->pref_lang );
			$sql .= " AND posts.post_status != 'trash'";
			$sql .= " AND postmeta.meta_key = '_sku'";
			$sql .= $wpdb->prepare( ' AND postmeta.meta_value = %s LIMIT 1', $sku );

			$product_id = $wpdb->get_var( $sql ); // WPCS: unprepared SQL ok.
		}

		return $product_id;
	}

	/**
	 * Returns the language to use when searching if a sku is unique
	 *
	 * @since 0.9
	 *
	 * @return object PLL_Language object
	 */
	public function language_for_unique_sku() {
		return PLL()->pref_lang;
	}
}
