<?php
/**
 * Custom Post Types
 *
 * @package WordPress
 * @subpackage cebo
 * @since Dream Home 1.0
 */
 
///////////////////////////////////////////////////////////////////////////// Custom Post Type

add_action('init', 'project_items');

function project_items()
{
  $labels = array(
    'name' => _x('Articles', 'post type general name'),
    'singular_name' => _x('Articles', 'post type singular name'),
    'add_new' => _x('Add New', 'Articles'),
    'add_new_item' => __('Add New Articles'),
    'edit_item' => __('Edit Articles'),
    'new_item' => __('New Articles'),
    'view_item' => __('View Articles'),
    'search_items' => __('Search Articles'),
    'not_found' =>  __('No Articles found'),
    'not_found_in_trash' => __('No Articles found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'project' ),
    'capability_type' => 'post',
    'menu_icon' => get_bloginfo('template_url').'/options/images/icon_project.png',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','custom-fields','editor','author','excerpt','comments','thumbnail')
  );
  register_post_type('article',$args);
}


//create taxonomy for project type

create_type_taxonomies();


function create_type_taxonomies()
{
  // Taxonomy for Location
  $labels = array(
    'name' => _x( 'Edition Number', 'taxonomy general name' ),
    'singular_name' => _x( 'Edition Number', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Edition Numbers' ),
    'all_items' => __( 'All Edition Numbers' ),
    'parent_item' => __( 'Parent Edition Number' ),
    'parent_item_colon' => __( 'Parent Edition Number:' ),
    'edit_item' => __( 'Edit Edition Number' ),
    'update_item' => __( 'Update Edition Number' ),
    'add_new_item' => __( 'Add New Edition Number' ),
    'new_item_name' => __( 'New Edition Number Name' ),
  ); 	

  register_taxonomy('edition', array('article'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'edition' ),
  ));

}



/**
 * Hooks the WP cpt_post_types filter 
 *
 * @param array $post_types An array of post type names that the templates be used by
 * @return array The array of post type names that the templates be used by
 **/
function my_cpt_post_types( $post_types ) {
    $post_types[] = 'article';
    $post_types[] = 'actor';
    return $post_types;
}
add_filter( 'cpt_post_types', 'my_cpt_post_types' );


?>