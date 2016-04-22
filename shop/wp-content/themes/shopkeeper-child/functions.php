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

*/

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
