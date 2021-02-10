<?php

	function misfit_sc_excerpt_container( $atts, $content = "" ) {
		return '<div class="excerpt-container">'. do_shortcode( sc_anti_wpautop( $content ) ) .'</div>';
	}
	add_shortcode( 'excerpt_container', 'misfit_sc_excerpt_container' );

?>