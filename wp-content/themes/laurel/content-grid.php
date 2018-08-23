<div class="<?php if(is_home() && get_theme_mod('laurel_sidebar_homepage') == true || is_archive() && get_theme_mod('laurel_sidebar_archive') == true) : ?>sp-col-4<?php else : ?>sp-col-6<?php endif; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>
		
		<?php if(has_post_thumbnail()) : ?>
		<div class="post-img">
			<a title="thubnail" href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('laurel-misc-thumb'); ?></a>
		</div>
		<?php endif; ?>
		
		<div class="post-header <?php if(!has_post_thumbnail()) : ?>no-feat-image<?php endif; ?>">
			
			<?php if(!get_theme_mod('laurel_post_cat')) : ?>
			<span class="cat"><?php the_category('<span>&#8226;</span> '); ?></span>
			<?php endif; ?>
		
			<h3><a title="permalink" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
				
		</div>
		
		<div class="post-entry <?php if(!is_single()) : ?>is-excerpt<?php endif; ?>">
			
			<p><?php echo laurel_string_limit_words(get_the_excerpt(), 15); ?>&hellip;</p>
			
			
			<?php if(!is_single()) : ?>
			<div class="read-more-wrapper">
				<a title="read" href="<?php echo get_permalink() ?>" class="read-more"><?php esc_html_e( 'Read More', 'laurel' ); ?></a>
			</div>
			<?php endif; ?>
			
		</div>
		
	</article>
</div>