<?php if(has_post_format('gallery')) : ?>

	<?php $images = rwmb_meta( 'laurel_meta_gallery'); ?>
	
	<?php if($images) : ?>
	<div class="fullimage-gallery">
	<div class="sideslides">
	<div class="bxslider">
	<?php foreach($images as $image) : ?>
		
		<?php $the_image = $image['full_url']; ?>
		<?php $the_caption = $image['caption']; ?>
		
		<div class="post-img-full" style="background-image:url(<?php echo $the_image; ?>);">
			<?php if($the_caption) : ?>
				<div class="fullimage-gallery-caption">
					<p><?php echo $the_caption; ?></p>
				</div>
			<?php endif; ?>
		</div>
		
	<?php endforeach; ?>
	</div>
	</div>
	</div>
	<?php endif; ?>

<?php elseif(has_post_format('video')) : ?>
	
	<?php 
	
		if( rwmb_meta( 'laurel_meta_custom_video_bg') ) {
			$get_custom_feat_image = rwmb_meta( 'laurel_meta_custom_video_bg', 'size=full&limit=1');
			$feat_image = $get_custom_feat_image[0]['full_url'];
		} else {
			if(has_post_thumbnail()) {
				$get_feat_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
				$feat_image = $get_feat_image[0];
			} else {
				$feat_image = get_template_directory_uri() . '/img/slider-default.png';
			}
		}
	
	?>
	
	<div class="post-img-full video" style="background-image:url(<?php echo $feat_image; ?>);">
		<div class="post-video-full">
			<div class="video-full">
				<?php echo rwmb_meta( 'laurel_meta_oembed'); ?>
			</div>
		</div>
	</div>
	
<?php elseif(has_post_format('audio')) : ?>

	<?php 
	
		if( rwmb_meta( 'laurel_meta_custom_audio_bg') ) {
			$get_custom_feat_image = rwmb_meta( 'laurel_meta_custom_audio_bg', 'size=full&limit=1');
			$feat_image = $get_custom_feat_image[0]['full_url'];
		} else {
			if(has_post_thumbnail()) {
				$get_feat_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
				$feat_image = $get_feat_image[0];
			} else {
				$feat_image = get_template_directory_uri() . '/img/slider-default.png';
			}
		}
	
	?>
	
	<div class="post-img-full video audio <?php if(rwmb_meta( 'laurel_meta_audio_spotify') == true) : ?>spotify-audio<?php endif; ?>" style="background-image:url(<?php echo $feat_image; ?>);">
		<div class="post-video-full">
			<div class="video-full">
				<?php echo rwmb_meta( 'laurel_meta_audio_oembed'); ?>
			</div>
		</div>
	</div>
	
<?php else : ?>
	
	
	<?php 
	
		if( rwmb_meta( 'laurel_meta_custom_bg_image') ) {
			$get_custom_feat_image = rwmb_meta( 'laurel_meta_custom_bg_image', 'size=full&limit=1');
			$feat_image = $get_custom_feat_image[0]['full_url'];
		} else {
			if(has_post_thumbnail()) {
				$get_feat_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
				$feat_image = $get_feat_image[0];
			} else {
				$feat_image = get_template_directory_uri() . '/img/slider-default.png';
			}
		}
	
	?>

	<div class="post-img-full" style="background-image:url(<?php echo $feat_image; ?>);"></div>
	
<?php endif; ?>