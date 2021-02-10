<?php

	function misfit_sc_bullet_gray( $atts, $content = "" ) {
		return '<div class="bullet-gray">'. do_shortcode( sc_anti_wpautop( $content ) ) .'</div>';
	}
	add_shortcode( 'bullet_gray', 'misfit_sc_bullet_gray' );

?>