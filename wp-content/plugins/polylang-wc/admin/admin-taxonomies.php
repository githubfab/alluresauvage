<?php

/**
 * Manages Woocommerce taxonomies
 *
 * @since 0.1
 */
class PLLWC_Admin_Taxonomies {

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ), 11 ); // After Woocommerce
	}

	/**
	 * Setups actions
	 *
	 * @since 0.1
	 */
	public function init() {
		// WooCommerce (2.5.5) inconsistently uses created_term and edit_term so we can't use pll_save_term
		add_action( 'created_product_cat', array( $this, 'saved_product_cat' ), 999 );
		add_action( 'edited_product_cat', array( $this, 'saved_product_cat' ), 999 );

		// FIXME would be better if Woocomerce would give access to its object
		// FIXME would be even better if filters could allow to pre-populate term meta the same way 'taxonomy_parent_dropdown_args' does
		pll_remove_anonymous_object_filter( 'product_cat_add_form_fields', array( 'WC_Admin_Taxonomies', 'add_category_fields' ) );
		add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ) );

		add_action( 'admin_print_footer_scripts', array( $this, 'admin_print_footer_scripts' ) );
	}

	/**
	 * Backward compatibility function with WP < 4.4 and WC < 2.6
	 * Can't use get_woocommerce_term_meta() as $key is not optional in this function
	 *
	 * @since 0.2
	 *
	 * @param int    $term_id
	 * @param string $key
	 * @param bool   $single default: false like WP, unlike WC
	 * @return mixed
	 */
	public function get_term_meta( $term_id, $key = '', $single = false ) {
		return function_exists( 'get_term_meta' ) ? get_term_meta( $term_id, $key, $single ) : get_metadata( 'woocommerce_term', $term_id, $key, $single );
	}

	/**
	 * Copy or synchronize term metas
	 *
	 * @since 0.1
	 *
	 * @param int    $from id of the term from which we copy informations
	 * @param int    $to   id of the term to which we paste informations
	 * @param string $lang language slug
	 * @param bool   $sync true if it is synchronization, false if it is a copy, defaults to false
	 */
	public function copy_term_metas( $from, $to, $lang, $sync = false ) {
		$metas = $this->get_term_meta( $from );

		$to_copy = array(
			'display_type',
			'order',
			'thumbnail_id',
		);

		// Add attributes order
		foreach ( array_keys( $metas ) as $key ) {
			if ( 0 === strpos( $key, 'order_' ) ) {
				$to_copy[] = $key;
			}
		}

		/**
		 * Filter the custom fields to copy or synchronize
		 *
		 * @since 0.7
		 *
		 * @param array  $to_copy list of custom fields names
		 * @param bool   $sync    true if it is synchronization, false if it is a copy
		 * @param int    $from    id of the term from which we copy informations
		 * @param int    $to      id of the term to which we paste informations
		 * @param string $lang    language slug
		 */
		$to_copy = apply_filters( 'pllwc_copy_term_metas', $to_copy, $sync, $from, $to, $lang );

		// FIXME create all this meta in one unique query?
		foreach ( $metas as $key => $values ) {
			if ( in_array( $key, $to_copy ) ) {
				foreach ( $values as $value ) {
					$value = maybe_unserialize( $value );

					if ( 'thumbnail_id' === $key ) {
						// Translate a post id
						update_term_meta( $to, $key, ( $tr_value = pll_get_post( $value, $lang ) ) ? $tr_value : $value );
					} else {
						// Just copy the value
						update_term_meta( $to, $key, $value );
					}
				}
			}
		}

		// In case the category image is deleted, let's sync that.
		if ( $sync && empty( $metas['thumbnail_id'] ) ) {
			delete_woocommerce_term_meta( $to, 'thumbnail_id' );
		}
	}

	/**
	 * Synchronize metas in translations
	 * Maybe fix the language of the product cat image
	 *
	 * @since 0.1
	 *
	 * @param int $term_id term id
	 */
	public function saved_product_cat( $term_id ) {
		// Maybe fix the language of the product cat image
		// It is needed because if the image was just uploaded, it is assigned the preferred language instead of the current language
		$thumbnail_id = $this->get_term_meta( $term_id, 'thumbnail_id', true );
		$lang = pll_get_term_language( $term_id );

		if ( $thumbnail_id && PLL()->options['media_support'] && pll_get_post_language( $thumbnail_id ) !== $lang ) {
			$translations = pll_get_post_translations( $thumbnail_id );

			if ( ! empty( $translations[ $lang ] ) ) {
				update_woocommerce_term_meta( $term_id, 'thumbnail_id', $translations[ $lang ] ); // Take the translation in the right language
			} else {
				pll_set_post_language( $thumbnail_id, $lang ); // Or fix the language
			}
		}

		// Synchronise metas in translations
		$translations = pll_get_term_translations( $term_id );

		foreach ( $translations as $lang => $tr_id ) {
			if ( ! $tr_id || $tr_id === $term_id ) {
				continue;
			}

			// Synchronize metas
			$this->copy_term_metas( $term_id, $tr_id, $lang, true );
		}
	}

	/**
	 * Rewrites WC_Admin_Taxonomies::add_category_fields to populate metas when creating a new translation
	 *
	 * @since 0.1
	 */
	public function add_category_fields() {
		$wc_admin_tax = pll_get_anonymous_object_from_filter( 'product_cat_edit_form_fields', array( 'WC_Admin_Taxonomies', 'edit_category_fields' ), 10 );

		if ( isset( $_GET['taxonomy'], $_GET['from_tag'], $_GET['new_lang'] ) ) {
			$term = get_term( (int) $_GET['from_tag'], 'product_cat' );
		}

		if ( ! empty( $term ) ) {
			$wc_admin_tax->edit_category_fields( $term );
		} else {
			$wc_admin_tax->add_category_fields();
		}
	}

	/**
	 * Filter the media list when adding an image to a product category
	 *
	 * @since 0.2
	 */
	public function admin_print_footer_scripts() {
		$screen = get_current_screen();
		if ( empty( $screen ) || ! in_array( $screen->base, array( 'edit-tags', 'term' ) ) || 'product_cat' !== $screen->taxonomy ) {
			return;
		}
		?>
		<script type="text/javascript">
			if (typeof jQuery != 'undefined') {
				(function( $ ){
					$.ajaxPrefilter(function ( options, originalOptions, jqXHR ) {
						if ( options.data.indexOf( 'action=query-attachments' ) > 0 ) {
							options.data = 'lang=' + $( '#term_lang_choice' ).val() + '&' + options.data;
						}
					});
				})( jQuery )
			}
		</script>
		<?php
	}
}
