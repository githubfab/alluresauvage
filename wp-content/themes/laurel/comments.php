<div class="post-comments" id="comments">
	
	<?php 
		if ( comments_open() ) :
		echo '<h4 class="block-heading">';
		comments_number(esc_html__('No Comments','laurel'), esc_html__('1 Comment','laurel'), '% ' . esc_html__('Comments','laurel') );
		echo '</h4>';
		endif;

		echo "<div class='comments'><ul>";
		
			wp_list_comments(array(
				'avatar_size'	=> 60,
				'style'			=> 'ul',
				'callback'		=> 'laurel_comments',
				'type'			=> 'all'
			));

		echo "</ul></div>";

		echo "<div id='comments_pagination'>";
			paginate_comments_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;'));
		echo "</div>";

		$custom_comment_field = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';  //label removed for cleaner layout

		comment_form(array(
			'comment_field'			=> $custom_comment_field,
			'comment_notes_after'	=> '',
			'logged_in_as' 			=> '',
			'comment_notes_before' 	=> '',
			'title_reply'			=> esc_html__('Leave a Reply', 'laurel'),
			'cancel_reply_link'		=> esc_html__('Cancel Reply', 'laurel'),
			'label_submit'			=> esc_html__('Post Comment', 'laurel')
		));
	 ?>


</div> <!-- end comments div -->