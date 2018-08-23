			
			<!-- END ROW -->
			</div>
			
		<!-- END CONTAINER -->
		</div>
		
		<footer id="footer">
			
			<div id="ig-footer">
				<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('sidebar-2') ) ?>
			</div>
			
			<?php if(!get_theme_mod('laurel_footer_share')) : ?>
			<div class="container">
				
				<div id="footer-social">
					
					<?php if(get_theme_mod('laurel_facebook')) : ?><a href="http://facebook.com/<?php echo esc_html(get_theme_mod('laurel_facebook')); ?>" target="_blank"><i class="fa fa-facebook"></i> <span><?php esc_html_e( 'Facebook', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_twitter')) : ?><a href="http://twitter.com/<?php echo esc_html(get_theme_mod('laurel_twitter')); ?>" target="_blank"><i class="fa fa-twitter"></i> <span><?php esc_html_e( 'Twitter', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_instagram')) : ?><a href="http://instagram.com/<?php echo esc_html(get_theme_mod('laurel_instagram')); ?>" target="_blank"><i class="fa fa-instagram"></i> <span><?php esc_html_e( 'Instagram', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_pinterest')) : ?><a href="http://pinterest.com/<?php echo esc_html(get_theme_mod('laurel_pinterest')); ?>" target="_blank"><i class="fa fa-pinterest"></i> <span><?php esc_html_e( 'Pinterest', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_bloglovin')) : ?><a href="http://bloglovin.com/<?php echo esc_html(get_theme_mod('laurel_bloglovin')); ?>" target="_blank"><i class="fa fa-heart"></i> <span><?php esc_html_e( 'Bloglovin', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_google')) : ?><a href="http://plus.google.com/<?php echo esc_html(get_theme_mod('laurel_google')); ?>" target="_blank"><i class="fa fa-google-plus"></i> <span><?php esc_html_e( 'Google +', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_tumblr')) : ?><a href="http://<?php echo esc_html(get_theme_mod('laurel_tumblr')); ?>.tumblr.com/" target="_blank"><i class="fa fa-tumblr"></i> <span><?php esc_html_e( 'Tumblr', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_youtube')) : ?><a href="http://youtube.com/<?php echo esc_html(get_theme_mod('laurel_youtube')); ?>" target="_blank"><i class="fa fa-youtube-play"></i> <span><?php esc_html_e( 'Youtube', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_dribbble')) : ?><a href="http://dribbble.com/<?php echo esc_html(get_theme_mod('laurel_dribbble')); ?>" target="_blank"><i class="fa fa-dribbble"></i> <span><?php esc_html_e( 'Dribbble', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_soundcloud')) : ?><a href="http://soundcloud.com/<?php echo esc_html(get_theme_mod('laurel_soundcloud')); ?>" target="_blank"><i class="fa fa-soundcloud"></i> <span><?php esc_html_e( 'Soundcloud', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_vimeo')) : ?><a href="http://vimeo.com/<?php echo esc_html(get_theme_mod('laurel_vimeo')); ?>" target="_blank"><i class="fa fa-vimeo-square"></i> <span><?php esc_html_e( 'Vimeo', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_linkedin')) : ?><a href="<?php echo esc_html(get_theme_mod('laurel_linkedin')); ?>" target="_blank"><i class="fa fa-linkedin"></i> <span><?php esc_html_e( 'Linkedin', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_snapchat')) : ?><a href="http://snapchat.com/add/<?php echo esc_html(get_theme_mod('laurel_soundcloud')); ?>" target="_blank"><i class="fa fa-snapchat-ghost"></i> <span><?php esc_html_e( 'Snapchat', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_rss')) : ?><a href="<?php echo esc_url(get_theme_mod('laurel_rss')); ?>" target="_blank"><i class="fa fa-rss"></i> <span><?php esc_html_e( 'RSS', 'laurel' ); ?></span></a><?php endif; ?>
					
				</div>
				
			</div>
			<?php endif; ?>
			
		</footer>
		
		<div id="footer-bottom">
			
			<div class="container">
				
				<div class="copyright">
					<p><?php echo wp_kses_post(get_theme_mod('laurel_footer_copyright_text', '&copy; Copyright 2016 - Solo Pine. All Rights Reserved. Designed & Developed by <a href="http://solopine.com">Solo Pine</a>')); ?></p>
				</div>
				
			</div>
			
		</div>	
		
	<!-- END INNER WRAPPER -->
	</div>
		
	<!-- END WRAPPER -->
	</div>
	
	
	<?php wp_footer(); ?>

	<script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us17.list-manage.com","uuid":"b6afd3d21bace8cda51a61bf1","lid":"9d56561a9a"}) })</script>
	
</body>

</html>