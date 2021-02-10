<?php

	function misfit_sc_clear( $atts, $content = "" ) {
		return '<div class="clear"></div>';
	}
	add_shortcode( 'clear', 'misfit_sc_clear' );

?>