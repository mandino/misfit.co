<?php

if ( have_rows('flexible_content') ) : while ( have_rows('flexible_content') ) : the_row();

	$row_layout = get_row_layout();
	$row_layout_file = str_replace('_', '-', $row_layout);
	$template_part = get_stylesheet_directory() . '/inc/flexible-content/'. $row_layout_file .'.php';

	require $template_part;

endwhile; endif;