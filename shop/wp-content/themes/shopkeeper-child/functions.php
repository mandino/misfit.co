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