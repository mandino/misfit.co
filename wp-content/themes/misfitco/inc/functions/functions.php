<?php

// FUNCTION: IS_SUBPAGE()

function is_subpage() {
	global $post;
	if ( is_page() && $post->post_parent ) {
		return $post->post_parent;
	} else { return false; }
}


function hexrgb($hexstr) {
	$int = hexdec($hexstr);
	return array("red" => 0xFF & ($int >> 0x10), "green" => 0xFF & ($int >> 0x8), "blue" => 0xFF & $int);
}


// WORDPRESS IMAGE TO ACF GET IMAGE

function wp_image_to_acf_get_image($thumbnail_id) {

	$image_array = false;
	$thumbnail_id = (int)$thumbnail_id;

	if ( $thumbnail_id !== 0 ) :

		// IMAGE FULL URL
			$image_full_url = wp_get_attachment_image_src($thumbnail_id, 'full');
			if ( $image_full_url ) :
				$image_full_url = $image_full_url[0];
			endif;


		// GET ALL IMAGE URL|WIDTH|HEIGHT BY IMAGE SIZE
			$image_sizes = get_intermediate_image_sizes();
			$image_array_sizes = array();

			foreach ( $image_sizes as $image_size ) :

				$image_item = wp_get_attachment_image_src($thumbnail_id, $image_size);

				if ( $image_item ) :
					$image_array_sizes[$image_size] = $image_item[0];
					// $image_array_sizes[$image_size . '-width'] = $image_item[1];
					// $image_array_sizes[$image_size . '-height'] = $image_item[2];
				endif;

			endforeach;


		// ADD EVERYTHING TO ARRAY
			$image_array = array(
				'ID' => $thumbnail_id,
				'id' => $thumbnail_id,
				'url' => $image_full_url,
				'title' => get_the_title($thumbnail_id),
				'alt' => wp_image_alt($thumbnail_id),
				'sizes' => $image_array_sizes,
			);

	endif;

	return $image_array;

}


// FUNCTION: WORDPRESS IMAGE ALT

function wp_image_alt($thumbnail_id) {
	$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
	if ( $alt == '' ) {
		$alt = get_the_title($thumbnail_id);
	}
	return $alt;
}


// ADD CATEGORY TO PAGES

add_action( 'init', 'add_taxonomies_to_pages' );
function add_taxonomies_to_pages() {
	register_taxonomy_for_object_type( 'post_tag', 'page' );
	register_taxonomy_for_object_type( 'category', 'page' );
}


// ACF: WP AUTOP

//add_filter('acf/format_value/type=wysiwyg', 'format_value_wysiwyg', 10, 3);
//function format_value_wysiwyg( $value, $post_id, $field ) {
//	$value = apply_filters( 'the_content', $value );
//	return $value;
//}


// ADD CLASS TO MENU LINKS?

add_filter( 'nav_menu_link_attributes', 'add_menu_atts', 10, 3 );
function add_menu_atts( $atts, $item, $args ) {
	$atts['class'] = 'animsition-link';
	return $atts;
}


// REMOVE COMMENT FUNCTIONS

require( get_stylesheet_directory() . '/inc/functions/remove-comment-functions.php');


// ADD LANG TEXT DOMAIN

load_theme_textdomain( 'thumos', get_template_directory() . '/languages' );


// REMOVE CONTACT FORM 7 CSS STYLES?

add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
function wps_deregister_styles() {
	wp_deregister_style( 'contact-form-7' );
}


// REMOVE GUTENBURG VISUAL/TEXT EDITOR?

if ( is_admin() ) {
	add_filter('use_block_editor_for_post', '__return_false', 10);
	add_filter('use_block_editor_for_post_type', '__return_false', 10);
}


// ADD PHP VARS SCRIPT VARIABLE

function php_vars() {
	$php_vars = array(
		'admin_ajax_url' => admin_url('admin-ajax.php'),
		'get_bloginfo_url' => get_bloginfo('url'),
		'get_stylesheet_directory' => get_stylesheet_directory(),
		'get_stylesheet_directory_uri' => get_stylesheet_directory_uri(),
		'get_template_directory' => get_template_directory(),
		'get_template_directory_uri' => get_template_directory_uri(),
	);
	echo '<script type="text/javascript">var php_vars =' . json_encode($php_vars) . ';</script>';
}
add_action('wp_head', 'php_vars');

function sc_anti_wpautop($content) {
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);
	$content = strtr( $content, $array );

	$get_first_string = substr($content, 0, 4);
	$get_last_string = substr($content, -3);

	// check if $content starts with </p>
	if ( preg_match('/<\/p>/', $get_first_string) ) :
		$content = substr($content, 4);
	endif;

	// check if $content ends with <p>
	if ( preg_match('/<p>/', $get_last_string) ) :
		$content = substr($content, 0, -3);
	endif;

	// var_dump($content);

	return $content;
}

function generate_random_seed($length = 6) {
	$seed = str_split(
		'abcdefghijklmnopqrstuvwxyz'
		.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
		//.'0123456789!@#$%^&*()'
	);
	shuffle($seed);
	$string = '';
	foreach (array_rand($seed, $length) as $k) $string .= $seed[$k];
	return $string;
}

function excerpt($content, $limit) {
	$excerpt = explode(' ', $content, $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return $excerpt;
}


function get_user_ip() {

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;

}

function get_user_ip_data() {

	$user_ip = get_user_ip();

	// CURL

		// from: https://geojs.io/
		$api_url = 'https://get.geojs.io/v1/ip/geo.json?ip=' . $user_ip;

		// Get cURL resource
		$api_curl = curl_init();

		// Set some options - we are passing in a useragent too here
		curl_setopt_array($api_curl, array(
			CURLOPT_URL => $api_url,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_NOBODY => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		));

		// Send the request & save response to $api_json
		$api_json = curl_exec($api_curl);

		// Close request to clear up some resources
		curl_close($api_curl);

	// PHP

		// convert json to php object
		// get first array index only
		$api_json = json_decode($api_json)[0];

		// return false if $api_json is null or empty
		if ( !isset($api_json) || empty($api_json) ) $api_json = false;

		return $api_json;	

}

function responsiveHeight( $desktop = 100, $tablet = 100, $mobile = 100 ) {
	$heightClass = array();

	if($desktop)
		$heightClass[] = 'height__desktop--' . $desktop;

	if($tablet)
		$heightClass[] = 'height__tablet--' . $tablet;

	if($mobile)
		$heightClass[] = 'height__mobile--' . $mobile;

	return implode(' ', $heightClass);
}

function dynamicImageSetup($desktop, $tablet, $mobile, $class = '') {
	$responsiveData = array();

	if( $desktop ) {
		$responsiveData[] = array(
								'class' => 'show-for-large',
								'data' => $desktop,
								'size' => 'xxl'
							);
		responsive_background_image($desktop, 'landscape', $class.'.show-for-large', 'xxl', false, false);
	}

	$tablet_image = $tablet;
	if( !$tablet_image )
		$tablet_image = $desktop;

	if( $tablet_image ) {
		$responsiveData[] = array(
								'class' => 'show-for-medium-only',
								'data' => $tablet_image,
								'size' => 'large'
							);
		responsive_background_image( $tablet_image, 'landscape', $class.'.show-for-medium-only', 'large', false, false);
	}

	$mobile_image = $mobile;
	if( !$mobile_image )
		$mobile_image = ($tablet) ? $tablet_image : $desktop;

	if( $mobile_image ) {
		$responsiveData[] = array(
								'class' => 'show-for-small-only',
								'data' => $mobile_image,
								'size' => 'medium'
							);
		responsive_background_image($mobile_image, 'landscape', $class.'.show-for-small-only', 'medium', false, false);
	}

	return $responsiveData;
}