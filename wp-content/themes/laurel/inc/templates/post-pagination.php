<?php
	$prev_post = get_previous_post();
	$next_post = get_next_post();
?>
<?php if (!empty( $prev_post ) || !empty( $next_post )) : ?>
<div class="post-pagination">
	
	<?php if (!empty( $prev_post )) : ?>
	<div class="prev <?php if (empty( $next_post )) : ?>first<?php endif; ?>">
	<span class="post-pagi-title"><?php esc_html_e( 'Previous Post', 'laurel' ); ?></span>
	<a href="<?php echo get_permalink( $prev_post->ID ); ?>"><i class="fa fa-angle-left"></i> <?php echo esc_html($prev_post->post_title); ?></a>
	</div>
	<?php endif; ?>
	
	<?php if (!empty( $next_post )) : ?>
	<div class="next">
	<span class="post-pagi-title"><?php esc_html_e( 'Next Post', 'laurel' ); ?></span>
	<a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo esc_html($next_post->post_title); ?> <i class="fa fa-angle-right"></i></a>
	</div>
	<?php endif; ?>
	
</div>
<?php endif ?>