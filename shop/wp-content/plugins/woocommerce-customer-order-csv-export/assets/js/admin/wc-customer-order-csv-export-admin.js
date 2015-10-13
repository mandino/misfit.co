jQuery( document ).ready( function ( $ ) {

	'use strict';

	/* global wc_customer_order_csv_export_admin_params */

	// make order status multiselects chosen
	$( 'select.chosen_select' ).chosen();


	/** bulk export page **/

	if ( $( 'input[name=wc_customer_order_csv_export_bulk_export]' ).val() ) {

		// datepicker for start date
		$( '#wc_customer_order_csv_export_start_date' ).datepicker( {
			dateFormat     : 'yy-mm-dd',
			numberOfMonths : 1,
			showButtonPanel: true,
			showOn         : 'button',
			buttonImage    : wc_customer_order_csv_export_admin_params.calendar_icon_url,
			buttonImageOnly: true
		} );

		// datepicker for end date
		$( '#wc_customer_order_csv_export_end_date' ).datepicker( {
			dateFormat     : 'yy-mm-dd',
			numberOfMonths : 1,
			showButtonPanel: true,
			showOn         : 'button',
			buttonImage    : wc_customer_order_csv_export_admin_params.calendar_icon_url,
			buttonImageOnly: true
		} );

		// hide order status multiselect when customers are exported
		$( 'input[name=wc_customer_order_csv_export_type]' ).change( function() {

			var $order_status_row = $( 'select' ).closest( 'tr' );

			if ( 'customers' === $( this ).val() ) {

				$order_status_row.hide();

			} else {

				$order_status_row.show();
			}
		} );
	}


	/** settings page **/


	// hide auto-export & export method settings if auto-export is not checked
	$( '#wc_customer_order_csv_export_auto_export_method' ).change( function () {

		var export_method = $( this ).val(),
			$ftp_settings = $( '#wc_customer_order_csv_export_ftp_server' ).closest( 'table' ),
			$http_post_settings = $( '#wc_customer_order_csv_export_http_post_url' ).closest( 'table' ),
			$email_settings = $( '#wc_customer_order_csv_export_email_recipients' ).closest( 'table' );

		if ( 'disabled' === export_method ) {
			$( this ).closest( 'tr' ).nextUntil( 'h3' ).hide();
			$ftp_settings.prev().hide();
			$ftp_settings.hide();
			$http_post_settings.prev().hide();
			$http_post_settings.hide();
			$email_settings.prev().hide();
			$email_settings.hide();

		} else if ( 'ftp' === export_method ) {

			// show export & FTP settings
			$( this ).closest( 'tr' ).nextUntil( 'h3' ).show();
			$ftp_settings.prev().show();
			$ftp_settings.show();
			$http_post_settings.prev().hide();
			$http_post_settings.hide();
			$email_settings.prev().hide();
			$email_settings.hide();

		} else if ( 'http_post' === export_method ) {

			// show export & HTTP POST settings
			$( this ).closest( 'tr' ).nextUntil( 'h3' ).show();
			$http_post_settings.prev().show();
			$http_post_settings.show();
			$ftp_settings.prev().hide();
			$ftp_settings.hide();
			$email_settings.prev().hide();
			$email_settings.hide();

		} else if ( 'email' === export_method ) {

			// show export & Email settings
			$( this ).closest( 'tr' ).nextUntil( 'h3' ).show();
			$email_settings.prev().show();
			$email_settings.show();
			$http_post_settings.prev().hide();
			$http_post_settings.hide();
			$ftp_settings.prev().hide();
			$ftp_settings.hide();

		}

	} ).change();

	// auto export start time timepicker
	$( '.js-wc-customer-order-csv-export-auto-export-timepicker' ).timepicker();

	// change port to 22 if SFTP is selected or 990 if FTP with Implicit SSL
	$( 'select[name=wc_customer_order_csv_export_ftp_security]' ).change( function () {

		var $ftp_port = $( '#wc_customer_order_csv_export_ftp_port' );

		if ( '' === $ftp_port.val() ) {

			if ( 'sftp' === $( this) .val() ) {

				$ftp_port.val( '22' );

			} else if ( 'ftp_ssl' === $( this ).val() ) {

				$ftp_port.val( '990' );

			} else {

				$ftp_port.val( '21' );
			}

		}

	} ).change();

	// add a helper hidden input when test buttons are clicked to indicate which method to test
	$( 'input[name=wc_customer_order_csv_export_test_button]' ).on( 'click', function() {

		$( '<input>' ).attr( {
			type: 'hidden',
			id: 'wc_customer_order_csv_export_test_method',
			name: 'wc_customer_order_csv_export_test_method',
			value: $( this ).data( 'method' )
		} ).appendTo( '.woocommerce form' );
	} );

} );
