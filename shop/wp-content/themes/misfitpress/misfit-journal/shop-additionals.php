<div class="slideshow" id="slideshow">
	<ol class="slides">

		<?php

			$i=1;
			$product_1 = new wp_query(array(
				'post_type' => 'product',
				'posts_per_page' => 6
			)); 
			if($product_1->have_posts()) : while($product_1->have_posts()) : $product_1->the_post();
			$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); 

	    ?>

			<li <?php if($i == 1) { echo 'class="current"'; } ?>>
				<div class="description">

					<h2><?php the_title(); ?></h2>

					<?php if( has_excerpt() ) { ?>
						<?php the_excerpt(); ?>
					<?php } else { ?>
						<?php the_content(); ?>
					<?php } ?>

				</div>
				<div class="tiltview col">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php echo $imgsrc[0]; ?>&w=500&h=500"/>
					</a>

					<?php if( get_post_meta($post->ID,'misfit_extra_product_photo',true) ) { ?>
						<a href="<?php the_permalink(); ?>">
							<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php echo get_post_meta($post->ID,'misfit_extra_product_photo',true); ?>&w=500&h=500"/>
						</a>
					<?php } ?>
				</div>
			</li>

		<?php $i++; endwhile; endif; ?>
		
	</ol>
</div>

<section class="tile-gallery">
	<div class="section-four">
		<div class="tile-wrapper">
		
		<div class="displayonly-mobile">

			<?php

				$product_1 = new wp_query(array(
					'post_type' => 'product',
					'posts_per_page' => 6
				)); 
				if($product_1->have_posts()) : while($product_1->have_posts()) : $product_1->the_post();
				$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); 
		    ?>

				<div class="portfoliocontainer mobile">
					<div class="portfolio-item">
						<div class="portfolio-shade"></div>
						<a href="#"></a>
						<div class="portimg" style="background-image: url('<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php echo $imgsrc[0]; ?>&w=500&h=500');"></div>
						<h3><?php the_title(); ?></h3>
						<h1>Available Now</h1>
						
						<div class="overlay">
							
							<div class="smallview">
								<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
								<a target="_blank" href="https://twitter.com/intent/tweet?hashtags=misfitshop&text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&via=misfit_inc"><i class="fa fa-twitter"></i></a>
								<a target="_blank" href="http://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $imgsrc[0]; ?>&guid=nJ5S7t7i86Xi-1&description=<?php the_title(); ?>"><i class="fa fa-pinterest"></i></a>
								<a href="<?php the_permalink(); ?>"><i class="fa fa-shopping-cart"></i></a>
							</div>

							<div class="bigview">
								<a href="<?php the_permalink(); ?>"><i class="fa fa-chevron-right"></i></a>
							</div>
							
							<div class="clear"></div>
						</div>
					</div>
				</div>

			<?php endwhile; endif; ?>

		</div>
		
		<!-- Block Left -->
		
		<div class="displayonly-desktop">

			<?php

				$i=1;
				$product_1 = new wp_query(array(
					'post_type' => 'product',
					'posts_per_page' => 2
				)); 
				if($product_1->have_posts()) : 

			?>

			<div style="float: left; width: 49%; margin-right: 1%;">

			<?php while($product_1->have_posts()) : $product_1->the_post();
				$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); 
		    ?>

		    	<div class="portfoliocontainer <?php echo convertNumber($i); ?>">
					<div class="portfolio-item">
						<a href="<?php the_permalink(); ?>"><div class="portfolio-shade"></div></a>
						<a href="#"></a>
						<div class="portimg" style="background-image: url('<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php echo $imgsrc[0]; ?>&w=500&h=500');"></div>
						<h3><?php the_title(); ?></h3>
						<h1>Available Now</h1>
						
						<div class="overlay">
							<div class="smallview">
								<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
								<a target="_blank" href="https://twitter.com/intent/tweet?hashtags=misfitshop&text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&via=misfit_inc"><i class="fa fa-twitter"></i></a>
								<a target="_blank" href="http://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $imgsrc[0]; ?>&guid=nJ5S7t7i86Xi-1&description=<?php the_title(); ?>"><i class="fa fa-pinterest"></i></a>
								<a href="<?php the_permalink(); ?>"><i class="fa fa-shopping-cart"></i></a>
							</div>
							
							<div class="bigview">
								<a href="<?php the_permalink(); ?>"><i class="fa fa-chevron-right"></i></a>
							</div>
							
							<div class="clear"></div>
						</div>
					</div>
				</div>
		
			<?php $i++; endwhile; ?>

			</div>

			<?php endif; ?>

			
			
			<!-- Block Right -->

			<?php

				$product_1 = new wp_query(array(
					'post_type' => 'product',
					'posts_per_page' => 2,
					'offset' => 2
				)); 
				if($product_1->have_posts()) : 
				$i=3;

			?>

			<div style="float: right; width: 49%;">

			<?php while($product_1->have_posts()) : $product_1->the_post();
				$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); 
		    ?>
		
				<div class="portfoliocontainer <?php echo convertNumber($i); ?>">
					<div class="portfolio-item">
						<a href="<?php the_permalink(); ?>"><div class="portfolio-shade"></div></a>
						<a href="#"></a>
						<div class="portimg" style="background-image: url('<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php echo $imgsrc[0]; ?>&w=500&h=500');"></div>
						<h3><?php the_title(); ?></h3>
						<h1>Available Now</h1>
						
						<div class="overlay">
							<div class="smallview">
								<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
								<a target="_blank" href="https://twitter.com/intent/tweet?hashtags=misfitshop&text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&via=misfit_inc"><i class="fa fa-twitter"></i></a>
								<a target="_blank" href="http://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $imgsrc[0]; ?>&guid=nJ5S7t7i86Xi-1&description=<?php the_title(); ?>"><i class="fa fa-pinterest"></i></a>
								<a href="<?php the_permalink(); ?>"><i class="fa fa-shopping-cart"></i></a>
							</div>
							
							<div class="bigview">
								<a href="<?php the_permalink(); ?>"><i class="fa fa-chevron-right"></i></a>
							</div>
							
							<div class="clear"></div>
						</div>
					</div>
				</div>

			<?php $i++; endwhile; ?>

			</div>

			<?php endif; ?>


			
			<!-- Block Bottom 2 - 1 -->

			<?php

				$product_1 = new wp_query(array(
					'post_type' => 'product',
					'posts_per_page' => 1,
					'offset' => 4
				)); 
				if($product_1->have_posts()) : 
				$i=5;

			?>

			<div style="width: 49%; float: left;">

			<?php while($product_1->have_posts()) : $product_1->the_post();
				$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); 
		    ?>

		    	<div class="portfoliocontainer <?php echo convertNumber($i); ?>">
					<div class="portfolio-item">
						<a href="<?php the_permalink(); ?>"><div class="portfolio-shade"></div></a>
						<a href="#"></a>
						<div class="portimg" style="background-image: url('<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php echo $imgsrc[0]; ?>&w=500&h=500');"></div>
						<h3><?php the_title(); ?></h3>
						<h1>Available Now</h1>
						
						<div class="overlay">
							<div class="smallview">
								<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
								<a target="_blank" href="https://twitter.com/intent/tweet?hashtags=misfitshop&text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&via=misfit_inc"><i class="fa fa-twitter"></i></a>
								<a target="_blank" href="http://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $imgsrc[0]; ?>&guid=nJ5S7t7i86Xi-1&description=<?php the_title(); ?>"><i class="fa fa-pinterest"></i></a>
								<a href="<?php the_permalink(); ?>"><i class="fa fa-shopping-cart"></i></a>
							</div>
							
							<div class="bigview">
								<a href="<?php the_permalink(); ?>"><i class="fa fa-chevron-right"></i></a>
							</div>
							
							<div class="clear"></div>
						</div>
					</div>
				</div>

		    <?php endwhile; ?>

			</div>

			<?php endif; ?>


			
			<!-- Block Bottom 2 - 2 -->

			<?php

				$product_1 = new wp_query(array(
					'post_type' => 'product',
					'posts_per_page' => 1,
					'offset' => 5
				)); 
				if($product_1->have_posts()) : 
				$i=6;

			?>

			<div style="width: 49%; float: right;">

			<?php while($product_1->have_posts()) : $product_1->the_post();
				$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); 
		    ?>

		    	<div class="portfoliocontainer <?php echo convertNumber($i); ?>">
					<div class="portfolio-item">
						<a href="<?php the_permalink(); ?>"><div class="portfolio-shade"></div></a>
						<a href="#"></a>
						<div class="portimg" style="background-image: url('<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php echo $imgsrc[0]; ?>&w=500&h=500');"></div>
						<h3><?php the_title(); ?></h3>
						<h1>Available Now</h1>
						
						<div class="overlay">
							<div class="smallview">
								<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
								<a target="_blank" href="https://twitter.com/intent/tweet?hashtags=misfitshop&text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&via=misfit_inc"><i class="fa fa-twitter"></i></a>
								<a target="_blank" href="http://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $imgsrc[0]; ?>&guid=nJ5S7t7i86Xi-1&description=<?php the_title(); ?>"><i class="fa fa-pinterest"></i></a>
								<a href="<?php the_permalink(); ?>"><i class="fa fa-shopping-cart"></i></a>
							</div>
							
							<div class="bigview">
								<a href="<?php the_permalink(); ?>"><i class="fa fa-chevron-right"></i></a>
							</div>
							
							<div class="clear"></div>
						</div>
					</div>
				</div>

		    <?php endwhile; ?>

			</div>

			<?php endif; wp_reset_query(); ?>
		
		</div><!-- .tile-wrapper -->
	</div>
	
	
	</div>
</section>