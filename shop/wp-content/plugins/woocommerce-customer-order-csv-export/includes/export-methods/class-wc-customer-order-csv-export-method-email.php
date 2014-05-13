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
 * @package     WC-Customer-Order-CSV-Export/Export-Methods/Email
 * @author      SkyVerge
 * @copyright   Copyright (c) 2012-2014, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Customer/Order CSV Export Email Class
 *
 * TODO
 *
 * @since 3.0
 */
class WC_Customer_Order_CSV_Export_Method_Email implements WC_Customer_Order_CSV_Export_Method {


	/**
	 * Emails the admin with the exported CSV as an attachment
	 *
	 * @since 3.0
	 * @param string $filename the attachment filename
	 * @param string $csv the CSV to attach to the email
	 */
	public function perform_action( $filename, $csv ) {

		// TODO: implement
	}


} // end \WC_Customer_Order_CSV_Export_Method_Email class
