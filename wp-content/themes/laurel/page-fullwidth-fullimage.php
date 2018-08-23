<?php

	/* Template Name: Full Width Page w/ Fullwidth Image */

?>
<?php get_header(); ?>
	
	<?php get_template_part('inc/templates/post-image-full'); ?>
	
	<div class="sp-container single-fullimage">
		
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