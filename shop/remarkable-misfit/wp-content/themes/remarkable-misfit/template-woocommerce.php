<?php
/**
 *
 * Template name: Woocommerce
 *
 */

get_header('woo'); ?>

	<div id="main">
			
		<section id="content">
		
			<div class="container">
			
				<div class="sixteen columns">
						
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					
					<h1><?php the_title(); ?></h1>
								
					<?php the_content(); ?>
						
					<?php endwhile; endif; ?>
								
				</div><!-- end .sixteen columns -->
		
			</div><!-- end .container -->
		
		</section><!-- end #content -->
	
	</div><!-- end #main -->
		
<?php get_footer(); ?>