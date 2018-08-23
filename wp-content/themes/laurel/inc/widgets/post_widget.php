<?php
/**
 * Plugin Name: Latest Posts Widget
 */

add_action( 'widgets_init', 'laurel_latest_news_load_widget' );

function laurel_latest_news_load_widget() {
	register_widget( 'laurel_latest_news_widget' );
}

class laurel_latest_news_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function laurel_latest_news_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'laurel_latest_news_widget', 'description' => __('A widget that displays your latest posts from all categories or a certain', 'laurel') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'laurel_latest_news_widget' );

		/* Create the widget. */
		parent::__construct( 'laurel_latest_news_widget', __('Laurel: Latest Posts', 'laurel'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$layout = $instance['layout'];
		$categories = $instance['categories'];
		$number = $instance['number'];
		$date = $instance['date'];
		
		$query = array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'cat' => $categories);
		
		$loop = new WP_Query($query);
		if ($loop->have_posts()) :
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		?>
			
			<?php  while ($loop->have_posts()) : $loop->the_post(); ?>
				
				<div class="side-pop <?php if($layout == 'small_thumb') : ?>list<?php endif; ?>">
					
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : ?>
					<div class="side-pop-img">
						<a href="<?php echo get_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('laurel-misc-thumb'); ?></a>
					</div>
					<?php endif; ?>
					
					<div class="side-pop-content">
						<h4><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h4>
						<?php if(!$date) : ?><span class="date"><?php the_time( get_option('date_format') ); ?></span><?php endif; ?>
					</div>
				
				</div>
			
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
			<?php endif; ?>
			
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['layout'] = $new_instance['layout'];
		$instance['categories'] = $new_instance['categories'];
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['date'] = strip_tags( $new_instance['date'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Latest Posts', 'laurel'), 'number' => 5, 'categories' => '', 'layout' => '', 'date' => false);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'laurel'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>
		
		<!-- Layout -->
		<p>
		<label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e( 'Choose Layout', 'laurel' ); ?>:</label> 
		<select id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>" class="widefat categories" style="width:100%;">
			<option value='big_thumb' <?php if ('big_thumb' == $instance['layout']) echo 'selected="selected"'; ?>><?php _e( 'Big Thumbnail', 'laurel' ); ?></option>
			<option value='small_thumb' <?php if ('small_thumb' == $instance['layout']) echo 'selected="selected"'; ?>><?php _e( 'Small Thumbnail', 'laurel' ); ?></option>
		</select>
		</p>
		
		<!-- Category -->
		<p>
		<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e( 'Filter by Category', 'laurel' ); ?>:</label> 
		<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
			<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All categories</option>
			<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
			<?php foreach($categories as $category) { ?>
			<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
			<?php } ?>
		</select>
		</p>
		
		<!-- Number of posts -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show:', 'laurel'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php _e( 'Hide Date', 'laurel' ); ?>:</label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" <?php checked( (bool) $instance['date'], true ); ?> />
		</p>


	<?php
	}
}

?>