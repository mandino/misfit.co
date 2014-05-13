<?php
/*
Plugin Name: WooCommerce Cart Reports
Plugin URI: http://woothemes.com/woocommerce
Description: WooCommerce Cart Reports allows site admins to keep track of Abandoned, Open, and Converted Carts. Admins can look at items in their customers carts, get site usage information, email customers, and access a new graphical report illustrating cart behavior trends on your site.
Version: 1.0.2
Author: avEIGHT
Author URI: http://www.aveight.com
*/

/*  Copyright 2013  avEIGHT  (email : bryan@aveight.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), '3920e2541c6030c45f6ac8ccb967d9d5', '184638' );

define("CONVERTED",'Converted');
define("ABANDONED",'Abandoned');
define("OPEN",'Open');

if ( is_woocommerce_active() ) {

	/**
	 * Localisation
	 **/
	load_plugin_textdomain( 'woocommerce_cart_reports', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	include(plugin_dir_path( __FILE__ ).'/models/AV8_Cart_Actions.php');
	include(plugin_dir_path( __FILE__ ).'/models/AV8_Cart_Receipt.php');
	include(plugin_dir_path( __FILE__ ).'/admin/cart_index_interface.php');
	include(plugin_dir_path( __FILE__ ).'/admin/cart_edit_interface.php');
	include(plugin_dir_path( __FILE__ ).'/admin/cart_reports_settings.php');
	include(plugin_dir_path( __FILE__ ).'/admin/cart_reports_dashboard.php');
	include(plugin_dir_path( __FILE__ ).'/admin/cart_reports_page.php');
	include(plugin_dir_path( __FILE__ ).'/includes/helpers.php');


	//Add our Custom Cart Post type

	add_action('init', 'create_custom_tax', 0); //Init, create custom stuff first

	/*
	* We need a custom taxonomy for "Cart Status." You'll only find 2 terms here - Open
	* and Converted. Abandoned status is determined on the fly :\ with a custom 'post_where'
	* filter hook.
	*/

	function create_custom_tax(){

		register_taxonomy( 'shop_cart_status',
		   array('carts'),
		   array(
				'hierarchical' 			=> false,
				'update_count_callback' => '_update_post_term_count',
				'labels' => array(
							'name' 				=> __( 'Cart statuses', 'woocommerce'),
							'singular_name' 	=> __( 'Cart status', 'woocommerce'),
							'search_items' 		=> __( 'Search Cart statuses', 'woocommerce'),
							'all_items' 		=> __( 'All Cart statuses', 'woocommerce'),
							'parent_item' 		=> __( 'Parent Cart status', 'woocommerce'),
							'parent_item_colon' => __( 'Parent Cart status:', 'woocommerce'),
							'edit_item' 		=> __( 'Edit Cart status', 'woocommerce'),
							'update_item' 		=> __( 'Update Cart status', 'woocommerce'),
							'add_new_item' 		=> __( 'Add New Cart status', 'woocommerce'),
							'new_item_name' 	=> __( 'New Cart status Name', 'woocommerce')
					 ),
				'show_in_nav_menus' 	=> false,
				'public' => false,
				'show_ui' => false,
				'query_var' => is_admin(),
				'rewrite' 				=> false,
				)
		);

		$cart_status = array("open", "converted");

		foreach ( $cart_status as $status ) {
			if ( ! get_term_by( 'slug', sanitize_title($status), 'shop_cart_status' ) )
				wp_insert_term( $status, 'shop_cart_status' );
		}
	}

	/**
	 * Register our shiny new post type for "Carts"
	 *
	 */
	function cart_add_type_init() {
	register_post_type('carts', array(	'label' => 'Carts','description' => '','public' => false,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'exclude_from_search' => false,'supports' => array('title','author'),'labels' => array (
	  'name' => 'Carts',
	  'singular_name' => 'Cart',
	  'menu_name' => 'Carts',
	  'add_new' => 'Add Cart',
	  'add_new_item' => '',
	  'edit' => 'Edit',
	  'edit_item' => 'Cart Details',
	  'new_item' => 'New Cart',
	  'view' => 'View Cart',
	  'view_item' => 'View Cart',
	  'search_items' => 'Search Carts',
	  'not_found' => 'No Carts Found',
	  'not_found_in_trash' => 'No Carts Found in Trash',
	  'parent' => 'Parent Cart',

	),
	'public' => false,
	'show_ui' => true,
	'show_in_menu' 			=> 'woocommerce',
				'hierarchical' 			=> false,
				'show_in_nav_menus' 	=> true,

	) );

	}
	// Styling for the custom post type icon

	add_action( 'init', 'cart_add_type_init' );

	if ( ! function_exists( 'is_woocommerce_active' ) ) require_once( 'woo-includes/woo-functions.php' );

	register_activation_hook( __FILE__, 'woocommerce_abandoned_carts_activate');
	register_deactivation_hook( __FILE__, 'woocommerce_abandoned_carts_deactivate' );
	register_uninstall_hook( __FILE__,  'woocommerce_abandoned_carts_uninstall'  );
	/**
	 * Activate the function with some default options
	 */
	function woocommerce_abandoned_carts_activate() {

	//Check first to see if we need to upgrade

		global $wpdb;

		$check_sql = "SELECT meta_value FROM ".$wpdb->prefix. "postmeta WHERE meta_key = 'av8_cartitems'";
		$upgrade_needed = false;
		$check_meta_vals = $wpdb->get_results($check_sql);
		foreach($check_meta_vals as $check_meta_val):
			if(strpos($check_meta_val->meta_value, 'WC_Product')):
				$upgrade_needed = true;
			endif;
		endforeach;

		if($upgrade_needed) {
			//Upgrade needed.
			$check_sql = "SELECT * from ".$wpdb->prefix. "postmeta WHERE meta_key = 'av8_cartitems'";

			$meta_vals = $wpdb->get_results($check_sql);
			$counter = 0;
			foreach($meta_vals as $meta_key):
				$new_meta_value = str_replace('O:10:"WC_Product"','O:8:"stdclass"', $meta_key->meta_value);
				$upgrade_sql = "UPDATE ".$wpdb->prefix. "postmeta SET meta_value = '" . $new_meta_value ."'WHERE meta_id = '" . $meta_key->meta_id . "' AND meta_key = '" . $meta_key->meta_key . "'";
				$wpdb->query($upgrade_sql);
				$counter ++;
			endforeach;

		}


	}

	/**
	 * Deactivate the plugin - cleanup the options
	 */
	function woocommerce_abandoned_carts_deactivate() {
	}


		/**
	 * Delete the plugin - delete all cart data
	 */
	function woocommerce_abandoned_carts_uninstall() {
		global $wpdb;
		$sql = "SELECT * FROM ".$wpdb->prefix. "posts WHERE post_type = 'carts'";
		$result = $wpdb->get_results($sql);

		foreach($result as $cart)
		{
			$delete_meta_sql = "DELETE FROM ".$wpdb->prefix. "postmeta WHERE post_id = '" . $cart->ID . "'";
			$wpdb->query($delete_meta_sql);
			$delete_sql = "DELETE FROM ".$wpdb->prefix. "posts WHERE ID = '" . $cart->ID . "'";
			$wpdb->query($delete_sql);
		}

	}


	class AV8_Cart_Reports {

	public $existing_id;
	public $receipt;

	public function __construct(){

		global $wpdb;
		global $woocommerce_cart_reports_options;

		$woocommerce_cart_reports_options['timeout'] = get_option("wc_cart_reports_timeout");
		$productsindex = get_option("wc_cart_reports_productsindex");
		if($productsindex == 'yes')
			$woocommerce_cart_reports_options['productsindex'] = true;
		else
			$woocommerce_cart_reports_options['productsindex'] = false;

		$logips = get_option("wc_cart_reports_logip");

		if($logips =='yes')
		$woocommerce_cart_reports_options['logip'] = true;
		else
		$woocommerce_cart_reports_options['logip'] = false;

		$woocommerce_cart_reports_options['dashboardrange'] = get_option("wc_cart_reports_dashboardrange");
		if(!is_numeric((int)$woocommerce_cart_reports_options['dashboardrange']) || $woocommerce_cart_reports_options['dashboardrange'] < 1)
			$woocommerce_cart_reports_options['dashboardrange'] ==2;
		if(!is_numeric((int)$woocommerce_cart_reports_options['timeout']) || $woocommerce_cart_reports_options['timeout'] < 1)
			$woocommerce_cart_reports_options['timeout'] ==1200;

		$woocommerce_cart_reports_options['timeout'] = (int)$woocommerce_cart_reports_options['timeout'];

			if(function_exists('get_product') && defined('COOKIEVALUE')){
		$session = COOKIEVALUE;
	}
	else
	{
		$session = session_id();
	}

		$this->receipt = new AV8_Cart_Receipt($session);



		add_action('woocommerce_checkout_update_order_review', array($this,'save_from_ajax'));
		add_action('woocommerce_cart_updated', array($this, 'save_receipt'));
		add_action('woocommerce_created_customer', array($this, 'save_user_id'));
		add_action('woocommerce_new_order',array($this, 'save_order_id'));

		if(is_admin()){
			$Edit_Interface = new AV8_Edit_Interface();
			$Cart_Index = new AV8_Cart_Index_Page();
			$Settings_Page = new AV8_Cart_Reports_Settings();
			$Dashboard_Page = new AV8_Cart_Dashboard();
			$Reports = new AV8_Cart_Reports_Page();
		}
	}


	/**
	 * This is the main routine that acts when the visitor makes a change to their cart.
	 * First we save the user id and useragent info (if the option is set to "on") Next we
	 * populate the receipt object with the products, owner (if exists) and session id.
	 */
	public function save_receipt() {
		global $woocommerce_cart_reports_options, $woocommerce;

		if ( isset( $_SERVER ) && isset( $woocommerce_cart_reports_options['logip'] ) && $woocommerce_cart_reports_options['logip'] == 'on' ) {
			$this->ip_address = $_SERVER['SERVER_ADDR'];
			$this->user_agent = $_SERVER['HTTP_USER_AGENT'];
		}

		//Get current user, generate full name for use later
		$person = get_current_user_id(); //$person is '' if guest

		if ( function_exists( 'get_product' ) ) {
			$session = COOKIEVALUE;
		} else {
			$session = session_id();
		}

		// Don't save if is a search engine
		if ( ! detect_search_engines( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$receipt = new AV8_Cart_Receipt( $session );
			$receipt->set_owner( $person );
			$receipt->set_products( $woocommerce ); //Grab products from woocommerce global object
			$receipt->save_receipt(); //Save the object to the database
		}
	}

	/**
	 * Hooks into the woo action for conversions. This function tells the model that it's now
	 * a converted cart and should act as such
	 */


	public function save_from_ajax($data)
	{
		global $woocommerce_cart_reports_options;
		global $current_user;
		global $options;
		global $woocommerce;
		if(isset($_SERVER) && isset($woocommerce_cart_reports_options['logip']) && $woocommerce_cart_reports_options['logip'] == 'on') {
			$this->ip_address = $_SERVER['SERVER_ADDR'];
			$this->user_agent = $_SERVER['HTTP_USER_AGENT'];
		}

		parse_str($data, $data_array);

		$billing_first_name = (isset($data_array['billing_first_name'])) ? $data_array['billing_first_name'] : '';

		$billing_last_name = (isset($data_array['billing_last_name'])) ? $data_array['billing_last_name'] : '';
		$billing_company = (isset($data_array['billing_company'])) ? $data_array['billing_company'] : '';
		$billing_address_1 = (isset($data_array['billing_address_1'])) ? $data_array['billing_address_1'] : '';
		$billing_address_2 = (isset($data_array['billing_address_2'])) ? $data_array['billing_address_2'] : '';
		$billing_city = (isset($data_array['billing_city'])) ? $data_array['billing_city'] : '';
		$billing_state = (isset($data_array['billing_state'])) ? $data_array['billing_state'] : '';
		$billing_zip = (isset($data_array['billing_zip'])) ? $data_array['billing_zip'] : '';
		$billing_phone = (isset($data_array['billing_phone'])) ? $data_array['billing_phone'] : '';
		$billing_email = (isset($data_array['billing_email'])) ? $data_array['billing_email'] : 'test@test.com';

		$save_arr = array("billing_first_name"=>$billing_first_name,"billing_last_name"=>$billing_last_name,"billing_company"=>$billing_company,"billing_address_1"=>$billing_address_1,"billing_address_2"=>$billing_address_2,"billing_city"=>$billing_city,"billing_state"=>$billing_state,"billing_zip"=>$billing_zip,"billing_phone"=>$billing_phone,"billing_email"=>$billing_email);


		if(function_exists('get_product')){
			$session = COOKIEVALUE;
		}
		else
		{
			$session = session_id();
		}


		$receipt = new AV8_Cart_Receipt($session);
		$id = $receipt->get_id_from_session($session);
		if($id > 0 && $id != '')
		{
			update_post_meta($id, '_customer_data', $save_arr);
		}

			//FIND current ticket id, if it exists...

	}

	/**
	 * If the user selected "create account" on the checkout page,we send the user id info to the model for saving.
	 *
	 */

	public function save_user_id($user_id)
	{
	if(function_exists('get_product')){
		$session = COOKIEVALUE;
	}
	else
	{
		$session = session_id();
	}

		assert(is_numeric($user_id));
		$post_id = $this->receipt->get_id_from_session($session);
		$this->receipt->save_user_id($user_id, $post_id );
	}
	/**
	 *
	 * Save the order id of the newly created order in the post meta of the cart object
	 */
	public function save_order_id($order_id)
	{

		if(function_exists('get_product')){
			$session = COOKIEVALUE;
		}
		else
		{
			$session = session_id();
		}

		assert($order_id > 0);

			//$customer_id = get_post_meta($order_id, '_customer_user', true);

		$receipt = new AV8_Cart_Receipt($session);
		$id = $receipt->get_id_from_session($session);

		$receipt->save_conversion();

		global $woocommerce; //We need the woo object to get billing info to replace the name fields for Guest Checkouts
		$receipt->save_order_id($order_id, $woocommerce);

	}

	/**
	 * Record page view on the frontend, and perform appropriate action if the user has
	 * and session with a cart associated.
	 */


	}//END CLASS

	//Functions used to compute number of items

	/**
	 * Generate at-a-glance stats for the dashboard widget. Generates both ranged-induced
	 * and lifetime values and returns an array.
	 */
	function av8_woocommerce_cart_numbers($range = false){ //meta_value is the cart type you'd like to count
		global $wpdb;

		$args = array(
			'numberposts'     => -1,
			'offset'          => 0,
			'orderby'         => 'post_date',
			'order'           => 'DESC',
			'post_type'       => 'carts',
			'post_status'     => 'publish',
			'suppress_filters' => FALSE,

			'tax_query' => array(
				array(
					'taxonomy' => 'shop_cart_status',
					'terms' => 'open',
					'field' => 'slug',
					'operator' => 'IN'
				)
			)
		);

		if($range)
			add_filter( 'posts_where','dashboard_stats_where_abandoned_range' );
		else
			add_filter( 'posts_where','dashboard_stats_where_abandoned_lifetime' );
		$abandoned = sizeof(get_posts( $args ));
		if($range)
			remove_filter( 'posts_where','dashboard_stats_where_abandoned_range' );
		else
			remove_filter( 'posts_where','dashboard_stats_where_abandoned_lifetime' );

		$args = array(
			'numberposts'     => -1,
			'offset'          => 0,
			'orderby'         => 'post_date',
			'order'           => 'DESC',
			'post_type'       => 'carts',
			'post_status'     => 'publish',
			'suppress_filters' => FALSE,

				'tax_query' => array(
					array(
						'taxonomy' => 'shop_cart_status',
						'terms' => 'open',
						'field' => 'slug',
						'operator' => 'IN'
					)
				)

			);

		add_filter( 'posts_where','dashboard_stats_where_open' );
		$open = sizeof(get_posts( $args ));
		remove_filter( 'posts_where','dashboard_stats_where_open' );

		$args = array(
			'numberposts'     => -1,
			'offset'          => 0,
			'orderby'         => 'post_date',
			'order'           => 'DESC',
			'post_type'       => 'carts',
			'post_status'     => 'publish',
			'suppress_filters' => FALSE,

			'tax_query' => array(
					array(
						'taxonomy' => 'shop_cart_status',
						'terms' => 'converted',
						'field' => 'slug',
						'operator' => 'IN'
					)
			)

		);

		if($range)
			add_filter( 'posts_where','dashboard_stats_where_converted' );
			$converted = sizeof(get_posts( $args ));
		if($range)
			remove_filter( 'posts_where','dashboard_stats_where_converted' );

		$vals = array("Converted"=>$converted, "Abandoned"=>$abandoned, "Open"=>$open);
		return $vals;
	}

	 /*
	 *  Filter for the range-induced abandoned section on the dashboard
	 */
	function dashboard_stats_where_abandoned_range( $where ) {
		global $woocommerce_cart_reports_options;
		global $offset;
		assert(is_numeric($offset));
		$where .= " AND post_date > '" . date('Y-m-d G:i:s',  gmmktime() +($offset*3600) - ($woocommerce_cart_reports_options['dashboardrange'] * 24 * 60 *60 )) ."' and post_date < '" . date('Y-m-d G:i:s',  gmmktime() +($offset*3600)  - $woocommerce_cart_reports_options['timeout']) . "' ";
		return $where;
	}

	/*
	 *  Filter for the abandoned lifetime fields on the dashboard widget
	 */
	function dashboard_stats_where_abandoned_lifetime( $where ) {
		global $woocommerce_cart_reports_options;
		global $offset;
		assert(is_numeric($offset));
		$where .= " AND post_date < '" . date('Y-m-d G:i:s',  gmmktime() +($offset*3600)  - $woocommerce_cart_reports_options['timeout']) . "' ";
		return $where;
	}
	/*
	 * wp filter for the open filter on the index page
	 */
	function dashboard_stats_where_open( $where ) {
		global $woocommerce_cart_reports_options;
		global $offset;
		assert(is_numeric($offset));
		$where .= " AND post_date > '" . date('Y-m-d G:i:s',  gmmktime() + ($offset*3600) - $woocommerce_cart_reports_options['timeout']) . "' ";
		return $where;
	}

	/**
	 *wp filter for the converted filter on the index page
	 */
	function dashboard_stats_where_converted( $where ) {
		global $woocommerce_cart_reports_options;
		global $offset;
		assert(is_numeric($offset));
		$where .= " AND post_date > '" . date('Y-m-d G:i:s',  gmmktime() + ($offset*3600) - ($woocommerce_cart_reports_options['dashboardrange'] * 60*60 * 24)) . "' ";
		return $where;
	}


$WooCommerce_Cart_Reports = new AV8_Cart_Reports(); //Instantiate!!!

} //ENDCLASS

/**
 * Print out tool tip code, input contains desired text, requires
 */
function av8_tooltip($text, $print = true){
	global $woocommerce;
	$disp = '<img class="help_tip" data-tip="'.$text.'" src="' . $woocommerce->plugin_url() . '/assets/images/help.png" />';
	if($print)
		echo $disp;
	else
		return $disp;
}

function woocommerce_json_search_customers_carts() {

	check_ajax_referer( 'search-customers', 'security' );

	$term = urldecode( stripslashes( strip_tags( $_GET['term'] ) ) );

	if ( empty( $term ) )
		die();

	$default = isset( $_GET['default'] ) ? $_GET['default'] : __('Guest', 'woocommerce');

	$found_customers = array( '' => $default );

	$customers_query = new WP_User_Query( array(
		'fields'			=> 'all',
		'orderby'			=> 'display_name',
		'search'			=> '*' . $term . '*',
		'search_columns'	=> array( 'ID', 'user_login', 'user_email', 'user_nicename' )
	) );

	$customers = $customers_query->get_results();

	if ( $customers ) {
		foreach ( $customers as $customer ) {
			$found_customers[ $customer->ID ] = $customer->display_name . ' (#' . $customer->ID . ' &ndash; ' . $customer->user_email . ')';
		}
	}

	echo json_encode( $found_customers );
	die();
}

//add_action('wp_ajax_woocommerce_json_search_customers', 'woocommerce_json_search_customers_carts');

add_action('init','load_cookie_carts',0);

function load_cookie_carts() {
	define( 'COOKIEVALUE', get_session_cookie_carts() );
}

function get_session_cookie_carts() {
	if ( class_exists( 'WC_Session' ) ) {

		$cookieid = 'wc_session_cookie_' . COOKIEHASH;

		if ( isset( $_COOKIE[ $cookieid ] ) ) {
			list( $customer_id, $session_expiration, $session_expiring, $cookie_hash ) = explode( '||', $_COOKIE[ $cookieid ] );
			return $customer_id;
		}
	}

	return false;
}