<?php get_header(); ?>
	
	<div class="sp-container">
		
		<div class="sp-row">
		
			<div id="main">
			
				<div class="sp-row post-layout">
			
					<div class="sp-col-12">
						<article class="post none-content">
							
							<div class="post-header">
							
								<h1><?php esc_html_e( '404', 'laurel' ); ?></h1>
								
							</div>
							
							<div class="post-entry nothing">

								<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'laurel' ); ?></p>
								<?php get_search_form(); ?>
								
							</div>
							
						</article>
					</div>
				
				</div>
				
			</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>