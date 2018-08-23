<div class="sp-col-12">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if(is_page_template('page-default-fullimage.php') || is_page_template('page-fullwidth-fullimage.php')) : else : ?>
	<?php if(has_post_thumbnail()) : ?>
	<div class="post-img">
		<a title="title" href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('laurel-full-thumb'); ?></a>
	</div>
	<?php endif; ?>
	<?php endif; ?>
	
	<?php if(!get_theme_mod('laurel_page_title')) : ?>
	<div class="post-header">
		<h1><?php the_title(); ?></h1>
	</div>
	<?php endif; ?>
	
	<div class="post-entry">
		
		<?php the_content('', false); ?>
		
	</div>
	
	<?php if(!get_theme_mod('laurel_page_share') || comments_open()) : ?>
	<div class="post-meta">
		
		<div class="meta-left">
			<?php if(!get_theme_mod('laurel_page_share')) : ?>
			<div class="share">
				<a title="face" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
				<a title="tw" target="_blank" href="https://twitter.com/intent/tweet?text=Check%20out%20this%20article:%20<?php print laurel_social_title( get_the_title() ); ?>&url=<?php echo urlencode(the_permalink()); ?>"><i class="fa fa-twitter"></i></a>
				<?php $pin_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>
				<a title="pint" data-pin-do="none" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(the_permalink()); ?>&media=<?php echo esc_url($pin_image); ?>&description=<?php print laurel_social_title( get_the_title() ); ?>"><i class="fa fa-pinterest"></i></a>
				<a title="plus" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a>
			</div>
			<?php endif; ?>
		</div>
		
		<div class="meta-right">
			<?php if(comments_open()) : ?>
			<div class="meta-comment">
				<a title="coment" href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?> <i class="fa fa-comment-o"></i></a>
			</div>
			<?php endif; ?>
		</div>
		
	</div>
	<?php endif; ?>
	
	<?php if(comments_open()) : ?>
	<?php comments_template( '', true );  ?>
	<?php endif; ?>
	
</article>
</div>