<?php
	global $postid;
	$postid = get_the_ID();
?>
<!DOCTYPE html>
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
	
	<!-- Meta
	================================================== -->
	
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- Default CSS
	================================================== -->
	<link href='<?php echo get_template_directory_uri(); ?>/remarkable-misfit/style.css' rel='stylesheet' type='text/css'>
	
	<!-- Favicons
	================================================== -->
	
	<link rel="shortcut icon" href="<?php global $data; echo $data['custom_favicon']; ?>">
	<link rel="apple-touch-icon" href="<?php get_template_directory_uri(); ?>/remarkable-misfit/assets/img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php get_template_directory_uri(); ?>/remarkable-misfit/assets/img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php get_template_directory_uri(); ?>/remarkable-misfit/assets/img/apple-touch-icon-114x114.png">

	<!-- Google Fonts
	================================================== -->
	<link href='http://fonts.googleapis.com/css?family=Gentium+Book+Basic:400italic' rel='stylesheet' type='text/css'>

<?php wp_head(); ?>

	<!-- Custom CSS
	================================================== -->
	<link href='<?php echo get_template_directory_uri(); ?>/remarkable-misfit/custom.css' rel='stylesheet' type='text/css'>

	<!-- Custom CSS
	================================================== -->
	<link href='<?php echo get_template_directory_uri(); ?>/remarkable-misfit/css/woocommerce.css' rel='stylesheet' type='text/css'>

</head>

<body <?php body_class(); ?> >