<?php
/**
 * Homepage Slider
 */
	global $wp_query, $post, $panel_error_message, $slider_counter, $slider_instance;

	$settings = array(
					'featured_entries' => 3,
					'featured_height' => 380,
					'featured_tags' => '',
					'slider_video_title' => 'true',
					'featured_order' => 'DESC',
					'featured_sliding_direction' => 'vertical',
					'featured_animation' => 'slide',
					'featured_speed' => '7',
					'featured_hover' => 'false',
					'featured_touchswipe' => 'true',
					'featured_animation_speed' => '0.6',
					'featured_pagination' => 'false',
					'featured_nextprev' => 'true',
					'content_width' => '960',
					'post_type' => 'slide',
					'slider_header_text' => '',
					'slider_sub_header_text' => ''
					);

	$settings = woo_get_dynamic_values( $settings );

	if ( $slider_counter > 0 ) { $settings = wp_parse_args( $slider_instance, $settings ); }

	$count = 0;
?>

<?php
	$featposts = $settings['featured_entries']; // Number of featured entries to be shown
	$orderby = 'date';
	if ( $settings['featured_order'] == 'rand' )
		$orderby = 'rand';
?>

<?php $slides = get_posts(array('post_type' => $settings['post_type'], 'numberposts' => $featposts, 'order' => $settings['featured_order'], 'orderby' => $orderby, 'suppress_filters' => 0)); ?>

<?php if ( count($slides) > 0 ) { ?>

    <div id="slider" class="home-section <?php if( $settings['slider_header_text'] == '' ) { echo 'no-header'; } ?> fix">
    <?php if( $settings['slider_header_text'] != '' ) { ?>
    <header class="section-title fix">
	    <?php if( $settings['slider_header_text'] != '' ) { ?><h1><?php echo $settings['slider_header_text']; ?></h1><?php } ?>
		<?php if( $settings['slider_sub_header_text'] != '' ) { ?><span class="sub"><?php echo $settings['slider_sub_header_text']; ?></span><?php } ?>
	</header>
	<?php } ?>

	<section id="featured-<?php echo $slider_counter; ?>" class="featured "><?php /* TO DO - DYNAMIC ID / CLASS */ ?>

	    <ul class="slides fix"><?php /* TO DO - DYNAMIC ID / CLASS */ ?>

            <?php foreach( $slides as $post ) : setup_postdata( $post ); $count++; ?>

	            <li id="slide-<?php echo $count; ?>" class="slide slide-id-<?php the_ID(); ?>">

    				<?php if ( $settings['post_type'] == 'portfolio' ) { $url = get_post_meta( $post->ID, '_portfolio_url', true ); } else { $url = get_post_meta( $post->ID, 'url', true ); } ?>
    	    		<?php
	    	    		$has_embed = woo_embed( 'width=' . $settings['content_width'] . '&height=' . $settings['featured_height'] . '&class=slide-video-carousel' );
	        			if ( $has_embed ) {
	        				echo $has_embed;
	        			} else {
	        				if ( isset( $url ) && $url != '' ) { ?>
	        					<a href="<?php echo esc_url( $url ); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
	        				<?php }
	        				woo_image( 'width=' . $settings['content_width'] . '&height=' . $settings['featured_height'] . '&class=slide-image&link=img&noheight=true' );
    	    				if ( isset($url) && $url != '' ) { ?></a><?php }
	        			}
	        		?>

    	    		<?php if ( !$has_embed OR ( $has_embed && $settings['slider_video_title'] != "true" ) )  { // Hide title/description if video post ?>
    	    		<div class="slide-content-container">
	    	    	<article class="slide-content col-full <?php if ( !$has_embed ) { echo "not-video"; } ?>">

	    	    		<header>

	    	    			<h1>
	    	    				<?php if ( isset( $url ) && $url != '' ) { ?><a href="<?php echo esc_url( $url ); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php } ?>
	    	    					<?php
	    	    						$slide_title = get_the_title();
	    	    						echo woo_text_trim ( $slide_title, 25 );
	    	    					?>
	    	    				<?php if ( isset( $url ) && $url != '' ) { ?></a><?php } ?>
	    	    			</h1>

	    	    			<div class="entry">
	    	    				<?php
	    	    					$slide_excerpt = get_the_excerpt();
	    	    					echo woo_text_trim ( $slide_excerpt, 16 );
	    	    				?>
	    	    			</div>

	    	    		</header>

	    	    	</article>
	    	    	</div>
	    	    	<?php } ?>

	            </li><!--/.slide-->

			<?php endforeach; ?>

	    </ul><!-- /.slides -->

	</section><!-- /#featured -->
	</div>

<?php
// Slider Settings
/*
$slideDirection = $settings['featured_sliding_direction'];
*/
$animation = $settings['featured_animation'];
if ( $settings['featured_speed'] == "Off" ) { $slideshow = 'false'; } else { $slideshow = 'true'; }
$pauseOnHover = $settings['featured_hover'];
if ( $pauseOnHover == '' ) { $pauseOnHover = 'false'; }
$touchSwipe = $settings['featured_touchswipe'];
if ( $touchSwipe == '' ) { $touchSwipe = 'false'; }
$slideshowSpeed = $settings['featured_speed'] * 1000; // milliseconds
$animationDuration = $settings['featured_animation_speed'] * 1000; // milliseconds
$pagination = $settings['featured_pagination'];
if ( $pagination == '' ) { $pagination = 'false'; }
$nextprev = $settings['featured_nextprev'];
if ( $nextprev == '' ) { $nextprev = 'false'; }
?>

<script type="text/javascript">
   jQuery(document).ready(function() {
   	jQuery('#featured-<?php echo esc_js( $slider_counter ); ?>').flexslider({
   		/* slideDirection: "<?php echo $slideDirection; ?>", */
   		animation: "<?php echo $animation; ?>",
   		controlsContainer: "#slider.home-section",
   		slideshow: <?php echo $slideshow; ?>,
   		directionNav: <?php echo $nextprev; ?>,
   		controlNav: <?php echo $pagination; ?>,
   		pauseOnHover: <?php echo $pauseOnHover; ?>,
   		slideshowSpeed: <?php echo $slideshowSpeed; ?>,
   		animationDuration: <?php echo $animationDuration; ?>,
   		smoothHeight: true
   	});
   	jQuery('#featured-<?php echo $slider_counter; ?>').addClass('loaded');
   });

</script>

<?php } else { ?>
	<div class="col-full"><?php echo do_shortcode( '[box type="info"]Please add some slides in the WordPress admin backend to show in the Featured Slider.[/box]' ); ?></div>
<?php } ?>
