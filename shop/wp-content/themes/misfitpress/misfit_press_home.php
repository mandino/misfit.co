<?php 

/* Template Name: Misfit Press Home

*/

get_header(); ?>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- #content Starts -->
    <div id="content">
	
		<header id="header">
		
			<img class="logo" src="<?php the_field('splash_logo_image', 'options'); ?>"/>
			
			<img class="sub-title" src="<?php the_field('splash_sub_title', 'options'); ?>" />
			
			<img class="henry" src="<?php the_field('splash_henry_logo', 'options'); ?>" />
			
		</header>
		
    	<div id="container">
		
			<p><?php the_field('splash_paragraph_text', 'options'); ?></p>
		
		</div><!-- /#container -->
		
    </div><!-- /#content -->
		
<?php get_footer(); ?>