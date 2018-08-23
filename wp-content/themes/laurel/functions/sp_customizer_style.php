<?php
//////////////////////////////////////////////////////////////////
// Customizer - Add CSS
//////////////////////////////////////////////////////////////////
function laurel_customizer_css() {
    ?>
    <style type="text/css">
	
		<?php if(get_theme_mod('laurel_logo_width')) : ?>#logo img, #logo-secondary img { max-width:<?php echo get_theme_mod('laurel_logo_width'); ?>%; }<?php endif; ?>
		<?php if(get_theme_mod('laurel_secondary_header_top')) : ?>#logo-secondary { padding-top:<?php echo get_theme_mod('laurel_secondary_header_top'); ?>px; }<?php endif; ?>
		<?php if(get_theme_mod('laurel_secondary_header_bottom')) : ?>#logo-secondary { padding-bottom:<?php echo get_theme_mod('laurel_secondary_header_bottom'); ?>px; }<?php endif; ?>
		<?php if(get_theme_mod('laurel_text_logo_size')) : ?>.text-logo { font-size:<?php echo get_theme_mod('laurel_text_logo_size'); ?>px; }<?php endif; ?>
		<?php if(get_theme_mod('laurel_text_logo_weight')) : ?>.text-logo { font-weight:<?php echo get_theme_mod('laurel_text_logo_weight'); ?>; }<?php endif; ?>
		<?php if(get_theme_mod('laurel_text_logo_color')) : ?>.text-logo a{ color:<?php echo get_theme_mod('laurel_text_logo_color'); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_bg_color' )) : ?>body { background-color:<?php echo get_theme_mod( 'laurel_bg_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_bg_image' )) : ?>body { background-image:url(<?php echo get_theme_mod( 'laurel_bg_image' ); ?>); }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_bg_repeat' )) : ?>body { background-repeat:<?php echo get_theme_mod( 'laurel_bg_repeat' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_bg_size' )) : ?>body { background-size:<?php echo get_theme_mod( 'laurel_bg_size' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_bg_position' )) : ?>body { background-position:<?php echo get_theme_mod( 'laurel_bg_position' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_bg_attachment' )) : ?>body { background-attachment:<?php echo get_theme_mod( 'laurel_bg_attachment' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_2header_bg_color' )) : ?>#logo-secondary { background-color:<?php echo get_theme_mod( 'laurel_2header_bg_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_2header_bg_image' )) : ?>#logo-secondary { background-image:url(<?php echo get_theme_mod( 'laurel_2header_bg_image' ); ?>); }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_2header_bg_repeat' )) : ?>#logo-secondary { background-repeat:<?php echo get_theme_mod( 'laurel_2header_bg_repeat' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_2header_bg_size' )) : ?>#logo-secondary { background-size:<?php echo get_theme_mod( 'laurel_2header_bg_size' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_2header_bg_position' )) : ?>#logo-secondary { background-position:<?php echo get_theme_mod( 'laurel_2header_bg_position' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_2header_bg_attachment' )) : ?>#logo-secondary { background-attachment:<?php echo get_theme_mod( 'laurel_2header_bg_attachment' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_wrapper_color' )) : ?>#wrapper { box-shadow:0 0 15px 15px rgba(<?php laurel_hex2rgb(get_theme_mod( 'laurel_wrapper_color' ), get_theme_mod( 'laurel_wrapper_opacity', '0.14' )) ?>); } <?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_header_bg_color' )) : ?>#top-bar { background-color:<?php echo get_theme_mod( 'laurel_header_bg_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_menu_color' )) : ?>#nav-wrapper .menu li a { color:<?php echo get_theme_mod( 'laurel_menu_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_menu_color_hover' )) : ?>#nav-wrapper .menu li a:hover { color:<?php echo get_theme_mod( 'laurel_menu_color_hover' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_menu_dropdown_arrow' )) : ?>#nav-wrapper .menu > li.menu-item-has-children > a:after { color:<?php echo get_theme_mod( 'laurel_menu_dropdown_arrow' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_menu_dropdown_bg' )) : ?>#nav-wrapper .menu .sub-menu, #nav-wrapper .menu .children { background-color:<?php echo get_theme_mod( 'laurel_menu_dropdown_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_menu_dropdown_border' )) : ?>#top-bar #navigation #nav-wrapper ul.menu ul a, #top-bar #navigation #nav-wrapper .menu ul ul a { border-color:<?php echo get_theme_mod( 'laurel_menu_dropdown_border' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_menu_dropdown_text_color' )) : ?>#top-bar #navigation #nav-wrapper ul.menu ul a, #top-bar #navigation #nav-wrapper .menu ul ul a { color:<?php echo get_theme_mod( 'laurel_menu_dropdown_text_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_menu_dropdown_text_hover_bg' )) : ?>#nav-wrapper ul.menu ul a:hover, #nav-wrapper .menu ul ul a:hover { background-color:<?php echo get_theme_mod( 'laurel_menu_dropdown_text_hover_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_menu_dropdown_text_hover_color' )) : ?>#top-bar #navigation #nav-wrapper ul.menu ul a:hover, #top-bar #navigation #nav-wrapper .menu ul ul a:hover { color:<?php echo get_theme_mod( 'laurel_menu_dropdown_text_hover_color' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_header_social_color' )) : ?>#top-social a { color:<?php echo get_theme_mod( 'laurel_header_social_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_header_social_color_hover' )) : ?>#top-social a:hover { color:<?php echo get_theme_mod( 'laurel_header_social_color_hover' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_header_search_icon' )) : ?>#top-search a  { color:<?php echo get_theme_mod( 'laurel_header_search_icon' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_header_search_icon_hover' )) : ?>#top-search a:hover  { color:<?php echo get_theme_mod( 'laurel_header_search_icon_hover' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_header_search_input_bg' )) : ?>#show-search input { background-color:<?php echo get_theme_mod( 'laurel_header_search_input_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_header_search_input_text' )) : ?>#show-search input, #show-search ::-webkit-input-placeholder, #show-search i.search-icon { color:<?php echo get_theme_mod( 'laurel_header_search_input_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_header_search_input_close' )) : ?>#show-search .close-search { color:<?php echo get_theme_mod( 'laurel_header_search_input_close' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_header_search_input_close_hover' )) : ?>#show-search a.close-search:hover { color:<?php echo get_theme_mod( 'laurel_header_search_input_close_hover' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_mobile_show' )) : ?>.slicknav_menu .slicknav_menutxt { color:<?php echo get_theme_mod( 'laurel_mobile_show' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_mobile_show_hover' )) : ?>.slicknav_menu .slicknav_menutxt:hover { color:<?php echo get_theme_mod( 'laurel_mobile_show_hover' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_mobile_burger' )) : ?>.slicknav_menu .slicknav_icon-bar { background-color:<?php echo get_theme_mod( 'laurel_mobile_burger' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_mobile_dropdown_bg' )) : ?>.slicknav_nav, .slicknav_nav ul { background-color:<?php echo get_theme_mod( 'laurel_mobile_dropdown_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_mobile_dropdown_border' )) : ?>.slicknav_nav a { border-color:<?php echo get_theme_mod( 'laurel_mobile_dropdown_border' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_mobile_dropdown_text' )) : ?>.slicknav_nav a { color:<?php echo get_theme_mod( 'laurel_mobile_dropdown_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_mobile_dropdown_text_hover' )) : ?>.slicknav_nav a:hover { color:<?php echo get_theme_mod( 'laurel_mobile_dropdown_text_hover' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_mobile_dropdown_text_bg_hover' )) : ?>.slicknav_nav a:hover, .slicknav_nav .slicknav_item:hover { background-color:<?php echo get_theme_mod( 'laurel_mobile_dropdown_text_bg_hover' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_promo_color_bg' )) : ?>#promo-area { background:<?php echo get_theme_mod( 'laurel_promo_color_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_promo_color_overlay_bg' )) : ?>.promo-overlay h4 { background:<?php echo get_theme_mod( 'laurel_promo_color_overlay_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_promo_color_overlay_text' )) : ?>.promo-overlay h4 { color:<?php echo get_theme_mod( 'laurel_promo_color_overlay_text' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_sidebar_color_border' )) : ?>.widget { border-color:<?php echo get_theme_mod( 'laurel_sidebar_color_border' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_sidebar_color_title' )) : ?>.widget-title { color:<?php echo get_theme_mod( 'laurel_sidebar_color_title' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_sidebar_social_color' )) : ?>.social-widget a { color:<?php echo get_theme_mod( 'laurel_sidebar_social_color' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_sidebar_social_color_hover' )) : ?>.social-widget a:hover { color:<?php echo get_theme_mod( 'laurel_sidebar_social_color_hover' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_footer_color_social_bg' )) : ?>#footer { background:<?php echo get_theme_mod( 'laurel_footer_color_social_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_footer_color_social_text' )) : ?>#footer-social a { color:<?php echo get_theme_mod( 'laurel_footer_color_social_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_footer_color_social_text_hover' )) : ?>#footer-social a:hover { color:<?php echo get_theme_mod( 'laurel_footer_color_social_text_hover' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_footer_color_copy_bg' )) : ?>#footer-bottom { background:<?php echo get_theme_mod( 'laurel_footer_color_copy_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_footer_color_copy_text' )) : ?>#footer-bottom { color:<?php echo get_theme_mod( 'laurel_footer_color_copy_text' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_post_color_title' )) : ?>.post-header h2 a, .post-header h1, .feat-overlay h2, .feat-overlay h2 a { color:<?php echo get_theme_mod( 'laurel_post_color_title' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_color_cat' )) : ?>.feat-overlay .cat a, .post-header .cat a { color:<?php echo get_theme_mod( 'laurel_post_color_cat' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_color_text' )) : ?>.post-entry, .post-entry p { color:<?php echo get_theme_mod( 'laurel_post_color_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_color_text_heading' )) : ?>.post-entry h1, .post-entry h2, .post-entry h3, .post-entry h4, .post-entry h5, .post-entry h6 { color:<?php echo get_theme_mod( 'laurel_post_color_text_heading' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_color_more_bg' )) : ?>.post-entry .read-more, .read-more { background:<?php echo get_theme_mod( 'laurel_post_color_more_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_color_more_text' )) : ?>.post-entry .read-more, .read-more { color:<?php echo get_theme_mod( 'laurel_post_color_more_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_tag_bg' )) : ?>.widget .tagcloud a, .post-tags a { background:<?php echo get_theme_mod( 'laurel_post_tag_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_tag_text' )) : ?>.widget .tagcloud a, .post-tags a { color:<?php echo get_theme_mod( 'laurel_post_tag_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_tag_bg_hover' )) : ?>.widget .tagcloud a:hover, .post-tags a:hover { background:<?php echo get_theme_mod( 'laurel_post_tag_bg_hover' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_tag_text_hover' )) : ?>.widget .tagcloud a:hover, .post-tags a:hover { color:<?php echo get_theme_mod( 'laurel_post_tag_text_hover' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_quote_border' )) : ?>.post-entry blockquote, .entry-content blockquote { border-color:<?php echo get_theme_mod( 'laurel_post_quote_border' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_quote_text' )) : ?>.post-entry blockquote p, .entry-content blockquote p { color:<?php echo get_theme_mod( 'laurel_post_quote_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_post_share_color' )) : ?>.share a { color:<?php echo get_theme_mod( 'laurel_post_share_color' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_newsletter_bg' )) : ?>.subscribe-box { background:<?php echo get_theme_mod( 'laurel_newsletter_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_newsletter_title' )) : ?>.subscribe-box h4 { color:<?php echo get_theme_mod( 'laurel_newsletter_title' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_newsletter_text' )) : ?>.subscribe-box p { color:<?php echo get_theme_mod( 'laurel_newsletter_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_newsletter_input_bg' )) : ?>.subscribe-box input { background:<?php echo get_theme_mod( 'laurel_newsletter_input_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_newsletter_input_text' )) : ?>.subscribe-box ::-webkit-input-placeholder, .subscribe-box input { color:<?php echo get_theme_mod( 'laurel_newsletter_input_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_newsletter_submit_bg' )) : ?>.subscribe-box input[type=submit] { background:<?php echo get_theme_mod( 'laurel_newsletter_submit_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_newsletter_submit_text' )) : ?>.subscribe-box input[type=submit] { color:<?php echo get_theme_mod( 'laurel_newsletter_submit_text' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_newsletter_submit_bg_hover' )) : ?>.subscribe-box input[type=submit]:hover { background:<?php echo get_theme_mod( 'laurel_newsletter_submit_bg_hover' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_newsletter_submit_text_hover' )) : ?>.subscribe-box input[type=submit]:hover { color:<?php echo get_theme_mod( 'laurel_newsletter_submit_text_hover' ); ?>; }<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_misc_color_accent' )) : ?>a, .woocommerce .star-rating, .cart-contents .sp-count { color:<?php echo get_theme_mod( 'laurel_misc_color_accent' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_misc_color_archive_bg' )) : ?>.archive-box-wrapper, .archive-box { background:<?php echo get_theme_mod( 'laurel_misc_color_archive_bg' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_misc_color_archive_border' )) : ?>.archive-box { border-color:<?php echo get_theme_mod( 'laurel_misc_color_archive_border' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_misc_color_archive_browsing' )) : ?>.archive-box span{ color:<?php echo get_theme_mod( 'laurel_misc_color_archive_browsing' ); ?>; }<?php endif; ?>
		<?php if(get_theme_mod( 'laurel_misc_color_archive_title' )) : ?>.archive-box h1{ color:<?php echo get_theme_mod( 'laurel_misc_color_archive_title' ); ?>; }<?php endif; ?>
		
		<?php if(is_single() && laurel_get_post_layout() == 'default-fullimage' || is_single() && laurel_get_post_layout() == 'fullwidth-fullimage') : ?>
		
		<?php if(rwmb_meta( 'laurel_meta_post_layout' ) == 'default-fullimage' || rwmb_meta( 'laurel_meta_post_layout' ) == 'fullwidth-fullimage') { $feat_height = rwmb_meta( 'laurel_meta_fullimage_height' ); } else { $feat_height = get_theme_mod('laurel_truefull_height'); } ?>
		
		.post-img-full {
			height:<?php echo $feat_height; ?>px;
		}
		@media only screen and (max-width : 1400px) {
			.post-img-full {
				height:<?php $get_ratio1 = $feat_height / 1500; $new_height1 = 1280 * $get_ratio1; echo $new_height1 . 'px'; ?>
			}
		}
		@media only screen and (min-width: 942px) and (max-width: 1170px) {
			.post-img-full {
				height:<?php $get_ratio2 = $new_height1 / 1280; $new_height2 = 940 * $get_ratio2; echo $new_height2 . 'px'; ?>
			}
		}
		@media only screen and (min-width: 768px) and (max-width: 960px) {
			.post-img-full {
				height:<?php $get_ratio3 = $new_height2 / 940; $new_height3 = 726 * $get_ratio3; echo $new_height3 . 'px'; ?>
			}
		}
		@media only screen and (min-width: 480px) and (max-width: 768px) {
			.post-img-full {
				height:<?php $get_ratio4 = $new_height3 / 726; $new_height4 = 480 * $get_ratio4; if($new_height4 < 250) : $new_height4 = 250; endif; echo $new_height4 . 'px'; ?>
			}
		}
		@media only screen and (min-width: 100px) and (max-width: 479px) {
			.post-img-full {
				height:<?php $get_ratio5 = $new_height4 / 480; $new_height5 = 300 * $get_ratio5; if($new_height5 < 220) : $new_height5 = 220; endif; echo $new_height5 . 'px'; ?>
			}
		}
		<?php endif; ?>
		
		<?php if(get_theme_mod( 'laurel_custom_css' )) : ?>
		<?php echo get_theme_mod( 'laurel_custom_css' ); ?>
		<?php endif; ?>
		
    </style>
    <?php
}
add_action( 'wp_head', 'laurel_customizer_css' );

?>