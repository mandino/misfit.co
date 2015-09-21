<?php
/**
 * Plugin Name:         WooCommerce - Stripe Connect
 * Plugin URI:          http://shop.mgates.me/?p=1276
 * Description:         Accept payments via Stripe. Made to be used with the <a href="http://shop.mgates.me/shop/wc-marketing/wc-product-vendor/">Product Vendor</a> plugin for WooCommerce.
 * Author:              Matt Gates
 * Author URI:          http://mgates.me
 *
 * Version:             1.0.4
 * Requires at least:   3.2.1
 * Tested up to:        3.5.1
 *
 * Text Domain:         wc_stripe_connect
 *
 * @category            Payment Gateways
 * @copyright           Copyright © 2013 Matt Gates.
 * @author              Matt Gates
 * @package             WooCommerce
 */

/*
	Adapted from Stripe gateway by WooThemes

	Copyright: © 2009-2011 WooThemes.
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Required functions
 */
if ( ! class_exists( 'MGates_Plugin_Updater' ) ) require_once 'classes/mg-includes/mg-functions.php';
if ( is_admin() ) new MGates_Plugin_Updater( __FILE__, 'e9bc7350ef3120347b1dc7a8c295d4bd' );

add_action( 'plugins_loaded', 'woocommerce_stripe_connect_init', 0 );

function woocommerce_stripe_connect_init() {

	if ( ! class_exists( 'WC_Payment_Gateway' ) )
		return;

	if ( ! class_exists( 'Product_Vendor' ) )
		return;

	load_plugin_textdomain( 'wc_stripe_connect', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	include_once 'classes/class-wc-gateway-stripe.php';

	if ( class_exists( 'WC_Subscriptions_Order' ) )
		include_once 'classes/class-wc-gateway-stripe-subscriptions.php';

	/**
	 * account_cc function.
	 *
	 * @access public
	 * @return void
	 */
	function woocommerce_stripe_saved_cards() {
		$credit_cards = get_user_meta( get_current_user_id(), '_stripe_customer_id', false );

		if ( ! $credit_cards )
			return;

		if ( isset( $_POST['delete_card'] ) && wp_verify_nonce( $_POST['_wpnonce'], "stripe_del_card" ) ) {
			$credit_card = $credit_cards[ (int) $_POST['delete_card'] ];
			delete_user_meta( get_current_user_id(), '_stripe_customer_id', $credit_card );
		}

		$credit_cards = get_user_meta( get_current_user_id(), '_stripe_customer_id', false );

		if ( ! $credit_cards )
			return;
?>
			<h2 id="saved-cards" style="margin-top:40px;"><?php _e( 'Saved cards', 'wc_stripe_connect' ); ?></h2>
			<table class="shop_table">
				<thead>
					<tr>
						<th><?php _e( 'Card ending in...', 'wc_stripe_connect' ); ?></th>
						<th><?php _e( 'Expires', 'wc_stripe_connect' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $credit_cards as $i => $credit_card ) : ?>
					<tr>
                        <td><?php esc_html_e( $credit_card['active_card'] ); ?></td>
                        <td><?php echo esc_html( $credit_card['exp_month'] ) . '/' . esc_html( $credit_card['exp_year'] ); ?></td>
						<td>
                            <form action="#saved-cards" method="POST">
                                <?php wp_nonce_field ( 'stripe_del_card' ); ?>
                                <input type="hidden" name="delete_card" value="<?php esc_attr( $i ); ?>">
                                <input type="submit" value="<?php _e( 'Delete card', 'wc_stripe_connect' ); ?>">
                            </form>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php
	}

	add_action( 'woocommerce_after_my_account', 'woocommerce_stripe_saved_cards' );

	function woocommerce_stripe_connect_user() {

		$settings = get_option('woocommerce_stripe-connect_settings');

		if ( !$settings ) return;
		$client_id  = $settings['testmode'] == 'yes' ? $settings['test_client_id'] : $settings['client_id'];
		$secret_key = $settings['testmode'] == 'yes' ? $settings['test_secret_key'] : $settings['secret_key'];

		?><div class="pv_stripe_connect_container"><b><?php _e( 'Connect with Stripe', 'wc_stripe_connect' ); ?></b><br><?php

		$key = get_user_meta( get_current_user_id(), '_stripe_connect_access_key', true );
		if ( empty( $key ) ) {

			_e( 'Your account is not yet connected with Stripe.', 'wc_stripe_connect' );

			require_once 'classes/lib/oauth/OAuth2Exception.php';
			require_once 'classes/lib/oauth/OAuth2Client.php';
			require_once 'classes/lib/StripeOAuth.class.php';

			// redirect to proper application OAuth url
			$oauth = ( new StripeOAuth( $client_id, $secret_key ) );
			$url = $oauth->getAuthorizeUri();

?>
			</br><a class="clear" href="<?php echo $url; ?>" target="_TOP">
				<img src="<?php echo plugins_url( '/assets/images/blue.png', __FILE__ ); ?>" width="190" height="33" data-hires="true">
			</a>
<?php
		} else {
			_e( 'Your account is already connected with Stripe.', 'wc_stripe_connect' );
			echo '<br/>';
			echo '<a href="?disconnect_stripe_connect=true">' . __('Click here to disconnect.', 'wc_stripe_connect') . '</a>';
		}
		?></p></div><?php
	}

	add_action( 'wc_product_vendor_settings_after_paypal', 'woocommerce_stripe_connect_user' );

	function stripe_check_connect() {
		global $woocommerce;

		if ( !empty($_GET['disconnect_stripe_connect'] ) ) {
			update_user_meta( get_current_user_id(), '_stripe_connect_access_key', '' );
			$woocommerce->add_message(__('Success! Your account has been disconnected with Stripe.', 'wc_stripe_connect'));
			wp_redirect( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) );
			exit;
		}

		if ( empty( $_GET['scope'] ) && empty( $_GET['code'] ) ) return;

		$settings   = get_option('woocommerce_stripe-connect_settings');
		$client_id  = $settings['testmode'] == 'yes' ? $settings['test_client_id'] : $settings['client_id'];
		$secret_key = $settings['testmode'] == 'yes' ? $settings['test_secret_key'] : $settings['secret_key'];

		require_once 'classes/lib/oauth/OAuth2Exception.php';
		require_once 'classes/lib/oauth/OAuth2Client.php';
		require_once 'classes/lib/StripeOAuth.class.php';

		// from the callback, after a person has linked their Stripe account with your Stripe application
		$oauth = ( new StripeOAuth( $client_id, $secret_key ) );
		$token = $oauth->getAccessToken( $_GET['code'] );
		$key = $oauth->getPublishableKey( $_GET['code'] );

		update_user_meta( get_current_user_id(), '_stripe_connect_access_key', $token );

		$woocommerce->add_message(__('Success! Your account has been connected with Stripe.', 'wc_stripe_connect'));

		wp_redirect( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) );
		exit;
	}

	add_action( 'init', 'stripe_check_connect' );

	/**
	 * Add the Gateway to WooCommerce
	 * */
	function add_stripe_gateway( $methods ) {
		if ( class_exists( 'WC_Subscriptions_Order' ) )
			$methods[] = 'WC_Gateway_Stripe_Connect_Subscriptions';
		else
			$methods[] = 'WC_Gateway_Stripe_Connect';
		return $methods;
	}

	add_filter( 'woocommerce_payment_gateways', 'add_stripe_gateway' );
}
