<?php if ( ! defined( 'ABSPATH' ) ) exit;

$orientations = [
	'portrait' => 'portrait',
	'landscape' => 'landscape',
	'square' => 'square'
];

$sizes = [
	'xs' => [320, 180],
	'small' => [640, 360],
	'medium' => [1024, 576],
	'large' => [1280, 720],
	'xl' => [1366, 768],
	'xxl' => [1440, 900],
	'xxxl' => [1920, 1080],
];

foreach ($orientations as $orientation) {
	foreach ($sizes as $key => $size) {
		if($orientation === 'portrait') {
			add_image_size( $orientation . '-' . $key, $size[1], $size[0]);
			add_image_size( $orientation . '-' . $key . '-cropped', $size[1], $size[0]);
		} elseif($orientation === 'landscape') {
			add_image_size( $orientation . '-' . $key, $size[0], $size[1]);		
			add_image_size( $orientation . '-' . $key . '-cropped', $size[0], $size[1]);		
		} else {
			add_image_size( $orientation . '-' . $key, $size[0], $size[0]);		
			add_image_size( $orientation . '-' . $key . '-cropped', $size[0], $size[0]);
		}
	}
}

function picture($src, $orientation, $max_size = 'xxxl', $cropped = false, $lazy_load = true, $class = '') {
	
	global $sizes, $orientations;
	$new_sizes = $sizes;
	// var_dump($new_sizes);
	$srcset = '';

	$size_key = array_search($max_size, array_keys($new_sizes), true) + 1;
	// ( ($size_key + 1) <= count($new_sizes) ) ? $size_key = $size_key+1 : '';
	$new_sizes = array_slice($new_sizes, 0, $size_key, true);

	foreach ($new_sizes as $key => $size) {

		if($orientation === 'portrait') {
			if($cropped) {
				if($key === $max_size) {
					$srcset .= '<source media="(max-width: '. $size[0] .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'">';
					$srcset .= '<source media="(min-width: '. ($size[0]+1) .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'">';
				} else {
					$srcset .= '<source media="(max-width: '. $size[0] .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'">';
				}
			} else {
				if($key === $max_size) {
					$srcset .= '<source media="(max-width: '. $size[0] .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key] .'">';
					$srcset .= '<source media="(min-width: '. ($size[0]+1) .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key] .'">';
				} else {
					$srcset .= '<source media="(max-width: '. $size[0] .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key] .'">';
				}
			}
		} else {
			if($cropped) {
				if($key === $max_size) {
					$srcset .= '<source media="(max-width: '. $size[0] .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'">';
					$srcset .= '<source media="(min-width: '. ($size[0]+1) .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'">';
				} else {
					$srcset .= '<source media="(max-width: '. $size[0] .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'">';
				}
			} else {
				if($key === $max_size) {
					$srcset .= '<source media="(max-width: '. $size[0] .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key] .'">';
					$srcset .= '<source media="(min-width: '. ($size[0]+1) .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key] .'">';
				} else {
					$srcset .= '<source media="(max-width: '. $size[0] .'px)" srcset="'. $src['sizes'][$orientations[$orientation] . '-' . $key] .'">';
				}
			}
		}
	}

	if ($class)
		$class = 'class="' . $class . '"';
	else
		$class = '';

	echo '
		<picture class="'. (($lazy_load) ? 'lozad' : '') .'" '. (($lazy_load) ? 'style="display: block; min-height: 1rem"' : '') .' data-iesrc="'. $src['sizes'][$orientations[$orientation] . '-' . 'large'] .'" data-src="'. $src['sizes'][$orientations[$orientation] . '-' . 'large'] .'" data-alt="'. $src['alt'] .'">'.
		$srcset .
				(($lazy_load) 
					? '' 
					: '<img src="'. $src['sizes'][$orientations[$orientation] . '-' . 'xs'] .'" alt="'. $src['alt'] .'" ' . $class . ' />')
			.'
		</picture>
	';

}

function responsive_background_image($src, $orientation, $target_class, $max_size = 'xxxl', $cropped = false, $lazy_load = true) {
	
	global $sizes, $orientations;
	$new_sizes = $sizes;
	$srcset = '';

	$size_key = array_search($max_size, array_keys($new_sizes), true) + 1;
	// ( ($size_key + 1) === count($new_sizes) ) ? $size_key = $size_key+1 : '';
	$new_sizes = array_slice($new_sizes, 0, $size_key, true);

	// var_dump($src);
	// var_dump($orientation);
	// var_dump($target_class);
	// var_dump($max_size);
	// var_dump($cropped);
	// var_dump($lazy_load);
	// var_dump($size_key);
	// var_dump($sizes);

	foreach ($new_sizes as $key => $size) {
		if($orientation === 'portrait') {
			if($cropped) {
				if($key === $max_size) {
					$srcset .= '@media only screen and (max-width: '. $size[0] .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'\'); } }';
					$srcset .= '@media only screen and (min-width: '. ($size[0]+1) .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'\'); } }';
				} else {
					$srcset .= '@media only screen and (max-width: '. $size[0] .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'\'); } }';
				}
			} else {
				if($key === $max_size) {
					$srcset .= '@media only screen and (max-width: '. $size[0] .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key] .'\'); } }';
					$srcset .= '@media only screen and (min-width: '. ($size[0]+1) .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key] .'\'); } }';
				} else {
					$srcset .= '@media only screen and (max-width: '. $size[0] .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key] .'\'); } }';
				}
			}
		} else {
			if($cropped) {
				if($key === $max_size) {
					$srcset .= '@media only screen and (max-width: '. $size[0] .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'\'); } }';
					$srcset .= '@media only screen and (min-width: '. ($size[0]+1) .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'\'); } }';
				} else {
					$srcset .= '@media only screen and (max-width: '. $size[0] .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key . '-cropped'] .'\'); } }';
				}
			} else {
				if($key === $max_size) {
					$srcset .= '@media only screen and (max-width: '. $size[0] .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key] .'\'); } }';
					$srcset .= '@media only screen and (min-width: '. ($size[0]+1) .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key] .'\'); } }';
				} else {
					$srcset .= '@media only screen and (max-width: '. $size[0] .'px) { .'. $target_class .'{ background-image:url(\''. $src['sizes'][$orientations[$orientation] . '-' . $key] .'\'); } }';
				}
			}
		}
	}

	echo '<style>'. $srcset .'</style>';
}