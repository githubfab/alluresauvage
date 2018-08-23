	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<?php get_template_part('inc/templates/post-image-full'); ?>
	
	<div class="sp-container <?php if(has_post_thumbnail() || has_post_format('video') || has_post_format('gallery') || has_post_format('audio')) : ?>single-fullimage<?php endif; ?>">
		
		<div class="sp-row">
		
			<div id="main">
			
				<div class="sp-row post-layout">
			
					<?php get_template_part('content'); ?>
						
				</div>
				
			</div>
			
	<?php endwhile; ?>		
	<?php endif; ?>

<?php get_sidebar(); ?>