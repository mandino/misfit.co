<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( $order ) : ?>

	<div class="thank_you_header text-center">
	
		<?php if ( $order->has_status( 'failed' ) ) : ?>
    
            <p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>
    
            <p><?php
                if ( is_user_logged_in() )
                    _e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
                else
                    _e( 'Please attempt your purchase again.', 'woocommerce' );
            ?></p>
    
            <p>
                <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
                <?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
                <?php endif; ?>
            </p>
    
        <?php else : ?>
            
            <div class="thank_you_header_text">			
                <div class="row">
                    <div class="xlarge-6 xlarge-centered large-8 large-centered columns">
                        
                        <p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></p>
                    
                    </div><!-- .xlarge-6-->
                </div><!--	.row	-->                
            </div>
			
            <div class="clear"></div>
    
        <?php endif; ?>
    
    </div><!-- .thank_you_header-->
    
    <div class="row">
        <div class="xlarge-6 xlarge-centered large-8 large-centered columns">
			
			<div class="signup-btn">
				<a target="_blank" href="http://eepurl.com/bQiS5L">Sign up for our mailing list</a>
			</div>
			
			<div class="stay_awhile">
				<img src="<?php bloginfo('url'); ?>/wp-content/uploads/2016/04/misfitpresslogo.jpg" />
				<p>Pssst. Did you know that misfit press has its own blog? Check it out <a target="_blank" href="http://www.misfitpress.co/blog">here</a></p>
			</div>
			
            <div class="thank_you_bank_details">
                <?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
            </div><!-- .thank_you_bank_details-->
            
            
            <?php do_action( 'woocommerce_thankyou', $order->id ); ?>
            
        </div><!-- .medium-10-->
    </div><!--	.row	-->

<?php else : ?>
	<div class="row">
		<div class="medium-10 medium-centered  large-8 large-centered text-center columns">
			<div class="thank_you_header">
				<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>
			</div>
		</div>
	</div>
<?php endif; ?>