<?php
/**
 *
 * Description: Standard Blog (Single Article) template.
 *
 */

get_header(); ?>

	<div id="main">
			
		<section id="content">
		
			<div class="container">
			
				<div class="sixteen columns">
					
					<section id="post-content" class="ten columns alpha">
										
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
						<article <?php post_class("single-article"); ?>>
											
							<h1><?php the_title(); ?><span>.</span></h1>
							
							<span class="meta-author">By <?php the_author_posts_link(); ?></span>
							
							<span class="meta-category"><?php _e('Posted in', 'kula'); ?> - <?php the_category(' & '); ?> <?php _e('on', 'kula'); ?> <strong><?php the_time('F jS, Y'); ?></strong></span>
	
							<?php the_post_thumbnail('single-post'); ?>
							
							<?php the_content(); ?>
							
							<span class="tags"><i class="icon-tags"></i> <?php the_tags(' ',' '); ?></span>
												
						</article><!-- end #single-article -->
						
					<?php endwhile; endif; ?>
					
					<?php comments_template(); ?>
					
					<?php gt_content_nav('nav-below');?>
						
					</section><!-- end #post-content -->
					
					<?php get_sidebar(); ?>
			
				</div><!-- end .sixteen columns -->
		
			</div><!-- end .container -->
		
		</section><!-- end #content -->
	
	</div><!-- end #main -->
		
<?php get_footer(); ?>
