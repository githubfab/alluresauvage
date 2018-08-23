<div class="sp-col-12">
	<article id="post-<?php the_ID(); ?>" <?php post_class('list-item'); ?>>
		
		<?php if(has_post_thumbnail()) : ?>
		<div class="post-img">
			<a title="link" href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('laurel-misc-thumb'); ?></a>
		</div>
		<?php endif; ?>
		
		<div class="list-content">
		
			<div class="post-header <?php if(!has_post_thumbnail()) : ?>no-feat-image<?php endif; ?>">
				
				<?php if(!get_theme_mod('laurel_post_cat')) : ?>
				<span class="cat"><?php the_category('<span>&#8226;</span> '); ?></span>
				<?php endif; ?>
			
				<h3><a title="link" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>

			</div>
			
			<div class="post-entry <?php if(!is_single()) : ?>is-excerpt<?php endif; ?>">
				
				<p><?php echo laurel_string_limit_words(get_the_excerpt(), 18); ?>&hellip;</p>
				
				<?php if(!is_single()) : ?>
				<div class="read-more-wrapper">
					<a title="link" href="<?php echo get_permalink() ?>" class="read-more"><?php esc_html_e( 'Read More', 'laurel' ); ?></a>
				</div>
				<?php endif; ?>
				
			</div>
			
			<?php if(get_theme_mod('laurel_post_date') && get_theme_mod('laurel_post_share') && get_theme_mod('laurel_post_comment_link')) : else : ?>
			<div class="post-meta">
		
				<div class="meta-left">
					<?php if(!get_theme_mod('laurel_post_date')) : ?>
					<span class="date"><span class="by"><?php esc_html_e( 'On', 'laurel' ); ?></span> <a href="<?php echo get_permalink(); ?>"><?php the_time( get_option('date_format') ); ?></a></span>
					<?php endif; ?>
				</div>
				
				<div class="meta-right">
					<?php if(!get_theme_mod('laurel_post_share')) : ?>
					<div class="share">
						<a title="link" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
						<a target="_blank" href="https://twitter.com/intent/tweet?text=Check%20out%20this%20article:%20<?php print laurel_social_title( get_the_title() ); ?>&url=<?php echo urlencode(the_permalink()); ?>"><i class="fa fa-twitter"></i></a>
						<?php $pin_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>
						<a title="link" data-pin-do="none" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(the_permalink()); ?>&media=<?php echo esc_url($pin_image); ?>&description=<?php print laurel_social_title( get_the_title() ); ?>"><i class="fa fa-pinterest"></i></a>
						<a title="link" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a>
					</div>
					<?php endif; ?>
					<?php if(!get_theme_mod('laurel_post_comment_link')) : ?>
					<div class="meta-comment">
						<a title="link" href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?> <i class="fa fa-comment-o"></i></a>
					</div>
					<?php endif; ?>
				</div>
				
			</div>
			<?php endif; ?>
		
		</div>
		
	</article>
</div>