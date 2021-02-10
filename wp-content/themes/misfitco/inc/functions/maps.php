<?php

// Neighborhood Location

function ajax_locations() {
	global $post, $sitepress;

	$category_slug = $_POST['category_slug'];
	$person_slug = $_POST['person_slug'];

	$ajax_locations_query = new WP_Query(array(
		'post_type' => 'locations',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		// 'suppress_filters' => false,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'loctype',
				'field' => 'slug',
				'terms' => array($category_slug),
			),
			array(
				'taxonomy' => 'locper',
				'field' => 'slug',
				'terms' => array($person_slug),
			),
		),
	));

	if ( $ajax_locations_query->have_posts()) : while ( $ajax_locations_query->have_posts() ) : $ajax_locations_query->the_post();

		$location_image = getImageValues( get_field('location_image') );
		$location_distance_label = get_field('location_distance_label');
		$location_link_label = get_field('location_link_label');

		// Link Open New Tab

		if ( get_field('location_open_new_tab') ) :

			$location_open_new_tab = 'target="_blank"';

		else :

			$location_open_new_tab = 'target="_self"';

		endif;


		// Link Type

		if ( get_field('location_link_type') == 'custom_link' ) :

			$location_page_link = get_field('location_custom_link');

		elseif ( get_field('location_link_type') == 'page_link' ) :

			$location_page_link = get_field('location_page_link');

		else :

			$location_page_link = '';

		endif;


		// Distance Open New Tab

		if ( get_field('location_distance_open_new_tab') ) :

			$location_distance_open_new_tab = 'target="_blank"';

		else :

			$location_distance_open_new_tab = 'target="_self"';

		endif;


		// Distance Coordinates Type

		if ( get_field('location_distance_coordinates_type') == 'custom_coordinates' ) :

			$location_distance_latitude = get_field('location_distance_latitude');
			$location_distance_longitude = get_field('location_distance_longitude');
			$link_coordinates = '';

		elseif ( get_field('location_distance_coordinates_type') == 'backend_coordinates' ) :

			$location_distance_latitude = get_field('location_latitude');
			$location_distance_longitude = get_field('location_longitude');
			$link_coordinates = '';

		elseif ( get_field('location_distance_coordinates_type') == 'link_coordinates' ) :

			$location_distance_latitude = '';
			$location_distance_longitude = '';
			$link_coordinates = get_field('location_distance_link');

		else :

			$location_distance_latitude = '';
			$location_distance_longitude = '';
			$link_coordinates = '';

		endif;
	?>

		<div class="neighborhood__location-item" data-count="<?= $ajax_locations_query->post_count; ?>">
			<div class="neighborhood__location-image" style="background-image: url(<?= $location_image['url']; ?>)">
				<img src="<?= $location_image['url']; ?>" alt="<?= $location_image['alt']; ?>" class="img-hidden">

				<?php if ( $location_distance_label ) : ?>
					<div class="neighborhood__distance">
						<div class="neighborhood__distance-inner">
							<?php if ($link_coordinates) { ?><a href="<?= $link_coordinates; ?>"><?php } ?>
								<span><?= $location_distance_label; ?></span>
							<?php if ($link_coordinates) { ?></a><?php } ?>
						</div>
						
						<?php if ( $location_distance_latitude && $location_distance_longitude ) : ?>
							<a href="//www.google.com/maps/place/<?= $location_distance_latitude; ?>,<?= $location_distance_longitude; ?>" <?= $location_distance_open_new_tab; ?>></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="neighborhood__location-content">
				<?php if ( get_field('location_title') ) : ?>
					<h2><?php the_field('location_title'); ?></h2>
				<?php endif; ?>	

				<?php the_field('location_content'); ?>

				<?php if ( $location_link_label ) : ?>
					<a href="<?= $location_page_link; ?>" class="btn btn--highlight btn--highlight-hover btn--text-black" <?= $location_open_new_tab; ?>><?= $location_link_label; ?></a>
				<?php endif; ?>
			</div>

			<?php if ( $location_distance_label ) : ?>
				<div class="neighborhood__distance">
					<div class="neighborhood__distance-inner">
						<?php if ($link_coordinates) { ?><a href="<?= $link_coordinates; ?>"><?php } ?>
							<span><?= $location_distance_label; ?></span>
						<?php if ($link_coordinates) { ?></a><?php } ?>
					</div>
					
					<?php if ( $location_distance_latitude && $location_distance_longitude ) : ?>
						<a href="//www.google.com/maps/place/<?= $location_distance_latitude; ?>,<?= $location_distance_longitude; ?>" <?= $location_distance_open_new_tab; ?>></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

	<?php endwhile; else : ?>

		<div class="neighborhood__location-item" data-count="0">
			<span class="neighborhood__location-error"><?php _e('Sorry no locations available!', 'amapa'); ?></span>
		</div>

	<?php endif; wp_reset_postdata(); die();
}

add_action('wp_ajax_ajax_locations','ajax_locations');
add_action('wp_ajax_nopriv_ajax_locations','ajax_locations');


function ajax_locations_coordinates() {
	$neighborhood_query = new WP_Query(array(
		'post_type' => 'locations',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'loctype',
				'field' => 'slug',
				'terms' => $_POST['category_slug']
			),
			array(
				'taxonomy' => 'locper',
				'field' => 'slug',
				'terms' => $_POST['person_slug']
			),
		),
	));

		$locations = array();

			if ( $neighborhood_query->have_posts() ) : while ( $neighborhood_query->have_posts() ) : $neighborhood_query->the_post();

				$get_loc_person_slug = $_POST['person_slug'];
				$get_loc_location_slug = $_POST['category_slug'];
				$loc_title = str_replace("'", "\'", get_field('location_title'));
				$get_latitude = get_field('location_latitude');
				$get_longitude = get_field('location_longitude');
				$get_icon = get_get_template_directory_uri() . '/images/gmaps/mi-tan.png';
				$get_image = getImageValues( get_field('location_image') );

				if ( $get_latitude && $get_longitude ) :
					$locations[] = array(
							'category' => $get_loc_location_slug,
							'person' => $get_loc_person_slug,
							'lat' => $get_latitude,
							'lng' => $get_longitude,
							'title' => $loc_title,
							'icon' => $get_icon,
							'image' => $get_image['url']
						);
				endif;

			endwhile; endif; wp_reset_postdata();

		echo json_encode($locations);
		die();
}

add_action('wp_ajax_ajax_locations_coordinates','ajax_locations_coordinates');
add_action('wp_ajax_nopriv_ajax_locations_coordinates','ajax_locations_coordinates');