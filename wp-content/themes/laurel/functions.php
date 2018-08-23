<?php
//////////////////////////////////////////////////////////////////
// Set Content Width
//////////////////////////////////////////////////////////////////
if ( ! isset( $content_width ) )
	$content_width = 1150;
	
//////////////////////////////////////////////////////////////////
// Theme set up
//////////////////////////////////////////////////////////////////
add_action( 'after_setup_theme', 'laurel_theme_setup' );

if ( !function_exists('laurel_theme_setup') ) {

	function laurel_theme_setup() {
	
		// Register navigation menu
		register_nav_menus(
			array(
				'main-menu' => esc_html__('Primary Menu', 'laurel'),
			)
		);
		
		// Localization support
		load_theme_textdomain('laurel', get_template_directory() . '/lang');
		
		// Featured image
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'laurel-full-thumb', 1150, 0, true );
		add_image_size( 'laurel-misc-thumb', 520, 400, true );
		
		// Title tag
		add_theme_support( 'title-tag' );
		
		// Feed Links
		add_theme_support( 'automatic-feed-links' );
		
		// Post formats
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );
		
		// WooCommerce Support
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		
	}

}

//////////////////////////////////////////////////////////////////
// Register & enqueue styles/scripts
//////////////////////////////////////////////////////////////////

add_action( 'wp_enqueue_scripts','laurel_load_scripts' );

function laurel_load_scripts() {

	// Register scripts and styles
	wp_enqueue_style('laurel_style', get_stylesheet_directory_uri() . '/style.css');
	wp_enqueue_style('fontawesome-css', get_template_directory_uri() . '/css/font-awesome.min.css');
	wp_enqueue_style('bxslider-css', get_template_directory_uri() . '/css/jquery.bxslider.css');
	if(!get_theme_mod('laurel_responsive')) {
	wp_enqueue_style('laurel_respon', get_template_directory_uri() . '/css/responsive.css');
	}

	wp_enqueue_script('slicknav', get_template_directory_uri() . '/js/jquery.slicknav.min.js', array( 'jquery' ), '', true);
	wp_enqueue_script('bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array( 'jquery' ), '', true);
	wp_enqueue_script('fitvids', get_template_directory_uri() . '/js/fitvids.js', array( 'jquery' ), '', true);
	wp_enqueue_script('laurel_scripts', get_template_directory_uri() . '/js/solopine.js', array( 'jquery' ), '', true);
	
	// Register Fonts
	function laurel_fonts_url() {
		$font_url = '';
		
		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'laurel' ) ) {
			$font_url = add_query_arg( 'family', urlencode( 'Karla:400,700,400italic,700italic&subset=latin,latin-ext|Lora:400,700,700italic,400italic&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
		}
		return $font_url;
	}
	// Enqueue fonts
	wp_enqueue_style( 'laurel-fonts', laurel_fonts_url(), array(), '1.0.0' );
	
	if (is_singular() && get_option('thread_comments'))	wp_enqueue_script('comment-reply');
	
}

//////////////////////////////////////////////////////////////////
// Include files
//////////////////////////////////////////////////////////////////
// Meta Boxes
require get_template_directory() . '/functions/meta-box/meta-box.php';
require get_template_directory() . '/functions/meta-box-conditional-logic/meta-box-conditional-logic.php';
include( get_template_directory() . '/functions/sp_meta_boxes.php');

// Theme Options
include( get_template_directory() . '/functions/sp_custom_controller.php');
include( get_template_directory() . '/functions/sp_customizer_settings.php');
include( get_template_directory() . '/functions/sp_customizer_style.php');

// Widgets
include( get_template_directory() . '/inc/widgets/about_widget.php');
include( get_template_directory() . '/inc/widgets/social_widget.php');
include( get_template_directory() . '/inc/widgets/post_widget.php');
include( get_template_directory() . '/inc/widgets/facebook_widget.php');
include( get_template_directory() . '/inc/widgets/promo_widget.php');

// TGM
include( get_template_directory() . '/sp-tgm.php');

//////////////////////////////////////////////////////////////////
// Register widgets
//////////////////////////////////////////////////////////////////
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => esc_html__('Sidebar', 'laurel'),
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
		'description' => esc_html__('Widgets here will appear vertically to the right of your content.', 'laurel'),
	));
	register_sidebar(array(
		'name' => esc_html__('Instagram Footer', 'laurel'),
		'id' => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="instagram-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="instagram-title">',
		'after_title' => '</h4>',
		'description' => esc_html__('Use the "Instagram" widget here. IMPORTANT: For best result set number of photos to 6.', 'laurel'),
	));

}

//////////////////////////////////////////////////////////////////
// Logo Function
//////////////////////////////////////////////////////////////////
function laurel_get_logo() {
	if(!get_theme_mod('laurel_logo') && !get_theme_mod('laurel_text_logo')) {
		?>
			<?php if(is_front_page()) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="<?php bloginfo( 'name' ); ?>" /></a>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="<?php bloginfo( 'name' ); ?>" /></a>
			<?php endif; ?>
		<?php
	} elseif(get_theme_mod('laurel_logo') && !get_theme_mod('laurel_text_logo')) {
		?>
			<?php if(is_front_page()) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url(get_theme_mod('laurel_logo')); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url(get_theme_mod('laurel_logo')); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
			<?php endif; ?>
		<?php
	} elseif(get_theme_mod('laurel_text_logo')) {
		?>
			<?php if(is_front_page()) : ?>
				<h1 class="text-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<h3 class="text-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo bloginfo( 'name' ); ?></a></h3>
			<?php endif; ?>
		<?php
	}
}

//////////////////////////////////////////////////////////////////
// COMMENTS LAYOUT
//////////////////////////////////////////////////////////////////
function laurel_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		
		<div class="thecomment">
					
			<div class="author-img">
				<?php echo get_avatar($comment,$args['avatar_size']); ?>
			</div>
			
			<div class="comment-text">
				<span class="reply">
					<?php comment_reply_link(array_merge( $args, array('reply_text' => esc_html__('Reply', 'laurel'), 'depth' => $depth, 'max_depth' => $args['max_depth'])), $comment->comment_ID); ?>
					<?php edit_comment_link(esc_html__('Edit', 'laurel')); ?>
				</span>
				<h6 class="author"><?php echo get_comment_author_link(); ?></h6>
				<span class="date"><?php printf(esc_html__('%1$s at %2$s', 'laurel'), get_comment_date(),  get_comment_time()) ?></span>
				<?php if ($comment->comment_approved == '0') : ?>
					<em><i class="icon-info-sign"></i> <?php esc_html_e('Comment awaiting approval', 'laurel'); ?></em>
					<br />
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
					
		</div>
		
		
	</li>

	<?php 
}

//////////////////////////////////////////////////////////////////
// PAGINATION
//////////////////////////////////////////////////////////////////
function laurel_pagination() {
	
	?>
	<div class="sp-col-12">
		<div class="pagination">
			
			<div class="older"><?php next_posts_link(wp_kses( __( 'Older Posts <i class="fa fa-angle-right"></i>', 'laurel' ), array( 'i' => array( 'class' => array() ) ) )); ?></div>
			<div class="newer"><?php previous_posts_link(wp_kses( __( '<i class="fa fa-angle-left"></i> Newer Posts', 'laurel' ), array( 'i' => array( 'class' => array() ) ) )); ?></div>
			
		</div>
	</div>
					
	<?php
	
}

//////////////////////////////////////////////////////////////////
// THE EXCERPT
//////////////////////////////////////////////////////////////////
function laurel_custom_excerpt_length( $length ) {
	return 200;
}
add_filter( 'excerpt_length', 'laurel_custom_excerpt_length', 999 );

function laurel_string_limit_words($string, $word_limit)
{
	$words = explode(' ', $string, ($word_limit + 1));
	
	if(count($words) > $word_limit) {
		array_pop($words);
	}
	
	return implode(' ', $words);
}

//////////////////////////////////////////////////////////////////
// TWITTER AMPERSAND ENTITY DECODE
//////////////////////////////////////////////////////////////////
function laurel_social_title( $title ) {
    $title = html_entity_decode( $title );
    $title = urlencode( $title );
    return $title;
}

//////////////////////////////////////////////////////////////////
// Get Post Layout Function
//////////////////////////////////////////////////////////////////
function laurel_get_post_layout() {
		
	$customizer_template_setting = get_theme_mod('laurel_post_layout') ?: 'default';
	$single_template = rwmb_meta( 'laurel_meta_post_layout' );
	
	if($single_template == 'customizer') {
	
		$current_layout = $customizer_template_setting;
		return $current_layout;
	
	} elseif($single_template == 'default') {
		
		$current_layout = 'default';
		return $current_layout;
		
	} elseif($single_template == 'container-width') {
		
		$current_layout = 'container-width';
		return $current_layout;
			
	} elseif($single_template == 'default-fullimage') {
			
		$current_layout = 'default-fullimage';
		return $current_layout;
		
	} elseif($single_template == 'fullwidth-fullimage') {
			
		$current_layout = 'fullwidth-fullimage';
		return $current_layout;
		
	} else {
			
		$current_layout = $customizer_template_setting;
		return $current_layout;
	}
	
}

//////////////////////////////////////////////////////////////////
// HEX to RGB function
//////////////////////////////////////////////////////////////////
function laurel_hex2rgb($hex, $opacity = "0.14") {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
	  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
	  $r = hexdec(substr($hex,0,2));
	  $g = hexdec(substr($hex,2,2));
	  $b = hexdec(substr($hex,4,2));
   }

   echo $r . ',' . $g . ',' . $b . ',' . $opacity;
}

//////////////////////////////////////////////////////////////////
// WooCommerce functions
//////////////////////////////////////////////////////////////////

// Make sure WooCommerce is active
if ( class_exists( 'WooCommerce' ) ) {
	
	// Create WooCommerce sidebar-1
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => esc_html__('WooCommerce Sidebar', 'laurel'),
			'id' => 'sidebar-3',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			'description' => esc_html__('Widgets here will appear on your WooCommerce shop and product pages.', 'laurel'),
		));
	}
	
	// Change number or products per row to 3
	add_filter('loop_shop_columns', 'loop_columns');
	if (!function_exists('loop_columns')) {
		function loop_columns() {
			return 3; // 3 products per row
		}
	}
	
	// Display 9 products per page.
	if(get_theme_mod('laurel_woo_per_page')) :
		$sp_products_per_page = get_theme_mod('laurel_woo_per_page');
	else :
		$sp_products_per_page = 9;
	endif;

	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$sp_products_per_page.';' ), 20 );
	
	// Remove rating from shop page
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	
	// Set related products to 3
	function woo_related_products_limit() {
	  global $product;
		
		$args['posts_per_page'] = 3;
		return $args;
	}
	add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
	  function jk_related_products_args( $args ) {
		$args['posts_per_page'] = 3; // 3 related products
		$args['columns'] = 3; // arranged in 3 columns
		return $args;
	}
	
	// Set upsell items to 3 columns
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
	if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
		function woocommerce_output_upsells() {
			woocommerce_upsell_display( 3,3 ); // Display 3 products in rows of 3
		}
	}
	
	// Function for WooCommerce cart in top bar
	function my_header_add_to_cart_fragment( $fragments ) {
	 
		ob_start();
		$count = WC()->cart->cart_contents_count;
		?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart', 'laurel' ); ?>"><?php if ( $count > 0 ) echo '(' . $count . ')'; ?></a><?php
	 
		$fragments['a.cart-contents'] = ob_get_clean();
		 
		return $fragments;
	}

}

// Change Comment link Hash
add_filter( 'get_comments_link', 'laurel_comment_link', 99 );
function laurel_comment_link( $link ) {
	
    global $post;
    $hash = '#comments';
    return get_permalink( $post->ID ) . $hash;
    
}