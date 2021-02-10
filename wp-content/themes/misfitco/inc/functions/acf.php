<?php if ( ! defined( 'ABSPATH' ) ) exit;

if(
	$_SERVER['ENV'] === 'production' ||
	$_SERVER['ENV'] === 'development'
){
	add_filter('acf/settings/show_admin', '__return_false');
}

// ACF PLUGIN INIT

add_filter('acf/settings/path', 'acf_settings_path');
function acf_settings_path( $path ) {
	$path = get_stylesheet_directory_uri() . '/acf/';
	return $path;
}

add_filter('acf/settings/dir', 'acf_settings_dir');
function acf_settings_dir( $dir ) {
	$dir = get_stylesheet_directory_uri() . '/acf/';
	return $dir;
}

// ACF JSON SAVE/LOAD POINT

add_filter('acf/settings/save_json', 'acf_json_save_point');
function acf_json_save_point( $path ) {
	$path = get_stylesheet_directory() . '/inc/acf';
	return $path;
}

add_filter('acf/settings/load_json', 'acf_json_load_point');
function acf_json_load_point( $path ) {
	unset( $path[0] );
	$path[] = get_stylesheet_directory() . '/inc/acf';
	return $path;
}


// ACF OPTION

if ( function_exists('acf_add_options_page') ) {

	$options_page_parent = acf_add_options_page(array(
		'page_title'	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'redirect'		=> false
	));
}


// ACF: HTML TAG

function acf_html_tag($value, $default = 'div') {
	if ( $value ) :
		if ( $value == 'default' ) :
			$value = $default;
		endif;
	else :
		$value = $default;
	endif;

	return $value;
}


// ACF: OPEN IN NEW TAB

function acf_open_in_new_tab($open_tab) {
	if ( $open_tab ) :
		$open_tab = 'target="_blank"';
	else :
		$open_tab = '';
	endif;

	return $open_tab;
}

// ACF: GET BUTTON STYLE
function acf_get_btn_style($link_style) {
	switch ($link_style) {
		case 'link':
			$style = 'link';
		break;

		default:
			$style = 'button';
		break;
	}
	return $style;
}

// ACF: GET COLUMNS
function acf_get_col_num($num) {
	switch ($num) {
		case 'two':
			$style = 'large-6 medium-6 small-12';
		break;
		case 'three':
			$style = 'large-4 medium-4 small-12';
		break;
		case 'four':
			$style = 'large-3 medium-3 small-12';
		break;
		case 'five':
			$style = 'custom-large-5 custom-medium-5 custom-small-12';
		break;
		default:
			$style = 'large-4 medium-4 small-12';
		break;
	}
	return $style;
}

// ACF: GET LINK

function acf_get_link( $link_type, $link_url, $page_link ) {
	$link = false;

	if ( $link_type == 'external' || $link_type == 'custom' ) :
		$link = $link_url;
	elseif ( $link_type == 'internal' || $link_type == 'page' ) :
		$page_link_url = ( $link_type == 'internal' ) ? get_permalink($page_link->ID) : $page_link;
		$link = $page_link_url;
	endif;

	return $link;
}


// ACF: GET IMAGE

function acf_get_image( $image ) {

	if ( $image ) {
		if ( $image['alt'] == '' ) {
			$image['alt'] = $image['title'];
		}
	}

	return $image;

}


// ACF: GET VIDEO LINK

function acf_get_video_link( $video_type, $video_link, $video_file ) {
	$link = false;

	if ( $video_type == 'link' ) :
		$link = $video_link;
	elseif ( $video_type == 'file' ) :
		$link = $video_file;
	endif;

	return $link;
}


// ACF: HEX TO RGB

function acf_hex_to_rgb($hexstr) {
	if ( $hexstr ) :
		$hexstr = str_replace('#', '', $hexstr);
		$int = hexdec($hexstr);
		return array("red" => 0xFF & ($int >> 0x10), "green" => 0xFF & ($int >> 0x8), "blue" => 0xFF & $int);
	else :
		return $hexstr;
	endif;
}


// ACF: SHORTCODE

function cleanup_shortcode_fix($content) {
	$array = array(
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']',
		']<br>' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}
// add_filter('acf_the_content', 'cleanup_shortcode_fix');


// ACF: CUSTOM FIELD EXCERPT

function acf_custom_field_excerpt($content, $excerpt_length) {
	global $post;

	if ( '' != $content ) {
		$content = strip_shortcodes( $content );
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]&gt;', ']]&gt;', $content);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '...');
		$content = wp_trim_words( $content, $excerpt_length, $excerpt_more );
	}
	return apply_filters('the_excerpt', $content);
}


// ACF: VISIBILITY CLASSES

function acf_visibility_class($visibility) {
	if ($visibility && !empty($visibility)) :
		foreach ($visibility as &$str) :
			$str = str_replace('_', '-', $str);
		endforeach;
	endif;

	return $visibility;
}