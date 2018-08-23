<?php if(has_post_format('gallery')) : ?>
	
		<?php $images = rwmb_meta( 'laurel_meta_gallery'); ?>
		
		<?php if($images) : ?>
		<div class="post-img">
		<div class="sideslides">
		<ul class="bxslider">
		<?php foreach($images as $image) : ?>
			
			<?php $the_image = $image['full_url']; ?>
			<?php $the_caption = $image['caption']; ?>
			<li><img src="<?php echo esc_url($the_image); ?>" <?php if($the_caption) : ?>title="<?php echo esc_html($the_caption); ?>"<?php endif; ?> /></li>
			
		<?php endforeach; ?>
		</ul>
		</div>
		</div>
		<?php endif; ?>
		
<?php elseif(has_post_format('video')) : ?>

	<div class="post-img">
		
		<?php echo rwmb_meta( 'laurel_meta_oembed'); ?>
		
	</div>
	
<?php elseif(has_post_format('audio')) : ?>
	
	<div class="post-img audio <?php if(rwmb_meta( 'laurel_meta_audio_spotify') == true) : ?>spotify-audio<?php endif; ?>">
		
		<?php echo rwmb_meta( 'laurel_meta_audio_oembed'); ?>
		
	</div>
	
<?php else : ?>

	<?php if(has_post_thumbnail()) : ?>
				
		<?php if(get_theme_mod('laurel_post_thumb') == 'no_display') : elseif(get_theme_mod('laurel_post_thumb') == 'ho_display') : ?>
			
			<?php if(is_single()) : else : ?>
			
				<div class="post-img">
					<a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('laurel-full-thumb'); ?></a>
				</div>
				
			<?php endif; ?>
				
		<?php else : ?>
		
			<div class="post-img">
				<?php if(is_single()) : ?>
					<?php the_post_thumbnail('laurel-full-thumb'); ?>
				<?php else : ?>
					<a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('laurel-full-thumb'); ?></a>
				<?php endif; ?>
			</div>
			
		<?php endif; ?>
		
	<?php endif; ?>
	
<?php endif; ?>