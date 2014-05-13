<?php
/**
 *
 * 
 */

class AV8_Cart_Reports_Settings {

/**
 *
 * 
 */
public function __construct() {
	$this->settings = array(
					array( 'name' => __( 'Cart Reports Settings', 'woocommerce_cart_reports' ), 'type' => 'title', 'desc' => '', 'id' => 'minmax_quantity_options' ),
					array(  
						'name' 		=> __('Abandoned Cart Timeout (Seconds)', 'wc_min_max_quantity'),
						'desc' 		=> __('Site activity timeout length for cart abandonment, in seconds.', 'wc_min_max_quantity'),
						'id' 		=> 'wc_cart_reports_timeout',
						'type' 		=> 'text'
					),
					array(  
						'name' 		=> __('Dashboard Widget Time Range (Days)', 'wc_min_max_quantity'),
						'desc' 		=> __('Time-range displayed in the middle column of the "Recent Cart Activity" dashboard widget.', 'wc_min_max_quantity'),
						'id' 		=> 'wc_cart_reports_dashboardrange',
						'type' 		=> 'text'
					),
					array(  
						'name' 		=> __('Show Products On The Cart Index Page', 'wc_min_max_quantity'),
						'desc' 		=> __('Displaying cart products may slow down table listing when showing many carts at once.', 'wc_min_max_quantity'),
						'id' 		=> 'wc_cart_reports_productsindex',
						'type' 		=> 'checkbox'
					),
					array(  
						'name' 		=> __('Log Customer IP Address', 'wc_min_max_quantity'),
						'desc' 		=> __('Logged IP addresses are visible in the edit cart view.', 'wc_min_max_quantity'),
						'id' 		=> 'wc_cart_reports_logip',
						'type' 		=> 'checkbox'
					),
					array( 'type' => 'sectionend', 'id' => 'woocommerce_cart_report_settings'),
				);
				
				//Defaults
				add_option('wc_cart_reports_timeout', '1200');
				add_option('wc_cart_reports_dashboardrange', '2');
				add_option('wc_cart_reports_productsindex', 'yes');
				add_option('wc_cart_reports_logip', 'yes');
				
				
				
	if( is_admin() ) {
		add_action('admin_init', array( &$this, 'admin_init' ) );
	}
}

/**
 *
 * 
 */	

public function admin_settings() {
	woocommerce_admin_fields( $this->settings );
}
public function  save_admin_settings(){
	woocommerce_update_options( $this->settings );
}
public function admin_init()
{
	global $pagenow;
	if($pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] =='woocommerce_cart_reports');

		add_action('woocommerce_settings_general_options_after', array(&$this, 'admin_settings'));
		add_action('woocommerce_update_options_general', array(&$this, 'save_admin_settings'));
	} // function
/**
 * General text description section
 * 
 */


		
	} //END CLASS

?>