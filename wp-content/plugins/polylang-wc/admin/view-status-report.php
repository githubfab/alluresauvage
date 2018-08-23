<?php

/**
 * Adds status report for translations of the default pages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly
}
?>
<table class="wc_status_table widefat" cellspacing="0">
	<thead>
		<tr>
			<th colspan="3" data-export-label="WC Pages Translations"><?php esc_html_e( 'WC Pages Translations', 'pllwc' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$check_pages = array(
			_x( 'Shop base', 'Page setting', 'woocommerce' ) => array(
				'option'    => 'woocommerce_shop_page_id',
				'shortcode' => '',
				'help'      => __( 'The status of your WooCommerce shop\'s homepage translations.', 'pllwc' ),
			),
			_x( 'Cart', 'Page setting', 'woocommerce' ) => array(
				'option'    => 'woocommerce_cart_page_id',
				'shortcode' => '[' . apply_filters( 'woocommerce_cart_shortcode_tag', 'woocommerce_cart' ) . ']',
				'help'      => __( 'The status of your WooCommerce shop\'s cart translations.', 'pllwc' ),
			),
			_x( 'Checkout', 'Page setting', 'woocommerce' ) => array(
				'option'    => 'woocommerce_checkout_page_id',
				'shortcode' => '[' . apply_filters( 'woocommerce_checkout_shortcode_tag', 'woocommerce_checkout' ) . ']',
				'help'      => __( 'The status of your WooCommerce shop\'s checkout page translations.', 'pllwc' ),
			),
			_x( 'My account', 'Page setting', 'woocommerce' ) => array(
				'option'    => 'woocommerce_myaccount_page_id',
				'shortcode' => '[' . apply_filters( 'woocommerce_my_account_shortcode_tag', 'woocommerce_my_account' ) . ']',
				'help'      => __( 'The status of your WooCommerce shop\'s “My Account” page translations.', 'pllwc' ),
			),
		);

		$languages = pll_languages_list();

		foreach ( $check_pages as $page_name => $values ) {
			$error   = false;
			$page_id = get_option( $values['option'] );

			if ( $page_id ) {
				/* translators: %s is a page name */
				$_page_name = '<a href="' . esc_url( get_edit_post_link( $page_id ) ) . '" title="' . esc_attr( sprintf( __( 'Edit %s page', 'woocommerce' ), $page_name ) ) . '">' . esc_html( $page_name ) . '</a>';
			} else {
				$_page_name = esc_html( $page_name );
			}

			echo '<tr><td data-export-label="' . esc_attr( $page_name ) . '">' . $_page_name . ':</td>';
			echo '<td class="help">' . wc_help_tip( $values['help'] ) . '</td><td>';

			// Page ID check
			if ( ! $page_id ) {
				echo '<mark class="error">' . esc_html__( 'Page not set', 'woocommerce' ) . '</mark>';
				$error = true;
			} else {
				$translations = pll_get_post_translations( $page_id );
				$missing = array_diff( $languages, array_keys( $translations ) );

				// Do translations exist?
				if ( $missing ) {
					foreach ( $missing as $key => $slug ) {
						$missing[ $key ] = PLL()->model->get_language( $slug )->name;
					}
					echo '<mark class="error">' . esc_html( sprintf(
						/* translators: %s comma separated list of native languages names */
						_n( 'Missing translation: %s', 'Missing translations: %s', count( $missing ), 'pllwc' ),
						implode( ', ', $missing )
					) ) . '</mark>';
					$error = true;
				}

				// Do translations have the correct shortcode?
				elseif ( $values['shortcode'] ) {
					$wrong_translations = array();
					foreach ( $translations as $lang => $translation ) {
						$page = get_post( $translation );
						if ( ! strstr( $page->post_content, $values['shortcode'] ) ) {
							$wrong_translations[] = PLL()->model->get_language( $lang )->name;
						}
					}

					if ( $wrong_translations ) {
						echo '<mark class="error">' . esc_html( sprintf(
							/* translators: %s comma separated list of native languages names */
							_n( 'The shortcode is missing for the translation in %s', 'The shortcode is missing for the translations in %s', count( $wrong_translations ), 'pllwc' ),
							implode( ', ', $wrong_translations )
						) ) . '</mark>';
						$error = true;
					}
				}
			}

			if ( ! $error ) {
				echo '<mark class="yes">&#10004;</mark>';
			}

			echo '</td></tr>';
		}
		?>
	</tbody>
</table>
