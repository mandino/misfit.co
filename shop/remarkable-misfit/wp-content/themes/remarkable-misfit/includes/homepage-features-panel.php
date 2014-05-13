<?php
/**
 * Homepage Features Panel
 */
 
	/**
 	* The Variables
 	*
 	* Setup default variables, overriding them if the "Theme Options" have been saved.
 	*/
	global $post;
	
	$settings = array(
					'features_area_entries' => 3,
					'features_area_heading' => '',
					'features_area_sub' => '',
					'features_area_link_text' => __( 'View all our features', 'woothemes' ),
					'features_area_link_URL' => '',
					'features_area_order' => 'DESC'
					);
					
	$settings = woo_get_dynamic_values( $settings );
	$orderby = 'date';
	if ( $settings['features_area_order'] == 'rand' )
		$orderby = 'rand';
	
?>
			<?php
    		$number_of_features = $settings['features_area_entries'];
    		$features_args = array(
					'post_type' => 'features',  
					'posts_per_page' => $number_of_features, 
					'order' => $settings['features_area_order'], 
					'orderby' => $orderby
				);
				
			/* The Query. */			   
			$query = new WP_Query( $features_args );
			
			/* The Loop. */	
			if ( $query->have_posts() ) { $count = 0; ?>
			<section id="features" class="home-section fix">
			
				<header class="section-title fix">
					<h1><?php echo stripslashes( $settings['features_area_heading'] ); ?></h1>
					<?php if($settings['features_area_sub'] != "") { ?>
						<span class="sub"><?php echo stripslashes( $settings['features_area_sub'] ); ?></span>
					<?php } ?>
					<a class="section-more" href="<?php if ( $settings['features_area_link_URL'] != '' ) echo $settings['features_area_link_URL']; else echo get_post_type_archive_link('features'); ?>" title="<?php echo stripslashes( $settings['features_area_link_text'] ); ?>"><?php echo stripslashes( $settings['features_area_link_text'] ); ?></a>
				</header>
    			
    			<ul class="section-list">
				<?php
				while ( $query->have_posts() ) { $query->the_post(); $count++;
    				?>
    				<li class="<?php if ( $count % 3 == 0 ) { echo 'last'; } ?>">
    					
    					<?php $feature_readmore = get_post_meta( $post->ID, 'feature_readmore', true ); ?>
	    				<h2><a href="<?php if ( $feature_readmore != '' ) { echo $feature_readmore; } else { the_permalink(); } ?>"><?php the_title(); ?></a></h2>
	    				<?php $feature_excerpt = get_post_meta( $post->ID, 'feature_excerpt', true ); ?>
	    				<?php $feature_icon = get_post_meta( $post->ID, 'feature_icon', true ); ?>
	    					<?php if ($feature_icon != '') { ?><img src="<?php echo $feature_icon; ?>" alt="" /><?php } ?>
	    					<?php 
	    					if ( $feature_excerpt != '' ) { 
	    						echo stripslashes( $feature_excerpt ); 
	    					} else { 
	    						the_excerpt(); 
	    					} ?>
	    				</li>
    				<?php
    			} // End While Loop ?>
    			</ul>
    		
    		</section>
    		<?php } // End If Statement ?>
    		
    		<?php wp_reset_postdata(); ?>