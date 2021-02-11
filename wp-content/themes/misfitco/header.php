<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>
		<?php wp_title(); ?>
	</title>

	<?php
		echo '<style>';
		require get_stylesheet_directory() . '/assets/css/critical.css.php';
		echo '</style>';
	?>

	<link rel="preload" id="style" href="<?= get_stylesheet_directory_uri(); ?>/assets/css/style.css" as="style" media="screen" crossorigin="anonymous">
	<link rel="shortcut icon" href="<?= get_stylesheet_directory_uri(); ?>/assets/images/favicon_studio-misfit.png">

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			var this_preload = document.querySelectorAll('link[rel="preload"][as="style"]');
			for ( var i = 0; i < this_preload.length; i++ ) {
				var preload = this_preload[i];
				preload.rel = 'stylesheet';
			}
			this_preload.forEach(function(preload) { //IE 11: forEach Object doesn't support this property or method
				preload.rel = 'stylesheet';
			});
		});

		var url_vars = {
			'get_stylesheet_directory_uri': '<?= get_stylesheet_directory_uri(); ?>',
			'ajax_url' : '<?= admin_url( 'admin-ajax.php' ); ?>'
		};
	</script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-134694881-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-134694881-1');
	</script>

	<noscript>
		<link rel="preload" type="text/css" media="screen" href="<?= get_stylesheet_directory_uri(); ?>/assets/css/style.css">
		<link rel="preload" type="text/css" media="screen" href="<?= get_stylesheet_directory_uri(); ?>/assets/css/components.css">
	</noscript>

	<?php 
		wp_head();
	?>
</head>

<body <?php body_class(); ?>>
	<main class="wrapper">