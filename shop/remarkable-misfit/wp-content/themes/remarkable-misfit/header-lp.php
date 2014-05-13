<?php
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 */
 
 // Setup the tag to be used for the header area (`h1` on the front page and `span` on all others).
 $heading_tag = 'span';
 if ( is_home() OR is_front_page() ) { $heading_tag = 'h1'; }
 
 // Get our website's name, description and URL. We use them several times below so lets get them once.
 $site_title = get_bloginfo( 'name' );
 $site_url = home_url( '/' );
 $site_description = get_bloginfo( 'description' );
 $postid = get_the_ID();

global $postid;
//global $woo_options;
 

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php the_title(); ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php //wp_head(); ?>

<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style-lp.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/custom-lp.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/lp/css/custom.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/lp/css/custommobile.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/lp/css/customlp2.css" media="all" />

<link href='http://fonts.googleapis.com/css?family=Gentium+Book+Basic:400,400italic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="//use.typekit.net/sjv6bez.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<script type="text/javascript" src="/misfit-press/remarkable-misfit/wp-content/themes/remarkable-misfit/includes/js/superfish.js"></script>

<script>
 
    $(document).ready(function() { 
        $('ul#main-nav').superfish({
			autoArrows:  false,
		});
		
    }); 
 
</script>

<script type="text/javascript">
// if (typeof jQuery != 'undefined') {
    jQuery(document).ready(function($) {
    //     var filetypes = /\.(zip|exe|pdf|doc*|xls*|ppt*|mp3)$/i;
    //     var baseHref = '';
    //     if (jQuery('base').attr('href') != undefined)
    //         baseHref = jQuery('base').attr('href');
    //     jQuery('a').each(function() {
    //         var href = jQuery(this).attr('href');
    //         if (href && (href.match(/^https?\:/i)) && (!href.match(document.domain)) && jQuery(this).attr('class') != 'hellobar-link') {
    //             jQuery(this).click(function() {
    //                 var extLink = href.replace(/^https?\:\/\//i, '');
    //                 _gaq.push(['_trackEvent', 'External', 'Click', extLink]);
    //                 if (jQuery(this).attr('target') != undefined && jQuery(this).attr('target').toLowerCase() != '_blank') {
    //                     setTimeout(function() { location.href = href; }, 200);
    //                     return false;
    //                 }
    //             });
    //         }
    //         else if (href && href.match(/^mailto\:/i)) {
    //             jQuery(this).click(function() {
    //                 var mailLink = href.replace(/^mailto\:/i, '');
    //                 _gaq.push(['_trackEvent', 'Email', 'Click', mailLink]);
    //             });
    //         }
    //         else if (href && href.match(filetypes)) {
    //             jQuery(this).click(function() {
    //                 var extension = (/[.]/.exec(href)) ? /[^.]+$/.exec(href) : undefined;
    //                 var filePath = href;
    //                 _gaq.push(['_trackEvent', 'Download', 'Click-' + extension, filePath]);
    //                 if (jQuery(this).attr('target') != undefined && jQuery(this).attr('target').toLowerCase() != '_blank') {
    //                     setTimeout(function() { location.href = baseHref + href; }, 200);
    //                     return false;
    //                 }
    //             });
    //         }
    //         else if (href && jQuery(this).hasClass('hellobar-link')) {
                
    //         }
    //     });

        jQuery('a.hellobar-link').click(function() {
            _gaq.push(['_trackEvent', 'Kickstarter Pursuit of Everything', 'Kickstarter Hellobar', 'Clicked link to Kickstarter']);
        });

    });
//}
</script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
 <script>
    $(function() {
        $( "#progressbar" ).progressbar({
        });
    });
</script>

</head>
<body <?php body_class(); ?>>

    <div id="fb-root"></div>
    <script>
          window.fbAsyncInit = function() {
            FB.init({
        appId  : '135669679827333',
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml  : true, // parse XFBML
        //channelUrl : 'http://WWW.MYDOMAIN.COM/channel.html', // channel.html file
        oauth  : true // enable OAuth 2.0
            });
                //FB.Canvas.setAutoGrow();
                FB.Canvas.setSize({ width: 800 });
          };
          (function() {
            var e = document.createElement('script'); e.async = true;
            e.src = document.location.protocol +
              '//connect.facebook.net/en_US/all.js';
            document.getElementById('fb-root').appendChild(e);
          }());
    </script>

<?php if( get_field( "common_lp_top_line" , 'options') ): ?>
    <div class="topline">

        <h3><?php the_field('common_lp_top_line', 'options'); ?></h3>

    </div>
<?php endif; ?>

<div id="wrapper">        
    
	<div id="header" class="col-full">

	</div><!-- /#header -->