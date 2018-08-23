<?php

/**
 * Manages WooCommerce specific translations on frontend
 *
 * @since 0.1
 */
class PLLWC_Frontend {

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {
		if ( did_action( 'pll_language_defined' ) ) {
			$this->init();
		} else {
			add_action( 'pll_language_defined', array( $this, 'init' ), 1 );

			// Set the language early if a form has been posted with a language value
			if ( ! empty( $_REQUEST['lang'] ) && $lang = PLL()->model->get_language( $_REQUEST['lang'] ) ) {
				PLL()->curlang = $lang;
				$GLOBALS['text_direction'] = $lang->is_rtl ? 'rtl' : 'ltr';
				do_action( 'pll_language_defined', $lang->slug, $lang );
			}
		}

		// Shop on front and orders
		add_action( 'parse_query', array( $this, 'parse_query' ), 3 ); // Before Polylang (for orders)
		add_filter( 'pll_set_language_from_query', array( $this, 'pll_set_language_from_query' ), 5, 2 ); // Before Polylang
	}

	/**
	 * Setups actions filters once the language is defined
	 *
	 * @since 0.1
	 */
	public function init() {
		// Resets the cart when switching the language
		// FIXME can't work on multiple domains
		if ( isset( $_COOKIE[ PLL_COOKIE ] ) && pll_current_language() !== $_COOKIE[ PLL_COOKIE ] ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
			add_action( 'wp_head', array( $this, 'wp_head' ) );
		}

		// Translate products in cart
		add_action( 'woocommerce_cart_loaded_from_session', array( $this, 'woocommerce_cart_loaded_from_session' ) );
		add_filter( 'woocommerce_add_to_cart_hash', array( $this, 'woocommerce_add_to_cart_hash' ), 10, 2 );

		// Translates pages ids
		foreach ( array( 'myaccount', 'shop', 'cart', 'checkout', 'terms' ) as $page ) {
			// Don't use the filter 'woocommerce_get' . $page . '_page_id' as some themes (ex: Flatsome) are retrieving directly the option
			add_filter( 'option_woocommerce_' . $page . '_page_id', 'pll_get_post' );
		}

		// Filters the product search form
		add_filter( 'get_product_search_form', array( PLL()->filters_search, 'get_search_form' ), 99 );

		if ( ! PLL()->options['force_lang'] ) {
			if ( ! get_option( 'permalink_structure' ) ) {
				// Fix product page when using plain permalinks and the language is set from the content
				add_filter( 'pll_check_canonical_url', array( $this, 'pll_check_canonical_url' ), 10, 2 );
				add_filter( 'pll_translation_url', array( $this, 'pll_translation_url' ), 10, 2 );
			} else {
				// Fix shop link when using pretty permalinks and the language is set from the content
				add_filter( 'post_type_archive_link', array( $this, 'post_type_archive_link' ), 99, 2 ); // After Polylang
			}

			// Add language input field to forms to detect the language before wp_loaded is fired
			$actions = array(
				'woocommerce_login_form_start', // Login
				'woocommerce_before_cart_table', // Cart
				'woocommerce_before_add_to_cart_button', // Product
			);

			foreach ( $actions as $action ) {
				add_action( $action, array( $this, 'language_form_field' ) );
			}

			add_filter( 'woocommerce_get_remove_url', array( $this, 'add_lang_query_arg' ) );
		}

		// Translates home url in widgets
		add_filter( 'pll_home_url_white_list', array( $this, 'home_url_white_list' ) );

		// Layered nav chosen attributes
		add_filter( 'woocommerce_product_query_tax_query', array( $this, 'product_tax_query' ) );

		if ( PLL()->options['force_lang'] > 1 ) {
			add_filter( 'home_url', array( $this, 'fix_widget_price_filter' ), 10, 2 );
		}

		// Shortcodes
		add_filter( 'woocommerce_shortcode_products_query', array( $this, 'shortcode_products_query' ) ); // Since WC 3.0.2

		// Ajax endpoint
		add_filter( 'woocommerce_ajax_get_endpoint', array( $this, 'ajax_get_endpoint' ), 10, 2 );
	}

	/**
	 * Disables the languages filter for a customer to see all orders whatever the languages
	 *
	 * @since 0.3
	 *
	 * @param object $query WP_Query object
	 */
	public function parse_query( $query ) {
		$qvars = $query->query_vars;

		// Customers should see all their orders whatever the language
		if ( ! isset( $qvars['lang'] ) && ( isset( $qvars['post_type'] ) && ( 'shop_order' === $qvars['post_type'] || ( is_array( $qvars['post_type'] ) && in_array( 'shop_order', $qvars['post_type'] ) ) ) ) ) {
			$query->set( 'lang', 0 );
		}
	}

	/**
	 * Fixes query vars on translated front page when the front page displays the shop
	 *
	 * @since 0.3.2
	 *
	 * @param bool|object $lang  false or language object
	 * @param object      $query WP_Query object
	 */
	public function pll_set_language_from_query( $lang, $query ) {
		$qvars = $query->query_vars;
		$languages = PLL()->model->get_languages_list();
		$pages = wp_list_pluck( $languages, 'page_on_front' );

		if ( 'page' === get_option( 'show_on_front' ) && in_array( wc_get_page_id( 'shop' ), $pages ) ) {
			// Redirect the language page to the homepage when using a static front page
			if ( ( PLL()->options['redirect_lang'] || PLL()->options['hide_default'] ) && ( count( $query->query ) === 1 || ( ( is_preview() || is_paged() || ! empty( $query->query['page'] ) ) && count( $query->query ) === 2 ) || ( ( is_preview() && ( is_paged() || ! empty( $query->query['page'] ) ) ) && count( $query->query ) === 3 ) ) && is_tax( 'language' ) ) {
				$lang = PLL()->model->get_language( get_query_var( 'lang' ) );
				$query->is_home = false;
				$query->is_tax = false;
				$query->is_page = true;
				$query->is_post_type_archive = true;
				$query->set( 'page_id', $lang->page_on_front );
				$query->set( 'post_type', 'product' );
				unset( $query->query_vars['lang'], $query->queried_object ); // Reset queried object
			}

			// Set the language when requesting a static front page
			elseif ( ( $page_id = $this->get_page_id( $query ) ) && false !== $n = array_search( $page_id, $pages ) ) {
				$lang = $languages[ $n ];
				$query->is_home = false;
				$query->is_page = true;
				$query->is_post_type_archive = true;
				$query->set( 'page_id', $page_id );
				$query->set( 'post_type', 'product' );
			}

			// Multiple domains (when the url contains the page slug)
			elseif ( is_post_type_archive( 'product' ) && ! empty( PLL()->curlang ) ) {
				$query->is_page = true;
				$query->set( 'page_id', PLL()->curlang->page_on_front );
			}

			// Plain permalinks + language set from the content
			elseif ( is_post_type_archive( 'product' ) && ! empty( $qvars['lang'] ) && $lang = PLL()->model->get_language( $qvars['lang'] ) ) {
				$query->is_page = true;
				$query->set( 'page_id', $lang->page_on_front );
			}

			// Plain permalinks + language set from the content + default language hidden from url
			elseif ( ! PLL()->options['force_lang'] && is_home() && ( empty( $query->query ) || ! array_diff( array_keys( $query->query ), array( 'preview', 'page', 'paged', 'cpage', 'orderby' ) ) ) ) {
				$lang = PLL()->model->get_language( PLL()->options['default_lang'] );
				$query->is_home = false;
				$query->is_page = true;
				$query->is_post_type_archive = true;
				$query->set( 'page_id', $lang->page_on_front );
				$query->set( 'post_type', 'product' );
			}
		}

		// Reload the cart when the language is set from the content
		if ( ! PLL()->options['force_lang'] ) {
			if ( did_action( 'pll_language_defined' ) ) {
				// Specific case for the Site home (when the language code is hidden for the defualt language).
				// Done here and not in the 'pll_language_defined' action to avoid a notice with WooCommerce Dynamic pricing which calls is_shop()
				WC()->cart->get_cart_from_session();
			} else {
				add_action( 'pll_language_defined', array( WC()->cart, 'get_cart_from_session' ) );
			}
		}

		return $lang;
	}

	/**
	 * Get queried page_id ( if exists )
	 * If permalinks are used, WordPress does set and use $query->queried_object_id and sets $query->query_vars['page_id'] to 0
	 * and does set and use $query->query_vars['page_id'] if permalinks are not used :(
	 *
	 * @since 1.5
	 *
	 * @param object $query instance of WP_Query
	 * @return int page_id
	 */
	protected function get_page_id( $query ) {
		if ( ! empty( $query->query_vars['pagename'] ) && isset( $query->queried_object_id ) ) {
			return $query->queried_object_id;
		}

		if ( isset( $query->query_vars['page_id'] ) ) {
			return $query->query_vars['page_id'];
		}

		return 0; // No page queried
	}

	/**
	 * Enqueues jQuery
	 *
	 * @since 0.1
	 */
	public function wp_enqueue_scripts() {
		wp_enqueue_script( 'jquery' );
	}

	/**
	 * Reset cached data when switching the language
	 *
	 * @since 0.1
	 */
	public function wp_head() {
		// reset shipping methods (needed since WC 2.6)
		WC()->shipping->calculate_shipping( WC()->cart->get_shipping_packages() );

		// FIXME backward compatibility with WC < 3.1
		$fragment_name = version_compare( WC()->version, '3.1', '<' ) ? 'wc_fragments' : 'wc_fragments_' . md5( get_current_blog_id() . '_' . get_site_url( get_current_blog_id(), '/' ) );
		$fragment_name = apply_filters( 'woocommerce_cart_fragment_name', $fragment_name );

		// Add js to reset the cart
		echo '
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ){
					sessionStorage.removeItem( "wc_cart_hash" );
					sessionStorage.removeItem( "' . esc_js( $fragment_name ) . '" );
				} );
			</script>
		';
	}

	/**
	 * Translates products in cart
	 *
	 * @since 0.3.5
	 *
	 * @param array  $item Cart item
	 * @param string $lang Language code
	 * @return array
	 */
	protected function translate_cart_item( $item, $lang ) {
		$orig_lang = pll_get_post_language( $item['product_id'] );
		$item['product_id'] = pll_get_post( $item['product_id'], $lang );

		// Variable product
		if ( $item['variation_id'] && $tr_id = pll_get_post( $item['variation_id'], $lang ) ) {
			$item['variation_id'] = $tr_id;
			if ( ! empty( $item['data'] ) ) {
				$item['data'] = wc_get_product( $item['variation_id'] );
			}

			// Variations attributes
			if ( ! empty( $item['variation'] ) ) {
				foreach ( $item['variation'] as $name => $value ) {
					if ( '' === $value ) {
						continue;
					}

					$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

					if ( taxonomy_exists( $taxonomy ) ) {
						// Don't use get_term_by( 'slug' ) which is filtered in the current language by Polylang Pro
						$terms = get_terms( $taxonomy, array( 'slug' => $value, 'lang' => $orig_lang ) );

						if ( ! empty( $terms ) && is_array( $terms ) ) {
							$term = reset( $terms );
							if ( $term_id = pll_get_term( $term->term_id, $lang ) ) {
								$term = get_term( $term_id, $taxonomy );
								$item['variation'][ $name ] = $term->slug;
							}
						}
					}
				}
			}
		} elseif ( ! empty( $item['data'] ) ) {
			// Simple product
			$item['data'] = wc_get_product( $item['product_id'] );
		}

		/**
		 * Filters a cart item when it is translated
		 *
		 * @since 0.6
		 *
		 * @param array $item Cart item
		 */
		$item = apply_filters( 'pllwc_translate_cart_item', $item );
		return $item;
	}

	/**
	 * Translates cart contents
	 *
	 * @since 0.3.5
	 *
	 * @param array  $contents Cart contents
	 * @param string $lang     Language code
	 * @return array
	 */
	protected function translate_cart_contents( $contents, $lang = '' ) {
		if ( empty( $lang ) ) {
			$lang = pll_current_language();
		}

		foreach ( $contents as $key => $item ) {
			if ( $item['product_id'] && ( $tr_id = pll_get_post( $item['product_id'], $lang ) ) && $tr_id !== $item['product_id'] ) {
				unset( $contents[ $key ] );
				$item = $this->translate_cart_item( $item, $lang );

				/**
				 * Filters cart item data
				 * This filters aims to replace the filter 'woocommerce_add_cart_item_data'
				 * which can't be used here as it conflicts with WooCommerce Bookings
				 * which uses the filter to create new bookings and not only to filter the cart item data
				 *
				 * @since 0.7.4
				 *
				 * @param array $cart_item_data Cart item data
				 * @param array $item           Cart item
				 */
				$cart_item_data = (array) apply_filters( 'pllwc_add_cart_item_data', array(), $item );
				$cart_id = WC()->cart->generate_cart_id( $item['product_id'], $item['variation_id'], $item['variation'], $cart_item_data );
				$contents[ $cart_id ] = $item;
			}
		}

		return $contents;
	}

	/**
	 * Translates the products and removed products in cart
	 *
	 * @since 0.3.5
	 */
	public function woocommerce_cart_loaded_from_session() {
		WC()->cart->cart_contents = $this->translate_cart_contents( WC()->cart->cart_contents );
		WC()->cart->removed_cart_contents = $this->translate_cart_contents( WC()->cart->removed_cart_contents );
	}

	/**
	 * Makes the cart hash language independent by relying on products in default language
	 *
	 * @since 0.9.4
	 *
	 * @param string $hash Cart hash
	 * @param array  $cart Cart contents
	 * @return string Modified cart hash
	 */
	public function woocommerce_add_to_cart_hash( $hash, $cart ) {
		if ( ! empty( $cart ) ) {
			$cart = PLLWC()->frontend->translate_cart_contents( $cart, pll_default_language() );
			$hash = md5( json_encode( $cart ) );
		}
		return $hash;
	}

	/**
	 * Fix canonical redirection from shop page to product archive when using plain permalinks and the language is set from the content
	 *
	 * @since 0.3.2
	 *
	 * @param string $redirect_url
	 * @param object $lang
	 * @return string
	 */
	public function pll_check_canonical_url( $redirect_url, $lang ) {
		if ( is_post_type_archive( 'product' ) ) {
			return false;
		}
		return $redirect_url;
	}

	/**
	 * Fix translation url of shop page (product archive) when using plain permalinks and the language is set from the content
	 *
	 * @since 0.3.2
	 *
	 * @param string $url  translation url
	 * @param string $lang language code
	 * @return string
	 */
	public function pll_translation_url( $url, $lang ) {
		if ( is_post_type_archive( 'product' ) ) {
			$lang = PLL()->model->get_language( $lang );

			if ( PLL()->options['hide_default'] && 'page' === get_option( 'show_on_front' ) && PLL()->options['default_lang'] === $lang->slug ) {
				$pages = pll_languages_list( array( 'fields' => 'page_on_front' ) );
				if ( in_array( wc_get_page_id( 'shop' ), $pages ) ) {
					return $lang->home_url;
				}
			}

			$url = get_post_type_archive_link( 'product' );
			$url = PLL()->links_model->switch_language_in_link( $url, $lang );
			$url = PLL()->links_model->remove_paged_from_link( $url );
		}
		return $url;
	}

	/**
	 * Fixes the shop link when using pretty permalinks and the language is set from the content
	 * This fixes the widget layered nav which calls get_post_type_archive_link( 'product' )
	 *
	 * @since 0.4.6
	 *
	 * @param string $link
	 * @param string $post_type
	 * @return string modified link
	 */
	public function post_type_archive_link( $link, $post_type ) {
		return 'product' === $post_type ? wc_get_page_permalink( 'shop' ) : $link;
	}

	/**
	 * Outputs the hidden language input field
	 *
	 * @since 0.3.5
	 */
	public function language_form_field() {
		printf( '<input type="hidden" name="lang" value="%s" />', esc_attr( pll_current_language() ) );
	}

	/**
	 * Add a lang query arg to the url
	 *
	 * @since 0.5
	 *
	 * @param string $url
	 * @return string
	 */
	public function add_lang_query_arg( $url ) {
		return add_query_arg( 'lang', pll_current_language(), $url );
	}

	/**
	 * Fixes home url in widgets
	 *
	 * @since 0.5
	 *
	 * @param array $arr
	 * @return array
	 */
	public function home_url_white_list( $arr ) {
		// FIXME Backward compatibility with WC < 3.3
		if ( version_compare( WC()->version, '3.3', '<' ) ) {
			$arr = array_merge( $arr, array(
				array( 'file' => 'class-wc-widget-layered-nav.php' ),
				array( 'file' => 'class-wc-widget-layered-nav-filters.php' ),
				array( 'file' => 'class-wc-widget-rating-filter.php' ),
			) );
		} else {
			$arr = array_merge( $arr, array(
				array( 'file' => 'abstract-wc-widget.php' ),
			) );
		}

		// Avoid a redirect when the language is set from the content
		if ( PLL()->options['force_lang'] > 0 ) {
			$arr = array_merge( $arr, array(
				array( 'file' => 'class-wc-widget-product-categories.php' ),
			) );
		}

		return $arr;
	}

	/**
	 * Fixes the layered nav chosen attributes when shared slugs are in query
	 * Otherwise the query would look for products in all attributes in all languages which always return an empty result
	 *
	 * @since 0.5
	 *
	 * @param array $tax_query
	 * @return array
	 */
	public function product_tax_query( $tax_query ) {
		foreach ( $tax_query as $k => $q ) {
			if ( is_array( $q ) && 'slug' === $q['field'] ) {
				$terms = get_terms( $q['taxonomy'], array( 'slug' => $q['terms'] ) );
				$tax_query[ $k ]['terms'] = wp_list_pluck( $terms, 'term_taxonomy_id' );
				$tax_query[ $k ]['field'] = 'term_taxonomy_id';
			}
		}
		return $tax_query;
	}

	/**
	 * Filters the form action url of the widget price filter for subdomains and multiple domains
	 *
	 * @since 0.5
	 *
	 * @param string $url
	 * @param string $path
	 * @return string
	 */
	public function fix_widget_price_filter( $url, $path ) {
		global $wp;

		if ( ! empty( $wp->request ) && trailingslashit( $wp->request ) === $path ) {
			$url = PLL()->links_model->switch_language_in_link( $url, PLL()->curlang );
		}

		return $url;
	}

	/**
	 * Adds language to shortcodes query args to get one cache key per language
	 * Needed for WC 3.0, Requires WC 3.0.2+
	 *
	 * @since 0.7.4
	 *
	 * @param array $args Query arguments
	 * @return array
	 */
	public function shortcode_products_query( $args ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'language',
			'field'    => 'term_taxonomy_id',
			'terms'    => PLL()->curlang->term_taxonomy_id,
			'operator' => 'IN',
		);

		return $args;
	}

	/**
	 * Make sure the ajax endpoint is in the right language. Needed since WC 3.2.
	 *
	 * @since 0.9.1
	 *
	 * @param string $url     Ajax endpoint
	 * @param string $request Ajax endpoint request
	 * @return string
	 */
	public function ajax_get_endpoint( $url, $request ) {
		// Remove wc-ajax to avoid the value %%endpoint%% to be encoded by add_query_arg (used in plain permalinks)
		$url = remove_query_arg( 'wc-ajax', $url );
		$url = PLL()->links_model->switch_language_in_link( $url, PLL()->curlang );
		return add_query_arg( 'wc-ajax', $request, $url );
	}
}
