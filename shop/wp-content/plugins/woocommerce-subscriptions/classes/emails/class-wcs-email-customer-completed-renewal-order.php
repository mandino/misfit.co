<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Customer Completed Order Email
 *
 * Order complete emails are sent to the customer when the order is marked complete and usual indicates that the order has been shipped.
 *
 * @class 		WC_Email_Customer_Completed_Order
 * @version		2.0.0
 * @package		WooCommerce/Classes/Emails
 * @author 		WooThemes
 * @extends 	WC_Email
 */
class WCS_Email_Completed_Renewal_Order extends WC_Email_Customer_Completed_Order {

	/**
	 * Constructor
	 */
	function __construct() {

		// Call override values
		$this->id             = 'customer_completed_renewal_order';
		$this->title          = __( 'Completed Renewal Order', 'woocommerce-subscriptions' );
		$this->description    = __( 'Renewal order complete emails are sent to the customer when a subscription renewal order is marked complete and usually indicates that the item for that renewal period has been shipped.', 'woocommerce-subscriptions' );

		$this->heading        = __( 'Your renewal order is complete', 'woocommerce-subscriptions' );
		$this->subject        = __( 'Your {blogname} renewal order from {order_date} is complete', 'woocommerce-subscriptions' );

		$this->template_html  = 'emails/customer-completed-renewal-order.php';
		$this->template_plain = 'emails/plain/customer-completed-renewal-order.php';
		$this->template_base  = plugin_dir_path( WC_Subscriptions::$plugin_file ) . 'templates/';

		// Other settings
		$this->heading_downloadable = $this->get_option( 'heading_downloadable', __( 'Your subscription renewal order is complete - download your files', 'woocommerce-subscriptions' ) );
		$this->subject_downloadable = $this->get_option( 'subject_downloadable', __( 'Your {blogname} subscription renewal order from {order_date} is complete - download your files', 'woocommerce-subscriptions' ) );

		// Triggers for this email
		add_action( 'woocommerce_order_status_completed_renewal_notification', array( $this, 'trigger' ) );

		// We want most of the parent's methods, with none of its properties, so call its parent's constructor
		WC_Email::__construct();
	}

	/**
	 * get_subject function.
	 *
	 * @access public
	 * @return string
	 */
	function get_subject() {
		return apply_filters( 'woocommerce_subscriptions_email_subject_customer_completed_renewal_order', parent::get_subject(), $this->object );
	}

	/**
	 * get_heading function.
	 *
	 * @access public
	 * @return string
	 */
	function get_heading() {
		return apply_filters( 'woocommerce_email_heading_customer_renewal_order', parent::get_heading(), $this->object );
	}

	/**
	 * get_content_html function.
	 *
	 * @access public
	 * @return string
	 */
	function get_content_html() {
		ob_start();
		woocommerce_get_template(
			$this->template_html,
			array(
				'order'         => $this->object,
				'email_heading' => $this->get_heading()
			),
			'',
			$this->template_base
		);
		return ob_get_clean();
	}

	/**
	 * get_content_plain function.
	 *
	 * @access public
	 * @return string
	 */
	function get_content_plain() {
		ob_start();
		woocommerce_get_template(
			$this->template_plain,
			array(
				'order'         => $this->object,
				'email_heading' => $this->get_heading()
			),
			'',
			$this->template_base
		);
		return ob_get_clean();
	}
}