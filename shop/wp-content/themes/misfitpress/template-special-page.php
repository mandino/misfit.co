<?php
/**
 * Template Name: Special Page
 */


get_header('special');

?>

	<div id="section-divider-22" class="section quote">
		
		<div class="bg6"></div>
	
		<div class="container">
		
			<div class="text-container">
				
				<section class="latest-quotes">
					
					<ul class="quotes">
								
						<?php
						global $data;
						
						$args = array('post_type' => 'quotes', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1);
						$loop = new WP_Query($args);
						while ($loop->have_posts()) : $loop->the_post(); ?>
						
							<li>
								<blockquote><?php echo get_post_meta($post->ID, 'gt_quotes_quote', true) ?></blockquote>
								<a href="<?php the_field('speaker_twitter_link_quote', $post->ID); echo get_post_meta($post->ID, 'speaker_twitter_link_quote', true) ?>" target="_blank"><cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite></a>
							</li>
							
						<?php endwhile; ?>
			
					</ul><!-- end .quotes -->
				
				</section><!-- end .latest-quotes -->
			
			</div><!-- end .text-container -->
	
		</div><!-- end .container -->
	
	</div><!-- end #section-divider-3 -->
		 
	<!-- #content Starts -->
	<div id="content" class="col-full">

		<div class="container">
			
			<div class="sixteen columns">
			
				<div class="fourteen columns">

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<h2 class="title"><?php the_title(); ?></h2>

						<div class="page-content"><?php the_content(); ?></div>

					<?php endwhile; endif; ?>

				</div><!-- end .sixteen columns -->
		
			</div><!-- end .container -->
		
		</div><!-- end .container -->

	</div><!-- /#content -->

<?php get_footer('special'); ?>