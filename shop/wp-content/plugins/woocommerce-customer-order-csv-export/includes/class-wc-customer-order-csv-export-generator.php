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
 * Customer/Order CSV Export Generator
 *
 * Converts customer/order data into CSV
 *
 * @since 3.0
 */
class WC_Customer_Order_CSV_Export_Generator {

	/** @var array order IDs or customer IDs */
	public $ids;

	/** @var array CSV header fields */
	public $headers;

	/** @var resource output stream containing CSV */
	private $stream;


	/**
	 * Setup the IDs to export and CSV options
	 *
	 * @since 3.0
	 * @param $ids
	 * @return \WC_Customer_Order_CSV_Export_Generator
	 */
	public function __construct( $ids ) {

		// either order IDs or customer IDs
		$this->ids = $ids;

		/**
		 * CSV Delimiter.
		 *
		 * Filter the delimiter used for the CSV file
		 *
		 * @since 3.0
		 * @param string $delimiter, defaults to comma (,)
		 * @param \WC_Customer_Order_CSV_Export_Generator $this, generator instance
		 */
		$this->delimiter = apply_filters( 'wc_customer_order_csv_export_delimiter', ',', $this );

		/**
		 * CSV Enclosure.
		 *
		 * Filter the enclosure used for the CSV file
		 *
		 * @since 3.0
		 * @param string $enclosure, defaults to double quote (")
		 * @param \WC_Customer_Order_CSV_Export_Generator $this, generator instance
		 */
		$this->enclosure = apply_filters( 'wc_customer_order_csv_export_enclosure', '"', $this );

		// open output buffer to write CSV to
		$this->stream = fopen( 'php://output', 'w' );
		ob_start();

		/**
		 * CSV BOM (Byte order mark).
		 *
		 * Enable adding a BOM to the exported CSV
		 *
		 * @since 3.0
		 * @param bool $enable_bom true to add the BOM, false otherwise. Defaults to false.
		 * @param \WC_Customer_Order_CSV_Export_Generator $this, generator instance
		 */
		if ( apply_filters( 'wc_customer_order_csv_export_enable_bom', false, $this ) ) {

			fputs( $this->stream, ( chr(0xEF) . chr(0xBB) . chr(0xBF) ) );
		}
	}


	/**
	 * Get the CSV for orders
	 *
	 * @since 3.0
	 * @return string CSV data
	 */
	public function get_orders_csv() {

		// order headers
		$this->headers = $this->get_orders_csv_headers();

		// write headers
		$this->write( $this->headers );

		// iterate through order IDs
		foreach ( $this->ids as $order_id ) {

			// get data for each order
			$data = $this->get_orders_csv_row( $order_id );

			// data can be an array of arrays when each line item is it's own row
			$first_element = reset( $data );
			if ( is_array( $first_element ) ) {

				// iterate through each line item row and write it
				foreach( $data as $row ) {

					$this->write( $row );
				}

			} else {

				// otherwise simply write the single order row
				$this->write( $data );
			}
		}

		return $this->get_csv();
	}


	/**
	 * Get the column headers for the orders CSV
	 *
	 * Note that the headers are keyed in column_key => column_name format so that plugins can control the output
	 * format using only the column headers and row data is not required to be in the exact same order, as the row data
	 * is matched on the column key
	 *
	 * @since 3.0
	 * @return array column headers in column_key => column_name format
	 */
	private function get_orders_csv_headers() {

		$column_headers = array(
			'order_id'            => 'order_id',
			'order_number'        => 'order_number',
			'order_date'          => 'date',
			'status'              => 'status',
			'shipping_total'      => 'shipping_total',
			'shipping_tax_total'  => 'shipping_tax_total',
			'tax_total'           => 'tax_total',
			'cart_discount'       => 'cart_discount',
			'order_discount'      => 'order_discount',
			'discount_total'      => 'discount_total',
			'order_total'         => 'order_total',
			'payment_method'      => 'payment_method',
			'shipping_method'     => 'shipping_method',
			'customer_id'         => 'customer_id',
			'billing_first_name'  => 'billing_first_name',
			'billing_last_name'   => 'billing_last_name',
			'billing_company'     => 'billing_company',
			'billing_email'       => 'billing_email',
			'billing_phone'       => 'billing_phone',
			'billing_address_1'   => 'billing_address_1',
			'billing_address_2'   => 'billing_address_2',
			'billing_postcode'    => 'billing_postcode',
			'billing_city'        => 'billing_city',
			'billing_state'       => 'billing_state',
			'billing_country'     => 'billing_country',
			'shipping_first_name' => 'shipping_first_name',
			'shipping_last_name'  => 'shipping_last_name',
			'shipping_address_1'  => 'shipping_address_1',
			'shipping_address_2'  => 'shipping_address_2',
			'shipping_postcode'   => 'shipping_postcode',
			'shipping_city'       => 'shipping_city',
			'shipping_state'      => 'shipping_state',
			'shipping_country'    => 'shipping_country',
			'shipping_company'    => 'shipping_company',
			'customer_note'       => 'customer_note',
			'line_items'          => 'line_items',
			'shipping_items'      => 'shipping_items',
			'tax_items'           => 'tax_items',
			'coupon_items'        => 'coupons',
			'order_notes'         => 'order_notes',
		);

		/**
		 * CSV Order Export Column Headers.
		 *
		 * Filter the column headers for the order export
		 *
		 * @since 3.0
		 * @param array $column_headers {
		 *     column headers in key => name format
		 *     to modify the column headers, ensure the keys match these and set your own values
		 * }
		 * @param \WC_Customer_Order_CSV_Export_Generator $this, generator instance
		 */
		return apply_filters( 'wc_customer_order_csv_export_order_headers', $column_headers, $this );
	}


	/**
	 * Get the order data for a single CSV row
	 *
	 * Note items are keyed according to the column header keys above so these can be modified using
	 * the provider filter without needing to worry about the array order
	 *
	 * @since 3.0
	 * @param int $order_id the WC_Order ID
	 * @return array order data in the format key => content
	 */
	private function get_orders_csv_row( $order_id ) {

		$order = new WC_Order( $order_id );

		$line_items = $shipping_items = $tax_items = $coupon_items = array();

		// get line items
		foreach( $order->get_items() as $_ => $item ) {

			$product = $order->get_product_from_item( $item );

			$line_items[] = implode( '|', array(
				'name:' . html_entity_decode( $product->get_title(), ENT_NOQUOTES, 'UTF-8' ),
				'sku:' . $product->get_sku(),
				'quantity:' . $item['qty'],
				'total:' . SV_WC_Plugin_Compatibility::wc_format_decimal( $order->get_line_total( $item ), 2 ),
			) );
		}

		// get shipping items (only in WC 2.1+)
		if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_2_1() ) {

			foreach ( $order->get_shipping_methods() as $_ => $shipping_item ) {

				$shipping_items[] = implode( '|', array(
					'method:' . $shipping_item['name'],
					'total:' . SV_WC_Plugin_Compatibility::wc_format_decimal( $shipping_item['cost'], 2 ),
				) );
			}
		}

		// get tax items
		foreach ( $order->get_tax_totals() as $tax_code => $tax ) {

			$tax_items[] = implode( '|', array(
				'code:' . $tax_code,
				'total:' . SV_WC_Plugin_Compatibility::wc_format_decimal( $tax->amount, 2 ),
			) );
		}

		// add coupons
		foreach ( $order->get_items( 'coupon' ) as $_ => $coupon_item ) {

			$coupon_items[] = implode( '|', array(
				'code:' . $coupon_item['name'],
				'amount:' . SV_WC_Plugin_Compatibility::wc_format_decimal( $coupon_item['discount_amount'], 2 ),
			) );
		}

		$order_data = array(
			'order_id'            => $order->id,
			'order_number'        => $order->get_order_number(),
			'order_date'          => $order->order_date,
			'status'              => $order->status,
			'shipping_total'      => SV_WC_Plugin_Compatibility::get_total_shipping( $order ),
			'shipping_tax_total'  => SV_WC_Plugin_Compatibility::wc_format_decimal( $order->get_shipping_tax(), 2 ),
			'tax_total'           => SV_WC_Plugin_Compatibility::wc_format_decimal( $order->get_total_tax(), 2 ),
			'cart_discount'       => SV_WC_Plugin_Compatibility::wc_format_decimal( $order->get_cart_discount(), 2 ),
			'order_discount'      => SV_WC_Plugin_Compatibility::wc_format_decimal( $order->get_order_discount(), 2 ),
			'discount_total'      => SV_WC_Plugin_Compatibility::wc_format_decimal( $order->get_total_discount(), 2 ),
			'order_total'         => SV_WC_Plugin_Compatibility::wc_format_decimal( $order->get_total(), 2 ),
			'payment_method'      => $order->payment_method,
			'shipping_method'     => $order->get_shipping_method(),
			'customer_id'         => $order->customer_user,
			'billing_first_name'  => $order->billing_first_name,
			'billing_last_name'   => $order->billing_last_name,
			'billing_company'     => $order->billing_company,
			'billing_email'       => $order->billing_email,
			'billing_phone'       => $order->billing_phone,
			'billing_address_1'   => $order->billing_address_1,
			'billing_address_2'   => $order->billing_address_2,
			'billing_postcode'    => $order->billing_postcode,
			'billing_city'        => $order->billing_city,
			'billing_state'       => $order->billing_state,
			'billing_country'     => $order->billing_country,
			'shipping_first_name' => $order->shipping_first_name,
			'shipping_last_name'  => $order->shipping_last_name,
			'shipping_company'    => $order->shipping_company,
			'shipping_address_1'  => $order->shipping_address_1,
			'shipping_address_2'  => $order->shipping_address_2,
			'shipping_postcode'   => $order->shipping_postcode,
			'shipping_city'       => $order->shipping_city,
			'shipping_state'      => $order->shipping_state,
			'shipping_country'    => $order->shipping_country,
			'customer_note'       => $order->customer_note,
			'line_items'          => implode( ';', $line_items ),
			'shipping_items'      => implode( ';', $shipping_items ),
			'tax_items'           => implode( ';', $tax_items ),
			'coupon_items'        => implode( ';', $order->get_used_coupons() ),
			'order_notes'         => implode( '|', $this->get_order_notes( $order ) ),
		);

		/**
		 * CSV Order Export Row.
		 *
		 * Filter the individual row data for the order export
		 *
		 * @since 3.0
		 * @param array $order_data {
		 *     order data in key => value format
		 *     to modify the row data, ensure the key matches any of the header keys and set your own value
		 * }
		 * @param \WC_Order $order WC Order object
		 * @param \WC_Customer_Order_CSV_Export_Generator $this, generator instance
		 */
		return apply_filters( 'wc_customer_order_csv_export_order_row', $order_data, $order, $this );
	}


	/**
	 * Get the order notes for given order
	 *
	 * @since 3.0
	 * @param WC_Order $order
	 * @return array order notes
	 */
	private function get_order_notes( $order ) {

		if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_2_1() ) {

			$callback = array( 'WC_Comments', 'exclude_order_comments' );

		} else {

			$callback = 'woocommerce_exclude_order_comments';
		}

		$args = array(
			'post_id' => $order->id,
			'approve' => 'approve',
			'type'    => 'order_note'
		);

		remove_filter( 'comments_clauses', $callback );

		$notes = get_comments( $args );

		add_filter( 'comments_clauses', $callback );

		$order_notes = array();

		foreach ( $notes as $note ) {

			$order_notes[] = $note->comment_content;
		}

		return $order_notes;
	}


	/**
	 * Get the CSV for customers
	 *
	 * @since 3.0
	 * @return string CSV data
	 */
	public function get_customers_csv() {

		// customer headers
		$this->headers = $this->get_customers_csv_headers();

		// write headers
		$this->write( $this->headers );

		$customers = array();

		// get customers to export
		foreach ( $this->ids as $order_id ) {

			$billing_email = get_post_meta( $order_id, '_billing_email', true );

			// skip orders without a billing email
			if ( ! $billing_email ) {
				continue;
			}

			$customers[ $order_id ] = $billing_email;
		}

		// ensure each customer has a unique billing email
		$customers = array_unique( $customers );

		foreach ( $customers as $order_id => $customer_email ) {

			// get data for each customer
			$data = $this->get_customers_csv_row( $customer_email, $order_id );

			// data can be an array of arrays when customer meta is it's own row
			$first_element = reset( $data );
			if ( is_array( $first_element ) ) {

				// iterate through each customer meta row and write it
				foreach( $data as $row ) {

					$this->write( $row );
				}

			} else {

				// otherwise simply write the single customer row
				$this->write( $data );
			}
		}

		return $this->get_csv();
	}


	/**
	 * Get the column headers for the customers CSV
	 *
	 * Note that the headers are keyed in column_key => column_name format so that plugins can control the output
	 * format using only the column headers and row data is not required to be in the exact same order, as the row data
	 * is matched on the column key
	 *
	 * @since 3.0
	 * @return array column headers in column_key => column_name format
	 */
	public function get_customers_csv_headers() {

		$column_headers = array(
			'customer_id'         => 'customer_id',
			'first_name'          => 'first_name',
			'last_name'           => 'last_name',
			'email'               => 'email',
			'date_registered'     => 'date_registered',
			'billing_first_name'  => 'billing_first_name',
			'billing_last_name'   => 'billing_last_name',
			'billing_company'     => 'billing_company',
			'billing_email'       => 'billing_email',
			'billing_phone'       => 'billing_phone',
			'billing_address_1'   => 'billing_address_1',
			'billing_address_2'   => 'billing_address_2',
			'billing_postcode'    => 'billing_postcode',
			'billing_city'        => 'billing_city',
			'billing_state'       => 'billing_state',
			'billing_country'     => 'billing_country',
			'shipping_first_name' => 'shipping_first_name',
			'shipping_last_name'  => 'shipping_last_name',
			'shipping_company'    => 'shipping_company',
			'shipping_address_1'  => 'shipping_address_1',
			'shipping_address_2'  => 'shipping_address_2',
			'shipping_postcode'   => 'shipping_postcode',
			'shipping_city'       => 'shipping_city',
			'shipping_state'      => 'shipping_state',
			'shipping_country'    => 'shipping_country',
		);

		/**
		 * CSV Customer Export Column Headers.
		 *
		 * Filter the column headers for the customer export
		 *
		 * @since 3.0
		 * @param array $column_headers {
		 *     column headers in key => name format
		 *     to modify the column headers, ensure the keys match these and set your own values
		 * }
		 * @param \WC_Customer_Order_CSV_Export_Generator $this, generator instance
		 */
		return apply_filters( 'wc_customer_order_csv_export_customer_headers', $column_headers, $this );
	}


	/**
	 * Get the customer data for a single CSV row
	 *
	 * Note items are keyed according to the column header keys above so these can be modified using
	 * the provider filter without needing to worry about the array order
	 *
	 * @since 3.0
	 * @param string $customer_email the customer's email
	 * @param int $order_id a valid order ID for the customer
	 * @return array order data in the format key => content
	 */
	private function get_customers_csv_row( $customer_email, $order_id ) {

		$user = get_user_by( 'email', $customer_email );

		// guest, get info from order
		if ( ! $user ) {

			$order = new WC_Order( $order_id );

			// create blank user
			$user = new stdClass();

			// set properties on user
			$user->ID                  = 0;
			$user->first_name          = $order->billing_first_name;
			$user->last_name           = $order->billing_last_name;
			$user->user_email          = $order->billing_email;
			$user->user_registered     = $order->order_date;
			$user->billing_first_name  = $order->billing_first_name;
			$user->billing_last_name   = $order->billing_last_name;
			$user->billing_company     = $order->billing_company;
			$user->billing_email       = $order->billing_email;
			$user->billing_phone       = $order->billing_phone;
			$user->billing_address_1   = $order->billing_address_1;
			$user->billing_address_2   = $order->billing_address_2;
			$user->billing_postcode    = $order->billing_postcode;
			$user->billing_city        = $order->billing_city;
			$user->billing_state       = $order->billing_state;
			$user->billing_country     = $order->billing_country;
			$user->shipping_first_name = $order->shipping_first_name;
			$user->shipping_last_name  = $order->shipping_last_name;
			$user->shipping_company    = $order->shipping_company;
			$user->shipping_address_1  = $order->shipping_address_1;
			$user->shipping_address_2  = $order->shipping_address_2;
			$user->shipping_postcode   = $order->shipping_postcode;
			$user->shipping_city       = $order->shipping_city;
			$user->shipping_state      = $order->shipping_state;
			$user->shipping_country    = $order->shipping_country;
		}

		$customer_data = array(
			'customer_id'         => $user->ID,
			'first_name'          => $user->first_name,
			'last_name'           => $user->last_name,
			'email'               => $user->user_email,
			'date_registered'     => $user->user_registered,
			'billing_first_name'  => $user->billing_first_name,
			'billing_last_name'   => $user->billing_last_name,
			'billing_company'     => $user->billing_company,
			'billing_email'       => $user->billing_email,
			'billing_phone'       => $user->billing_phone,
			'billing_address_1'   => $user->billing_address_1,
			'billing_address_2'   => $user->billing_address_2,
			'billing_postcode'    => $user->billing_postcode,
			'billing_city'        => $user->billing_city,
			'billing_state'       => $user->billing_state,
			'billing_country'     => $user->billing_country,
			'shipping_first_name' => $user->shipping_first_name,
			'shipping_last_name'  => $user->shipping_last_name,
			'shipping_company'    => $user->shipping_company,
			'shipping_address_1'  => $user->shipping_address_1,
			'shipping_address_2'  => $user->shipping_address_2,
			'shipping_postcode'   => $user->shipping_postcode,
			'shipping_city'       => $user->shipping_city,
			'shipping_state'      => $user->shipping_state,
			'shipping_country'    => $user->shipping_country,
		);

		/**
		 * CSV Customer Export Row.
		 *
		 * Filter the individual row data for the customer export
		 *
		 * @since 3.0
		 * @param array $customer_data {
		 *     order data in key => value format
		 *     to modify the row data, ensure the key matches any of the header keys and set your own value
		 * }
		 * @param \WP_User $user WP User object
		 * @param int $order_id an order ID for the customer
		 * @param \WC_Customer_Order_CSV_Export_Generator $this, generator instance
		 */
		return apply_filters( 'wc_customer_order_csv_export_customer_row', $customer_data, $user, $order_id, $this );
	}


	/**
	 * Write the given row to the CSV
	 *
	 * This is abstracted so the provided data can be matched to the CSV headers set and the CSV delimiter and
	 * enclosure can be controlled from a single method
	 *
	 * @since 3.0
	 * @param array $row
	 */
	private function write( $row ) {

		$data = array();

		foreach ( $this->headers as $header_key => $_ ) {

			if ( ! isset( $row[ $header_key ] ) ) {
				$row[ $header_key ] = '';
			}

			// strict string comparison, as values like '0' are valid
			$data[] = ( '' !== $row[ $header_key ] ) ? $row[ $header_key ] : '';
		}

		fputcsv( $this->stream, $data, $this->delimiter, $this->enclosure );
	}


	/**
	 * Return the CSV data by closing the output buffer and stream
	 *
	 * @since 3.0
	 * @return string CSV
	 */
	private function get_csv() {

		$csv = ob_get_clean();

		fclose( $this->stream );

		return $csv;
	}


} //end \WC_Customer_Order_CSV_Export_Generator class
