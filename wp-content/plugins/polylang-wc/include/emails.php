<?php

/**
 * Manages the customer email languages
 * Associates a language to the user and to orders
 *
 * @since 0.1
 */
class PLLWC_Emails {
	protected $language, $saved_curlang;

	/**
	 * Constructor
	 * Setups actions
	 *
	 * @since 0.1
	 */
	public function __construct() {
		// Define the customer preferred language
		add_action( 'woocommerce_created_customer', array( $this, 'created_customer' ), 5 ); // Before WC sends the notification
		add_action( 'save_post', array( $this, 'save_post' ), 300, 2 ); // After Polylang on frontend

		// Automatic user emails
		$actions = array(
			'woocommerce_created_customer_notification', // Customer new account
			'woocommerce_reset_password_notification', // Reset password
		);

		foreach ( $actions as $action ) {
			add_action( $action, array( $this, 'before_user_email' ), 1 ); // Switch the language for the email
			add_action( $action, array( $this, 'after_email' ), 999 ); // Switch the language back after the email has been sent
		}

		// FIXME new order and cancelled order are sent to the shop. Should I really change the language?
		// Automatic order emails
		$actions = array(
			// Cancelled order
			'woocommerce_order_status_pending_to_cancelled_notification',
			'woocommerce_order_status_on-hold_to_cancelled_notification',
			// Completed order
			'woocommerce_order_status_completed_notification',
			// Customer note
			'woocommerce_new_customer_note_notification',
			// On hold
			'woocommerce_order_status_failed_to_on-hold_notification', // + new order
			'woocommerce_order_status_pending_to_on-hold_notification', // + new order
			// Processing
			'woocommerce_order_status_on-hold_to_processing_notification',
			'woocommerce_order_status_pending_to_processing_notification', // + new order
			// Refunded order
			'woocommerce_order_fully_refunded_notification',
			'woocommerce_order_partially_refunded_notification',
			// Failed order
			'woocommerce_order_status_pending_to_failed_notification',
			'woocommerce_order_status_on-hold_to_failed_notification',
			// New order
			'woocommerce_order_status_pending_to_completed_notification',
			'woocommerce_order_status_failed_to_processing_notification',
			'woocommerce_order_status_failed_to_completed_notification',
		);

		foreach ( $actions as $action ) {
			add_action( $action, array( $this, 'before_order_email' ), 1 ); // Switch the language for the email
			add_action( $action, array( $this, 'after_email' ), 999 ); // Switch the language back after the email has been sent
		}

		// Manually sent order emails (incl. Customer Invoice )
		add_action( 'woocommerce_before_resend_order_emails', array( $this, 'before_order_email' ) );
		add_action( 'woocommerce_after_resend_order_email', array( $this, 'after_email' ) );

		// Translate site title
		add_filter( 'woocommerce_email_format_string_replace', array( $this, 'format_string_replace' ), 10, 2 );
	}

	/**
	 * Set the preferred customer language at customer creation
	 *
	 * @since 0.1
	 *
	 * @param int $user_id
	 */
	public function created_customer( $user_id ) {
		update_user_meta( $user_id, 'locale', get_locale() );
	}

	/**
	 * May be change the customer language when he places a new order
	 * The chosen language is the currently browsed language
	 *
	 * @since 0.1
	 *
	 * @param int    $post_id
	 * @param object $post
	 */
	public function save_post( $post_id, $post ) {
		if ( 'shop_order' === $post->post_type ) {
			$order = wc_get_order( $post_id );
			if ( ( $user_id = $order->get_user_id() ) ) {
				$post_locale = pll_get_post_language( $post_id, 'locale' );
				$user_locale = get_user_meta( $user_id, 'locale', true );
				if ( ! empty( $post_locale ) && $post_locale !== $user_locale ) {
					update_user_meta( $user_id, 'locale', $post_locale );
				}
			}
		}
	}

	/**
	 * Filters the locale
	 *
	 * @since 0.1
	 *
	 * @param string $locale
	 * @return string
	 */
	public function locale( $locale ) {
		return $this->language->locale;
	}

	/**
	 * Reload text domains and change locale
	 *
	 * @since 0.1
	 *
	 * @param object $language
	 */
	protected function reload_text_domains( $language ) {
		unload_textdomain( 'woocommerce' );
		WC()->load_plugin_textdomain();

		unload_textdomain( 'default' );

		// $language may be empty after the email has been sent if the site's main language is not in the list of Polylang languages
		if ( ! empty( $language ) ) {
			$GLOBALS['text_direction'] = $language->is_rtl ? 'rtl' : 'ltr';
			load_default_textdomain( $language->locale );
		} else {
			load_default_textdomain();
		}

		unset( $GLOBALS['wp_locale'] );
		$GLOBALS['wp_locale'] = new WP_Locale();

		/**
		 * Fires just after text domains have been reloaded for emails
		 *
		 * @since 0.4.6
		 *
		 * @param object $language
		 */
		do_action( 'pllwc_email_reload_text_domains', $language );
	}

	/**
	 * Set the email language
	 *
	 * @since 0.1
	 *
	 * @param object $language
	 */
	protected function set_email_language( $language ) {
		// FIXME test get_user_locale for backward compatibility with WP 4.7
		$locale = is_admin() && function_exists( 'get_user_locale' ) && version_compare( WC()->version, '2.6.14', '<' ) ? get_user_locale() : get_locale();

		if ( $locale !== $language->locale ) {
			$this->language = $language;
			add_filter( 'locale', array( $this, 'locale' ) );
			add_filter( 'plugin_locale', array( $this, 'locale' ) );
			$this->reload_text_domains( $language );
		}

		// Since WP 4.7, don't use PLL()->load_strings_translations() which rely on get_locale()
		$mo = new PLL_MO();
		$mo->import_from_db( $language );
		$GLOBALS['l10n']['pll_string'] = &$mo;

		// Set current language
		$this->saved_curlang = empty( PLL()->curlang ) ? null : PLL()->curlang;
		PLL()->curlang = $language;

		// Translates pages ids (to translate urls if any)
		foreach ( array( 'myaccount', 'shop', 'cart', 'checkout', 'terms' ) as $page ) {
			add_filter( 'option_woocommerce_' . $page . '_page_id', 'pll_get_post' );
		}

		/**
		 * Fires just after the language of the email has been set
		 *
		 * @since 0.1
		 */
		do_action( 'pllwc_email_language' );
	}

	/**
	 * Set the email language depending on the order language
	 *
	 * @since  0.1
	 *
	 * @param int|array|object $order
	 */
	public function before_order_email( $order ) {
		if ( is_numeric( $order ) ) {
			$order_id = $order;
		} elseif ( is_array( $order ) ) {
			$order_id = $order['order_id'];
		} elseif ( is_object( $order ) ) {
			// FIXME Backward compatibility with WC < 2.7
			$order_id = version_compare( WC()->version, '2.7', '<' ) ? $order->id : $order->get_id();
		}

		if ( ! empty( $order_id ) ) {
			$language = PLL()->model->post->get_language( $order_id );
			$this->set_email_language( $language );
		}
	}

	/**
	 * Set the email language depending on the user language
	 *
	 * @since 0.1
	 *
	 * @param int|string $user user ID or user login
	 */
	public function before_user_email( $user ) {
		if ( is_numeric( $user ) ) {
			$user_id = $user;
		} else {
			$user = get_user_by( 'login', $user );
			$user_id = $user->ID;
		}

		$lang = get_user_meta( $user_id, 'locale', true );
		$lang = empty( $lang ) ? get_locale() : $lang;
		$language = PLL()->model->get_language( $lang );
		$this->set_email_language( $language );
	}

	/**
	 * Set the language back after the email has been sent
	 *
	 * @since  0.1
	 */
	public function after_email() {
		if ( ! empty( $this->language ) ) {
			unset( $this->language );
			remove_filter( 'locale', array( $this, 'locale' ) );
			remove_filter( 'plugin_locale', array( $this, 'locale' ) );

			foreach ( array( 'myaccount', 'shop', 'cart', 'checkout', 'terms' ) as $page ) {
				remove_filter( 'option_woocommerce_' . $page . '_page_id', array( $this, 'translate_wc_page_id' ) );
			}

			$language = PLL()->model->get_language( get_locale() );
			$this->reload_text_domains( $language );
		}

		// Set back the current language
		PLL()->curlang = $this->saved_curlang;
	}

	/**
	 * Translate the site title which is filled before the email is triggered
	 *
	 * @since 0.5
	 *
	 * @param array  $replace Array of strings to replace placeholders in emails
	 * @param object $email   Instance of WC_Email
	 * @return array
	 */
	public function format_string_replace( $replace, $email ) {
		$replace['blogname']   = $email->get_blogname();
		$replace['site-title'] = $email->get_blogname();
		return $replace;
	}
}
