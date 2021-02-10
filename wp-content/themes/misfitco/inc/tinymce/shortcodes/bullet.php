<?php

	function misfit_sc_bullet( $atts, $content = "" ) {
		return '<div class="bullet">'. do_shortcode( sc_anti_wpautop( $content ) ) .'</div>';
	}
	add_shortcode( 'bullet', 'misfit_sc_bullet' );

?>