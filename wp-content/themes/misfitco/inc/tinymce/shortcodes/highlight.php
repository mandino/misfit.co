<?php

	function misfit_sc_highlight( $atts, $content = "" ) {
		$atts = shortcode_atts(array(
			'highlight_color' => '',
		), $atts );

		$html = '<span class="highlight highlight--' . $atts['highlight_color'] . '">' . do_shortcode( $content ) . '</span>';

		return $html;
	}
	add_shortcode( 'highlight', 'misfit_sc_highlight' );

?>