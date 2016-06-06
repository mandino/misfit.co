<?php
/**
 * Homepage Features Panel
 */
 
	/**
 	* The Variables
 	*
 	* Setup default variables, overriding them if the "Theme Options" have been saved.
 	*/
	
	global $woo_options, $post;
	
	$settings = array(
					'home_portfolio_entries' => 4,
					'home_portfolio_heading' => '',
					'home_portfolio_sub' => '',
					'home_portfolio_link_text' => __( 'View all our portfolio', 'woothemes' ),
					'home_portfolio_link_URL' => '',
					'home_portfolio_order' => 'DESC',
					'rel' => '',
					'large' => ''
					);
					
	$settings = woo_get_dynamic_values( $settings );
	$orderby = 'date';
	if ( $settings['home_portfolio_order'] == 'rand' )
		$orderby = 'rand';
	
?>
			<?php
    		$number_of_portfolio = $settings['home_portfolio_entries'];
    		$portfolio_args = array(
					'post_type' => 'portfolio',  
					'posts_per_page' => $number_of_portfolio, 
					'order' => $settings['home_portfolio_order'], 
					'orderby' => $orderby
				);
				
			/* The Query. */			   
			$query = new WP_Query( $portfolio_args );
			
			/* The Loop. */	
			if ( $query->have_posts() ) { $count = 0; ?>
			<section id="portfolio-home" class="home-section fix">
			
				<header class="section-title fix">
					<h1><?php echo stripslashes( $settings['home_portfolio_heading'] ); ?></h1>
					<?php if($settings['home_portfolio_sub'] != "") { ?>
						<span class="sub"><?php echo stripslashes( $settings['home_portfolio_sub'] ); ?></span>
					<?php } ?>
					<a class="section-more" href="<?php if ( $settings['home_portfolio_link_URL'] != '' ) echo $settings['home_portfolio_link_URL']; else echo get_post_type_archive_link('portfolio'); ?>" title="<?php echo stripslashes( $settings['home_portfolio_link_text'] ); ?>"><?php echo stripslashes( $settings['home_portfolio_link_text'] ); ?></a>
				</header>
    			
    			<ul id="portfolio" class="section-list">
				<?php
				while ( $query->have_posts() ) { $query->the_post(); $count++;
    				?>
    			<?php	
    				/* Get the settings for this portfolio item. */
		$settings = woo_portfolio_item_settings( $post->ID );
		
		/* If the theme option is set to link to the single portfolio item, adjust the $settings. */
		if ( isset( $woo_options['woo_portfolio_linkto'] ) && ( $woo_options['woo_portfolio_linkto'] == 'post' ) ) {
			$settings['large'] = get_permalink( $post->ID );
			$settings['rel'] = '';
		}

		// Check for custom URL on item
		$custom_url = get_post_meta( $post->ID, '_portfolio_url', true ); 
		if ( $custom_url != '' )
			$settings['large'] = $custom_url;
			?>
    				
    			<li class="portfolio-item <?php if ( $count % 4 == 0 ) { echo 'last'; } ?>">
    					
        			<?php
	    			/* Setup image for display and for checks, to avoid doing multiple queries. */
	    				$image = woo_image( 'width=225&height=225&link=img&return=true&noheight=true' ); 
	    				$image_src = woo_image( 'width=225&height=225&link=url&return=true&noheight=true' );
	    				if ( !$image )
	    					$image = '<img src="' . get_template_directory_uri() . '/images/temp-portfolio.png" alt="" />';
	    			?>
	    			<a <?php echo $settings['rel']; ?> title="<?php echo $settings['caption']; ?>" href="<?php echo $settings['large']; ?>" class="item drop-shadow curved curved-hz-1">
	    				<?php echo $image; ?>
	    				<span class="mask">
	    					<span class="icon">
	    						<img src="<?php echo get_template_directory_uri(); ?>/images/ico-portfolio-hover.png" alt="View" />
	    						<strong>Details</strong>
	    					</span>
	    				</span>
	    			</a>
	    			
	    			<?php 
	    			//setup terms
	    			$tag_list = get_the_term_list( $post->ID, 'portfolio-gallery', '' , ', ' , ''  );
	    			$tag_list = strip_tags($tag_list);
	    			?>
	    			
	    			<h2>
	    				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
	    					<span class="title"><?php the_title(); ?></span>
							<span class="categories"><?php echo $tag_list; ?></span>
	    				</a>
	    			</h2>
			
				</li>
    				<?php
    			} // End While Loop ?>
    			</ul>
    		
    		</section>
    		<?php } // End If Statement ?>
    		<?php wp_reset_postdata(); ?>