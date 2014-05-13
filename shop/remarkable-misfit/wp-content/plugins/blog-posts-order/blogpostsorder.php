<?php
/**
 * @package Blog_Posts_Order
 * @version 1.0
 */
/*
Plugin Name: Blog Posts Order
Plugin URI: http://wordpress.org/extend/plugins/blog-posts-order/
Description: This plugin uses the WordPress's inbuilt functionality to apply ordering feature for the posts on the blog. Just like you order your pages on a menu, you can change the order of appearance of the posts on the blog. When this plugin is activated, it overrides the default ordering by published date and the posts are ordered according to the value provided in the order field for each of the posts.
Author: Gagan S Goraya
Version: 1.0
Author URI: http://gagangoraya.com/
*/

// Turn on the Attributes metabox for the posts
add_post_type_support( 'post', 'page-attributes' );

// Register a callback function for the pre_get_posts action
add_action( 'pre_get_posts', 'create_new_posts_order' );


/**
 * Registered Callback for the pre_get_posts action
 *
 * Modifies the blog query to order the posts by the value provided in the 'order' field for each post. 
 */
function create_new_posts_order( $query ) {

	if ( $query->is_main_query() )
		$query->set( 'orderby', 'menu_order' );

}
?>