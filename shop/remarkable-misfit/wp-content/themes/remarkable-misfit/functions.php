<?php

// /*-----------------------------------------------------------------------------------*/
// /* Start WooThemes Functions - Please refrain from editing this section */
// /*-----------------------------------------------------------------------------------*/

// // Define the theme-specific key to be sent to PressTrends.
// define( 'WOO_PRESSTRENDS_THEMEKEY', 'pivqh37o1az912ycxt502jsfg2vcbtam7' );

// // WooFramework init
// require_once ( get_template_directory() . '/functions/admin-init.php' );

// /*-----------------------------------------------------------------------------------*/
// /* Load the theme-specific files, with support for overriding via a child theme.
// /*-----------------------------------------------------------------------------------*/

// $includes = array(
//         'includes/theme-options.php',       // Options panel settings and custom settings
//         'includes/theme-functions.php',     // Custom theme functions
//         'includes/theme-actions.php',       // Theme actions & user defined hooks
//         'includes/theme-comments.php',      // Custom comments/pingback loop
//         'includes/theme-js.php',        // Load JavaScript via wp_enqueue_script
//         'includes/sidebar-init.php',      // Initialize widgetized areas
//         'includes/theme-widgets.php'      // Theme widgets
//         );

// // Allow child themes/plugins to add widgets to be loaded.
// $includes = apply_filters( 'woo_includes', $includes );

// foreach ( $includes as $i ) {
//   locate_template( $i, true );
// }

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/

/* Kula functions and definitions */

/*-----------------------------------------------------------------------------------*/
/* Declaring the content width based on the theme's design and stylesheet
/*-----------------------------------------------------------------------------------*/

if ( !isset( $content_width ) )
  $content_width = 960; /* pixels */

/*-----------------------------------------------------------------------------------*/
/* Declaring the theme language domain (for language translations)
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain('kula', get_template_directory().'/lang');

/*-----------------------------------------------------------------------------------*/
/* Register & Enqueue JS and CSS
/*-----------------------------------------------------------------------------------*/

function gt_queue_assets() {
	$data = get_option("kula_options");
	
	$body_font = ucwords($data['body_font']['face']);
	$headings_font = ucwords($data['headings_font']['face']);
	$logo_font = ucwords($data['logo_font']['face']);
	$uber_font = ucwords($data['uber_font']['face']);
	
	$body_font_weight = ucwords($data['body_font']['style']);
	$headings_font_weight = ucwords($data['headings_font']['style']);
	$logo_font_weight = ucwords($data['logo_font']['style']);
	$uber_font_weight = ucwords($data['uber_font']['style']);
  	
  	if ( !is_admin() ) {
  	
  	wp_enqueue_script('jquery');
  	
  // Register Scripts (Places all jQuery dependant scripts into Footer)
  	wp_register_script('modernizr', get_template_directory_uri() .'/assets/js/modernizr-2.6.2.min.js');
  	wp_register_script('jquery-easing', get_template_directory_uri() .'/assets/js/jquery.easing.min.js', 'jquery', '1.3', true);
  	wp_register_script('fancybox', get_template_directory_uri() .'/assets/js/jquery.fancybox.min.js', 'jquery', '2.1', true);
  	wp_register_script('fitvids', get_template_directory_uri() .'/assets/js/jquery.fitvids.js', 'jquery', '1.0', true);
  	wp_register_script('flexslider', get_template_directory_uri() .'/assets/js/jquery.flexslider.min.js', 'jquery', '2.1', true);
  	wp_register_script('isotope', get_template_directory_uri() .'/assets/js/jquery.isotope.min.js', 'jquery', '1.5', true);
  	wp_register_script('quote-rotator', get_template_directory_uri() .'/assets/js/jquery.quote.rotator.min.js', 'jquery', '1.0', true);
  	wp_register_script('sticky-nav', get_template_directory_uri() .'/assets/js/jquery.sticky.js', 'jquery', '1.0', true);
  	wp_register_script('mobile-menu', get_template_directory_uri() .'/assets/js/jquery.mobilemenu.js', 'jquery', '1.0', true);
  	wp_register_script('contact-form', get_template_directory_uri() .'/assets/js/jquery.form.min.js', 'jquery', '3.1', true);
  	wp_register_script('form-validate', get_template_directory_uri() .'/assets/js/jquery.validate.min.js', 'jquery', '1.9', true);
  	wp_register_script('respond', get_template_directory_uri() .'/assets/js/respond.min.js');
  	wp_register_script('custom-js-settings', get_template_directory_uri() .'/assets/js/custom.js', 'jquery', '1.0', true);
    wp_register_script('colorbox', get_template_directory_uri() .'/assets/js/jquery.colorbox-min.js', 'jquery', '1.0', true);
    wp_register_script('chosen', get_template_directory_uri() .'/assets/js/chosen.jquery.min.js', 'jquery', '1.0', true);
  	
  // Register Styles
  
  	wp_register_style('style', get_stylesheet_directory_uri() .'/style.css');

	if(is_multisite()) {
		$uploads = wp_upload_dir();
		wp_register_style('options', trailingslashit($uploads['baseurl']) .'options.css', 'style');
	} else {
		wp_register_style('options', get_template_directory_uri() .'/assets/css/dynamic-css/options.css', 'style');
	}
  
  	wp_register_style('flexslider', get_template_directory_uri().'/assets/css/flexslider.css');
  	wp_register_style('fancybox', get_template_directory_uri().'/assets/css/fancybox.css');
  	wp_register_style('font-awesome', get_template_directory_uri().'/assets/css/font-awesome.css');
  	wp_register_style('social-media', get_template_directory_uri().'/assets/css/social-media.css');
  	wp_register_style("body-font", "http://fonts.googleapis.com/css?family={$body_font}:{$body_font_weight}");
  	wp_register_style("headings-font", "http://fonts.googleapis.com/css?family={$headings_font}:{$headings_font_weight}");
  	wp_register_style("logo-font", "http://fonts.googleapis.com/css?family={$logo_font}:{$logo_font_weight}");
  	wp_register_style("uber-font", "http://fonts.googleapis.com/css?family={$uber_font}:{$uber_font_weight}");
    wp_register_style("colorbox", get_template_directory_uri().'/assets/js/colorbox/colorbox.css');
    wp_register_style("chosen", get_template_directory_uri().'/assets/css/chosen.css');
    wp_register_style("google-fonts-open-sans", "http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800");
	
  // Enqueue Scripts (Global)
  	wp_enqueue_script('modernizr');
  	wp_enqueue_script('jquery-easing');
  	wp_enqueue_script('fancybox');
  	wp_enqueue_script('fitvids');
  	wp_enqueue_script('flexslider');
  	wp_enqueue_script('isotope');
  	wp_enqueue_script('quote-rotator');
  	wp_enqueue_script('sticky-nav');
  	wp_enqueue_script('mobile-menu');
  	wp_enqueue_script('contact-form');
  	wp_enqueue_script('form-validate');
  	wp_enqueue_script('respond');
	wp_enqueue_script('custom-js-settings');
    wp_enqueue_script('colorbox');
    wp_enqueue_script('chosen');
	
  // Enqueue Styles (Global)
  	wp_enqueue_style('options');
  	wp_enqueue_style('style');	
  	wp_enqueue_style('options');
  	wp_enqueue_style("flexslider");
  	wp_enqueue_style("fancybox");
  	wp_enqueue_style("font-awesome");
  	wp_enqueue_style("social-media");
	wp_enqueue_style("body-font");
	wp_enqueue_style("headings-font");
	wp_enqueue_style("logo-font");
	wp_enqueue_style("uber-font");
  wp_enqueue_style("colorbox");
    wp_enqueue_style("google-fonts-open-sans");
    wp_enqueue_style("chosen");  

	} 
}
add_action("wp_enqueue_scripts", "gt_queue_assets");

// Load Admin assets 
function gt_admin_scripts() {
	wp_register_script('gt-admin-js', get_template_directory_uri() . '/assets/js/jquery.custom.admin.js');
    wp_enqueue_script('gt-admin-js');
    wp_register_style('gt-admin-css', get_template_directory_uri() . '/assets/css/custom-admin.css');
    wp_enqueue_style('gt-admin-css');
}
add_action('admin_enqueue_scripts', 'gt_admin_scripts');

/*-----------------------------------------------------------------------------------*/
/* Register Custom Menu
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_nav_menus') ) :
	register_nav_menus( array(
		  'Front' => __('Front Navigation Menu', 'kula'),
		  'Inner' => __('Inner Navigation Menu', 'kula')
		) );
endif;

/*-----------------------------------------------------------------------------------*/
/* Add support, and configure Thumbnails (for WordPress 2.9+)
/*-----------------------------------------------------------------------------------*/

if ( function_exists('add_theme_support') ) {
add_theme_support('post-thumbnails');
set_post_thumbnail_size(200, 200, true); // Normal post thumbnails
add_image_size('large', 632, 290, true); // Large thumbnails
add_image_size('small', 125, '', true); // Small thumbnails
add_image_size('team-member-thumb', 234, 234, true); // Team Member Thumbnail (appears on the homepage)
add_image_size('latest-news-thumb', 234, 234, true); // Latest News Thumbnail (appears on the homepage)
add_image_size('portfolio-thumb', 300, 300, true); // Portfolio Thumbnail (appears on the homepage)
add_image_size('single-post', 980, 523, true); // Large Post Thumbnail (appears on single post)
add_image_size('archive-post', 980, 523, true); // Large Post Thumbnail (appears on archive pages)
add_image_size('large-slider-thumb', 980, 570, true); // Large Slider Thumbnail (appears on single portfolio)
}

/*-----------------------------------------------------------------------------------*/
/* Register Sidebars/Widget Areas
/*-----------------------------------------------------------------------------------*/

function gt_widgets_init() {
  
  register_sidebar( array(
    'name' => 'Page Sidebar',
    'id' => 'sidebar-page',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<header><h4 class="widget-title">',
    'after_title' => '</h4></header>',
  ));
  
  register_sidebar( array(
    'name' => 'Blog Sidebar',
    'id' => 'sidebar-blog',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<header><h4 class="widget-title">',
    'after_title' => '</h4></header>',
  ));

}

add_action( 'init', 'gt_widgets_init' );

/*-----------------------------------------------------------------------------------*/
/* Register Automatic Feed Links
/*-----------------------------------------------------------------------------------*/

add_theme_support('automatic-feed-links');

/*-----------------------------------------------------------------------------------*/
/* Register Custom Widgets
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/widgets/widget-flickr.php');

/*-----------------------------------------------------------------------------------*/
/* Call Custom Post Types
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/custom-post-types/portfolio-type.php');
require_once(get_template_directory() . '/functions/custom-post-types/services-type.php');
require_once(get_template_directory() . '/functions/custom-post-types/team-type.php');
require_once(get_template_directory() . '/functions/custom-post-types/quotes-type.php');

/*-----------------------------------------------------------------------------------*/
/* Setup custom Metaboxes
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/theme-portfoliometa.php');
require_once(get_template_directory() . '/functions/theme-servicesmeta.php');
require_once(get_template_directory() . '/functions/theme-teammeta.php');
require_once(get_template_directory() . '/functions/theme-quotesmeta.php');

/*-----------------------------------------------------------------------------------*/
/* Shortcodes
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/shortcodes.php');

/*-----------------------------------------------------------------------------------*/
/* Custom Theme Functions
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/functions/theme-functions.php');

/*-----------------------------------------------------------------------------------*/
/* Slightly Modified Options Framework (SMOF)
/*-----------------------------------------------------------------------------------*/

require_once(get_template_directory() . '/admin/index.php');

if(function_exists("register_options_page")) {
  register_options_page('General Settings');
  register_options_page('01 - The People');
  register_options_page('02 - Local Partners');
  register_options_page('03 - Their Words');
  register_options_page('LP - Common Settings');
}

/*-----------------------------------------------------------------------------------*/
/* add item to cart on visit
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'add_product_to_cart' );
function add_product_to_cart() {
  if ( ! is_admin() ) {
    global $woocommerce;
    $product_id = 371;
    $found = false;
    //check if product already in cart
    if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
      foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
      $_product = $values['data'];
      if ( $_product->id == $product_id )
      $found = true;
    }
    // if product not found, add it
    if ( ! $found )
      $woocommerce->cart->add_to_cart( $product_id );
    } else {
    // if no products in cart, add it
      $woocommerce->cart->add_to_cart( $product_id );
    }
  }
}