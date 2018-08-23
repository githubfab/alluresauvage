<?php

/**
 * Manages compatibility with WooCommerce Dynamic Pricing
 * Version tested: 2.11.6
 *
 * @since 0.5
 */
class PLLWC_Dynamic_Pricing {

	/**
	 * Constructor
	 *
	 * @since 0.5
	 */
	public function __construct() {
		add_action( 'pllwc_copy_product', array( $this, 'copy_post_metas' ), 10, 3 );

		if ( isset( $_GET['page'], $_GET['tab'] ) && 'wc_dynamic_pricing' === $_GET['page'] && 'category' === $_GET['tab'] ) {
			add_action( 'get_terms_args', array( $this, 'get_terms_args' ), 5, 2 );
		}

		if ( is_ajax() && isset( $_POST['action'] ) && 'create_empty_category_ruleset' === $_POST['action'] ) {
			add_action( 'get_terms_args', array( $this, 'get_terms_args' ), 5, 2 );
		}

		add_filter( 'sanitize_option__s_category_pricing_rules', array( $this, 'category_pricing_rules' ), 20 );
		add_filter( 'sanitize_option__a_category_pricing_rules', array( $this, 'advanced_category_pricing_rules' ), 20 );
	}

	/**
	 * Copy pricing rules from a product to a translation
	 * Translates categories in pricing rules
	 *
	 * @since 0.5
	 *
	 * @param int    $from Original product ID
	 * @param int    $to   Target product ID
	 * @param string $lang Language of the target product
	 */
	public function copy_post_metas( $from, $to, $lang ) {
		$pricing_rules = get_post_meta( $from, '_pricing_rules', true );

		if ( empty( $pricing_rules ) ) {
			delete_post_meta( $to, '_pricing_rules' );
		} else {
			foreach ( $pricing_rules as $k => $rule ) {
				if ( isset( $rule['collector']['args']['cats'] ) ) {
					foreach ( $rule['collector']['args']['cats'] as $term_id ) {
						$cats[] = pll_get_term( $term_id, $lang );
					}

					$pricing_rules[ $k ]['collector']['args']['cats'] = $cats;
				}

				if ( isset( $rule['variation_rules']['args']['variations'] ) ) {
					foreach ( $rule['variation_rules']['args']['variations'] as $post_id ) {
						$posts[] = pll_get_post( $post_id, $lang );
					}

					$pricing_rules[ $k ]['variation_rules']['args']['variations'] = $posts;
				}
			}

			update_post_meta( $to, '_pricing_rules', $pricing_rules );
		}
	}

	/**
	 * Make sure that products categories are displayed in only one language on Dyanmic Pricing > category page
	 * (even when the admin languages filter requests all languages)
	 * to avoid conflicts if inconsistent information would be given for products translations
	 *
	 * @since 0.5
	 *
	 * @param array $args
	 * @param array $taxonomies
	 * @return array modified arguments
	 */
	public function get_terms_args( $args, $taxonomies ) {
		if ( in_array( 'product_cat', $taxonomies ) && empty( PLL()->curlang ) ) {
			$args['lang'] = PLL()->options['default_lang'];
		}
		return $args;
	}

	/**
	 * Adds translated categories to pricing rules sets (Category pricing tab)
	 *
	 * @since 0.5
	 *
	 * @param array $rules Pricing rules set
	 * @return array
	 */
	public function category_pricing_rules( $rules ) {
		foreach ( $rules as $set_id => $rule ) {
			$cat_id = (int) substr( $set_id, 4 );
			foreach ( pll_get_term_translations( $cat_id ) as $lang => $tr_id ) {
				if ( $tr_id !== $cat_id ) {
					if ( isset( $rule['collector']['args']['cats'][0] ) ) {
						$rule['collector']['args']['cats'][0] = pll_get_term( $rule['collector']['args']['cats'][0], $lang );
					}
					$rules[ 'set_' . $tr_id ] = $rule;
				}
			}
		}
		return $rules;
	}

	/**
	 * Adds translated categories to pricing rules sets (Advanced Category pricing tab)
	 *
	 * @since 0.5
	 *
	 * @param array $rules Pricing rules set
	 * @return array
	 */
	public function advanced_category_pricing_rules( $rules ) {
		foreach ( $rules as $set_id => $rule ) {
			if ( isset( $rule['collector']['args']['cats'] ) ) {
				$cats = array();
				foreach ( $rule['collector']['args']['cats'] as $term_id ) {
					$cats = array_merge( $cats, array_values( pll_get_term_translations( $term_id ) ) );
				}
				$rules[ $set_id ]['collector']['args']['cats'] = $cats;
			}

			if ( isset( $rule['targets'] ) ) {
				$cats = array();
				foreach ( $rule['targets'] as $term_id ) {
					$cats = array_merge( $cats, array_values( pll_get_term_translations( $term_id ) ) );
				}
				$rules[ $set_id ]['targets'] = $cats;
			}
		}
		return $rules;
	}
}
