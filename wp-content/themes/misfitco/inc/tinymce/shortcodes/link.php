<?php

	function misfit_sc_link( $atts, $content = "" ) {
		$atts = shortcode_atts(array(
			'link_url' => '',
			'link_text' => '',
			'open_in_new_tab' => '',
		), $atts );

		// OPEN IN NEW TAB
		$open_in_new_tab = '';
		if ( $atts['open_in_new_tab'] == 'true' ) :
			$open_in_new_tab = 'target="_blank"';
		endif;

		$html = '<a ' . $open_in_new_tab . ' class="link" href="' . $atts['link_url'] . '"><span>' . $atts['link_text'] . '</span></a>';

		return $html;
	}
	add_shortcode( 'link', 'misfit_sc_link' );