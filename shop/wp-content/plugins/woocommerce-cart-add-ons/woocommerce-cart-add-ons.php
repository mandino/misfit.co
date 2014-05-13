<?php
/*
Plugin Name: WooCommerce Cart Add-Ons
Plugin URI: http://woothemes.com/woocommerce
Description: Adds the ability to define and display any product or variation based upon the products added to the cart by the user. Use widgets to display these recommendations in the sidebar, use <?php if (function_exists('sfn_display_cart_addons')) sfn_display_cart_addons(); ?> to show these recommendation anywhere in your theme, or select [display-addons] shortcode.
Version: 1.5.1
Author: 75nineteen Media
Author URI: http://www.75nineteen.com/woocommerce/shopping-cart-upsells

Copyright: © 2013 75nineteen Media.
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Localisation
 **/
load_plugin_textdomain( 'sfn_cart_addons', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), '3a8ef25334396206f5da4cf208adeda3', '18717' );

class SFN_Cart_Addons {

    public function __construct() {
        // activation
        register_activation_hook(__FILE__, array(&$this, 'activate'));

        require 'widget.php';
        add_action( 'widgets_init', create_function( '', 'register_widget( "cart_addons_widget" );' ) );

        // menu
        add_action('admin_menu', array(&$this, 'menu'), 20);

        add_filter('woocommerce_screen_ids', array($this, 'register_screen_id') );

        // help format variations
        add_filter('post_class', array($this, 'post_class'));
        add_filter('the_title', array($this, 'the_title'), 10, 2);
        add_filter('the_permalink', array($this, 'the_permalink'));

        // settings styles and scripts
        add_action( 'admin_enqueue_scripts', array(&$this, 'settings_scripts'));
        add_action( 'admin_post_sfn_cart_addons_update_settings', array(&$this, 'update_settings'));

        // cart page
        add_action('woocommerce_after_cart_table', array(&$this, 'cart_display_addons'), 20);

        // shortcode
        add_shortcode('display-addons', array(&$this, 'sc_display_addons'));
    }

    public function activate() {
        $settings = get_option( 'sfn_cart_addons', false );

        if ( !$settings ) {
            $settings = array(
                'header_title'      => __('Product Add-ons', 'sfn_cart_addons'),
                'default_addons'    => array()
            );

            update_option( 'sfn_cart_addons', $settings );
        }

        if ( ! get_option('sfn_cart_addons_products', false) ) {
            update_option( 'sfn_cart_addons_products', array() );
        }

        if ( ! get_option('sfn_cart_addons_categories', false) ) {
            update_option( 'sfn_cart_addons_categories', array() );
        }
    }

    public function menu() {
        add_submenu_page('woocommerce', __('Cart Add-Ons', 'sfn_cart_addons'),  __('Cart Add-Ons', 'sfn_cart_addons') , 'manage_woocommerce', 'sfn-cart-addons', array(&$this, 'settings'));
    }

    public function register_screen_id( $screens ) {
        $screens[] = 'woocommerce_page_sfn-cart-addons';

        return $screens;
    }

    public function settings_scripts() {
        global $woocommerce;

        if ( isset($_GET['page']) && $_GET['page'] == 'sfn-cart-addons' ) {
            wp_enqueue_style('sfn-cart-addons', plugins_url('settings.css', __FILE__));

            if ( !function_exists('wc_add_notice') ) {
                woocommerce_admin_scripts();

                wp_enqueue_script( 'woocommerce_admin' );
                wp_enqueue_script('farbtastic');
                wp_enqueue_script( 'ajax-chosen' );
                wp_enqueue_script( 'chosen' );

                wp_enqueue_style('chosen', plugins_url() .'/woocommerce/assets/css/chosen.css');
            }

            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'jquery-ui-core', null, array('jquery') );

            ?>
            <style type="text/css">
            .chzn-choices li.search-field .default {
                width: auto !important;
            }

            .chzn-container-multi .chzn-choices .search-field input { height: auto !important; }
            </style>
            <?php

            wp_enqueue_style( 'woocommerce_admin_styles', $woocommerce->plugin_url() . '/assets/css/admin.css' );
            wp_enqueue_style( 'jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/base/jquery-ui.css' );
        }
    }

    public function settings() {
        include dirname(__FILE__) .'/settings.php';
    }

    public function update_settings() {
        global $wpdb, $woocommerce;

        $_POST = array_map('stripslashes_deep', $_POST);

        $settings   = get_option('sfn_cart_addons', array());
        $default    = array();

        if ( isset($_POST['header_title']) ) {
            $settings['header_title'] = $_POST['header_title'];
        }

        if ( isset($_POST['upsell_number']) ) {
            $settings['upsell_number'] = (int)$_POST['upsell_number'];
        }

        if ( isset($_POST['default_products']) && is_array($_POST['default_products']) ) {
            if ( !empty($_POST['default_products']) ) {
                foreach ( $_POST['default_products'] as $product_id ) {
                    $default[] = $product_id;
                }
            }
        }
        $settings['default_addons'] = $default;
        update_option( 'sfn_cart_addons', $settings );

        // delete all entries
        $product_addons     = array();
        $category_addons    = array();

        if ( isset($_POST['category']) && is_array($_POST['category']) ) {
            foreach ( $_POST['category_priorities'] as $idx => $key ) {
                $category_id = $_POST['category'][$key];
                // make sure there are products selected
                if ( !empty($_POST['category_products'][$key]) ) {
                    // insert
                    $addon = array(
                        'category_id'   => $category_id,
                        'priority'      => $idx+1,
                        'products'      => array()
                    );

                    foreach ( $_POST['category_products'][$key] as $product_id ) {
                        $addon['products'][] = $product_id;
                    }

                    $category_addons[] = $addon;
                }
            }
        }

        if ( isset($_POST['product']) && is_array($_POST['product']) ) {
            foreach ( $_POST['product_priorities'] as $idx => $key ) {
                $product_id = $_POST['product'][$key];
                // make sure there are products selected
                if ( !empty($_POST['product_products'][$key]) ) {
                    // insert
                    $addon = array(
                        'product_id'    => $product_id,
                        'priority'      => $key+1,
                        'products'      => array()
                    );

                    foreach ( $_POST['product_products'][$key] as $product_id ) {
                        $addon['products'][] = $product_id;
                    }

                    $product_addons[] = $addon;
                }
            }
        }

        $tmp = array();
        foreach ($category_addons as $key => $row) {
            $tmp[$key]  = $row['priority'];
        }
        array_multisort($tmp, SORT_ASC, $category_addons);

        $tmp = array();
        foreach ($product_addons as $key => $row) {
            $tmp[$key]  = $row['priority'];
        }
        array_multisort($tmp, SORT_ASC, $product_addons);

        update_option( 'sfn_cart_addons_categories', $category_addons );
        update_option( 'sfn_cart_addons_products', $product_addons );

        wp_redirect( 'admin.php?page=sfn-cart-addons&updated=1' );
        exit;
    }

    public function cart_display_addons() {
        $this->display_addons(null, 'loop', 0, false);
    }

    public function display_addons( $length = null, $display_mode = 'loop', $add_to_cart = 0, $return = true ) {
        global $wpdb, $woocommerce;

        $add_to_cart    = (bool)$add_to_cart;
        $settings       = get_option( 'sfn_cart_addons' );
        $addon          = false;
        $args           = false;
        $addon_ids      = array();
        $contents       = $woocommerce->cart->cart_contents;

        if (! is_null($length) && !empty($length) ) {
            $max = $length;
        } else {
            $max = (isset($settings['upsell_number'])) ? (int)$settings['upsell_number'] : false;
        }

        if ( empty($contents) ) {
            return;
        }

        // extract all the product ids from the cart
        $products_in_cart = array();

        foreach ( $contents as $product ) {
            $products_in_cart[] = (isset($product['variation_id']) && $product['variation_id'] > 0) ? $product['variation_id'] : $product['product_id'];
        }

        // search for product matches
        $product_addons = get_option( 'sfn_cart_addons_products', array() );

        foreach ( $product_addons as $addons ) {
            if (in_array($addons['product_id'], $products_in_cart)) {
                foreach ( $addons['products'] as $pid ) {
                    if ( !in_array($pid, $addon_ids) && ($max !== false && count($addon_ids) < $max) ) {
                        $addon_ids[] = $pid;
                    }
                }
            }
        }

        // search for category matches
        $all_categories = array();

        foreach ( $products_in_cart as $product_id ) {
            $terms = wp_get_post_terms( $product_id, 'product_cat' );

            if ( is_array($terms) && count($terms) > 0 ) {
                foreach ( $terms as $term ) {
                    $all_categories[] = $term->term_id;
                }
            }
        }

        $category_addons = get_option( 'sfn_cart_addons_categories', array() );
        foreach ( $category_addons as $addons ) {
            if (in_array($addons['category_id'], $all_categories)) {
                foreach ( $addons['products'] as $pid ) {
                    if ( !in_array($pid, $addon_ids) && ($max !== false && count($addon_ids) < $max) ) {
                        $addon_ids[] = $pid;
                    }
                }
            }
        }

        // default addons
        if ( $max !== false && count($addon_ids) < $max ) {
            $default_addons = $settings['default_addons'];

            foreach ($default_addons as $addon) {
                if ( !in_array($addon, $addon_ids) && ($max !== false && count($addon_ids) < $max) ) {
                    $addon_ids[] = $addon;
                }
            }
        }

        $args = false;
        if ( !empty($addon_ids) ) {
            // remove the products that are already in the cart

            foreach ( $addon_ids as $idx => $prod_id ) {
                if ( in_array($prod_id, $products_in_cart) ) {
                    unset($addon_ids[$idx]);
                }
            }

            if (! empty($addon_ids) ) {
                $args = array( 'post_type' => array('product', 'product_variation'), 'post__in' => $addon_ids );
            } else {
                $args = false;
            }
        }

        // no addons to display!
        if ($args === false) return;

        $loop = new WP_Query( $args );

        // output buffering, we need to return the output
        ob_start();

        if ($display_mode == 'loop') {
            do_action('woocommerce_before_shop_loop');

            ?>
            <div class="sfn-cart-addons">
                <h2><?php echo esc_html($settings['header_title']); ?></h2>
                <ul class="products sfn-cart-addons">
                    <?php
                    do_action('woocommerce_before_shop_loop_products');
                    $x = 0;

                    if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); global $product;
                        $product = sfn_get_product(get_the_ID());
                        if ( !$product->is_visible() ) continue;
                        woocommerce_get_template('content-product.php', array('product' => $product));
                    endwhile; endif;
                    ?>

                </ul>

                <div style="clear:both; height:1px;"></div>
            </div>
            <?php
            do_action('woocommerce_after_shop_loop');
        } elseif ($display_mode == 'images') {
            ?>
            <div class="sfn-cart-addons-images">
                <ul class="products sfn-cart-addons">
                    <?php
                    $x = 0;
                    if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); global $product;
                        $product = sfn_get_product(get_the_ID());
                        if ( !$product->is_visible() ) continue;
                        echo '<li><a href="'. get_permalink($product->id) .'">'. woocommerce_get_product_thumbnail() .'</a>';
                        if ( $add_to_cart ) {
                            woocommerce_template_loop_add_to_cart();
                        }
                        echo '</li>';
                    endwhile; endif;
                    ?>
                </ul>
            </div>
            <?php
        } elseif ($display_mode == 'images_name') {
            ?>
            <div class="sfn-cart-addons-images">
                <ul class="products sfn-cart-addons">
                    <?php
                    $x = 0;
                    if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); global $product;
                        $product = sfn_get_product(get_the_ID());
                        if ( !$product->is_visible() ) continue;
                        echo '<li style="text-align:center;"><a href="'. get_permalink($product->id) .'">'. woocommerce_get_product_thumbnail() .'</a><br/><a href="'. get_permalink($product->id) .'">'. woocommerce_get_formatted_product_name($product) .'</a>';

                        if ( $add_to_cart ) {
                            woocommerce_template_loop_add_to_cart();
                        }

                        echo '</li>';
                    endwhile; endif;
                    ?>
                </ul>
            </div>
            <?php
        } elseif ($display_mode == 'images_name_price') {
            ?>
            <div class="sfn-cart-addons-images">
                <ul class="products sfn-cart-addons">
                    <?php
                    $x = 0;
                    if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); global $product;
                        $product = sfn_get_product(get_the_ID());
                        if ( !$product->is_visible() ) continue;

                        echo '<li style="text-align:center;"><a href="'. get_permalink($product->id) .'">'. woocommerce_get_product_thumbnail() .'</a><br/><a href="'. get_permalink($product->id) .'">'. woocommerce_get_formatted_product_name($product) .'</a> '. woocommerce_price( $product->get_price() );

                        if ( $add_to_cart ) {
                            //woocommerce_get_template( 'loop/add-to-cart.php' );
                            woocommerce_template_loop_add_to_cart();
                        }

                        echo '</li>';
                    endwhile; endif;
                    ?>
                </ul>
            </div>
            <?php
        } elseif ($display_mode == 'names') {
            ?>
            <div class="sfn-cart-addons-names">
                <ul class="products sfn-cart-addons">
                    <?php
                    $x = 0;
                    if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); global $product;
                        if ( !$product->is_visible() ) continue;
                        echo '<li><a href="'. get_permalink($product->id) .'">'. get_the_title($product->id) .'</a>';

                        if ( $add_to_cart ) {
                            woocommerce_template_loop_add_to_cart();
                        }

                        echo '</li>';
                    endwhile; endif;
                    ?>
                </ul>
            </div>
            <?php
        } elseif ($display_mode == 'names_price') {
            ?>
            <div class="sfn-cart-addons-names">
                <ul class="products sfn-cart-addons">
                    <?php
                    $x = 0;
                    if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); global $product;
                        if ( !$product->is_visible() ) continue;
                        echo '<li><a href="'. get_permalink($product->id) .'">'. woocommerce_get_formatted_product_name($product) .' '. woocommerce_price($product->get_price()) .'</a>';

                        if ( $add_to_cart ) {
                            woocommerce_template_loop_add_to_cart();
                        }

                        echo '</li>';
                    endwhile; endif;
                    ?>
                </ul>
            </div>
            <?php
        }

        $content = ob_get_clean();

        // reset data
        wp_reset_postdata();

        if ( $return ) {
            return $content;
        } else {
            echo $content;
        }

    }

    public function sc_display_addons($atts) {
        extract(shortcode_atts(array(
            'length'        => 4,
            'mode'          => 'loop',
            'add_to_cart'   => 0
        ), $atts));

        return $this->display_addons($length, $mode, $add_to_cart);
    }

    public function post_class( $classes ) {
        if ( in_array('product_variation', $classes) )
            $classes[] = 'product';

        return $classes;
    }

    public function the_title( $title, $id = null ) {
        global $post;

        if ( is_null($id) ) $id = $post->ID;

        $product = sfn_get_product( $id );

        if ( isset($product->variation_id) && $product->variation_id > 0 ) {
            $attributes = $product->get_variation_attributes();
            $extra_data = ' &ndash; ' . implode( ', ', $attributes );

            $title = sprintf( __( '%s%s', 'woocommerce' ), $product->get_title(), $extra_data );
        }

        return $title;
    }

    public function the_permalink($permalink) {
        global $product;

        if ( $product && $product->product_type == 'variation' ) {
            return get_permalink( $product->id );
        }

        return $permalink;
    }
}
if ( is_woocommerce_active() ) {
    $sfn_cart_addons = new SFN_Cart_Addons();
}

function sfn_display_cart_addons( $length = 4, $display_mode = 'loop', $add_to_cart = 0 ) {
    global $sfn_cart_addons;

    if ( isset($sfn_cart_addons) )
        echo $sfn_cart_addons->display_addons($length, $display_mode, $add_to_cart);
}

if (! function_exists('sfn_get_product') ) {
    function sfn_get_product( $id ) {
        if ( function_exists('get_product') ) {
            return get_product( $id );
        } else {
            $product_post = get_post( $id );

            if ( ! $product_post ) return new WC_Product( $id );

            if ( $product_post->post_type == 'product_variation' ) :
                return new WC_Product_Variation( $id );
            else :
                return new WC_Product( $id );
            endif;
        }
    }
}

if (! function_exists('woocommerce_template_loop_add_to_cart') ) {
    function woocommerce_template_loop_add_to_cart() {
        global $product;

        if ( $product->product_type == 'variation' ) {
            include 'add-to-cart.php';
        } else {
            woocommerce_get_template( 'loop/add-to-cart.php' );
        }

        //include 'add-to-cart.php';
    }
}
