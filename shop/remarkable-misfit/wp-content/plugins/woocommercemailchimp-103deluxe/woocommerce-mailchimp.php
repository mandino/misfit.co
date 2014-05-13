<?php
/**
 * Plugin Name: WooChimp Auto Subcribe Manager DELUXE
 * Plugin URI: http://www.woocommercemailchimp.com/
 * Description: Automated integration between woocommerce and mailchimp
 * Version: 1.0.3.d
 * Author: Mad Science Industries, Inc.
 * Author URI: http://www.woocommercemailchimp.com/
 */
if (!class_exists('MCAPI')) {
require_once "MCAPI.class.php";
}
function init_mailchimp_class() {
    include_once( 'mailchimp.class.php' );
}

add_action( 'plugins_loaded', 'init_mailchimp_class');