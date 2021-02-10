<?php

	function misfit_sc_highlight_box( $atts, $content = null ) {
		$atts = shortcode_atts(array(
			'html_title_tag' => 'h4',
			'title' => 'Enter Title Here'
		), $atts );

		$class = array('highlight-box');

		$html = '<div class="highlight-box grid-x align-center">' .
							'<div class="highlight-box__container cell small-12 medium-8 large-8 xlarge-12 xxlarge-12">' .
								'<span class="highlight-box__btn"></span>' .
								'<'. $atts['html_title_tag'] .' class="highlight-box__heading">' .
									$atts['title'] .
								'</'. $atts['html_title_tag'] .'>' .
								'<div class="highlight-box__content">' .
									$content .
								'</div>' .
							'</div>' .
						'</div>';

		return $html;
	}
	add_shortcode( 'highlight_box', 'misfit_sc_highlight_box' );