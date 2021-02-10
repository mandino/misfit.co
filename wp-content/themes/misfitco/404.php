<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<section class="error-page grid-x align-middle align-center text-center">
	<div class="error-page__shape-1">
		<img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/404-shape-1.png" alt="Shape 1">
	</div>

	<div class="error-page__container cell small-12">
		<h1 class="error-page__title">404</h1>
		<h2 class="error-page__subtitle">Page not found</h2>

		<p>The page you were looking <br/>for doesn't exist.</p>
	</div>

	<div class="error-page__shape-2">
		<img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/404-shape-2.png" alt="Shape 2">
	</div>
</section>

<?php get_footer('blank');