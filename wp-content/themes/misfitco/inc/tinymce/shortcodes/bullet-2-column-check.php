<?php

	function misfit_sc_bullet_2_column_check( $atts, $content = "" ) {
        $atts = shortcode_atts(array(
                'title' => ''
        ), $atts );

        $html = '<div class="bullet-2-col-check">';
        $html .= '<div class="bullet-title"><span>' .$atts['title'] . '</span></div>';
        $html .= do_shortcode( sc_anti_wpautop( $content ) ) .'</div>';

        return $html;
	}
	add_shortcode( 'bullet_2_column_check', 'misfit_sc_bullet_2_column_check' );

?>