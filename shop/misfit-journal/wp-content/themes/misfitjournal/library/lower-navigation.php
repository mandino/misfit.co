<div class="bottomnav">
			
			<div class="publisher">
			
				<a href="http://aj-leon.com/misfit-press/misfit-journal/misfit-in-chiefs-note/"><h4>Publisher's Letter</h4></a>
			
			</div>

			<!-- <div class="secondarynav">
				<ul>
				<li><a href="/misfit-press/product-category/misfit-journal">Purchase This Edition</a></li>
				</ul>		
			</div> -->
			
			<div class="primarynav">
				
				<ul>
				
				
					<?php query_posts('post_type=article'); if(have_posts()) : while(have_posts()) : the_post(); ?>
					<li>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<div class="upswing">
							<h1><?php the_title(); ?></h1>
							<h5><?php echo get_post_meta($post->ID, 'cebo_authorname', true); ?></h5>
							
							<p><?php echo excerpt(20); ?></p>
							
							<a href="<?php the_permalink(); ?>" class="readon">Read On</a>
						</div>
					</li>
					
					<?php endwhile; endif; wp_reset_query(); ?>	
				
				</ul>
			
			</div>
			
			<div class="logowrapper">
				
				<div class="subscribe">

					<?php if (wpmd_is_device()) { ?>

						<div class="subcr subcr-mob"><a href="/misfit-press/product-category/misfit-journal" target="_blank">Subscribe</a></div>

					<?php } else { ?>

						<div class="subcr">Get this Issue</div>

					<?php } ?>

					
					
					<div class="subbox">
						
						<div class="halfsies">
							
							<h4>Print Edition</h4>
							
							<a href="/misfit-press/product/misfit-journal-print-subscription"><img style="margin-left: -5px;" src="<?php bloginfo ('template_url'); ?>/images/printedition.png" /></a>
							
							<a href="/misfit-press/product/misfit-journal-print-subscription"><h5>Subscribe Now</h5></a>
						
						</div>
						
						<div class="halfsies">
							
							<h4>Digital Edition</h4>
							
							<a href="/misfit-press/product/misfit-journal-digital-subscription"><img src="<?php bloginfo ('template_url'); ?>/images/digitaledition.png" /></a>
							
							<a href="/misfit-press/product/misfit-journal-digital-subscription"><h5 class="short">Subscribe Now</h5></a>
						
						</div>
						
						<div class="clear"></div>
					
					</div>
				
				</div>

				<?php //if ( !is_front_page() && !wpmd_is_device() ) { ?>

					<!-- <a class="subscribe purchase" href="/misfit-press/product-category/misfit-journal">
						<div class="subcr">Purchase This Edition</div>
					</a> -->

				<?php //} ?>
				
			</div>
			
		</div>
		
<div class="bottomnavmob">
	<a class="publishermob" href="<?php bloginfo('url'); ?>/misfit-in-chiefs-note/"><h4>Publisher's Letter</h4></a>
	
	<ul class="primarynavmob">
		<?php query_posts('post_type=article'); if(have_posts()) : while(have_posts()) : the_post(); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php endwhile; endif; wp_reset_query(); ?>	
	</ul>
	
	<a class="subcrmob" href="http://misfit.co/shop/shop/" target="_blank">Get this Issue</a>
</div><!-- bottomnavmob -->
		
	</div><!-- end general wrapper -->