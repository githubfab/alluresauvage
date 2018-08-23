<?php

	/* Template Name: Full Width Page w/ Slider */

?>
<?php get_header(); ?>

	<?php get_template_part('inc/featured/featured'); ?>
	
	<?php if(get_theme_mod( 'laurel_promo' ) == true) : ?>
		<?php get_template_part('inc/promo/promo'); ?>
	<?php endif; ?>
	
	<div class="sp-container">
		
		<div class="sp-row">
		
			<div id="main" class="fullwidth">
			
				<div class="sp-row post-layout">
			
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
						<?php get_template_part('content', 'page'); ?>
							
					<?php endwhile; ?>
					
					<?php endif; ?>
				
				</div>
				
			</div>

<?php get_footer(); ?>