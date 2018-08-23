	<div class="sp-container">
		
		<div class="sp-row">
		
			<div id="main" class="fullwidth">
			
				<div class="sp-row post-layout">
			
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<?php get_template_part('content'); ?>
						
				<?php endwhile; ?>
				
				<?php endif; ?>
				
				</div>
				
			</div>