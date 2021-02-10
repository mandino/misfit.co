<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Load on Admin and Non-admin
require( get_stylesheet_directory() . '/inc/functions/theme-support.php');
require( get_stylesheet_directory() . '/inc/functions/image-sizes.php');
require( get_stylesheet_directory() . '/inc/functions/post-types.php');
require( get_stylesheet_directory() . '/inc/functions/custom-navigation.php');


// Shortcodes
require( get_stylesheet_directory() . '/inc/tinymce/shortcodes.php');


// Enqueue Scripts & Styles

if ( !is_admin() ) add_action( 'wp_enqueue_scripts', 'enqueue_scripts_styles', 11 );

function enqueue_scripts_styles() {
	wp_deregister_script( 'jquery' );
}

require( get_stylesheet_directory() . '/inc/functions/wpml.php' );
require( get_stylesheet_directory() . '/inc/functions/acf.php' );
require( get_stylesheet_directory() . '/inc/functions/functions.php' );
require( get_stylesheet_directory() . '/inc/functions/instagram.php' );

include_once(WP_PLUGIN_DIR.'/advanced-custom-fields-pro/acf.php');


function custom_excerpt_more( $excerpt ) {
    return '';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

function custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
