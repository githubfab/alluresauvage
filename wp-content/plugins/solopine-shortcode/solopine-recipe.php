<?php
/*
Plugin Name: Solo Pine Shortcode
Plugin URI: http://solopine.com
Description: Adds an archive index shortcode
Author: Solo Pine
Version: 1.0
Author URI: http://solopine.com
*/

function laurel_index_func( $atts ){
	
	$a = shortcode_atts( array(
        'cat' => '',
		'title' => '',
        'amount' => '3',
		'cols' => '3',
		'display_title' => 'yes',
		'display_cat' => 'no',
		'display_image' => 'yes',
		'cat_link' => 'yes',
		'cat_link_text' => 'View All',
		'offset' => ''
    ), $atts );
	
	$index_cat = $a['cat'];
	$index_title = $a['title'];
	$index_amount = $a['amount'];
	$index_cols = $a['cols'];
	$index_display_title = $a['display_title'];
	$index_display_cat = $a['display_cat'];
	$index_display_image = $a['display_image'];
	$index_cat_link = $a['cat_link'];
	$index_cat_text = $a['cat_link_text'];
	$offset = $a['offset'];
	
	$query = new WP_Query( array( 'category_name' => $index_cat, 'posts_per_page' => $index_amount, 'ignore_sticky_posts' => true, 'offset' => $offset ) );
	
	ob_start(); ?>
		
		<?php
			if($index_cat) : 
				$idObj = get_category_by_slug($index_cat); 
				$id = $idObj->term_id;
				$cat_link = get_category_link( $id );
			endif;
		?>
		
		<div class="index-shortcode">
		
		<?php if($index_title) : ?>
		<h4 class="index-heading"><span><?php echo esc_html($index_title); ?></span>
		<?php if($index_cat_link == "yes" && $cat_link) : ?>
		<a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($index_cat_text); ?> <i class="fa fa-angle-double-right"></i></a>
		<?php endif; ?>
		</h4>
		<?php endif; ?>
		
		<?php if ( $query->have_posts() ) : ?>
		
		<div class="sp-row post-layout grid">
		
		<?php
			if($index_cols == '3') :
				$cols = 4;
			elseif($index_cols == '4') :
				$cols = 3;
			else :
				$cols = 4;
			endif;
		?>
		
		
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			
			<div class="sp-col-<?php echo $cols; ?> index-item">
			<article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>
				
				<?php if($index_display_image != 'no') : ?>
				<div class="post-img">
					<a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('laurel-misc-thumb'); ?></a>
				</div>
				<?php endif; ?>
				
				<div class="post-header">
					
					<?php if($index_display_cat == 'yes') : ?>
					<span class="cat"><?php the_category('<span>&#8226;</span> '); ?></span>
					<?php endif; ?>
					
					<?php if($index_display_title != 'no') : ?>
					<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>
					
				</div>
				
			</article>
			</div>
			
		
		<?php endwhile; ?>
		
		</div>
		
		<?php wp_reset_postdata(); ?>
		
		<?php endif; ?>
		
		</div>
	
	<?php
	return ob_get_clean();
	
}
add_shortcode( 'laurel_index', 'laurel_index_func' );

//////////////////////////////////////////////////////////////////
// AUTHOR SOCIAL LINKS
//////////////////////////////////////////////////////////////////
function solopine_contactmethods( $contactmethods ) {

	$contactmethods['twitter']   = 'Twitter Username';
	$contactmethods['facebook']  = 'Facebook Username';
	$contactmethods['google']    = 'Google Plus Username';
	$contactmethods['tumblr']    = 'Tumblr Username';
	$contactmethods['instagram'] = 'Instagram Username';
	$contactmethods['pinterest'] = 'Pinterest Username';

	return $contactmethods;
}
add_filter('user_contactmethods','solopine_contactmethods',10,1);