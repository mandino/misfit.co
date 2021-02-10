<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// SOURCES
// https://codex.wordpress.org/Plugin_API/Filter_Reference/mce_external_plugins
// https://codex.wordpress.org/Function_Reference/add_shortcode

	// REGISTER SHORTCODES TO TINYMCE JS

		add_action( 'admin_init', 'misfit_shortcodes_button' );

		function misfit_shortcodes_button() {
			if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
				add_filter( 'mce_buttons', 'misfit_register_shortcodes_button' );
				add_filter( 'mce_external_plugins', 'misfit_add_shortcodes_button' );
			}
		}

		function misfit_register_shortcodes_button( $buttons ) {
			array_push( $buttons, 'shortcodes' );
			return $buttons;
		}

		function misfit_add_shortcodes_button( $plugin_array ) {
			$plugin_array['shortcodes'] = get_template_directory_uri() . '/inc/tinymce/shortcodes.js';
			return $plugin_array;
		}


	// ADD SHORTCODES

		// include( get_template_directory() . '/inc/tinymce/shortcodes/button-standard.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/button-plain-arrow.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/button-outline.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/link.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/highlight.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/highlight-box.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/clear.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/bullet.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/bullet-gray.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/bullet-big.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/bullet-2-column-gray.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/bullet-2-column-check.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/separator.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/paragraph-row-title-float.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/drop-cap-background.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/drop-cap.php' );
		include( get_template_directory() . '/inc/tinymce/shortcodes/column-container.php' );
		include( get_template_directory() . '/inc/tinymce/shortcodes/column-item.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/box-title-content.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/excerpt-container.php' );
		// include( get_template_directory() . '/inc/tinymce/shortcodes/bullet-list.php' );