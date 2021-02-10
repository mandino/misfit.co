<?php

	function misfit_sc_drop_cap_background( $atts, $content = "" ) {
		$atts = shortcode_atts(array(
			'letter' => '',
		), $atts );

		$html = '<span class="dropcap-blue">' . $atts['letter'] . '</span>';

		return $html;
	}
	add_shortcode( 'drop_cap_background', 'misfit_sc_drop_cap_background' );

?>