<?php
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */
 
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
	
	<!-- Favicons
	================================================== -->
	
	<link rel="shortcut icon" href="<?php global $data; echo $data['custom_favicon']; ?>">
	<link rel="apple-touch-icon" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon-114x114.png">

	<!-- Google Fonts
	================================================== -->
	<link href='http://fonts.googleapis.com/css?family=Gentium+Book+Basic:400,400italic' rel='stylesheet' type='text/css'>

<?php wp_head(); ?>

	<!-- Custom CSS
	================================================== -->
	<link href='<?php echo get_template_directory_uri(); ?>/custom.css' rel='stylesheet' type='text/css'>

</head>

<body <?php body_class(); ?> >

	<?php if (is_front_page()) { ?>
		
		<div class="header-background-image"><div class="top-credit-container"><a style="bottom: 80px;" target="_blank" href="http://www.jalanpaul.com/" class="photo-credit">Photo by J. Alan Paul Photography</a></div></div>
		
	<?php } else { ?>
	
		<div class="header-background-image-inner"></div>
	
	<?php } ?>
	
		<header id="header-global" role="banner">
		
			<div id="header-background">
		
				<div class="logo-icons container">
				
					<div class="row">
					
						<!-- <div class="header-logo eight columns">
							
							<?php if ($data['text_logo']) { ?>
								<div id="logo-default"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></div>
							<?php } elseif ($data['custom_logo']) { ?>
								<div id="logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $data['custom_logo']; ?>" alt="Header Logo" /></a></div>
							<?php } ?>
						  	
						</div> --><!-- end .header-logo -->

						<?php if ($data['text_uber_statement']) { ?>
							<h2 id="uber-statement"><?php echo $data['text_uber_statement']; ?></h2>
						<?php } ?>

						<div class="watch-video-area">
							<a class="watch-video nomobile" href="<?php the_field('home_watch_video_url', 'options'); ?>" target="_blank"><?php the_field('home_watch_video_text', 'options'); ?></a>
							
							<a class="watch-video gomobile threetwenty" href="<?php the_field('home_watch_video_url', 'options'); ?>" target="_blank"><?php the_field('home_watch_video_text', 'options'); ?></a>
							
							<a class="watch-video gomobile foureighty" href="<?php the_field('home_watch_video_url', 'options'); ?>" target="_blank"><?php the_field('home_watch_video_text', 'options'); ?></a>

							<div style='display:none'>
								<div id='inline_content' style='padding:10px; background:#fff;'>
									<iframe src="http://player.vimeo.com/video/70337545?portrait=0&amp;color=86c543" width="600" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
								</div>
							</div>

						</div>
						
					</div><!-- end .row -->
					
				</div><!-- end .logo-icons container -->
			
			</div><!-- end #header-background -->
			
			<div id="header-background-nav">
			
				<div class="container">
				
					<div class="row">
						
						<nav id="header-navigation" class="sixteen columns" role="navigation">
								
						<?php if (is_front_page()) { ?>
							
							<?php
							$header_menu_args = array(
							    'menu' => 'Header',
							    'theme_location' => 'Front',
							    'container' => false,
							    'menu_id' => 'navigation'
							);
							
							wp_nav_menu($header_menu_args);
							?>
							
						<?php } else { ?>
						
							<?php
							$header_menu_args = array(
							    'menu' => 'Header',
							    'theme_location' => 'Inner',
							    'container' => false,
							    'menu_id' => 'navigation'
							);
						
						wp_nav_menu($header_menu_args);
						?>
						
						<?php } ?>
				
						</nav><!-- end #header-navigation -->
						
					</div><!-- end .row -->
				
				</div><!-- end .container -->
			
			</div><!-- end #header-background-nav -->
				
		</header><!-- end #header-global -->
	