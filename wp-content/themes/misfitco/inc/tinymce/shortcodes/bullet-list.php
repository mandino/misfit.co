<?php

	function misfit_sc_bullet_list( $atts, $content = "" ) {

    return '<div class="bullet-list">'. do_shortcode( sc_anti_wpautop( $content ) ) .'</div>';
	}
	add_shortcode( 'bullet_list', 'misfit_sc_bullet_list' );

?>