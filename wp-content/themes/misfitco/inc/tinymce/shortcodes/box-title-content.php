<?php

	function misfit_sc_box_title_content( $atts, $content = "" ) {
		$atts = shortcode_atts(array(
			'title' => ''
		), $atts );

		$html = '<div class="box-tc">';
		$html .= '<div class="box-tc__titlebox"><span class="box-tc__title">' . $atts['title'].'</span></div>';
		$html .= '<div class="box-tc__content">';
		$html .= do_shortcode( sc_anti_wpautop( $content ) ); 
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
	add_shortcode( 'box_title_content', 'misfit_sc_box_title_content' );

?>