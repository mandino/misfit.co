<?php
/**
 *
 * Template Name: Page (Full Width)
 * Description: Template for page, with no sidebar.
 *
 */

get_header(); ?>

	<div id="main">
				
		<section id="content">
		
			<div class="container">
			
				<div class="sixteen columns">
		
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					
					<h1><?php the_title(); ?><span>.</span></h1>
								
					<?php the_content(); ?>
						
					<?php endwhile; endif; ?>
					
					</div>
			
				</div><!-- end .sixteen columns -->
		
			</div><!-- end .container -->
		
		</section><!-- end #content -->
	
	</div><!-- end #main -->
		
<?php get_footer(); ?>