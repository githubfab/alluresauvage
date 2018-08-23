<div class="sp-col-12">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if(rwmb_meta( 'laurel_meta_post_layout' ) == 'customizer') : ?>
	
		<?php if(is_single() && get_theme_mod('laurel_post_layout') == 'default-fullimage' || is_single() && get_theme_mod('laurel_post_layout') == 'fullwidth-fullimage') : else : ?>
	
			<?php get_template_part('inc/templates/post-image'); ?>
			
		<?php endif; ?>
		
	<?php elseif(is_single() && rwmb_meta( 'laurel_meta_post_layout' ) == 'default-fullimage' || is_single() && rwmb_meta( 'laurel_meta_post_layout' ) == 'fullwidth-fullimage') : else : ?>
		
		<?php get_template_part('inc/templates/post-image'); ?>
		
	<?php endif; ?>

	<div class="post-header <?php if(!has_post_thumbnail()) : ?>no-feat-image<?php endif; ?>">
		
		<?php if(!get_theme_mod('laurel_post_cat')) : ?>
		<span class="cat"><?php the_category('<span>&#8226;</span> '); ?></span>
		<?php endif; ?>
	
		<?php if(is_single()) : ?>
			<h1><?php the_title(); ?></h1>
		<?php else : ?>
			<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php endif; ?>
	</div>
	
	<div class="post-entry <?php if(get_theme_mod('laurel_post_summary') == 'full' || is_single()) : else : ?>is-excerpt<?php endif; ?>">
		
		<?php if(is_single()) : ?>
		
			<?php the_content('', false); ?>
			
		<?php else : ?>
		
			<?php if(get_theme_mod('laurel_post_summary') == 'full') : ?>
				
				<?php the_content('', false); ?>
				
			<?php else : ?>
				
				<p><?php echo laurel_string_limit_words(get_the_excerpt(), 26); ?>&hellip;</p>
				
			<?php endif; ?>
		
		<?php endif; ?>
		
		<?php if(!is_single()) : ?>
		<div class="read-more-wrapper">
			<a href="<?php echo get_permalink() ?>" class="read-more"><?php esc_html_e( 'Read More', 'laurel' ); ?></a>
		</div>
		<?php endif; ?>
		
		<?php wp_link_pages(); ?>
		
		<?php if(!get_theme_mod('laurel_post_tags')) : if(is_single()) : if(has_tag()) : ?>
			<div class="post-tags">
				<?php the_tags("",""); ?>
			</div>
		<?php endif; endif; endif;?>	
		
	</div>
	
	<?php if(get_theme_mod('laurel_post_date') && get_theme_mod('laurel_post_share_author') && get_theme_mod('laurel_post_share') && get_theme_mod('laurel_post_comment_link')) : else : ?>
	<div class="post-meta">
		
		<div class="meta-left">
			
			<?php if(!get_theme_mod('laurel_post_date')) : ?>
			<span class="date"><span class="by"><?php esc_html_e( 'On', 'laurel' ); ?></span> <a href="<?php echo get_permalink(); ?>"><?php the_time( get_option('date_format') ); ?></a></span>
			<?php endif; ?>
			
			<?php if(get_theme_mod('laurel_post_date') || !get_theme_mod('laurel_post_date') && get_theme_mod('laurel_post_share_author')) : else : ?>
			<span class="sep">&#8226;</span>
			<?php endif; ?>
			
			<?php if(!get_theme_mod('laurel_post_share_author')) : ?>
			<span class="author"><span class="by"><?php esc_html_e( 'By', 'laurel' ); ?></span> <?php the_author_posts_link(); ?></span>
			<?php endif; ?>
			
		</div>
		
		<?php if(get_theme_mod('solopine_post_date') && get_theme_mod('solopine_post_share_author') && get_theme_mod('solopine_post_share') && get_theme_mod('solopine_post_comment_link')) : else : ?>
		<div class="meta-right">
			<?php if(!get_theme_mod('laurel_post_share')) : ?>
			<div class="share">
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
				<a target="_blank" href="https://twitter.com/intent/tweet?text=Check%20out%20this%20article:%20<?php print laurel_social_title( get_the_title() ); ?>&url=<?php echo urlencode(the_permalink()); ?>"><i class="fa fa-twitter"></i></a>
				<?php $pin_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>
				<a data-pin-do="none" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(the_permalink()); ?>&media=<?php echo esc_url($pin_image); ?>&description=<?php print laurel_social_title( get_the_title() ); ?>"><i class="fa fa-pinterest"></i></a>
				<a target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a>
			</div>
			<?php endif; ?>
			<?php if(!get_theme_mod('laurel_post_comment_link')) : ?>
			<div class="meta-comment">
				<a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?> <i class="fa fa-comment-o"></i></a>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		
	</div>
	<?php endif; ?>
	
	<!-- Display Author Box -->
	<?php if(!get_theme_mod('laurel_post_author')) : ?>
	<?php if(is_single()) : ?>
	<?php get_template_part('inc/templates/post-author'); ?>
	<?php endif; ?>
	<?php endif; ?>
	
	<!-- Display Related Posts -->
	<?php if(!get_theme_mod('laurel_post_related')) : ?>
	<?php if(is_single()) : ?>
	<?php get_template_part('inc/templates/post-related'); ?>
	<?php endif; ?>
	<?php endif; ?>
	
	<!-- Display Post Pagination -->
	<?php if(!get_theme_mod('laurel_post_pagination_hide')) : ?>
	<?php if(is_single()) : ?>
	<?php get_template_part('inc/templates/post-pagination'); ?>
	<?php endif; ?>
	<?php endif; ?>
	
	<?php comments_template( '', true );  ?>
	
</article>
</div>