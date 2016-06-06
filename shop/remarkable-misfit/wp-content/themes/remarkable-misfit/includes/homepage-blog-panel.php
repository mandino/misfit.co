<?php
/**
 * Homepage Features Panel
 */
/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

global $woo_options, $post, $wp_query;

$settings = array(
				'blog_thumb_w' => 215,
				'blog_thumb_h' => 120,
				'blog_thumb_align' => 'aligncenter',
				'blog_area_entries' => 3,
				'blog_area_heading' => '',
				'blog_area_sub' => '',
				'blog_area_link_text' => __( 'View all our blog posts', 'woothemes' ),
				'blog_area_link_URL' => '',
				'blog_area_order' => 'DESC'
				);

$settings = woo_get_dynamic_values( $settings );
$orderby = 'date';
if ( $settings['blog_area_order'] == 'rand' )
	$orderby = 'rand';

// Process the category data and convert all categories to IDs.
$excluded_cats = woo_prepare_category_ids_from_option( 'woo_exclude_cats_home' );
$number_of_features = $settings['blog_area_entries'];

$args = array( 'post_type' => 'post', 'posts_per_page' => $number_of_features, 'paged' => $paged, 'order' => $settings['blog_area_order'], 'orderby' => $orderby );
if ( 0 < count( $excluded_cats ) && is_home() ) {
	$args['category__not_in'] = $excluded_cats;
}

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
/* The Query. */
$query = new WP_Query( $args );
// Preserve the original query.
$old_query = $wp_query;
$wp_query = $query;

/* The Loop. */
if ( $query->have_posts() ) { $count = 0;
?>
			<section id="blog-home" class="home-section fix">

				<header class="section-title fix">
    				<h1><?php echo stripslashes( $settings['blog_area_heading'] ); ?></h1>
    				<?php if( $settings['blog_area_sub'] != '') { ?>
    					<span class="sub"><?php echo stripslashes( $settings['blog_area_sub'] ); ?></span>
    				<?php } ?>
    				<a class="section-more" href="<?php if ( $settings['blog_area_link_URL'] != '' ) echo $settings['blog_area_link_URL']; else echo next_posts(); ?>" title="<?php echo stripslashes( $settings['blog_area_link_text'] ); ?>"><?php echo stripslashes( $settings['blog_area_link_text'] ); ?></a>
    			</header>

    			<ul class="section-list">
				<?php
				while ( $query->have_posts() ) { $query->the_post(); $count++;
    				?>
    				<li class="fix post <?php if ( $count % 3 == 0 ) { echo 'last'; } ?>">

	    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	    				<p class="meta"><span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span></p>
	    				<p>
	    					<?php woo_image( 'noheight=true&width=' . $settings['blog_thumb_w'] . '&height=' . $settings['blog_thumb_h'] . '&class=thumbnail ' . $settings['blog_thumb_align'] ); ?>
	    					<?php the_excerpt(); ?>
	    				</p>
	    				</li>
    				<?php
    			} // End While Loop ?>
    			</ul>

    		</section>
    		<?php } // End If Statement ?>
    		<?php
    			wp_reset_postdata();
    			// Restore the original query.
				$wp_query = $old_query;
    		?>