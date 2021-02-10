<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// TinyMCE

if ( !function_exists( 'ss_framework_admin_scripts' ) ) {

	// Backend Scripts
	function ss_framework_admin_scripts( $hook ) {

		if( $hook == 'post.php' || $hook == 'post-new.php' ) {
			wp_register_script( 'tinymce_scripts', get_stylesheet_directory() . 'includes/tinymce/js/scripts.js', array('jquery'), false, true );
			wp_enqueue_script('tinymce_scripts');
		}

	}
	add_action( 'admin_enqueue_scripts' , 'ss_framework_admin_scripts' );
	
}