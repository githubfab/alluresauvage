<?php get_header(); ?>
	
	<div class="sp-container">
		
		<div class="sp-row">
			
			<div id="main" <?php if(get_theme_mod('laurel_woo_layout') == 'sidebar') : else : ?>class="fullwidth"<?php endif; ?>>
				
				<?php woocommerce_content(); ?>
			
			</div>

<?php if(get_theme_mod('laurel_woo_layout') == 'sidebar') : ?><?php get_sidebar('woocommerce'); ?><?php endif; ?>
<?php get_footer(); ?>