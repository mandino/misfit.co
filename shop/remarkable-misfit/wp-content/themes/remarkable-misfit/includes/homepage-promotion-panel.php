<?php

	/**
	*
	* Homepage Promotion Section
	*
 	* The Variables
 	*
 	* Setup default variables, overriding them if the "Theme Options" have been saved.
 	*/
	global $post;

	$settings = array(
					'home_promotion_entries' => '3',
					'home_promotion_order' => 'DESC'
					);

	$settings = woo_get_dynamic_values( $settings );

	$orderby = 'date';
		if ( $settings['home_promotion_order'] == 'rand' )
			$orderby = 'rand';

	$number_of_promotions = $settings['home_promotion_entries'];
	$promotions_args = array(
	    	'post_type' => 'promotion',
	    	'posts_per_page' => $number_of_promotions,
	    	'order' => $settings['home_promotion_order'],
	    	'orderby' => $orderby
	    );

	/* The Query. */
	$query = new WP_Query( $promotions_args );

	/* The Loop. */
	if ( $query->have_posts() ) { $count = 0; ?>
	<section id="promotions" class="home-section fix">

	    <div class="promotion-slider">

	    	<ul class="slides fix">
	    	<?php
	    	while ( $query->have_posts() ) { $query->the_post(); $count++;
	    		?>

	    		<li id="promotion-<?php the_ID(); ?>" class="slide">
		    	    <?php get_template_part( 'content-promotion' ); ?>
	    	    </li>
	    	<?php } // End While Loop ?>
	    	</ul>

	    </div>

	</section>

	<script type="text/javascript">
	    jQuery(window).load(function() {
	    	jQuery('#promotions.home-section').flexslider({
	    		controlNav: false,
	    		pauseOnHover: true
	    	});
	   });
	</script>

	<?php } // End If Statement ?>

	<?php wp_reset_postdata(); ?>