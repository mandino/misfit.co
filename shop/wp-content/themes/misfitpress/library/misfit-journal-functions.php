<?php
/**

Misfit Journal Functions
 
 */

 remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
 remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
 // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );