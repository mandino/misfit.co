<div class="slideshow" id="slideshow">
	<ol class="slides">

		<?php

			$product_1 = new wp_query(array(
				'post_type' => 'product',
				'posts_per_page' => 6
			)); 
			if($product_1->have_posts()) : while($product_1->have_posts()) : $product_1->the_post();
			$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "Full"); 

	    ?>

			<li>
				<div class="description">
					<h2><?php the_title(); ?></h2>
					<?php the_content(); ?>
				</div>
				<div class="tiltview col">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php echo $imgsrc[0]; ?>&w=500&h=500"/>
					</a>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2013/11/Screen-Shot-2014-02-27-at-11.07.26-AM.png&w=500&h=500"/>
					</a>
				</div>
			</li>

		<?php endwhile; endif; wp_reset_query(); ?>
		
		<li>
			<div class="description">
				<h2>The Life &amp; Times of a Remarkable Misfit</h2>
				<p>The Life and Times of a Remarkable Misfit is a collection of essays about living with intention, doing work that matters and changing the world. If you&lsquo;ve never quite fit in &amp; you feel like there is more to life than working a job you hate, then this might be for you.</p>
			</div>
			<div class="tiltview col">
				<a href="/shop/product/the-life-times-of-a-remarkable-misfit">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2013/12/Books.jpeg&w=500&h=500"/>
				</a>
				<a href="/shop/product/the-life-times-of-a-remarkable-misfit">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2013/12/Books1.jpeg&w=500&h=500"/>
				</a>
			</div>
		</li>
		
		<li>
			<div class="description">
				<h2>Define Your Moments Print</h2>
				<p>The Define Your Moments print is a handcrafted 13x19 inch art piece which is based on a quote from The Life &amp; Times of a Remarkable Misfit. It is an artisan letterpress print on heavy card stock, made from recycled paper, with a vibrant red edge.</p>
			</div>
			<div class="tiltview col">
				<a href="/shop/product/define-your-moments-letterpress-print">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2014/03/Define-Your-Moments.jpg&w=500&h=500"/>
				</a>
				<a href="/shop/product/define-your-moments-letterpress-print">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2014/03/Define-Your-Moments-in-Fargo-.jpg&w=500&h=500"/>
				</a>
			</div>
		</li>
		
		<li>
			<div class="description">
				<h2>Wolftree Vol. 3 + Companion Album</h2>
				<p>Wolftree is a biannual publication and lifestyle blog that celebrates makers, dreamers and adventurers. 116 pages, offset-printed, perfect bound, full color on uncoated paper.  Printed and bound in Iowa. The paper used in Wolftree Vol. 3 was sourced from a mill in the Midwest and is FSC certified. Plus the “Life in the Dust of Our Youth” Companion Album includes 10 Songs Written and Recorded by Wolftree to delight your ears whilst delighting your eyes with Wolftree Magazine.</p>
			</div>
			<div class="tiltview col">
				<a href="/shop/product/wolftree-vol-3-digital-companion">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2014/05/Wolftree-page-4.jpg&w=500&h=500"/>
				</a>
				<a href="/shop/product/wolftree-vol-3-digital-companion">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2014/05/Pages-from-WolftreeVol3Final3-4.jpg&w=500&h=500"/>
				</a>
			</div>
		</li>
		
		<li>
			<div class="description">
				<h2>Misfit Journal 2 Digital Edition</h2>
				<p>We started this arts journal to prove that art and literature still very much have a place in this brave new world and we hope you enjoy taking pause from your hectic lives and getting lost in these beautiful pages for a few hours. We are trialing a 'pay what you can' model with the digital edition.</p>
			</div>
			<div class="tiltview col">
				<a href="/shop/product/misfit-journal-edition-2-digital">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2014/05/cover_MJ2_low.jpg&w=500&h=500"/>
				</a>
				<a href="/shop/product/misfit-journal-edition-2-digital">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2014/05/MJ-2-Dig-pg-1.jpg&w=500&h=500"/>
				</a>
			</div>
		</li>
		
		<li>
			<div class="description">
				<h2>Bundle of 10: The Life and Times of a Remarkable Misfit</h2>
				<p>The Life and Times of a Remarkable Misfit is a collection of essays about living with intention, doing work that matters and changing the world. If you’ve never quite fit in & you feel like there is more to life than working a job you hate, then this might be for you.</p>
			</div>
			<div class="tiltview col">
				<a href="/shop/product/bundle-of-10-the-life-and-times-of-a-remarkable-misfit">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2013/12/Books.jpeg&w=500&h=500"/>
				</a>
				<a href="/shop/product/bundle-of-10-the-life-and-times-of-a-remarkable-misfit">
					<img src="<?php bloginfo('template_url'); ?>/js/timthumb.php?src=<?php bloginfo('url'); ?>/wp-content/uploads/2013/12/misfit-book_jalanpaul_DSC_2763.jpg&w=500&h=500"/>
				</a>
			</div>
		</li>
		
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

			<?php endwhile; endif; wp_reset_query(); ?>

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