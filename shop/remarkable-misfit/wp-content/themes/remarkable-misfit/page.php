<?php
/**
 *
 * Description: Standard Page template.
 *
 */

get_header(); ?>

	<div id="main">
			
		<section id="content">
		
			<div class="container">
			
				<div class="sixteen columns">
				
					<div class="ten columns alpha">
		
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					
					<h1><?php the_title(); ?><span>.</span></h1>
								
					<?php the_content(); ?>
						
					<?php endwhile; endif; ?>
					
					</div>
					
					<?php get_sidebar(); ?>
			
				</div><!-- end .sixteen columns -->
		
			</div><!-- end .container -->
		
		</section><!-- end #content -->
	
	</div><!-- end #main -->
		
<?php get_footer(); ?>