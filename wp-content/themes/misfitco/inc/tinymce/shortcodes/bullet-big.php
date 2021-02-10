<?php

	function misfit_sc_bullet_big( $atts, $content = "" ) {
		return '<div class="bullet-big">'. do_shortcode( sc_anti_wpautop( $content ) ) .'</div>';
	}
	add_shortcode( 'bullet_big', 'misfit_sc_bullet_big' );

?>