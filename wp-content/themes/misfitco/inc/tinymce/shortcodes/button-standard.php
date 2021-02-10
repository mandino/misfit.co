<?php

	function misfit_sc_button_standard( $atts, $content = "" ) {
		$atts = shortcode_atts(array(
			'button_size' => '',
			'button_color' => '',
			'link_url' => '',
			'link_text' => '',
			'open_in_new_tab' => '',
		), $atts );

		$button_class = array('button button-button');

		// SIZE
		if ( $atts['button_size'] != '' ) :
			$button_class[] = 'button-button--' . $atts['button_size'];
		endif;

		// COLOR
		if ( $atts['button_color'] != '' ) :
			$button_class[] = 'button--' . $atts['button_color'];
		endif;

		// OPEN IN NEW TAB
		$open_in_new_tab = '';
		if ( $atts['open_in_new_tab'] == 'true' ) :
			$open_in_new_tab = 'target="_blank"';
		endif;

		$html = '<a ' . $open_in_new_tab . ' class="' . implode(' ', $button_class) . '" href="' . $atts['link_url'] . '"><span>' . $atts['link_text'] . '</span></a>';

		return $html;
	}
	add_shortcode( 'button_standard', 'misfit_sc_button_standard' );