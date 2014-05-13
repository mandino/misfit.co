<?php
/**
 * WooCommerce Customer/Order CSV Export
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Customer/Order CSV Export to newer
 * versions in the future. If you wish to customize WooCommerce Customer/Order CSV Export for your
 * needs please refer to http://docs.woothemes.com/document/ordercustomer-csv-exporter/
 *
 * @package     WC-Customer-Order-CSV-Export/Generator
 * @author      SkyVerge
 * @copyright   Copyright (c) 2012-2014, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Customer/Order CSV Export Cron Class
 *
 * Adds custom schedule and schedules the export event
 *
 * @since 3.0
 */
class WC_Customer_Order_CSV_Export_Cron {


	/**
	 * Setup hooks and filters specific to WP-cron functions
	 *
	 * @since 3.0
	 */
	public function __construct() {

		// Add custom schedule, e.g. every 10 minutes
		add_filter( 'cron_schedules', array( $this, 'add_auto_export_schedule' ) );

		// Schedule auto-update events if they don't exist, run in both frontend and backend so events are still scheduled when an admin reactivates the plugin
		add_action( 'init', array( $this, 'add_scheduled_export' ) );

		// Trigger export + upload of non-exported orders, wp-cron fires this action on the given recurring schedule
		add_action( 'wc_customer_order_csv_export_auto_export_orders', array( $this, 'auto_export_orders' ) );

		$this->exports_enabled = ( 'disabled' != get_option( 'wc_customer_order_csv_export_auto_export_method' ) );
	}


	/**
	 * If automatic exports are enabled, add the custom interval (e.g. every 15 minutes) set on the admin settings page
	 *
	 * @since 3.0
	 * @param array $schedules WP-Cron schedules array
	 * @return array $schedules now including our custom schedule
	 */
	public function add_auto_export_schedule( $schedules ) {

		if ( $this->exports_enabled ) {

			$export_interval = get_option( 'wc_customer_order_csv_export_auto_export_interval' );

			if ( $export_interval ) {

				$schedules['wc_customer_order_csv_export_auto_export_interval'] = array(
					'interval' => (int) $export_interval * 60,
					'display'  => sprintf( __( 'Every %d minutes', WC_Customer_Order_CSV_Export::TEXT_DOMAIN ), (int) $export_interval )
				);
			}
		}

		return $schedules;
	}


	/**
	 * If automatic exports are enabled, add the event if not already scheduled
	 *
	 * This performs a `do_action( 'wc_customer_order_csv_export_auto_export_orders' )` on our custom schedule
	 *
	 * @since 3.0
	 */
	public function add_scheduled_export() {

		if ( $this->exports_enabled ) {

			// use interval to set next immediate execution time
			$interval = get_option( 'wc_customer_order_csv_export_auto_export_interval' );

			// Schedule export
			if ( ! wp_next_scheduled( 'wc_customer_order_csv_export_auto_export_orders' ) ) {

				wp_schedule_event( strtotime( "{$interval} minutes" ), 'wc_customer_order_csv_export_auto_export_interval', 'wc_customer_order_csv_export_auto_export_orders' );
			}

		}
	}

	/**
	 * Exports any non-exported orders to CSV and performs the chosen action (upload, HTTP POST, email)
	 *
	 * @since 3.0
	 */
	public function auto_export_orders() {

		// get un-exported order IDs
		$query_args = array(
			'fields'      => 'ids',
			'post_type'   => 'shop_order',
			'post_status' => 'publish',
			'nopaging' => true,

			'meta_key'       => '_wc_customer_order_csv_export_is_exported',
			'meta_value'     => 0
		);

		$order_statuses = (array) get_option( 'wc_customer_order_csv_export_auto_export_statuses' );

		if ( ! empty( $order_statuses ) ) {

			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'shop_order_status',
					'field'    => 'slug',
					'terms'    => $order_statuses,
					'operator' => 'IN',
				)
			);
		}

		$query = new WP_Query( $query_args );

		if ( ! empty( $query->posts ) ) {

			// export them!
			$export = new WC_Customer_Order_CSV_Export_Handler( $query->posts );

			$export->export_via( get_option( 'wc_customer_order_csv_export_auto_export_method' ) );
		}

		/**
		 * Auto-Export Action.
		 *
		 * Fired when orders are auto-exported
		 *
		 * @since 3.0
		 * @param array $order_ids order IDs that were exported
		 */
		do_action( 'wc_customer_order_csv_export_orders_exported', $query->posts );
	}


} // end \WC_Customer_Order_CSV_Export_Cron class
