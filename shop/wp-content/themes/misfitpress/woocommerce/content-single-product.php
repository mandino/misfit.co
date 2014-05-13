<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;
$thePostID = $post->ID;
$terms = wp_get_post_terms( $post->ID, 'product_cat' );
foreach ( $terms as $term ) $categories[] = $term->slug;

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
	
	<?php function paragraph() { ?>
		<div class="clear"></div>
	<?php }
	add_action( 'woocommerce_single_product_summary', 'paragraph', 10, 3 ); ?>
	
	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */

			if ( is_product_category('remarkable-misfit') || in_array( 'remarkable-misfit', $categories ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			}

			do_action( 'woocommerce_single_product_summary' );
		?>
		
	<div class="product-text">
		<?php echo get_post_meta( $thePostID, 'paragraphdesc', true ); ?>
	</div>
	
	<div class="images edited-img">
		<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	</div>

	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>