<?php

	function misfit_sc_column_container( $atts, $content = "" ) {
		$atts = shortcode_atts(array(
			'colcount' => ''
		), $atts );

		if ( $atts['colcount'] ) :
			$col = 'column-content--' . $atts['colcount'];
		endif;

		$html = '<div class="column-content ' . $col . '">' . do_shortcode( sc_anti_wpautop( $content ) ) . '</div>';

		return $html;
	}
	add_shortcode( 'column_container', 'misfit_sc_column_container' );

?>