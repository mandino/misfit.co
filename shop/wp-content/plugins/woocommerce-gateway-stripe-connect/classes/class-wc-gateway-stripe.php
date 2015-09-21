<?php

/**
 * WC_Gateway_Stripe_Connect class.
 *
 * @extends WC_Payment_Gateway
 */
class WC_Gateway_Stripe_Connect extends WC_Payment_Gateway {

	function __construct() {

		$this->id           = 'stripe-connect';
		$this->method_title = __( 'Stripe Connect', 'wc_stripe_connect' );
		$this->icon         = plugins_url( '/assets/images/cards.png', dirname( __FILE__ ) );
		$this->has_fields   = true;
		$this->api_endpoint = 'https://api.stripe.com/';
		$this->supports     = array(
			'subscriptions',
			'products',
			'subscription_cancellation',
			'subscription_reactivation',
			'subscription_suspension',
			'subscription_amount_changes',
			'subscription_date_changes'
		);

		// Load the form fields
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();

		// Get setting values
		$this->title     = $this->settings['title'];
		$this->description    = $this->settings['description'];
		$this->enabled     = $this->settings['enabled'];
		$this->testmode    = $this->settings['testmode'];
		$this->stripe_checkout   = isset( $this->settings['stripe_checkout'] ) && $this->settings['stripe_checkout'] == 'yes' ? true : false;

		$this->secret_key    = $this->testmode == 'no' ? $this->settings['secret_key'] : $this->settings['test_secret_key'];
		$this->publishable_key  = $this->testmode == 'no' ? $this->settings['publishable_key'] : $this->settings['test_publishable_key'];

		// Hooks
		add_action( 'wp_enqueue_scripts', array( &$this, 'payment_scripts' ) );
		add_action( 'admin_notices', array( &$this, 'checks' ) );
		add_action( 'woocommerce_update_options_payment_gateways', array( &$this, 'process_admin_options' ) );
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * Check if SSL is enabled and notify the user
	 * */
	function checks() {
		global $woocommerce;

		if ( $this->enabled == 'no' )
			return;

		// Version check
		if ( $woocommerce->version < '1.5.8' ) {

			echo '<div class="error"><p>' . __( 'Stripe now uses stripe.js for security and requires WooCommerce 1.5.8. Please update WooCommerce to continue using Stripe.', 'wc_stripe_connect' ) . '</p></div>';

			return;
		}

		// Check required fields
		if ( ! $this->secret_key ) {

			echo '<div class="error"><p>' . sprintf( __( 'Stripe error: Please enter your secret key <a href="%s">here</a>', 'wc_stripe_connect' ), admin_url( 'admin.php?page=woocommerce&tab=payment_gateways&subtab=gateway-stripe' ) ) . '</p></div>';

			return;

		} elseif ( ! $this->publishable_key ) {

			echo '<div class="error"><p>' . sprintf( __( 'Stripe error: Please enter your publishable key <a href="%s">here</a>', 'wc_stripe_connect' ), admin_url( 'admin.php?page=woocommerce&tab=payment_gateways&subtab=gateway-stripe' ) ) . '</p></div>';

			return;
		}

		// Simple check for duplicate keys
		if ( $this->secret_key == $this->publishable_key ) {

			echo '<div class="error"><p>' . sprintf( __( 'Stripe error: Your secret and publishable keys match. Please check and re-enter.', 'wc_stripe_connect' ), admin_url( 'admin.php?page=woocommerce&tab=payment_gateways&subtab=gateway-stripe' ) ) . '</p></div>';

			return;
		}

		// Show message if enabled and FORCE SSL is disabled and WordpressHTTPS plugin is not detected
		if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'no' && ! class_exists( 'WordPressHTTPS' ) ) {

			echo '<div class="error"><p>' . sprintf( __( 'Stripe is enabled, but the <a href="%s">force SSL option</a> is disabled; your checkout may not be secure! Please enable SSL and ensure your server has a valid SSL certificate - Stripe will only work in test mode.', 'wc_stripe_connect' ), admin_url( 'admin.php?page=woocommerce' ) ) . '</p></div>';

		}
	}

	/**
	 * Check if this gateway is enabled and available in the user's country
	 */
	function is_available() {
		global $woocommerce;

		if ( $this->enabled == "yes" ) {

			if ( $woocommerce->version < '1.5.8' )
				return false;

			if ( ! is_ssl() && $this->testmode != 'yes' )
				return false;

			// Currency check
			if ( ! in_array( get_option( 'woocommerce_currency' ), array( 'USD', 'CAD', 'GBP' ) ) )
				return false;

			// Required fields check
			if ( ! $this->secret_key ) return false;
			if ( ! $this->publishable_key ) return false;

			return true;
		}

		return false;
	}

	/**
	 * Initialise Gateway Settings Form Fields
	 */
	function init_form_fields() {

		$this->form_fields = array(
			'enabled' => array(
				'title' => __( 'Enable/Disable', 'wc_stripe_connect' ),
				'label' => __( 'Enable Stripe', 'wc_stripe_connect' ),
				'type' => 'checkbox',
				'description' => '',
				'default' => 'no'
			),
			'title' => array(
				'title' => __( 'Title', 'wc_stripe_connect' ),
				'type' => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'wc_stripe_connect' ),
				'default' => __( 'Credit card (Stripe)', 'wc_stripe_connect' )
			),
			'description' => array(
				'title' => __( 'Description', 'wc_stripe_connect' ),
				'type' => 'textarea',
				'description' => __( 'This controls the description which the user sees during checkout.', 'wc_stripe_connect' ),
				'default' => 'Pay with your credit card via Stripe.'
			),
			'testmode' => array(
				'title' => __( 'Test mode', 'wc_stripe_connect' ),
				'label' => __( 'Enable Test Mode', 'wc_stripe_connect' ),
				'type' => 'checkbox',
				'description' => __( 'Place the payment gateway in test mode using test API keys.', 'wc_stripe_connect' ),
				'default' => 'yes'
			),
			'stripe_checkout' => array(
				'title' => __( 'Stripe Checkout', 'wc_stripe_connect' ),
				'label' => __( 'Enable Stripe Checkout', 'wc_stripe_connect' ),
				'type' => 'checkbox',
				'description' => __( 'If enabled, this option shows a "pay" button and modal credit card form on the checkout, instead of credit card fields directly on the page.', 'wc_stripe_connect' ),
				'default' => 'no'
			),
			'live-credentials-title' => array(
				'title' => __( 'Live credentials', 'wc_stripe_connect' ),
				'type' => 'title',
			),
			'secret_key' => array(
				'title' => __( 'Secret Key', 'wc_stripe_connect' ),
				'type' => 'text',
				'description' => __( 'Get your API keys from your stripe account.', 'wc_stripe_connect' ),
				'default' => ''
			),
			'publishable_key' => array(
				'title' => __( 'Publishable Key', 'wc_stripe_connect' ),
				'type' => 'text',
				'description' => __( 'Get your API keys from your stripe account.', 'wc_stripe_connect' ),
				'default' => ''
			),
			'client_id' => array(
				'title' => __( 'Client ID', 'wc_stripe_connect' ),
				'type' => 'text',
				'description' => __( 'Get your client ID from your stripe account, the Apps menu.', 'wc_stripe_connect' ),
				'default' => ''
			),
			'test-credentials-title' => array(
				'title' => __( 'Test credentials', 'wc_stripe_connect' ),
				'type' => 'title',
			),
			'test_secret_key' => array(
				'title' => __( 'Test Secret Key', 'wc_stripe_connect' ),
				'type' => 'text',
				'description' => __( 'Get your API keys from your stripe account.', 'wc_stripe_connect' ),
				'default' => ''
			),
			'test_publishable_key' => array(
				'title' => __( 'Test Publishable Key', 'wc_stripe_connect' ),
				'type' => 'text',
				'description' => __( 'Get your API keys from your stripe account.', 'wc_stripe_connect' ),
				'default' => ''
			),
			'test_client_id' => array(
				'title' => __( 'Test Client ID', 'wc_stripe_connect' ),
				'type' => 'text',
				'description' => __( 'Get your client ID from your stripe account, the Apps menu.', 'wc_stripe_connect' ),
				'default' => ''
			),
		);
	}

	/**
	 * Admin Panel Options
	 * - Options for bits like 'title' and availability on a country-by-country basis
	 */
	function admin_options() {
?>
    	<h3><?php _e( 'Stripe Connect', 'wc_stripe_connect' ); ?></h3>
    	<p><?php _e( 'Stripe works by adding credit card fields on the checkout and then sending the details to Stripe for verification.', 'wc_stripe_connect' ); ?></p>
    	<?php
		if ( in_array( get_option( 'woocommerce_currency' ), array( 'USD', 'CAD', 'GBP' ) ) ) {
?>
    		<table class="form-table">
	    		<?php $this->generate_settings_html(); ?>
			</table><!--/.form-table-->
    		<?php
		} else {
?>
			<div class="inline error"><p><strong><?php _e( 'Gateway Disabled', 'wc_stripe_connect' ); ?></strong> <?php echo __( 'Choose US Dollars as your store currency to enable Stripe Connect.', 'wc_stripe_connect' ); ?></p></div>
		<?php
		} // End check currency
	}

	/**
	 * Payment form on checkout page
	 */
	function payment_fields() {
		global $woocommerce;
?>
		<fieldset>

			<?php if ( $this->description ) : ?>
				<p><?php echo $this->description; ?>
					<?php if ( $this->testmode == 'yes' ) : ?>
						<?php _e( 'TEST MODE ENABLED. In test mode, you can use the card number 4242424242424242 with any CVC and a valid expiration date.', 'wc_stripe_connect' ); ?>
					<?php endif; ?></p>
			<?php endif; ?>

			<?php if ( is_user_logged_in() && ( $credit_cards = get_user_meta( get_current_user_id(), '_stripe_customer_id', false ) ) ) : ?>
				<p class="form-row form-row-wide">

					<a class="button" style="float:right;" href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>#saved-cards"><?php _e( 'Manage cards', 'wc_stripe_connect' ); ?></a>

					<?php foreach ( $credit_cards as $i => $credit_card ) : ?>
						<input type="radio" id="stripe_card_<?php echo $i; ?>" name="stripe_customer_id" style="width:auto;" value="<?php echo $i; ?>" />
						<label style="display:inline;" for="stripe_card_<?php echo $i; ?>"><?php _e( 'Card ending with', 'wc_stripe_connect' ); ?> <?php echo $credit_card['active_card']; ?> (<?php echo $credit_card['exp_month'] . '/' . $credit_card['exp_year'] ?>)</label><br />
					<?php endforeach; ?>

					<input type="radio" id="new" name="stripe_customer_id" style="width:auto;" <?php checked( 1, 1 ) ?> value="new" /> <label style="display:inline;" for="new"><?php _e( 'Use a new credit card', 'wc_stripe_connect' ); ?></label>

				</p>
				<div class="clear"></div>
			<?php endif; ?>

			<div class="stripe_new_card">

				<?php if ( $this->stripe_checkout ) : ?>

					<a id="stripe_payment_button" class="button" href="#"
						data-description=""
						data-amount="<?php echo $woocommerce->cart->total * 100; ?>"
						data-name="<?php echo sprintf( __( '%s', 'woocommerce' ), get_bloginfo( 'name' ) ); ?>"
						data-label="<?php _e( 'Confirm and Pay', 'woocommerce' ); ?>"
						data-currency="<?php echo strtolower( get_woocommerce_currency() ); ?>"
						><?php _e( 'Enter payment details', 'woocommerce' ); ?></a>

				<?php else : ?>

					<p class="form-row form-row-wide">
						<label for="stripe_cart_number"><?php _e( "Credit Card number", 'wc_stripe_connect' ) ?> <span class="required">*</span></label>
						<input type="text" autocomplete="off" class="input-text card-number" />
					</p>
					<div class="clear"></div>
					<p class="form-row form-row-first">
						<label for="cc-expire-month"><?php _e( "Expiration date", 'wc_stripe_connect' ) ?> <span class="required">*</span></label>
						<select id="cc-expire-month" class="woocommerce-select woocommerce-cc-month card-expiry-month">
							<option value=""><?php _e( 'Month', 'wc_stripe_connect' ) ?></option>
							<?php
			$months = array();
		for ( $i = 1; $i <= 12; $i++ ) :
			$timestamp = mktime( 0, 0, 0, $i, 1 );
		$months[date( 'n', $timestamp )] = date( 'F', $timestamp );
		endfor;
		foreach ( $months as $num => $name ) printf( '<option value="%u">%s</option>', $num, $name );
?>
						</select>
						<select id="cc-expire-year" class="woocommerce-select woocommerce-cc-year card-expiry-year">
							<option value=""><?php _e( 'Year', 'wc_stripe_connect' ) ?></option>
							<?php
		for ( $i = date( 'y' ); $i <= date( 'y' ) + 15; $i++ ) printf( '<option value="20%u">20%u</option>', $i, $i );
?>
						</select>
					</p>
					<p class="form-row form-row-last">
						<label for="stripe_card_csc"><?php _e( "Card security code", 'wc_stripe_connect' ) ?> <span class="required">*</span></label>
						<input type="text" id="stripe_card_csc" maxlength="4" style="width:4em;" autocomplete="off" class="input-text card-cvc" />
						<span class="help stripe_card_csc_description"></span>
					</p>
					<div class="clear"></div>

				<?php endif; ?>

			</div>

		</fieldset>
		<?php
	}

	/**
	 * payment_scripts function.
	 *
	 * Outputs scripts used for stripe payment
	 *
	 * @access public
	 */
	function payment_scripts() {

		if ( ! is_checkout() )
			return;

		if ( $this->stripe_checkout ) {

			wp_enqueue_script( 'stripe', 'https://checkout.stripe.com/v2/checkout.js', '', '2.0', true );
			wp_enqueue_script( 'woocommerce_stripe', plugins_url( 'assets/js/stripe_checkout.js', dirname( __FILE__ ) ), array( 'stripe' ), '2.0', true );

		} else {

			wp_enqueue_script( 'stripe', 'https://js.stripe.com/v1/', '', '1.0', true );
			wp_enqueue_script( 'woocommerce_stripe', plugins_url( 'assets/js/stripe.js', dirname( __FILE__ ) ), array( 'stripe' ), '1.0', true );

		}

		$stripe_params = array(
			'key' => $this->publishable_key
		);

		// If we're on the pay page we need to pass stripe.js the address of the order.
		if ( !empty( $_GET['order_id'] ) && is_page( woocommerce_get_page_id( 'pay' ) ) ) {
			$order_key = urldecode( $_GET['order'] );
			$order_id = (int) $_GET['order_id'];
			$order = new WC_Order( $order_id );

			if ( $order->id == $order_id && $order->order_key == $order_key ) {
				$stripe_params['billing_first_name'] = $order->billing_first_name;
				$stripe_params['billing_last_name']  = $order->billing_last_name;
				$stripe_params['billing_address_1']  = $order->billing_address_1;
				$stripe_params['billing_address_2']  = $order->billing_address_2;
				$stripe_params['billing_state']      = $order->billing_state;
				$stripe_params['billing_city']       = $order->billing_city;
				$stripe_params['billing_postcode']   = $order->billing_postcode;
				$stripe_params['billing_country']    = $order->billing_country;
			}
		}

		wp_localize_script( 'woocommerce_stripe', 'wc_stripe_connect_params', $stripe_params );
	}

	/**
	 * Process the payment
	 */
	function process_payment( $order_id ) {
		global $woocommerce;

		$customer_id  = 0;
		$order        = new WC_Order( $order_id );
		$stripe_token = isset( $_POST['stripe_token'] ) ? woocommerce_clean( $_POST['stripe_token'] ) : '';

		try {
			require_once 'lib/Stripe.php';
			Stripe::setApiKey( $this->secret_key );

			// Check if paying via customer ID
			if ( isset( $_POST['stripe_customer_id'] ) && $_POST['stripe_customer_id'] !== 'new' && is_user_logged_in() ) {
				$customer_ids = get_user_meta( get_current_user_id(), '_stripe_customer_id', false );

				if ( isset( $customer_ids[ $_POST['stripe_customer_id'] ]['customer_id'] ) )
					$customer_id = $customer_ids[ $_POST['stripe_customer_id'] ]['customer_id'];
				else
					throw new Exception( __( 'Invalid card.', 'wc_stripe_connect' ) );
			}

			// Else, Check token
			else if ( empty( $stripe_token ) ) {
					throw new Exception( __( 'Please make sure your card details have been entered correctly and that your browser supports JavaScript.', 'wc_stripe_connect' ) );
				}

			// Check amount
			if ( $order->order_total * 100 < 50 ) {
				throw new Exception( __( 'Minimum order total is 0.50', 'wc_stripe_connect' ) );
			}

			// Save token if logged in
			if ( ! $customer_id && $stripe_token ) {
				$customer_id = $this->add_customer( $order, $stripe_token );
			}

			// Static data
			$order_data = array(
				"currency"    => strtolower( get_woocommerce_currency() ),
				"description" => sprintf( __( '%s - Order %s', 'wp_stripe' ), esc_html( get_bloginfo( 'name' ) ), $order->get_order_number() ),
			);

			$charge_ids = array();

			// Process the vendor charges first
			$receivers = PV_Vendors::get_vendor_dues_from_order( $order, false );


			foreach ( $receivers as $vendor_id => $products ) {
				if ( $vendor_id == 1 ) continue;

				$access_token = get_user_meta( $vendor_id, '_stripe_connect_access_key', true );
				if ( empty( $access_token ) ) continue;

				$admin_fee = 0;
				$total = 0;

				foreach ( $products as $product_id => $product ) {
					$admin_fee = $receivers[1][$product_id]['total'];
					$total += ( $product['total'] + $admin_fee );
					unset( $receivers[1][$product_id], $receivers[$vendor_id][$product_id] );
				}

				$token = Stripe_Token::create( array( 'customer' => $customer_id ), $access_token );

				$order_data['amount'] = round( $total, 2 ) * 100;
				$order_data['application_fee'] = round( $admin_fee, 2 ) * 100;
				$order_data['card'] = !empty( $token->id ) ? $token->id : $stripe_token;

				$charge = Stripe_Charge::create( $order_data, $access_token );
				$charge_ids[] = $charge->id;

			}

			// Now process any remaining admin charges
			$total = 0;
			foreach ( $receivers as $vendor_id => $products ) {
				foreach ( $products as $product_id => $product ) {
					$total += $product['total'];
					unset( $receivers[$vendor_id][$product_id] );
				}
			}

			unset( $order_data['card'], $order_data['customer'], $order_data['application_fee'] );
			$order_data['amount'] = round( $total, 2 ) * 100;

			if ( ! empty( $order_data['amount'] ) ) {

				if ( $customer_id ) {
					$order_data['customer'] = $customer_id;
				} else {
					$order_data['card'] = $stripe_token;
				}

				$charge = Stripe_Charge::create( $order_data );
				$charge_ids[] = $charge->id;
			}

			$receivers = array_filter( $receivers );

		} catch( Exception $e ) {
			$woocommerce->add_error( __( 'Error: ', 'wc_stripe_connect' ) . $e->getMessage() );
			return;
		}

		// Add order note
		$order->add_order_note( sprintf( __( 'Stripe payment completed (Charge ID: %s)', 'wc_stripe_connect' ), implode( ', ', $charge_ids ) ) );

		// Payment complete
		$order->payment_complete();

		if ( class_exists( 'PV_Commission' ) ) {
			PV_Commission::set_order_commission_paid( $order_id );
		}

		// Remove cart
		$woocommerce->cart->empty_cart();

		// Return thank you page redirect
		return array(
			'result'  => 'success',
			'redirect' => $this->get_return_url( $order )
		);

	}


	/**
	 * add_customer function.
	 *
	 * @access public
	 * @param mixed   $stripe_token
	 * @return void
	 */
	function add_customer( $order, $stripe_token ) {

		if ( ! $stripe_token ) {
			return;
		}

		require_once 'lib/Stripe.php';
		Stripe::setApiKey( $this->secret_key );

		$customer = Stripe_Customer::create( array(
				'email'       => $order->billing_email,
				'description' => 'Customer: ' . $order->shipping_first_name . ' ' . $order->shipping_last_name,
				"card"        => $stripe_token
			)
		);

		add_user_meta( get_current_user_id(), '_stripe_customer_id', array(
				'customer_id' => $customer->id,
				'active_card' => !empty( $customer->active_card->last4 ) ? $customer->active_card->last4 : '',
				'exp_year'    => !empty( $customer->active_card->exp_year ) ? $customer->active_card->exp_year : '',
				'exp_month'   => !empty( $customer->active_card->exp_month ) ? $customer->active_card->exp_month : '',
			) );

		return $customer->id;
	}

}
