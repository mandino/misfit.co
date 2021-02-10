<?php
/**
 * Custom Post Types
 *
 * @package WordPress
 * @subpackage cebo
 * @since Dream Home 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* CUSTOM POST TYPES -------------------------------------------------------------------------------------*/

// Resources

// add_action('init', 'resources_post_type');

// function resources_post_type() {
// 	$labels = [
// 		'name' => _x('Resources', 'post type general name'),
// 		'singular_name' => _x('Resources', 'post type singular name'),
// 		'add_new' => _x('Add New', 'Resources'),
// 		'add_new_item' => __('Add New Resources'),
// 		'edit_item' => __('Edit Resources'),
// 		'new_item' => __('New Resources'),
// 		'view_item' => __('View Resources'),
// 		'search_items' => __('Search Resources'),
// 		'not_found' => __('No Resources found'),
// 		'not_found_in_trash' => __('No Resources found in Trash'),
// 		'parent_item_colon' => ''
// 	];

// 	$args = [
// 		'labels' => $labels,
// 		'public' => true,
// 		'publicly_queryable' => true,
// 		'show_ui' => true,
// 		'query_var' => true,
// 		'rewrite' => [
// 			'slug' => 'resources',
// 			'with_front' => false,
// 			'hierarchical' => true
// 		],
// 		'capability_type' => 'post',
// 		'menu_icon' => 'dashicons-admin-page',
// 		'hierarchical' => true,
// 		'menu_position' => null,
// 		'supports' => ['title','editor','comments','revisions','trackbacks','author','excerpt','thumbnail','custom-fields'],
// 	];

// 	register_post_type('resources', $args);

// 	register_taxonomy(
// 		'resources-category',
// 		'resources',
// 		[
// 			'label' => __( 'Categories' ),
// 			'rewrite' => array( 'slug' => 'resources-category' ),
// 			'show_admin_column' => true,
// 			'hierarchical' => true
// 		]
// 	);
// }