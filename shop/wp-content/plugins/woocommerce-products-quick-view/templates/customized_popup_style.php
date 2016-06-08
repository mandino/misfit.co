<style>
<?php
global $wc_qv_admin_interface, $wc_qv_fonts_face;

// Container Style
global $quick_view_template_global_settings;
extract($quick_view_template_global_settings);
?>
@charset "UTF-8";
/* CSS Document */

/* Container Style */
#fancybox-content > div, #cboxLoadedContent {
	background-color: <?php echo $container_bg_color; ?> !important;
}
.quick_view_popup_container {
	padding:10px;
	/*Background*/
	background-color: <?php echo $container_bg_color; ?> !important;
}
.quick_view_product_gallery_container {
	width: <?php echo $gallery_container_wide; ?>% !important;
	float: <?php echo $gallery_position; ?> !important;
}
.quick_view_product_data_container {
<?php if ( $gallery_position == 'right' ) { ?>
	float: left !important;
<?php } else { ?>
	float: right !important;
<?php } ?>
	width: <?php echo ( 98 - $gallery_container_wide ); ?>% !important;
}

<?php
// Controls Style
global $quick_view_template_control_settings;
extract($quick_view_template_control_settings);
?>
/* Container Style */
.quick_view_control_container {
	z-index:100;
	/*-webkit-filter: grayscale(100%);
	-webkit-transition: all 0.5s linear;
	-moz-transition: all 0.5s linear;
	-o-transition: all 0.5s linear;
	transition: all 0.5s linear;*/
<?php if ( $control_transition == 'alway' ) { ?>
	opacity:1;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=1);
	-moz-opacity: 1;
	-khtml-opacity: 1;
<?php } else { ?>
	opacity: 0;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
	filter: alpha(opacity=0);
	-moz-opacity: 0;
	-khtml-opacity: 0;
<?php } ?>
}
#cboxLoadedContent:hover .quick_view_control_container, #fancybox-content:hover .quick_view_control_container {
	opacity:1;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=1);
	-moz-opacity: 1;
	-khtml-opacity: 1;
}
.quick_view_previous_control {
	cursor:pointer;
	display:inline-block;
	position:absolute;
	margin-top:-25px;
	top:50%;
	left:5px;
	z-index:100;
}
.quick_view_next_control {
	cursor:pointer;
	display:inline-block;
	position:absolute;
	margin-top:-25px;
	top:50%;
	right:5px;
	z-index:100;
}

<?php
// Product Title Style
global $quick_view_template_product_title_settings;
extract( $quick_view_template_product_title_settings );
?>
/* Product Title Style */
.quick_view_product_title_container {
	text-align: <?php echo $title_alignment; ?> !important;
	/*Margin*/
	margin: <?php echo $title_margin_top; ?>px <?php echo $title_margin_right; ?>px <?php echo $title_margin_bottom; ?>px <?php echo $title_margin_left; ?>px !important;
	/*Padding*/
	padding: <?php echo $title_padding_top; ?>px <?php echo $title_padding_right; ?>px <?php echo $title_padding_bottom; ?>px <?php echo $title_padding_left; ?>px !important;
	/*Background*/
	background-color: <?php echo $title_bg_color; ?> !important;
	/* Shadow */
	<?php echo $wc_qv_admin_interface->generate_shadow_css( $title_shadow ); ?>
	/*Border*/
	<?php echo $wc_qv_admin_interface->generate_border_css( $title_border ); ?> 
}
.quick_view_product_title {
	text-transform: <?php echo $title_transformation; ?> !important;
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $title_font ); ?>	
}
.quick_view_product_title:hover {
	color: <?php echo $title_font_hover_color; ?> !important;
}

<?php
// Product Rating Style
global $quick_view_template_product_rating_settings;
extract( $quick_view_template_product_rating_settings );
?>
/* Product Title Style */
.quick_view_product_rating_container {
	/*Margin*/
	margin: <?php echo $rating_margin_top; ?>px <?php echo $rating_margin_right; ?>px <?php echo $rating_margin_bottom; ?>px <?php echo $rating_margin_left; ?>px !important;
	/*Padding*/
	padding: <?php echo $title_padding_top; ?>px <?php echo $title_padding_right; ?>px <?php echo $title_padding_bottom; ?>px <?php echo $title_padding_left; ?>px !important;
}
.quick_view_product_rating_container .star-rating {
<?php if ( $rating_alignment == 'center' ) { ?>
	float: none !important;
	margin:auto !important;
<?php } else { ?>
	float: <?php echo $rating_alignment; ?> !important;	
<?php } ?>
}

<?php
// Product Description Style
global $quick_view_template_product_description_settings;
extract( $quick_view_template_product_description_settings );
?>
/* Product Description Style */
.quick_view_product_description_container {
	text-align: <?php echo $description_alignment; ?> !important;
	/*Margin*/
	margin: <?php echo $description_margin_top; ?>px <?php echo $description_margin_right; ?>px <?php echo $description_margin_bottom; ?>px <?php echo $description_margin_left; ?>px !important;
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $description_font ); ?>
}
.quick_view_product_description_container * {
	text-align: <?php echo $description_alignment; ?> !important;
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $description_font ); ?>
}

<?php
// Product Meta Style
global $quick_view_template_product_meta_settings;
extract( $quick_view_template_product_meta_settings );
?>
/* Product Meta Style */
.quick_view_product_meta_container {
	margin:10px 0;	
}
.quick_view_product_meta {
	text-align: <?php echo $meta_alignment; ?> !important;
	/*Margin*/
	margin: <?php echo $meta_margin_top; ?>px <?php echo $meta_margin_right; ?>px <?php echo $meta_margin_bottom; ?>px <?php echo $meta_margin_left; ?>px !important;
}
.quick_view_product_meta .quick_view_product_meta_name {
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $meta_name_font ); ?>
}
.quick_view_product_meta .quick_view_product_meta_value, .quick_view_product_meta a {
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $meta_value_font ); ?>
}
.quick_view_product_meta a:hover {
	color: <?php echo $meta_value_font_hover_color; ?> !important;
}

<?php
// Product Price Style
global $quick_view_template_product_price_settings;
extract( $quick_view_template_product_price_settings );
?>
/* Product Price Style */
.quick_view_product_price_container {
	text-align: <?php echo $price_alignment; ?> !important;
	/*Margin*/
	margin: <?php echo $price_margin_top; ?>px <?php echo $price_margin_right; ?>px <?php echo $price_margin_bottom; ?>px <?php echo $price_margin_left; ?>px !important;
}
.quick_view_product_price_container span, .quick_view_product_price_container .amount  {
	margin:0 3px;
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $price_font ); ?>
}
.quick_view_product_price_container del, .quick_view_product_price_container del .amount  {
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $old_price_font ); ?>
}

.quick_view_product_addtocart_container .single_variation {
	text-align: <?php echo $price_alignment; ?> !important;
}
.quick_view_product_addtocart_container .price, .quick_view_product_addtocart_container .price * {
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $price_font ); ?>
}
.quick_view_product_addtocart_container .price del, .quick_view_product_addtocart_container .price del .amount {
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $old_price_font ); ?>
}

<?php
// Product Add To Cart Style
global $quick_view_template_addtocart_settings;
extract( $quick_view_template_addtocart_settings );
?>
/* Product Add To Cart Style */
.quick_view_product_addtocart_container {
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $description_font ); ?>
}
.quick_view_product_addtocart_button_container {
	display:block;
	text-align:center !important;
<?php if ( $addtocart_alignment == 'center' ) { ?>
	float: none !important;
<?php } else { ?>
	float: <?php echo $addtocart_alignment; ?> !important;	
<?php } ?>
}
.quick_view_product_addtocart_container .quick_view_add_to_cart_button {
<?php if ( $addtocart_alignment == 'center' ) { ?>
	float: none !important;
<?php } else { ?>
	float: <?php echo $addtocart_alignment; ?> !important;	
<?php } ?>

	/*Margin*/
	margin: <?php echo $addtocart_button_margin_top; ?>px <?php echo $addtocart_button_margin_right; ?>px <?php echo $addtocart_button_margin_bottom; ?>px <?php echo $addtocart_button_margin_left; ?>px !important;
	/*Padding*/
	padding: <?php echo $addtocart_button_padding_top; ?>px <?php echo $addtocart_button_padding_right; ?>px <?php echo $addtocart_button_padding_bottom; ?>px <?php echo $addtocart_button_padding_left; ?>px !important;
	
	/*Background*/
	background-color: <?php echo $addtocart_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $addtocart_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $addtocart_button_bg_colour_to; ?>)
				) !important;
	background: -moz-linear-gradient(
					center top,
					<?php echo $addtocart_button_bg_colour_from; ?> 20%,
					<?php echo $addtocart_button_bg_colour_to; ?> 100%
				) !important;
	
		
	/*Border*/
	<?php echo $wc_qv_admin_interface->generate_border_css( $addtocart_button_border ); ?>
	
	/* Shadow */
	<?php echo $wc_qv_admin_interface->generate_shadow_css( $addtocart_button_shadow ); ?>
	
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $addtocart_button_font ); ?>
	
	text-align: center !important;
	text-decoration: none !important;
	outline-color: transparent;
}
.quick_view_product_addtocart_container .quick_view_add_to_cart_link {
<?php if ( $addtocart_alignment == 'center' ) { ?>
	float: none !important;
<?php } else { ?>
	float: <?php echo $addtocart_alignment; ?> !important;	
<?php } ?>
	padding: 0 !important;
	margin:0 !important;
	border:none !important;
	background:none !important;
	box-shadow:none !important;
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $addtocart_link_font ); ?>
}
.quick_view_product_addtocart_container .quick_view_add_to_cart_link:hover {
	color: <?php echo $addtocart_link_font_hover_colour; ?> !important;
}
.quick_view_product_addtocart_container .quick_view_add_to_cart_button.added:after, .quick_view_product_addtocart_container .quick_view_add_to_cart_link.added:after {
	background-image: url("<?php echo $addtocart_success_icon; ?>") !important;
	background-repeat: no-repeat;
    background-size: contain;
    content: "" !important;
    padding-right: 16px;
}
.quick_view_product_addtocart_container .quick_view_add_to_cart_link.added:after {
	top:0 !important;	
}
.quick_view_product_addtocart_container .added_to_cart {
	display:table !important;
	text-align:center;
	white-space: normal !important;
}

<?php
// Product Read More Style
global $quick_view_template_readmore_settings;
extract( $quick_view_template_readmore_settings );
?>
/* Product Read More Style */
.quick_view_product_readmore_button_container {
	float: left;
	width: 100%;
}
.quick_view_product_readmore_button_container .quick_view_readmore_button {
	/*Margin*/
	margin: <?php echo $readmore_button_margin_top; ?>px <?php echo $readmore_button_margin_right; ?>px <?php echo $readmore_button_margin_bottom; ?>px <?php echo $readmore_button_margin_left; ?>px !important;
	/*Padding*/
	padding: <?php echo $readmore_button_padding_top; ?>px <?php echo $readmore_button_padding_right; ?>px <?php echo $readmore_button_padding_bottom; ?>px <?php echo $readmore_button_padding_left; ?>px !important;
	
	/*Background*/
	background-color: <?php echo $readmore_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $readmore_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $readmore_button_bg_colour_to; ?>)
				) !important;
	background: -moz-linear-gradient(
					center top,
					<?php echo $readmore_button_bg_colour_from; ?> 20%,
					<?php echo $readmore_button_bg_colour_to; ?> 100%
				) !important;
	
		
	/*Border*/
	<?php echo $wc_qv_admin_interface->generate_border_css( $readmore_button_border ); ?>
	
	/* Shadow */
	<?php echo $wc_qv_admin_interface->generate_shadow_css( $readmore_button_shadow ); ?>
	
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $readmore_button_font ); ?>
	
	text-align: center !important;
	text-decoration: none !important;
	outline-color: transparent;
	float: left !important;
}

.quick_view_product_readmore_button_container .quick_view_readmore_link {
	padding: 0 !important;
	margin:0 !important;
	border:none !important;
	background:none !important;
	box-shadow:none !important;
	float: left;
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $readmore_link_font ); ?>
}
.quick_view_product_readmore_button_container .quick_view_readmore_link:hover {
	color: <?php echo $readmore_link_font_hover_colour; ?> !important;
}

<?php
// Product Quantity Selector Style
global $quick_view_template_quantity_selector_settings;
extract( $quick_view_template_quantity_selector_settings );
?>
/* Product Quantity Selector Style */
.quick_view_product_addtocart_container div.quantity {
<?php if ( $addtocart_alignment == 'left' ) { ?>
	float: left !important;
<?php } else { ?>
	float: none !important;
<?php } ?>
	width:auto !important;
	padding: 0 22px 0 0 !important;
	text-align:center !important;
	vertical-align:middle !important;
	position:relative !important;
	display:inline-block;
	
	/*Margin*/
	margin: <?php echo $quantity_selector_margin_top; ?>px <?php echo $quantity_selector_margin_right; ?>px <?php echo $quantity_selector_margin_bottom; ?>px <?php echo $quantity_selector_margin_left; ?>px !important;
	
	/*Background*/
	background-color: <?php echo $quantity_selector_bg_colour; ?> !important;
		
	/*Border*/
	<?php echo $wc_qv_admin_interface->generate_border_css( $quantity_selector_border ); ?>
	
	/* Shadow */
	<?php echo $wc_qv_admin_interface->generate_shadow_css( $quantity_selector_shadow ); ?>
}
.quick_view_product_addtocart_container input.qty {
	width:auto !important;
	border:none !important;
	background: none !important;
	box-shadow: none !important;
	min-height:20px !important;
	line-height:none !important;
	margin:0 !important;
	width:40px !important;
	box-sizing: content-box !important;
	
	/*Padding*/
	padding: <?php echo $quantity_input_padding_top; ?>px <?php echo $quantity_input_padding_right; ?>px <?php echo $quantity_input_padding_bottom; ?>px <?php echo $quantity_input_padding_left; ?>px !important;
	
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $quantity_input_font ); ?>
}
.quick_view_product_addtocart_container input.quick_view_plus {
	top: -1px !important;
	right: -1px !important;
}
.quick_view_product_addtocart_container input.quick_view_minus {
	bottom: -1px !important;
	right: -1px !important;
}
.quick_view_product_addtocart_container input.quick_view_minus, .quick_view_product_addtocart_container input.quick_view_plus {
	width:20px !important;
	height:16px !important;
	line-height:none !important;
	position:absolute !important;
	cursor:pointer !important;
	vertical-align:middle !important;
	margin:0 !important;
	
	/*Padding*/
	padding: <?php echo $quantity_plus_minus_padding_top; ?>px <?php echo $quantity_plus_minus_padding_right; ?>px <?php echo $quantity_plus_minus_padding_bottom; ?>px <?php echo $quantity_plus_minus_padding_left; ?>px !important;
	
	/* Font */
	<?php echo $wc_qv_fonts_face->generate_font_css( $quantity_plus_minus_font ); ?>
	
	/*Background*/
	background-color: <?php echo $quantity_plus_minus_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $quantity_plus_minus_bg_colour_from; ?>),
					color-stop(1, <?php echo $quantity_plus_minus_bg_colour_to; ?>)
				) !important;
	background: -moz-linear-gradient(
					center top,
					<?php echo $quantity_plus_minus_bg_colour_from; ?> 20%,
					<?php echo $quantity_plus_minus_bg_colour_to; ?> 100%
				) !important;
				
	/*Border*/
	<?php echo $wc_qv_admin_interface->generate_border_css( $quantity_selector_border ); ?>
	
}

/* Product Table Variations */
.quick_view_product_addtocart_container table.quick_view_table_variations {
	border:none !important;
}
.quick_view_product_addtocart_container table.quick_view_table_variations td, 
.quick_view_product_addtocart_container table.quick_view_table_variations th {
	border:none !important;
	padding: 0 5px !important;
}
.quick_view_product_addtocart_container table.quick_view_table_variations select {
	width:90% !important;
	margin:0 0 5px 0 !important;
}

@media only screen and (max-width: 600px) {
	.quick_view_product_gallery_container {
		width: 100% !important;
		float: none !important;
	}
	.quick_view_product_data_container {
		width: 100% !important;
		float: none !important;
	}
	.quick_view_control_container {
		-webkit-filter: none;
		-webkit-transition: none;
		-moz-transition: none;
		-o-transition: none;
		transition: none;
		opacity:1;
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
		filter: alpha(opacity=1);
		-moz-opacity: 1;
		-khtml-opacity: 1;
	}
}

/* Dynamic Gallery Style */
<?php
global $wc_qv_admin_interface, $wc_qv_fonts_face;
global $quick_view_template_gallery_style_settings;
global $quick_view_template_gallery_thumbnails_settings;

$g_thumb_spacing            = $quick_view_template_gallery_thumbnails_settings['thumb_spacing'];

$main_bg_color              = $quick_view_template_gallery_style_settings['main_bg_color'];
$main_border                = $quick_view_template_gallery_style_settings['main_border'];
$main_shadow                = $quick_view_template_gallery_style_settings['main_shadow'];
$main_margin_top            = $quick_view_template_gallery_style_settings['main_margin_top'];
$main_margin_bottom         = $quick_view_template_gallery_style_settings['main_margin_bottom'];
$main_margin_left           = $quick_view_template_gallery_style_settings['main_margin_left'];
$main_margin_right          = $quick_view_template_gallery_style_settings['main_margin_right'];
$main_padding_top           = $quick_view_template_gallery_style_settings['main_padding_top'];
$main_padding_bottom        = $quick_view_template_gallery_style_settings['main_padding_bottom'];
$main_padding_left          = $quick_view_template_gallery_style_settings['main_padding_left'];
$main_padding_right         = $quick_view_template_gallery_style_settings['main_padding_right'];

$navbar_font                = $quick_view_template_gallery_style_settings['navbar_font'];
$navbar_bg_color            = $quick_view_template_gallery_style_settings['navbar_bg_color'];
$navbar_border              = $quick_view_template_gallery_style_settings['navbar_border'];
$navbar_shadow              = $quick_view_template_gallery_style_settings['navbar_shadow'];
$navbar_margin_top          = $quick_view_template_gallery_style_settings['navbar_margin_top'];
$navbar_margin_bottom       = $quick_view_template_gallery_style_settings['navbar_margin_bottom'];
$navbar_margin_left         = $quick_view_template_gallery_style_settings['navbar_margin_left'];
$navbar_margin_right        = $quick_view_template_gallery_style_settings['navbar_margin_right'];
$navbar_padding_top         = $quick_view_template_gallery_style_settings['navbar_padding_top'];
$navbar_padding_bottom      = $quick_view_template_gallery_style_settings['navbar_padding_bottom'];
$navbar_padding_left        = $quick_view_template_gallery_style_settings['navbar_padding_left'];
$navbar_padding_right       = $quick_view_template_gallery_style_settings['navbar_padding_right'];

$caption_font               = $quick_view_template_gallery_style_settings['caption_font'];
$caption_bg_color           = $quick_view_template_gallery_style_settings['caption_bg_color'];
$caption_bg_transparent     = $quick_view_template_gallery_style_settings['caption_bg_transparent'];

$transition_scroll_bar      = $quick_view_template_gallery_style_settings['transition_scroll_bar'];

$thumb_show_type            = $quick_view_template_gallery_thumbnails_settings['thumb_show_type'];
$thumb_border_color         = $quick_view_template_gallery_thumbnails_settings['thumb_border_color'];
$thumb_current_border_color = $quick_view_template_gallery_thumbnails_settings['thumb_current_border_color'];

?>
#TB_window {
    width: auto !important;
}
.product .onsale {
    z-index: 100;
}
.quick_view_product_gallery_container .a3-dgallery .a3dg-image-wrapper {
	<?php echo $wc_qv_admin_interface->generate_background_color_css( $main_bg_color ); ?>
    <?php echo $wc_qv_admin_interface->generate_border_css( $main_border ); ?>
    <?php echo $wc_qv_admin_interface->generate_shadow_css( $main_shadow ); ?>
    margin: <?php echo $main_margin_top; ?>px <?php echo $main_margin_right; ?>px <?php echo $main_margin_bottom; ?>px <?php echo $main_margin_left; ?>px !important;
    padding: <?php echo $main_padding_top; ?>px <?php echo $main_padding_right; ?>px <?php echo $main_padding_bottom; ?>px <?php echo $main_padding_left; ?>px !important;
}
.quick_view_product_gallery_container .a3-dgallery .a3dg-image-wrapper .a3dg-image {
    margin-top: <?php echo $main_padding_top; ?>px !important;
}
.quick_view_product_gallery_container .a3-dgallery .a3dg-thumbs li {
    margin-right: <?php echo $g_thumb_spacing; ?>px !important;
<?php if ( 'static' == $thumb_show_type ) { ?>
    margin-bottom: <?php echo $g_thumb_spacing; ?>px !important;
<?php } ?>
}

/* Caption Text */
.quick_view_product_gallery_container .a3dg-image-wrapper .a3dg-image-description {
    <?php echo $wc_qv_fonts_face->generate_font_css( $caption_font ); ?>;
    <?php echo $wc_qv_admin_interface->generate_background_color_css( $caption_bg_color, $caption_bg_transparent ); ?>
}

/* Navbar Control */
.quick_view_product_gallery_container .product_gallery .a3dg-navbar-control {
    <?php echo $wc_qv_fonts_face->generate_font_css( $navbar_font ); ?>
    <?php echo $wc_qv_admin_interface->generate_background_color_css( $navbar_bg_color ); ?>
    <?php echo $wc_qv_admin_interface->generate_border_css( $navbar_border ); ?>
    <?php echo $wc_qv_admin_interface->generate_shadow_css( $navbar_shadow ); ?>
    margin: <?php echo $navbar_margin_top; ?>px <?php echo $navbar_margin_right; ?>px <?php echo $navbar_margin_bottom; ?>px <?php echo $navbar_margin_left; ?>px !important;
}
.quick_view_product_gallery_container .product_gallery .a3dg-navbar-control .slide-ctrl,
.quick_view_product_gallery_container .product_gallery .a3dg-navbar-control .icon_zoom {
    padding: <?php echo $navbar_padding_top; ?>px <?php echo $navbar_padding_right; ?>px <?php echo $navbar_padding_bottom; ?>px <?php echo $navbar_padding_left; ?>px !important;
}

/* Lazy Load Scroll */
.quick_view_product_gallery_container .a3-dgallery .lazy-load {
    background-color: <?php echo $transition_scroll_bar; ?> !important;
}

.quick_view_product_gallery_container .product_gallery .a3-dgallery .a3dg-thumbs li a {
    border: 1px solid <?php echo $thumb_border_color; ?> !important;
}

.quick_view_product_gallery_container .a3-dgallery .a3dg-thumbs li a.a3dg-active {
    border: 1px solid <?php echo $thumb_current_border_color; ?> !important;
}

</style>
