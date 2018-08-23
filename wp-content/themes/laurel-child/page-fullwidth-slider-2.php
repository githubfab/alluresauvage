<?php

	/* Template Name: Full Width Page w/ Slider-2 */

?>
<?php get_header(); ?>

	<!-- <?php get_template_part('inc/featured/featured'); ?> -->

	<div id="featured-area">
		<div class="slider_homepage">
			<div>
				<iframe class="n2-ss-slider-frame" style="width: 100%; display: block; border: 0px; height: 392px;" frameborder="0" src="https://webbinart.tk/wp_alluresauvage?n2prerender=1&amp;n2app=smartslider&amp;n2controller=slider&amp;n2action=iframe&amp;sliderid=2&amp;hash=0b2c9fee8b29cefd2fd4651d39b36d80" onload="if(typeof window.n2SSIframeLoader != &quot;function&quot;){    (function($){        var frames = [],            clientHeight = 0;        var eventMethod = window.addEventListener ? &quot;addEventListener&quot; : &quot;attachEvent&quot;;        window[eventMethod](eventMethod == &quot;attachEvent&quot; ? &quot;onmessage&quot; : &quot;message&quot;, function (e) {            var sourceFrame = false;            for(var i = 0; i < frames.length; i++){                if(e.source == (frames[i].contentWindow || frames[i].contentDocument)){                    sourceFrame = frames[i];                }            }            if (sourceFrame) {                var data = e[e.message ? &quot;message&quot; : &quot;data&quot;];                                switch(data[&quot;key&quot;]){                    case &quot;ready&quot;:                        clientHeight = document.documentElement.clientHeight || document.body.clientHeight;                        $(sourceFrame).removeData();                        (sourceFrame.contentWindow || sourceFrame.contentDocument).postMessage({                            key: &quot;ackReady&quot;,                            clientHeight: clientHeight                        }, &quot;*&quot;);                    break;                    case &quot;resize&quot;:                        var $sourceFrame = $(sourceFrame);                                                if(data.fullPage){                            var resizeFP = function(){                                if(clientHeight != document.documentElement.clientHeight || document.body.clientHeight){                                    clientHeight = document.documentElement.clientHeight || document.body.clientHeight;                                    (sourceFrame.contentWindow || sourceFrame.contentDocument).postMessage({                                        key: &quot;update&quot;,                                        clientHeight: clientHeight                                    }, &quot;*&quot;);                                }                            };                            if($sourceFrame.data(&quot;fullpage&quot;) != data.fullPage){                                $sourceFrame.data(&quot;fullpage&quot;, data.fullPage);                                resizeFP();                                $(window).on(&quot;resize&quot;, resizeFP);                            }                        }                        $sourceFrame.css({                            height: data.height                        });                                                if(data.forceFull &amp;&amp; $sourceFrame.data(&quot;forcefull&quot;) != data.forceFull){                            $sourceFrame.data(&quot;forcefull&quot;, data.forceFull);                            $(&quot;body&quot;).css(&quot;overflow-x&quot;, &quot;hidden&quot;);                            var resizeFF = function(){                                var windowWidth = document.body.clientWidth || document.documentElement.clientWidth,                                    outerEl = $sourceFrame.parent(),                                    outerElOffset = outerEl.offset();                                $sourceFrame.css(&quot;maxWidth&quot;, &quot;none&quot;);                                                                if ($(&quot;html&quot;).attr(&quot;dir&quot;) == &quot;rtl&quot;) {                                    var bodyMarginRight = parseInt($(document.body).css(&quot;marginRight&quot;));                                    outerElOffset.right = $(window).width() - (outerElOffset.left + outerEl.outerWidth()) - bodyMarginRight;                                    $sourceFrame.css(&quot;marginRight&quot;, -outerElOffset.right - parseInt(outerEl.css(&quot;paddingRight&quot;)) - parseInt(outerEl.css(&quot;borderRightWidth&quot;))).width(windowWidth);                                } else {                                    var bodyMarginLeft = parseInt($(document.body).css(&quot;marginLeft&quot;));                                    $sourceFrame.css(&quot;marginLeft&quot;, -outerElOffset.left - parseInt(outerEl.css(&quot;paddingLeft&quot;)) - parseInt(outerEl.css(&quot;borderLeftWidth&quot;)) + bodyMarginLeft).width(windowWidth);                                }                            };                            resizeFF();                            $(window).on(&quot;resize&quot;, resizeFF);                                                }                        break;                }            }        });        window.n2SSIframeLoader = function(iframe){            frames.push(iframe);        }    })(jQuery);  }n2SSIframeLoader(this);"></iframe>
			</div>

<?php global $wp_query;
$post = $wp_query->post; 
$value = get_field('banner_box_title', $post->ID); ?>


				<div class="feat-overlay">
					<h2><a href="#about-us-section"><?php echo $value; ?></a></h2>
					<div class="feat-read-more">
					<a href="#about-us-section" class="read-more ps2id"><?php esc_html_e( 'Read More', 'laurel' ); ?>
					</a>
					</div>
				</div>

		</div>
	</div>

	<div id="promo-area">
		<div class="feat-line"></div>
	
			<div class="sp-container">

		
				<div class="sp-row">

					<?php if(get_theme_mod( 'laurel_promo' ) == true) : ?>
						<?php get_template_part('inc/promo/promo'); ?>
					<?php endif; ?>

					<?php 
					// the query
					$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>3,'order' => 'DESC')); ?>
					 
					<?php if ( $wpb_all_query->have_posts() ) : ?>
					 
					
					    <!-- the loop -->
					    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
					    	<div class="sp-col-4">
					    		<div class="promo-item" style="background-image:url(<?=wp_get_attachment_url( get_post_thumbnail_id() )?>); height:230px;">
						        	<a style="height: 100%;width:100%; display: table;position: relative;" href="<?php the_permalink(); ?>">
						        	<div class="promo-overlay">
										
										<h4><?php the_title(); ?></h4>
										
									</div>
						        		
						    		<!-- <img title="image title" alt="thumb image" class="wp-post-image" 
	             src="<?=wp_get_attachment_url( get_post_thumbnail_id() ); ?>" style="width:100%; height:230px;"> -->
						        	</a>
					    		</div>
					        </div>
					    <!-- end of the loop -->
					  	<?php endwhile; ?>
    					<!-- end of the loop -->
					
					 
					    <?php wp_reset_postdata(); ?>
					 
					<?php else : ?>
					    <p><?php _e( 'Sorry, no recent posts' ); ?></p>
					<?php endif; ?>


				</div>
			</div>
		</div>


	<div class="sp-container">
		
		<div class="sp-row">
		
			<div id="main" class="fullwidth">
			
				<div class="sp-row post-layout">
			
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
						<?php get_template_part('content', 'page'); ?>
							
					<?php endwhile; ?>
					
					<?php endif; ?>
				
				</div>
				
			</div>

<?php get_footer(); ?>