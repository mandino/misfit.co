<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Quick View Custom Template Dynamic Gallery Style Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_QV_Custom_Template_Gallery_Thumbnails_Settings extends WC_QV_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'gallery-settings';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'quick_view_template_gallery_thumbnails_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'quick_view_template_gallery_thumbnails_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 2;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Thumbnails Settings successfully saved.', 'wooquickview' ),
				'error_message'		=> __( 'Error: Thumbnails Settings can not save.', 'wooquickview' ),
				'reset_message'		=> __( 'Thumbnails Settings successfully reseted.', 'wooquickview' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_qv_admin_interface;
		
		$wc_qv_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'thumbnails-settings',
			'label'				=> __( 'Image Thumbnails', 'wooquickview' ),
			'callback_function'	=> 'wc_qv_custom_template_gallery_thumbnails_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_qv_admin_interface;
		
		$output = '';
		$output .= $wc_qv_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
				
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
		
			array(
            	'name' 		=> __('Image Thumbnails', 'wooquickview'),
                'type' 		=> 'heading',
                'id'     => 'wc_dgallery_thumbnails_box',
           	),
           	array(  
				'name' 		=> __( 'Gallery Thumbnails', 'wooquickview' ),
				'class'		=> 'enable_gallery_thumb',
				'id' 		=> 'enable_gallery_thumb',
				'default'			=> 'yes',
				'type' 				=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'wooquickview' ),
				'unchecked_label' 	=> __( 'OFF', 'wooquickview' ),
			),

			array(
                'type' 		=> 'heading',
				'class'		=> 'gallery_thumb_container',
           	),
			array(  
				'name' 		=> __( 'Single Image Thumbnail', 'wooquickview' ),
				'desc' 		=> __( "ON to hide thumbnail when only 1 image is loaded to gallery.", 'wooquickview' ),
				'id' 		=> 'hide_thumb_1image',
				'default'			=> 'no',
				'type' 				=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'wooquickview' ),
				'unchecked_label' 	=> __( 'OFF', 'wooquickview' ),
			),
			array(
				'name' 		=> __( 'Thumbnail Display', 'wooquickview' ),
				'desc'		=> __( 'Static displays all Gallery thumbnails in columns', 'wooquickview' ),
				'id' 		=> 'thumb_show_type',
				'default'			=> 'slider',
				'type' 				=> 'switcher_checkbox',
				'checked_value'		=> 'slider',
				'unchecked_value'	=> 'static',
				'checked_label'		=> __( 'Slider', 'wooquickview' ),
				'unchecked_label' 	=> __( 'Static', 'wooquickview' ),
			),
			array(
				'class'		=> 'gallery_thumb_container',
                'type' 		=> 'heading',
				'desc'		=> '<table class="form-table"><tbody>
				<tr valign="top">
				<th class="titledesc" scope="row"><label>' . __( 'Thumbnail Dimensions', 'wooquickview' ) . '</label></th>
				<td class="forminp">' . sprintf( __( 'The plugin is using <a href="%s" target="_blank">Product Thumbnails Dimension</a> from WooCommerce Settings', 'wooquickview' ), admin_url( 'admin.php?page=wc-settings&tab=products&section=display' ) ) . '</td>
				</tr></tbody></table>',
           	),
			array(
				'name' 		=> __( 'Thumbnail Spacing', 'wooquickview' ),
				'desc' 		=> 'px',
				'id' 		=> 'thumb_spacing',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '10'
			),
			array(
				'name' => __( 'Thumbnail Columns', 'wooquickview' ),
				'desc' 		=> __( 'columns', 'wooquickview' ) . '</span></div></div>
				<div style="clear: both;"></div>
				<div><div>' . __( 'Applies to Thumbnail Slider (number visible in Slider) and Static Thumbnail Display. Default of WooCommerce is 3 column', 'wooquickview' ) . '<span>',
				'id' 		=> 'thumb_columns',
				'type' 		=> 'slider',
				'default'	=> 3,
				'min'		=> 2,
				'max'		=> 8,
				'increment'	=> 1,
			),
			array(  
				'name' => __( 'Thumbnail Border Colour', 'wooquickview' ),
				'desc' 		=> __( 'Type in the word <code>transparent</code> for no colour', 'wooquickview' ),
				'id' 		=> 'thumb_border_color',
				'type' 		=> 'color',
				'default'	=> 'transparent'
			),
			array(  
				'name' => __( 'Current Thumbail Border Colour', 'wooquickview' ),
				'desc' 		=> __( 'Type in the word <code>transparent</code> for no colour', 'wooquickview' ),
				'id' 		=> 'thumb_current_border_color',
				'type' 		=> 'color',
				'default'	=> '#96588a'
			),
        ));
	}

	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.enable_gallery_thumb:checked").val() != 'yes') {
		$(".gallery_thumb_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px' } );
	}

	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.enable_gallery_thumb', function( event, value, status ) {
		$('.gallery_thumb_container').attr('style','display:none;');
		if ( status == 'true' ) {
			$(".gallery_thumb_container").slideDown();
		} else {
			$(".gallery_thumb_container").slideUp();
		}
	});
});
})(jQuery);
</script>
    <?php
	}
}

global $wc_qv_custom_template_gallery_thumbnails_settings;
$wc_qv_custom_template_gallery_thumbnails_settings = new WC_QV_Custom_Template_Gallery_Thumbnails_Settings();

/** 
 * wc_qv_custom_template_gallery_thumbnails_settings_form()
 * Define the callback function to show subtab content
 */
function wc_qv_custom_template_gallery_thumbnails_settings_form() {
	global $wc_qv_custom_template_gallery_thumbnails_settings;
	$wc_qv_custom_template_gallery_thumbnails_settings->settings_form();
}

?>
