<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'show_admin_bar', '__return_false' );

register_nav_menus(array(
	'main_nav' => __( 'Main Navigation', 'misfit' ),
	'button_nav' => __( 'Button Navigation', 'misfit' ),
	'hamburger_main_nav' => __( 'Hamburger Nav', 'misfit' ),
	 'footer_nav' => __( 'Footer Nav', 'misfit' ),
	// 'footer_approach' => __( 'Footer Approach Nav', 'misfit' ),
	// 'footer_platform' => __( 'Footer Platform Nav', 'misfit' ),
	// 'footer_company' => __( 'Footer Company Nav', 'misfit' ),
	// 'footer_engage' => __( 'Footer Engage Nav', 'misfit' ),
	// 'footer_bottom_nav' => __( 'Footer Bottom Nav', 'misfit' ),
));