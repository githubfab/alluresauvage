<?php

/**
 * Manages the products on admin side (interface and synchronization of data)
 *
 * @since 0.1
 */
class PLLWC_Admin_Products {

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {
		// Whole product
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 5, 2 );
		add_action( 'pll_save_post', array( $this, 'pll_save_post' ), 20, 3 ); // After PLL_Admin_Sync

		// Attributes
		add_filter( 'pll_copy_post_metas', array( $this, 'pll_copy_post_metas' ) );
		add_filter( 'update_post_metadata', array( $this, 'update_post_metadata' ), 10, 4 );
		add_filter( 'terms_clauses', array( $this, 'terms_clauses' ), 10, 3 ); // FIXME backward compatibility with Polylang < 2.0

		// Variations
		add_action( 'woocommerce_ajax_save_product_variations', array( $this, 'save_product_variations' ), 20 );
		add_action( 'woocommerce_save_product_variation', array( $this, 'save_product_variation' ), 20 ); // After WooCommerce Price Based on Country
		add_action( 'before_delete_post', array( $this, 'delete_post' ) );
		if ( version_compare( WC()->version, '2.7', '<' ) ) {
			// FIXME backward compatibility with WC < 2.7
			add_action( 'woocommerce_variable_product_sync', array( $this, 'variable_product_sync' ), 20 );
		} else {
			add_action( 'woocommerce_variable_product_sync_data', array( $this, 'variable_product_sync' ), 20 );
		}

		// Ajax
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_ajax_product_lang_choice', array( $this, 'product_lang_choice' ) );

		// Autocomplete ajax products search
		add_filter( 'woocommerce_json_search_found_products', array( $this, 'search_found_products' ) );
		add_filter( 'woocommerce_json_search_found_grouped_products', array( $this, 'search_found_products' ) );

		// Feature product column in products list
		add_action( 'wp_ajax_woocommerce_feature_product', array( $this, 'feature_product' ), 5 ); // Before WooCommerce which exits

		// Duplicate product
		add_filter( 'woocommerce_duplicate_product_exclude_children', '__return_true' );
		add_action( 'admin_action_duplicate_product', array( $this, 'duplicate_product_action' ), 5 ); // Before WooCommerce
		if ( version_compare( WC()->version, '2.7', '<' ) ) {
			// FIXME backward compatibility with WC < 2.7
			add_filter( 'woocommerce_duplicate_product_exclude_taxonomies', array( $this, 'duplicate_product_exclude_taxonomies' ) );
			add_action( 'woocommerce_duplicate_product', array( $this, 'duplicate_product' ), 10, 2 );
		} else {
			add_action( 'woocommerce_product_duplicate', array( $this, 'product_duplicate' ), 10, 2 );
		}

		// Unique SKU
		add_filter( 'wc_product_has_unique_sku', array( $this, 'unique_sku' ), 10, 3 );

		// Don't apply German and Danish specific sanitization for product attributes titles
		$specific_locales = array( 'da_DK', 'de_DE', 'de_DE_formal', 'de_CH', 'de_CH_informal' );
		if ( array_intersect( PLL()->model->get_languages_list( array( 'fields' => 'locale' ) ), $specific_locales ) ) {
			add_action( 'wp_ajax_woocommerce_load_variations', array( $this, 'remove_sanitize_title' ), 5 );
			add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'remove_sanitize_title' ), 5 );
			add_action( 'woocommerce_product_data_panels', array( $this, 'add_sanitize_title' ), 5 );
		}
	}

	/**
	 * Copy variations and metas when using "Add new" ( translation )
	 *
	 * @since 0.1
	 *
	 * @param string $post_type unused
	 * @param object $post      current post object
	 */
	public function add_meta_boxes( $post_type, $post ) {
		if ( 'post-new.php' === $GLOBALS['pagenow'] && isset( $_GET['from_post'], $_GET['new_lang'] ) && 'product' === $post_type ) {
			// Capability check already done in post-new.php
			$lang = PLL()->model->get_language( $_GET['new_lang'] ); // Make sure we have a valid language
			$this->copy_post_metas( (int) $_GET['from_post'], $post->ID, $lang->slug );
			$this->copy_variations( (int) $_GET['from_post'], $post->ID, $lang->slug );

			/**
			 * Fires after metas and variations have been copied from a product to a translation
			 *
			 * @since 0.5
			 *
			 * @param int    $from Original product ID
			 * @param int    $to   Target product ID
			 * @param string $lang Language of the target product
			 * @param bool   $sync true when synchronizing products, empty when creating a new translation
			 */
			do_action( 'pllwc_copy_product', (int) $_GET['from_post'], $post->ID, $lang->slug );
		}
	}

	/**
	 * Synchronizes variations and metas in translations
	 *
	 * @since 0.1
	 *
	 * @param int    $post_id      post id
	 * @param object $post         post object
	 * @param array  $translations post translations
	 */
	public function pll_save_post( $post_id, $post, $translations ) {
		global $wpdb;

		if ( 'product' === $post->post_type ) {
			$parent_id = wp_get_post_parent_id( $post_id );

			foreach ( $translations as $lang => $tr_id ) {
				if ( $tr_id ) {
					// Synchronize Grouping
					// FIXME Backward compatibility with WC < 2.7
					$tr_parent_id = $parent_id ? pll_get_post( $parent_id, $lang ) : 0;
					if ( wp_get_post_parent_id( $tr_id ) != $tr_parent_id ) {
						$wpdb->update( $wpdb->posts, array( 'post_parent' => $tr_parent_id ), array( 'ID' => $tr_id ) );
						clean_post_cache( $tr_id );
					}

					// Synchronize terms and metas in translations
					$this->copy_post_metas( $post_id, $tr_id, $lang, true );
					$this->copy_variations( $post_id, $tr_id, $lang, true );

					/** This action is documented in admin/admin-products.php */
					do_action( 'pllwc_copy_product', $post_id, $tr_id, $lang, true );
				}
			}
		}
	}

	/**
	 * Unsynchronize attributes custom fields.
	 * This is needed as WC stores them as public metas and thus they can be synchronized
	 * by Polylang when the custom fields synchronization option is activated.
	 *
	 * @since 0.9
	 *
	 * @param array $metas List of custom fields to synchronize
	 * @return array
	 */
	public function pll_copy_post_metas( $metas ) {
		foreach ( $metas as $k => $meta ) {
			if ( 0 === strpos( $meta, 'attribute_' ) ) {
				unset( $metas[ $k ] );
			}
		}
		return $metas;
	}

	/**
	 * Synchronizes attributes when saved in ajax
	 *
	 * @since 0.1
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

		if ( doing_action( 'wp_ajax_woocommerce_save_attributes' ) && '_product_attributes' === $key ) {
			// Security checks already done by WooCommerce in WC_AJAX::save_attributes()
			$translations = PLL()->model->post->get_translations( $object_id );

			foreach ( $translations as $lang => $to ) {
				if ( $to === $object_id ) {
					continue;
				}

				$tr_attributes = maybe_unserialize( get_post_meta( $to, '_product_attributes', true ) );

				// First synchronize deleted taxonomy attributes
				if ( is_array( $tr_attributes ) ) {
					foreach ( array_diff_key( $tr_attributes, $value ) as $key => $attribute ) {
						if ( $attribute['is_taxonomy'] ) {
							wp_set_object_terms( $to, array(), $attribute['name'] );
						}
					}
				}

				$tr_attributes = array(); // Reset the target _product_attributes meta

				// Sync taxonomy attributes
				foreach ( $value as $key => $attribute ) {
					if ( ! $attribute['is_taxonomy'] ) {
						$tr_attributes[ $key ] = $attribute;
					}

					$terms = get_the_terms( $object_id, $attribute['name'] );

					$newterms = array();
					if ( is_array( $terms ) ) {
						foreach ( $terms as $term ) {
							if ( $term_id = pll_get_term( $term->term_id, $lang ) ) {
								$newterms[] = (int) $term_id; // Cast is important otherwise we get 'numeric' tags
							}
						}
					}

					// For some reasons, the user may have untranslated terms in the translation. don't forget them.
					$tr_terms = get_the_terms( $to, $attribute['name'] );
					if ( is_array( $tr_terms ) ) {
						foreach ( $tr_terms as $term ) {
							if ( ! pll_get_term( $term->term_id, pll_get_post_language( $object_id ) ) ) {
								$newterms[] = (int) $term->term_id;
							}
						}
					}
					wp_set_object_terms( $to, $newterms, $attribute['name'] ); // Replace terms in translation
					$tr_attributes[ $key ] = $attribute;
				}

				// Finally update meta (we did not sync non taxonomy attributes)
				update_post_meta( $to, '_product_attributes', $tr_attributes );
			}
		}

		$avoid_recursion = false;
		return $null;
	}

	/**
	 * Filters attributes taxonomy terms by language
	 * when displaying the select box in ajax
	 *
	 * @since 0.1
	 *
	 * @param array $clauses    list of sql clauses
	 * @param array $taxonomies list of taxonomies
	 * @param array $args       get_terms arguments
	 * @return array modified sql clauses
	 */
	public function terms_clauses( $clauses, $taxonomies, $args ) {
		if ( doing_action( 'wp_ajax_woocommerce_add_attribute' ) ) {
			// Security checks already done by WooCommerce in WC_AJAX::add_attribute()
			$lang = PLL()->model->post->get_language( (int) $_POST['pll_post_id'] );
			return PLL()->model->terms_clauses( $clauses, $lang );
		}

		return $clauses;
	}

	/**
	 * Copy / Synchronize Variations Default Form Values
	 *
	 * @since 0.6
	 *
	 * @param int    $to    Id of variable product destination
	 * @param string $lang  Language slug
	 * @param array  $value Value to copy / synchronize
	 */
	protected function copy_default_attributes( $to, $lang, $value ) {
		$to_value = array();
		foreach ( $value as $k => $v ) {
			if ( taxonomy_exists( $k ) ) {
				$terms = get_terms( $k, array( 'slug' => $v, 'lang' => '' ) ); // Don't use get_term_by filtered by language since WP 4.7
				if ( is_array( $terms ) && ( $term = reset( $terms ) ) && $tr_id = pll_get_term( $term->term_id, $lang ) ) {
					$term = get_term( $tr_id, $k );
					$to_value[ $k ] = $term->slug;
				}
			} else {
				$to_value[ $k ] = $v;
			}
		}
		update_post_meta( $to, '_default_attributes', $to_value );
	}

	/**
	 * Synchronize Variations Default Form Values when saved in ajax
	 *
	 * @since 0.6
	 *
	 * @param int $id Variable product id
	 */
	public function save_product_variations( $id ) {
		$value = (array) maybe_unserialize( get_post_meta( $id, '_default_attributes', true ) );
		foreach ( PLL()->model->post->get_translations( $id ) as $lang => $tr_id ) {
			if ( $id !== $tr_id ) {
				$this->copy_default_attributes( $tr_id, $lang, $value );
			}
		}
	}

	/**
	 * Generates the title of a translated variation
	 *
	 * @since 0.7
	 *
	 * @param array $post      Original variation post
	 * @param int   $parent_id Post ID of the translated parent product
	 * @param int   $lang      Language of the variation translation
	 */
	protected function generate_translated_variation_title( $post, $parent_id, $lang ) {
		// FIXME Backward compatibility with WC < 2.7
		if ( version_compare( WC()->version, '2.7', '<' ) ) {
			return $post['post_title'] . ' ' . $lang; // Just a unique name, not displayed in WC < 2.7
		} else {
			// Since WC 2.7, the variation title is displayed and includes attributes names
			$product = wc_get_product( $post['ID'] );
			$attributes = $product->get_attributes();
			foreach ( $attributes as $tax => $value ) {
				if ( taxonomy_exists( $tax ) && $value ) {
					$terms = get_terms( $tax, array( 'slug' => $value, 'lang' => '' ) ); // Don't use get_term_by filtered by language since WP 4.7
					if ( is_array( $terms ) && ( $term = reset( $terms ) ) && $tr_id = pll_get_term( $term->term_id, $lang ) ) {
						$term = get_term( $tr_id, $tax );
						$attributes[ $tax ] = $term->slug;
					}
				}
			}

			$product->set_attributes( $attributes );

			// Determine whether to include attribute names through counting the number of one-word attribute values.
			// See WC_Product_Variation_Data_Store_CPT::generate_product_title()
			$include_attribute_names = false;
			$one_word_attributes = 0;
			foreach ( $attributes as $name => $value ) {
				if ( false === strpos( $value, '-' ) ) {
					++$one_word_attributes;
				}
				if ( $one_word_attributes > 1 ) {
					$include_attribute_names = true;
					break;
				}
			}

			$title = get_post( $parent_id )->post_title;
			return $title . ' &ndash; ' . wc_get_formatted_variation( $product, true, $include_attribute_names );
		}
	}

	/**
	 * Set language and synchronizes variations when saved in ajax
	 *
	 * @since 0.1
	 *
	 * @param int $id variation id
	 */
	public function save_product_variation( $id ) {
		global $wpdb;

		// Save the language
		$post = get_post( $id, ARRAY_A );
		$language = pll_get_post_language( $post['post_parent'] );
		pll_set_post_language( $id, $language );

		$translations = PLL()->model->post->get_translations( $id );
		$translations[ $language ] = $id;

		if ( 2 > count( $translations ) ) {
			$parent_translations = PLL()->model->post->get_translations( $post['post_parent'] );
			if ( 2 > count( $parent_translations ) ) {
				return; // The product is not yet translated
			}

			// We just created a new variation
			foreach ( $parent_translations as $lang => $parent_id ) {
				if ( $parent_id !== $post['post_parent'] ) {
					$tr_post = $post;
					$tr_post['title'] = $this->generate_translated_variation_title( $post, $parent_id, $lang );
					$tr_post['post_parent'] = $parent_id;
					$tr_post['ID'] = null;
					$translations[ $lang ] = wp_insert_post( $tr_post );
					pll_set_post_language( $translations[ $lang ], $lang );
				}
			}

			pll_save_post_translations( $translations );
		}

		foreach ( $translations as $lang => $tr_id ) {
			if ( $tr_id !== $id ) {
				// Checkbox "enabled"
				// Don't use wp_update_post as it would fire the action pll_save_post and cause reverse sync
				$wpdb->update( $wpdb->posts, array( 'post_status' => $post['post_status'] ), array( 'ID' => $tr_id ) );
				$this->copy_post_metas( $id, $tr_id, $lang, true );

				// Shipping class
				if ( isset( PLL()->sync->taxonomies ) ) {
					PLL()->sync->taxonomies->copy( $id, $tr_id, $lang, true );
				} else {
					// Backward compatibility with Polylang < 2.3
					PLL()->sync->copy_taxonomies( $id, $tr_id, $lang, true );
				}
			}
		}
	}

	/**
	 * Synchronizes variations deletion
	 *
	 * @since 0.1
	 *
	 * @param int $post_id
	 */
	public function delete_post( $post_id ) {
		static $avoid_delete = array();
		static $avoid_parent = 0;
		$post_type = get_post_type( $post_id );

		// Avoid deleting translated variations when deleting a product
		if ( 'product' === $post_type ) {
			$avoid_parent = $post_id;
		}

		if ( 'product_variation' === $post_type && ! in_array( $post_id, $avoid_delete ) ) {
			$post = get_post( $post_id );
			if ( $post->post_parent !== $avoid_parent ) {
				$tr_ids = PLL()->model->post->get_translations( $post_id );
				$avoid_delete = array_merge( $avoid_delete, array_values( $tr_ids ) ); // To avoid deleting a post two times
				foreach ( $tr_ids as $k => $tr_id ) {
					wp_delete_post( $tr_id );
				}
			}
		}
	}

	/**
	 * When a variable product is synchronized with its children, synchronize translations too
	 *
	 * @since 0.5
	 *
	 * @param int|object $product Product id for WC < 2.7, product object for WC2.7+
	 */
	public function variable_product_sync( $product ) {
		static $avoid_recursion = false;

		if ( $avoid_recursion ) {
			return;
		}

		$avoid_recursion = true;
		$product_id = is_numeric( $product ) ? $product : $product->get_id(); // FIXME backward compatibility with WC < 2.7

		foreach ( PLL()->model->post->get_translations( $product_id ) as $tr_id ) {
			if ( $tr_id !== $product_id ) {
				// FIXME backward compatibility with WC < 2.7
				// Use false not to save the translated variable product to avoid triggering 'save_post' and assign a wrong language
				version_compare( WC()->version, '2.7', '<' ) ? WC_Product_Variable::sync( $tr_id ) : WC_Product_Variable::sync( $tr_id, false );
			}
		}

		$avoid_recursion = false;
	}

	/**
	 * Copy or synchronize metas
	 *
	 * @since 0.1
	 *
	 * @param int    $from id of the product from which we copy informations
	 * @param int    $to   id of the product to which we paste informations
	 * @param string $lang language slug
	 * @param bool   $sync true if it is synchronization, false if it is a copy, defaults to false
	 */
	public function copy_post_metas( $from, $to, $lang, $sync = false ) {
		$metas = get_post_custom( $from );

		$to_copy = array(
			'_backorders',
			'_children',
			'_crosssell_ids',
			'_default_attributes',
			'_download_expiry',
			'_download_limit',
			'_download_type',
			'_downloadable',
			'_downloadable_files',
			'_featured',
			'_height',
			'_length',
			'_manage_stock',
			'_max_price_variation_id',
			'_max_regular_price_variation_id',
			'_max_sale_price_variation_id',
			'_max_variation_price',
			'_max_variation_regular_price',
			'_max_variation_sale_price',
			'_min_price_variation_id',
			'_min_regular_price_variation_id',
			'_min_sale_price_variation_id',
			'_min_variation_price',
			'_min_variation_regular_price',
			'_min_variation_sale_price',
			'_price',
			'_product_attributes',
			'_product_image_gallery',
			'_regular_price',
			'_sale_price',
			'_sale_price_dates_from',
			'_sale_price_dates_to',
			'_sku',
			'_sold_individually',
			'_stock',
			'_stock_status',
			'_tax_class',
			'_tax_status',
			'_thumbnail_id',
			'_upsell_ids',
			'_virtual',
			'_visibility',
			'_weight',
			'_width',
		);

		// Add attributes in variations
		foreach ( array_keys( $metas ) as $key ) {
			if ( 0 === strpos( $key, 'attribute_' ) ) {
				$to_copy[] = $key;
			}
		}

		// Copy the purchase note and variation description if the duplicate content deature is active in Polylang Pro
		if ( ! $sync ) {
			$duplicate_options = get_user_meta( get_current_user_id(), 'pll_duplicate_content', true );
			$active = ! empty( $duplicate_options ) && ! empty( $duplicate_options['product'] );
			if ( $active ) {
				$to_copy[] = '_button_text';
				$to_copy[] = '_product_url';
				$to_copy[] = '_purchase_note';
				$to_copy[] = '_variation_description';
			}
		}

		// Synchronized products since Polylang Pro 2.1
		if ( isset( PLL()->sync_post ) ) {
			if ( PLL()->sync_post->are_synchronized( $from, $to ) ) {
				$to_copy[] = '_button_text';
				$to_copy[] = '_product_url';
				$to_copy[] = '_purchase_note';
			}
			// Synchronize the variation description when parent products are synchronized
			if ( 'product_variation' === get_post_type( $from ) && PLL()->sync_post->are_synchronized( wp_get_post_parent_id( $from ), wp_get_post_parent_id( $to ) ) ) {
				$to_copy[] = '_variation_description';
			}
		}

		// Honor wpml-config.xml file ( needed for variations )
		// FIXME That's a hot fix. It may be better to fire the pll_save_post action when saving variations (todo in a major version)
		$to_copy = PLL_WPML_Config::instance()->copy_post_metas( $to_copy, $sync );

		/**
		 * Filter the custom fields to copy or synchronize
		 *
		 * @since 0.2
		 *
		 * @param array  $to_copy list of custom fields names
		 * @param bool   $sync    true if it is synchronization, false if it is a copy
		 * @param int    $from    id of the product from which we copy informations
		 * @param int    $to      id of the product to which we paste informations
		 * @param string $lang    language slug
		 */
		$to_copy = apply_filters( 'pllwc_copy_post_metas', array_combine( $to_copy, $to_copy ), $sync, $from, $to, $lang );

		// FIXME create all this meta in one unique query?
		foreach ( $metas as $key => $values ) {
			if ( in_array( $key, $to_copy ) ) {
				foreach ( $values as $value ) {
					$value = maybe_unserialize( $value );

					if ( '_thumbnail_id' === $key ) {
						// Translate a post id
						update_post_meta( $to, $key, ( $tr_value = pll_get_post( $value, $lang ) ) ? $tr_value : $value );
					}

					elseif ( '_product_image_gallery' === $key ) {
						// Translate a comma separated list of post ids
						$tr_value = array();
						foreach ( explode( ',', $value ) as $post_id ) {
							$tr_id = pll_get_post( $post_id, $lang );
							$tr_value[] = $tr_id ? $tr_id : $post_id;
						}
						update_post_meta( $to, $key, implode( ',', $tr_value ) );
					}

					elseif ( in_array( $key, array( '_upsell_ids', '_crosssell_ids', '_children' ) ) ) {
						// Translate an array of post ids
						$tr_value = array();
						foreach ( $value as $post_id ) {
							if ( $tr_id = pll_get_post( $post_id, $lang ) ) {
								$tr_value[] = $tr_id;
							}
						}
						update_post_meta( $to, $key, $tr_value );
					}

					// Translate attributes in variations
					elseif ( 0 === strpos( $key, 'attribute_' ) ) {
						$tax = substr( $key, 10 );
						if ( taxonomy_exists( $tax ) && $value ) {
							$terms = get_terms( $tax, array( 'slug' => $value, 'hide_empty' => false, 'lang' => '' ) ); // Don't use get_term_by filtered by language since WP 4.7

							if ( is_array( $terms ) && ( $term = reset( $terms ) ) && $tr_id = pll_get_term( $term->term_id, $lang ) ) {
								$term = get_term( $tr_id, $tax );
								update_post_meta( $to, $key, $term->slug );
							}
						} else {
							update_post_meta( $to, $key, $value ); // Just copy non taxonomy attributes
						}
					}

					// Translate global default attributes and copy local default attributes
					elseif ( '_default_attributes' === $key ) {
						$this->copy_default_attributes( $to, $lang, $value );
					}

					else {
						// Just copy the value
						update_post_meta( $to, $key, $value );
					}
				}
			}
		}

		// In case the product image is deleted, let's sync that.
		if ( $sync && empty( $metas['_thumbnail_id'] ) ) {
			delete_post_meta( $to, '_thumbnail_id' );
		}
	}

	/**
	 * Copy or synchronize variations
	 *
	 * @since 0.1
	 *
	 * @param int    $from id of the post from which we copy informations
	 * @param int    $to   id of the post to which we paste informations
	 * @param string $lang language slug
	 * @param bool   $sync true if it is synchronization, false if it is a copy, defaults to false
	 */
	public function copy_variations( $from, $to, $lang, $sync = false ) {
		global $wpdb;

		$variations = get_children( array(
			'post_parent' => $from,
			'post_type' => 'product_variation',
		), ARRAY_A ); // wp_insert_post wants an array

		foreach ( $variations as $post ) {
			$id = $post['ID'];
			$tr_id = pll_get_post( $id, $lang );

			if ( $tr_id ) {
				// If the translated product_variation already exists, make sure it has the right post_parent
				// And sync the post status ( checkbox "enabled" )
				// Don't use wp_update_post as it would fire the action pll_save_post and cause reverse sync
				$wpdb->update( $wpdb->posts, array( 'post_parent' => $to, 'post_status' => $post['post_status'] ), array( 'ID' => $tr_id ) );
			} else {
				// Creates the product_variation post if it does not exist yet
				$post['post_title'] = $this->generate_translated_variation_title( $post, $to, $lang );
				$post['post_parent'] = $to;
				$post['ID'] = null;
				$tr_id = wp_insert_post( $post );
				pll_set_post_language( $tr_id, $lang );

				$translations = PLL()->model->post->get_translations( $id );
				$translations[ pll_get_post_language( $id ) ] = $id; // In case this is the first translation created
				$translations[ $lang ] = $tr_id;
				pll_save_post_translations( $translations );
			}

			$this->copy_post_metas( $id, $tr_id, $lang, $sync );

			// Shipping class
			if ( isset( PLL()->sync->taxonomies ) ) {
				PLL()->sync->taxonomies->copy( $id, $tr_id, $lang, $sync );
			} else {
				// Backward compatibility with Polylang < 2.3
				PLL()->sync->copy_taxonomies( $id, $tr_id, $lang, $sync );
			}
		}
	}

	/**
	 * Setups the js script (only on the products page)
	 *
	 * @since 0.1
	 */
	public function admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ( ! empty( $screen ) && 'post' === $screen->base && 'product' === $screen->post_type ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_enqueue_script( 'pllwc_product', plugins_url( '/js/product' . $suffix . '.js', PLLWC_FILE ), 0, PLLWC_VERSION, 1 );
		}
	}

	/**
	 * Ajax response for changing the language in the product language metabox
	 *
	 * @since 0.1
	 */
	public function product_lang_choice() {
		check_ajax_referer( 'pll_language', '_pll_nonce' );

		$post_id = (int) $_POST['post_id'];
		$lang = PLL()->model->get_language( $_POST['lang'] );

		$x = new WP_Ajax_Response();

		// Attributes (taxonomies of select type)
		foreach ( wc_get_attribute_taxonomies() as $a ) {
			$taxonomy = wc_attribute_taxonomy_name( $a->attribute_name );
			if ( 'select' === $a->attribute_type && false !== $i = array_search( $taxonomy, $_POST['attributes'] ) ) {
				$all_terms = get_terms( $taxonomy, array( 'orderby' => 'name', 'hide_empty' => 0, 'lang' => $lang->slug ) );
				if ( $all_terms ) {
					$out = '';
					foreach ( $all_terms as $term ) {
						$out .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( has_term( absint( $term->term_id ), $taxonomy, $post_id ), true, false ) . '>' . $term->name . '</option>';
					}
				}

				$supplemental[ 'value-' . $i ] = $out;
			}
		}

		if ( ! empty( $supplemental ) ) {
			$x->Add( array( 'what' => 'attributes', 'supplemental' => $supplemental ) );
		}

		$x->send();
	}

	/**
	 * Filter the products per language in autocomplete ajax searches
	 *
	 * @since 0.1
	 *
	 * @param array $products array with product ids as keys and names as values
	 * @return array
	 */
	public function search_found_products( $products ) {
		// Either we are editing a product or an order
		if ( ! isset( $_REQUEST['pll_post_id'] ) || ! $lang = pll_get_post_language( (int) $_REQUEST['pll_post_id'] ) ) {
			$lang = PLLWC_Admin::get_preferred_language();
		}

		foreach ( array_keys( $products ) as $id ) {
			if ( pll_get_post_language( $id ) !== $lang ) {
				unset( $products[ $id ] );
			}
		}

		return $products;
	}

	/**
	 * Synchronizes feature product translations when done from the products list
	 *
	 * @since 0.7.1
	 */
	public function feature_product() {
		if ( current_user_can( 'edit_products' ) && check_admin_referer( 'woocommerce-feature-product' ) ) {
			$product_id = absint( $_GET['product_id'] );

			foreach ( pll_get_post_translations( $product_id ) as $tr_id ) {
				// Let WooCommerce act for the curent product being edited
				if ( $product_id !== $tr_id ) {
					// FIXME backward compatibility with WC < 2.7
					if ( version_compare( WC()->version, '2.7', '<' ) ) {
						update_post_meta( $tr_id, '_featured', get_post_meta( $tr_id, '_featured', true ) === 'yes' ? 'no' : 'yes' );
					} elseif ( $product = wc_get_product( $tr_id ) ) {
						$product->set_featured( ! $product->get_featured() );
						$product->save();
					}
				}
			}
		}
	}

	/**
	 * Removes the 'post_translations' taxonomy from duplicated product
	 * Legacy function for backward compatibility with WC < 2.7
	 *
	 * @since 0.1
	 *
	 * @param array $taxonomies
	 * return array
	 */
	public function duplicate_product_exclude_taxonomies( $taxonomies ) {
		$taxonomies[] = 'post_translations';
		return $taxonomies;
	}

	/**
	 * Fires the duplication of duplicated product translations
	 * Legacy function for backward compatibility with WC < 2.7
	 *
	 * @since 0.1
	 *
	 * @param int    $new_id post id of the duplicated product
	 * @param object $post   original product
	 */
	public function duplicate_product( $new_id, $post ) {
		// Get the original translations
		$tr_ids = pll_get_post_translations( $post->ID );
		$lang = array_search( $post->ID, $tr_ids );
		unset( $tr_ids[ $lang ] );
		$new_tr_ids[ $lang ] = $new_id;

		// A hack to get the WC anonymous object (to avoid creating a new one)
		$wc_duplicate_product = pll_get_anonymous_object_from_filter( 'admin_action_duplicate_product', array( 'WC_Admin_Duplicate_Product', 'duplicate_product_action' ) );

		// Duplicate translations
		foreach ( $tr_ids as $lang => $tr_id ) {
			$new_tr_ids[ $lang ] = $wc_duplicate_product->duplicate_product( $this->get_product_to_duplicate( $tr_id ) );

			// Fix taxonomies terms with shared slugs
			$this->duplicate_post_taxonomies( $tr_id, $new_tr_ids[ $lang ], $post->post_type );
		}

		// Link duplicated translations together
		pll_save_post_translations( $new_tr_ids );

		// Variations
		if ( $children_products = get_children( 'post_parent=' . $post->ID . '&post_type=product_variation' ) ) {
			foreach ( $children_products as $child ) {
				if ( $tr_ids = pll_get_post_translations( $child->ID ) ) {
					$new_child_tr_ids = array();
					foreach ( $tr_ids as $lang => $tr_id ) {
						$new_child_tr_ids[ $lang ] = $wc_duplicate_product->duplicate_product( $this->get_product_to_duplicate( $tr_id ), $new_tr_ids[ $lang ], $child->post_status );
					}
					pll_save_post_translations( $new_child_tr_ids );
				}
			}
		}
	}

	/**
	 * Remove taxonomy terms language check when duplicating products
	 * This is necessary because duplicate products are assigned the default language at creation.
	 *
	 * @since 0.9.3
	 */
	public function duplicate_product_action() {
		remove_action( 'set_object_terms', array( PLL()->filters_post, 'set_object_terms' ), 10, 4 );
	}

	/**
	 * Fires the duplication of duplicated product translations
	 * For WooCommerce 2.7+
	 * Obliged to copy the whole logic of WC_Admin_Duplicate_Product::product_duplicate()
	 * otherwise we can't avoid that WC creates a new sku before the language is assigned
	 * Code base: WC 3.0.5
	 * See also https://github.com/woocommerce/woocommerce/issues/13262
	 *
	 * @since 0.7
	 *
	 * @param int    $duplicate duplicated product
	 * @param object $product   original product
	 */
	public function product_duplicate( $duplicate, $product ) {
		// Get the original translations
		$tr_ids = pll_get_post_translations( $product->get_id() );

		$meta_to_exclude = array_filter( apply_filters( 'woocommerce_duplicate_product_exclude_meta', array() ) );

		// First set the language of the product duplicated by WooCommerce
		$lang = pll_get_post_language( $product->get_id() );
		$new_tr_ids[ $lang ] = $duplicate->get_id();
		pll_set_post_language( $new_tr_ids[ $lang ], $lang );

		// Duplicate translations
		foreach ( $tr_ids as $lang => $tr_id ) {
			if ( $product->get_id() !== $tr_id ) {
				$tr_product = wc_get_product( $tr_id );
				$tr_duplicate = clone $tr_product;

				$tr_duplicate->set_id( 0 );
				/* translators: %s is a product name */
				$tr_duplicate->set_name( sprintf( __( '%s (Copy)', 'woocommerce' ), $tr_duplicate->get_name() ) );
				$tr_duplicate->set_total_sales( 0 );
				$tr_duplicate->set_status( 'draft' );
				$tr_duplicate->set_date_created( null );
				$tr_duplicate->set_slug( '' );
				$tr_duplicate->set_rating_counts( 0 );
				$tr_duplicate->set_average_rating( 0 );
				$tr_duplicate->set_review_count( 0 );

				foreach ( $meta_to_exclude as $meta_key ) {
					$tr_duplicate->delete_meta_data( $meta_key );
				}

				do_action( 'woocommerce_product_duplicate_before_save', $tr_duplicate, $tr_product );

				$tr_duplicate->save();
				$new_tr_ids[ $lang ] = $tr_duplicate->get_id();

				pll_set_post_language( $new_tr_ids[ $lang ], $lang );

				// Set SKU only now that the language is known
				if ( '' !== $duplicate->get_sku( 'edit' ) ) {
					$tr_duplicate->set_sku( $duplicate->get_sku( 'edit' ) );
					$tr_duplicate->save();
				}
			}
		}

		// Link duplicated translations together
		pll_save_post_translations( $new_tr_ids );

		// Variations
		if ( $product->is_type( 'variable' ) ) {
			foreach ( $product->get_children() as $child_id ) {
				if ( $tr_ids = pll_get_post_translations( $child_id ) ) {
					$new_child_tr_ids = array();

					$child = wc_get_product( $child_id );
					$sku = wc_product_generate_unique_sku( 0, $child->get_sku( 'edit' ) );

					// 2 separate loops because we need to set all sku in the translation group before saving the variations to DB
					// Otherwise we get an Invalid or duplicated SKU exception
					// We use the fact that wc_product_has_unique_sku checks for existing sku in DB
					foreach ( $tr_ids as $lang => $tr_id ) {
						$tr_child = wc_get_product( $tr_id );
						$tr_child_duplicate[ $lang ] = clone $tr_child;
						$tr_child_duplicate[ $lang ]->set_parent_id( pll_get_post( $duplicate->get_id(), $lang ) );
						$tr_child_duplicate[ $lang ]->set_id( 0 );

						if ( '' !== $child->get_sku( 'edit' ) ) {
							$tr_child_duplicate[ $lang ]->set_sku( $sku );
						}

						do_action( 'woocommerce_product_duplicate_before_save', $tr_child_duplicate[ $lang ], $tr_child );
					}

					foreach ( $tr_ids as $lang => $tr_id ) {
						$tr_child_duplicate[ $lang ]->save();
						$new_child_tr_ids[ $lang ] = $tr_child_duplicate[ $lang ]->get_id();
						pll_set_post_language( $new_child_tr_ids[ $lang ], $lang );
					}

					pll_save_post_translations( $new_child_tr_ids );
				}
			}
		}
	}

	/**
	 * Exact duplicate of the private method WC_Admin_Duplicate_Product::get_product_to_duplicate()
	 * Code base is WC 2.6.4
	 *
	 * @since 0.3.5
	 *
	 * @param int $id post id
	 * @return object
	 */
	private function get_product_to_duplicate( $id ) {
		global $wpdb;

		$id = absint( $id );

		if ( ! $id ) {
			return false;
		}

		$post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" ); // WPCS: unprepared SQL ok.

		if ( isset( $post->post_type ) && 'revision' === $post->post_type ) {
			$id   = $post->post_parent;
			$post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" ); // WPCS: unprepared SQL ok.
		}

		return $post[0];
	}

	/**
	 * Fix duplicated taxonomy terms in case terms are shared across languages
	 * See also https://github.com/woocommerce/woocommerce/pull/12797
	 *
	 * @since 0.6
	 *
	 * @param int    $id        Original product id
	 * @param int    $new_id    Duplicated product id
	 * @param string $post_type Post Type
	 */
	private function duplicate_post_taxonomies( $id, $new_id, $post_type ) {
		$exclude    = array_filter( apply_filters( 'woocommerce_duplicate_product_exclude_taxonomies', array() ) );
		$taxonomies = array_diff( get_object_taxonomies( $post_type ), $exclude );

		foreach ( $taxonomies as $taxonomy ) {
			if ( pll_is_translated_taxonomy( $taxonomy ) ) {
				$post_terms       = wp_get_object_terms( $id, $taxonomy );
				$post_terms_count = count( $post_terms );

				for ( $i = 0; $i < $post_terms_count; $i++ ) {
					wp_set_object_terms( $new_id, (int) $post_terms[ $i ]->term_id, $taxonomy, true );
				}
			}
		}
	}

	/**
	 * Filters wc_product_has_unique_sku
	 * Adds the language filter to the query from WC_Product_Data_Store_CPT::is_existing_sku()
	 * Code base: WC 3.0.5
	 *
	 * @since 0.7
	 *
	 * @param bool   $sku_found
	 * @param int    $product_id
	 * @param string $sku
	 * @return bool
	 */
	public function unique_sku( $sku_found, $product_id, $sku ) {
		global $wpdb;

		if ( $sku_found ) {
			$language = PLL()->model->post->get_language( $product_id );

			/**
			 * Filter the language used to filter wc_product_has_unique_sku
			 *
			 * @since 0.9
			 *
			 * @param object $language
			 * @param int    $product_id
			 */
			$language = apply_filters( 'pllwc_language_for_unique_sku', $language, $product_id );

			if ( $language ) {
				$sql  = "SELECT {$wpdb->posts}.ID FROM {$wpdb->posts}";
				$sql .= " LEFT JOIN {$wpdb->postmeta} ON ( {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id )";
				$sql .= PLL()->model->post->join_clause();
				$sql .= " WHERE {$wpdb->posts}.post_type IN ( 'product', 'product_variation' )";
				$sql .= PLL()->model->post->where_clause( $language );
				$sql .= " AND {$wpdb->posts}.post_status != 'trash'";
				$sql .= $wpdb->prepare( " AND {$wpdb->postmeta}.meta_key = '_sku' AND {$wpdb->postmeta}.meta_value = %s", wp_slash( $sku ) );
				$sql .= $wpdb->prepare( " AND {$wpdb->postmeta}.post_id <> %d LIMIT 1", $product_id );

				return $wpdb->get_var( $sql ); // WPCS: unprepared SQL ok.
			}
		}
		return $sku_found;
	}

	/**
	 * Remove the German and Danish specific sanitization for titles
	 *
	 * @since 0.7.1
	 */
	function remove_sanitize_title() {
		remove_filter( 'sanitize_title', array( PLL()->filters, 'sanitize_title' ), 10, 3 );
	}

	/**
	 * Add the German and Danish specific sanitization for titles
	 *
	 * @since 0.7.1
	 */
	function add_sanitize_title() {
		add_filter( 'sanitize_title', array( PLL()->filters, 'sanitize_title' ), 10, 3 );
	}
}
