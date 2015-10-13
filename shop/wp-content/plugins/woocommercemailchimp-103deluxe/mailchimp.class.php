<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (!class_exists("WC_Integration")) return;

/**
 * Woocommerce and Maiclhimp Integration
 *
 * Places 
 *
 * @class 		WC_Mailchimp_List
 * @extends		WC_Integration
 * @version		1.0.1
 * @author 		WoocommerceMailchimp.com
 */
class WC_Mailchimp_List extends WC_Integration {

    private $vars ='';
    private $headers = null;

    /**
     * Init and hook in the integration.
     *
     * @access public
     * @return void
     */
    public function __construct() {
        global $woocommerce;

        $this->id					= 'mailchimp_list';
        $this->method_title     	= __( 'Mailchimp', 'woocommerce' );
        $this->method_description	= __( 'Mailchimp integration with woocommerce to automatically add users to defined lists. You can set product-specific lists on individual product pages and here you can set your Mailchimp settings and the main newsletter settings.', 'woocommerce' );

        // Define user set variables
        $this->mailchimp_api_key 	= $this->get_option( 'mailchimp_api_key' );
        $this->mailchimp_main_id 	= $this->get_option( 'mailchimp_main_id' );
        $this->mailchimp_process 	= $this->get_option( 'mailchimp_process' );
        $this->mailchimp_main_optin = ($this->get_option( 'mailchimp_main_optin' )=='yes')? true: false;
        $this->mailchimp_enable		= ($this->get_option( 'mailchimp_enable' )=='yes')? true: false;
        $this->mailchimp_goodbye	= ($this->get_option( 'mailchimp_goodbye' )=='yes')? true: false;
        $this->mailchimp_rm_main	= ($this->get_option( 'mailchimp_rm_main' )=='yes')? true: false;
        $this->api                  = new MCAPI($this->mailchimp_api_key);

        //Logs
        // $this->log = $woocommerce->logger();

        // Actions

        add_action( 'woocommerce_update_options_integration_mailchimp_list', array( $this, 'process_admin_options') );

        if($this->mailchimp_process == "created" ){
            add_action( 'woocommerce_thankyou', array( &$this, 'mailchimp_add_email_to_list' ) );
        } else {
            add_action( 'woocommerce_order_status_completed', array( &$this, 'mailchimp_add_email_to_list' ) );
        }


        /***
         * Add metabox to product page
         */

        add_action( 'load-post.php', array( $this, 'mailchimp_box_setup'));
        add_action( 'load-post-new.php', array( $this, 'mailchimp_box_setup'));
        add_action( 'save_post', array( &$this, 'mailchimp_box_save_post'), 10, 2 );
		
		/**
		* Remove from mailchimp list when they cancelled the subscription
		*/
		add_action( 'subscriptions_cancelled_for_order', array( $this, 'remove_subcribe') );
		add_action( 'subscriptions_put_on_hold_for_order', array( $this, 'remove_subcribe') );		
		
		add_action( 'cancelled_subscription', array( $this, 'remove_subcribe_user'), 100, 2 );
		add_action( 'subscription_put_on-hold', array( $this, 'remove_subcribe_user'), 100, 2 );
		
		
		/**
		* Add again when active
		*/
		add_action( 'subscriptions_activated_for_order', array( &$this, 'mailchimp_add_email_to_list' ) );
		add_action( 'activated_subscription', array( $this, 'activated_subcribe_user'), 100, 2 );
		
        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

    }
	
	/**
	* User make a active call, so read order_id and process it
	*/
	function activated_subcribe_user($user_id, $subscription_key){
		$subscription = WC_Subscriptions_Manager::get_users_subscription( $user_id, $subscription_key );
		$this->mailchimp_add_email_to_list($subscription['order_id']);
	}
	
	/**
	* User make a cancelled call, so read order_id and process it
	*/
	function remove_subcribe_user($user_id, $subscription_key){		
		$subscription = WC_Subscriptions_Manager::get_users_subscription( $user_id, $subscription_key );
		$this->remove_subcribe($subscription['order_id']);
		
	}
	
	/**
	* Remove a user from mailchimp list
	*/
	function remove_subcribe($order){
		$order = new WC_Order( $order );		
		$email = $order->billing_email;
		//using API to remove them
		//1. remove from main list
		if (!empty($this->mailchimp_main_id) && $this->mailchimp_rm_main) {
			$this->api->listUnsubscribe( $this->mailchimp_main_id, $email, false, $this->mailchimp_goodbye, $this->mailchimp_goodbye );
			//log error if have any
			if ($this->api->errorCode){            
				$this->log->add( 'mailchimp',"Code=".$this->api->errorCode.":\t".$this->api->errorMessage);
			}
		}
		
		//2. remove from product list
		foreach( $order->get_items() as $order_item ) {

			if ( ! WC_Subscriptions_Order::is_item_subscription( $order, $order_item ) )
				continue;

			$_product  = $order->get_product_from_item( $order_item );
			$product_list_id   = get_post_meta($_product->id, "mailchimp_list_id", true);
			if (!empty($product_list_id)){
				$this->api->listUnsubscribe( $product_list_id, $email , false, $this->mailchimp_goodbye, $this->mailchimp_goodbye );
				//log error if have any
				if ($this->api->errorCode){            
					$this->log->add( 'mailchimp',"Code=".$this->api->errorCode.":\t".$this->api->errorMessage);
				}
			}

		}
	}


    /**
     * Initialise Settings Form Fields
     *
     * @access public
     * @return void
     */
    function init_form_fields() {
        $select_lists = array();
        if (isset($_GET['section']) && $_GET['section']='mailchimp_list'){
            foreach ($this->get_lists() as $list){
                $select_lists[$list['id']] = $list['name'];
            }
        }

        $this->form_fields = array(
            'mailchimp_enable' => array(
                'title' 			=> __( 'Enable Mailchimp List', 'woocommerce' ),
                'label' 			=> __( '', 'woocommerce' ),
                'type' 				=> 'checkbox',
                'checkboxgroup'		=> 'end',
                'default' 			=> 'yes'
            ),
            'mailchimp_process' => array(
                'title' 			=> __( 'Event Occurs', 'woocommerce' ),
                'description' 		=> __( 'When will customer be added to lists?', 'woocommerce' ),
                'type' 				=> 'select',
                'options' 			=> array("completed" => "Order Completed", 'created' => 'Order Created')
            ),
            'mailchimp_api_key' => array(
                'title' 			=> __( 'API Key', 'woocommerce' ),
                'description' 		=> __( 'Log into <a href="https://us2.admin.mailchimp.com/account/api/">your mailchimp account</a> to find your ID.', 'woocommerce' ),
                'type' 				=> 'text',
                'default' 			=> ''
            ),
            'mailchimp_main_id' => array(
                'title' 			=> __( 'Main List', 'woocommerce' ),
                'description' 		=> __( 'All customers will be added to this main list', 'woocommerce' ),
                'type' 				=> 'select',
                'options' 			=> $select_lists
            ),
            'mailchimp_main_optin' => array(
                'title' 			=> __( 'Enable Double Optin for Main List?', 'woocommerce' ),
                'label' 			=> __( '', 'woocommerce' ),
                'type' 				=> 'checkbox',
                'checkboxgroup'		=> 'end',
                'default' 			=> 'no'
            ),
			'mailchimp_goodbye' => array(
                'title' 			=> __( 'Send goodbye when remove them from mailchimp list?', 'woocommerce' ),
                'label' 			=> __( '', 'woocommerce' ),
                'type' 				=> 'checkbox',
                'checkboxgroup'		=> 'end',
                'default' 			=> 'yes'
            ),
			'mailchimp_rm_main' => array(
                'title' 			=> __( 'Remove from main list when they cancelled the subscription?', 'woocommerce' ),
                'label' 			=> __( '', 'woocommerce' ),
                'type' 				=> 'checkbox',
                'checkboxgroup'		=> 'end',
                'default' 			=> 'yes'
            )
        );

    } // End init_form_fields()

    /**
     * Use mailchimp API to add a user to a list
     * @param $list_id
     * @param $email
     * @param bool $optin
     * @param array $userinfo
     */
    function subcribe_list($list_id, $email, $optin=false, $userinfo=array()){

        $this->api->listSubscribe( $list_id, $email, $userinfo, 'html', $optin );

        if ($this->api->errorCode){
            //echo "Unable to load listSubscribe()!\n";
            $this->log->add( 'mailchimp',"Code=".$this->api->errorCode.":\t".$this->api->errorMessage);
        } else {
            //$this->log->add( 'mailchimp',"Subscribed: ".$email." -> ".$list_id);
        }

    }

    /**
     * Use mailchimp API to get available list in account
     * @return mixed
     */
    function get_lists(){
        $result = $this->api->lists();
        //$this->log->add( 'mailchimp',"get list count");
        if ($this->api->errorCode){
            $this->log->add( 'mailchimp',"Code=".$this->api->errorCode.":\t".$this->api->errorMessage);
            return array();
        }
        return $result['data'];
    }

    /**
     * Get user information, add to email list of Mailchimp
     * @param $order_id
     */
    function mailchimp_add_email_to_list($order_id){


        //$this->log->add( 'mailchimp',"Starting with order ".$order_id);
        // Get the order and output tracking code
        if (! $this->mailchimp_enable) return;
        $order = new WC_Order( $order_id );

        $email      =   $order->billing_email;
        $userinfo   =   array(  'FNAME' =>   $order->billing_first_name,
                                'LNAME' =>   $order->billing_last_name
                        );

        //Add user to main list
        $this->subcribe_list($this->mailchimp_main_id, $email, $this->mailchimp_main_optin, $userinfo);

        //Get items in order
        if ( $order->get_items() ) {
            foreach ( $order->get_items() as $item ) {
                $_product  = $order->get_product_from_item( $item );
                $list_id   = get_post_meta($_product->id, "mailchimp_list_id", true);
                $optin     = get_post_meta($_product->id, "mailchimp_optin", true);

                if (!empty($list_id)) $this->subcribe_list($list_id, $email, ($optin)?true:false, $userinfo);
            }
        }


    }

    /**
     * To add a meta box to product add/edit page
     */
    function mailchimp_box_setup(){
        add_meta_box(
            'mailchimp_class',			// Unique ID
            'Mail Chimp Config',		// Title
            array(&$this, 'mailchimp_class_meta_box'), // Callback function
            'product',					// Admin page (or post type)
            'side',						// Context
            'default'					// Priority
        );
    }

    /**
     * Content of meta box
     * @param $post
     */
    function mailchimp_class_meta_box($post){
        // Use nonce for verification
        wp_nonce_field( plugin_basename( __FILE__ ), 'mailchimp_noncename' );

        // The actual fields for data entry
        // Use get_post_meta to retrieve an existing value from the database and use the value for the form
        $mailchimp_list_id  = get_post_meta( $post->ID, 'mailchimp_list_id', true );
        $mailchimp_optin    = get_post_meta( $post->ID, 'mailchimp_optin', true );
        ?>
        <label for="mailchimp_list_id">List:</label>
        <select id="mailchimp_list_id" name="mailchimp_list_id" style="width: 262px;">
            <option value="">No list</option>
            <?php foreach ($this->get_lists() as $list):?>
            <option value="<?php echo $list['id'];?>" <?php if($list['id']==$mailchimp_list_id) echo 'selected="selected"';?>><?php echo $list['name'];?></option>
            <?php endforeach;?>
        </select><br/>
        <label for="mailchimp_optin">Double Optin:</label>
        <select id="mailchimp_optin" name="mailchimp_optin">
            <option value="0" <?php echo ($mailchimp_optin==0)?'selected="selected"':"";?>>Disable</option>
            <option value="1" <?php echo ($mailchimp_optin==1)?'selected="selected"':"";?>>Enable</option>
        </select>
    <?php
    }

    /**
     * Save post with mailchimp_list_id and mailchimp_optin
     * @param $post_id
     * @return mixed
     */
    function mailchimp_box_save_post( $post_id ) {

        // First we need to check if the current user is authorised to do this action.
        //$this->log->add( 'mailchimp',"Save post ".$post_id);
        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) )
                return;
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return;
        }

        // Secondly we need to check if the user intended to change this value.
        if ( ! isset( $_POST['mailchimp_noncename'] ) || ! wp_verify_nonce( $_POST['mailchimp_noncename'], plugin_basename( __FILE__ ) ) )
            return;

        // Thirdly we can save the value to the database
        //sanitize user input
        $mailchimp_list_id = sanitize_text_field( $_POST['mailchimp_list_id'] );
        $mailchimp_optin = sanitize_text_field( $_POST['mailchimp_optin'] );

        // Do something with $mydata
        // either using
        update_post_meta($post_id, 'mailchimp_list_id', $mailchimp_list_id);
        update_post_meta($post_id, 'mailchimp_optin', $mailchimp_optin);
        // or a custom table (see Further Reading section below)
    }

}


/**
 * Add the integration to WooCommerce.
 *
 * @package		WooCommerce/Classes/Integrations
 * @access public
 * @param array $integrations
 * @return array
 */
function mailchimp_list_integration( $integrations ) {
    $integrations[] = 'WC_Mailchimp_List';
    return $integrations;
}

add_filter('woocommerce_integrations', 'mailchimp_list_integration' );
