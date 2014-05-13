<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html lang="en" class="ie ie6"> <![endif]--> 
<!--[if IE 7 ]>	<html lang="en" class="ie ie7"> <![endif]--> 
<!--[if IE 8 ]>	<html lang="en" class="ie ie8"> <![endif]--> 
<!--[if IE 9 ]>	<html lang="en" class="ie ie9"> <![endif]--> 
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title>
		<?php global $page, $paged; wp_title( '|', true, 'right' ); bloginfo( 'name' );
	
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
	
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'cebolang' ), max( $paged, $page ) );
		?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if (get_option('cebo_custom_favicon') == '') { ?>
	
	<link rel="icon" href="<?php bloginfo ('template_url'); ?>/cebo_options/<?php bloginfo ('template_url'); ?>/images/admin_sidebar_icon.png" type="image/x-ico"/>
	
	<? } else { ?>
	
	<link rel="icon" href="<?php echo get_option('cebo_custom_favicon'); ?>" type="image/x-ico"/>
	
	<? } ?>
	
	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('cebo_feedburner_url') <> "" ) { echo get_option('cebo_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
	
	
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo ('template_url'); ?>/css/style.css">
	
	<!-- fonts -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo ('template_url'); ?>/css/fonts.css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">	
	
	<!-- responsive style -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo ('template_url'); ?>/css/media.css">

	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Gentium+Basic:400,400italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Montaga' rel='stylesheet' type='text/css'>

	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->

	<!-- Colorbox -->
	<link href="<?php bloginfo( 'template_directory' ); ?>/includes/js/colorbox/colorbox.css" type="text/css" rel="stylesheet">
	<script src="<?php bloginfo( 'template_directory' ); ?>/includes/js/jquery.colorbox-min.js"></script>
		<script>
		$(document).ready(function(){
		  $("a.colorbox").colorbox({
		  		iframe:true, 
		  		height:"340px",
		  		width:'90%',
		  });
		});
	</script>


	<!-- Typekit -->
	<script type="text/javascript" src="//use.typekit.net/rew5cmp.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>


	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php if( is_home() || is_front_page() ) { ?>
		<style type="text/css">
			/* Default */
			body {
				background: url('<?php the_field('splash_desktop_image', 'options'); ?>') no-repeat center center fixed #000000;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
		</style>
	<?php } ?>








		<?php
			/****************** DO NOT REMOVE **********************
			/* We add some JavaScript to pages with the comment form
			 * to support sites with threaded comments (when in use).
			 */
			if ( is_singular() && get_option( 'thread_comments' ) )
				wp_enqueue_script( 'comment-reply' );
			wp_head();
		?>
		</head>

		<body <?php body_class(); ?>>
	
			<?php if( is_home() || is_front_page() ) { ?>
				<div id="mobilebg"></div>

				<?//php woo_top(); ?>
				<div id="wrapper">

					<div id="inner-wrapper">
			<?php } ?>