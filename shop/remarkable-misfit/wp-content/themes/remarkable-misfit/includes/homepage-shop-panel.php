<?php
/**
 * Homepage Shop Panel
 */

	/**
 	* The Variables
 	*
 	* Setup default variables, overriding them if the "Theme Options" have been saved.
 	*/

	global $woocommerce;

	$settings = array(
					'thumb_w' => 100,
					'thumb_h' => 100,
					'thumb_align' => 'alignleft',
					'shop_area' => 'false',
					'shop_area_entries' => 4,
					'shop_area_title' => '',
					'shop_area_message' => '',
					'shop_area_link_text' => 'View all our products',
					);

	$settings = woo_get_dynamic_values( $settings );

?>
			<section id="shop-home" class="home-section fix">

    			<header class="section-title fix">
    				<h1><?php echo stripslashes( $settings['shop_area_title'] ); ?></h1>
    				<span class="sub"><?php echo stripslashes($settings['shop_area_message']); ?></span>
    				<a class="section-more" href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>" title="<?php esc_attr_e( 'View all our products', 'woothemes' ); ?>"><?php echo stripslashes( $settings['shop_area_link_text'] ); ?></a>
    			</header>

    			<ul class="recent products">

					<?php
					$number_of_products = $settings['shop_area_entries'];
					$args = array(
						'post_type' => 'product',
						'posts_per_page' => $number_of_products,
						'meta_query' => array( array(
						'key' => '_visibility',
						'value' => array( 'catalog', 'visible' ),
						'compare' => 'IN'
						))
					);
					$first_or_last = 'first';
					$loop = new WP_Query( $args );
					if ( function_exists( 'get_product' ) ) {
						$_product = get_product( $loop->post->ID );
					} else {
						$_product = new WC_Product( $loop->post->ID );
					}
					$count = 0;
					while ( $loop->have_posts() ) : $loop->the_post(); $_product; $count++; ?>

						<?php woocommerce_get_template_part( 'content', 'product' ); ?>


					<?php endwhile; ?>

				</ul><!--/ul.recent-->

    		</section>

    		<?php wp_reset_query(); ?>