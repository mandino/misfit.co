<?php

/******************************************************************************/
/****** CUSTOM ******************************************/
/******************************************************************************/

/* disable review tab on product pages */
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab($tabs) {
	unset($tabs['reviews']);
	return $tabs;
}


/* Remove Related Products Output */
function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10); 


function tt($image,$width,$height){
    return get_stylesheet_directory_uri() . "/inc/thumb.php?src=$image&w=$width&h=$height";
}


/* Checkout fields

	sources:
	- https://wordpress.org/support/topic/added-checkout-fields-not-saving-to-post_meta
	- http://wordpress.stackexchange.com/questions/78339/how-to-reorder-billing-fields-in-woocommerce-checkout-template
	- https://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
	- https://wordpress.org/support/topic/get-billing-address-info-separately

add_filter( 'woocommerce_checkout_fields' , 'add_signup_box_checkbox_field' );

function add_signup_box_checkbox_field($fields) {
	
	$fields['billing']['billing_signup_checkbox'] = array(
		'type' => 'checkbox',
		'label' => __('Would you like to sign up for our Newsletter?', 'woocommerce'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true
	);
	
	return $fields;
}

add_filter("woocommerce_checkout_fields", "order_fields");

function order_fields($fields) {

    $order = array(
		"billing_first_name",
		"billing_last_name",
		"billing_company",
		"billing_email",
		"billing_phone",
		// "billing_signup_checkbox",
		"billing_country",
		"billing_address_1",
		"billing_address_2",
		"billing_city",
		"billing_state",
		"billing_postcode"
	);
	
    foreach($order as $field) {
		$ordered_fields[$field] = $fields["billing"][$field];
    }

	$fields["billing"] = $ordered_fields;
	return $fields;

}

*/


add_action( 'wp_enqueue_scripts', 'add_require_scripts_files' );

function add_require_scripts_files() {
	wp_enqueue_style('shopkeeper-style', get_stylesheet_directory_uri().'/style.css', array(), '1.0.5', "all");        
}


/******************************************************************************/
/****** WooCommerce CUSTOM ***********************************/
/******************************************************************************/

add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {

	$tabs['gallery_tab']['priority'] = 5;			
	$tabs['description']['priority'] = 10;			
	$tabs['comments_tab']['priority'] = 15;
	$tabs['additional_information']['priority'] = 20;
	// $tabs['shippings_tab']['priority'] = 25;
	// $tabs['ecology_tab']['priority'] = 30;

	return $tabs;
}


add_filter( 'woocommerce_product_tabs', 'woocommerce_custom_product_tab' );
function woocommerce_custom_product_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['gallery_tab'] = array(
		'title' 	=> __( 'Gallery', 'woocommerce' ),
		'priority' 	=> 40,
		'callback' 	=> 'woocommerce_gallery_tab'
	);

	$tabs['comments_tab'] = array(
		'title' 	=> __( 'Comments', 'woocommerce' ),
		'priority' 	=> 30,
		'callback' 	=> 'woocommerce_comments_tab'
	);

	return $tabs;

}

function woocommerce_gallery_tab() {
	global $product;
	$attachment_ids = $product->get_gallery_attachment_ids();

	echo '<div class="gallery-mosaic" data-columns>';
		foreach( $attachment_ids as $attachment_id ) {
			echo wp_get_attachment_image($attachment_id, 'full');
		}
	echo '</div>';

}

function woocommerce_comments_tab() {

	echo '<div class="fb-comments" data-href="http://misfit.co/shop/shop/" data-numposts="5"></div>';

}

add_filter( 'woocommerce_sale_flash', 'wc_custom_replace_sale_text' );
function wc_custom_replace_sale_text( $html ) {
    return str_replace( __( 'Sale!', 'woocommerce' ), __( 'On Sale!', 'woocommerce' ), $html );
}