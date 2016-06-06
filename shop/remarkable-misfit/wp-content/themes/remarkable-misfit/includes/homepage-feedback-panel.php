<?php

	/**
	*
	* Homepage Feedback Section
	*
 	* The Variables
 	*
 	* Setup default variables, overriding them if the "Theme Options" have been saved.
 	*/
	global $post;

	$settings = array(
					'home_feedback_heading' => '',
					'home_feedback_sub' => '',
					'home_feedback_link_text' => __( 'View all feedback', 'woothemes' ),
					'home_feedback_link_URL' => '',
					'home_feedback_entries' => '3',
					'home_feedback_order' => 'DESC'
					);

	$settings = woo_get_dynamic_values( $settings );

	$orderby = 'date';
	if ( $settings['home_feedback_order'] == 'rand' )
		$orderby = 'rand';

?>
			<?php
    		$number_of_feedback = $settings['home_feedback_entries'];
    		$feedback_args = array(
					'post_type' => 'feedback',
					'posts_per_page' => $number_of_feedback,
					'order' => $settings['home_feedback_order'],
					'orderby' => $orderby
				);

			/* The Query. */
			$query = new WP_Query( $feedback_args );

			/* The Loop. */
			if ( $query->have_posts() ) { $count = 0; ?>
			<section id="feedback" class="home-section fix">

				<header class="section-title fix">
					<h1><?php echo stripslashes( $settings['home_feedback_heading'] ); ?></h1>
					<?php if($settings['home_feedback_sub'] != "") { ?>
						<span class="sub"><?php echo stripslashes( $settings['home_feedback_sub'] ); ?></span>
					<?php } ?>
					<a class="section-more" href="<?php if ( $settings['home_feedback_link_URL'] != '' ) echo $settings['home_feedback_link_URL']; else echo get_post_type_archive_link('feedback'); ?>" title="<?php echo stripslashes( $settings['home_feedback_link_text'] ); ?>"><?php echo stripslashes( $settings['home_feedback_link_text'] ); ?></a>
				</header>

				<div class="feedback-slider">

    				<ul class="slides fix">
					<?php
					while ( $query->have_posts() ) { $query->the_post(); $count++;
    					?>

    					<li class="slide">

	    					<?php get_template_part( 'content', 'feedback' ); ?>

	    				</li>
    					<?php
    				} // End While Loop ?>
    				</ul>

    			</div>

    		</section>

    		<script type="text/javascript">
				jQuery(window).load(function() {
					jQuery('#feedback.home-section').flexslider({
						controlNav: false,
						pauseOnHover: true
					});
				});
			</script>

    		<?php } // End If Statement ?>
    		<?php wp_reset_postdata(); ?>