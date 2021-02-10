<?php

	function misfit_sc_column_item( $atts, $content = "" ) {

		$html = '<div class="column-content__item">' . do_shortcode( sc_anti_wpautop( $content ) ) . '</div>';

		return $html;
	}
	add_shortcode( 'column_item', 'misfit_sc_column_item' );

?>