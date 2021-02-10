<?php

	function misfit_sc_paragraph_row_title_float( $atts, $content = null ) {
		$atts = shortcode_atts(array(
			'title_text' => '',
			'title_html_tag' => '',
		), $atts );

		if ( $atts['title_html_tag'] === '' ) :
			$atts['title_html_tag'] = 'div';
		endif;

		$html = '<'.$atts['title_html_tag'].' class="paragraph-row__title-float">'.$atts['title_text'].'</'.$atts['title_html_tag'].'>';

		return $html;
	}
	add_shortcode( 'paragraph_row_title_float', 'misfit_sc_paragraph_row_title_float' );

?>