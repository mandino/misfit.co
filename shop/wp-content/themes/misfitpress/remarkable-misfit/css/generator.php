<?php 
    $content_width = intval ( filter_input(INPUT_GET, 'content_width', FILTER_SANITIZE_NUMBER_INT) );
    if ( $content_width > 0 ) { /* Has legitimate width */ } else { $content_width = 960; } // Default Width
    header("Content-type: text/css; charset: UTF-8");
?>
@media only screen and (min-width: 768px) {
	#wrapper #main.fullwidth, #wrapper .layout-full #main, #wrapper .col-full { max-width: <?php echo $content_width; ?>px; }
}
@media only screen and (min-width: <?php echo ($content_width + 440); ?>px) {
	#wrapper.floated-header  { position: relative; }
	#wrapper.floated-header #content  { padding-top: 3em; }
	#wrapper.floated-header #header  {
	    position: absolute; padding: 0;
	    z-index: 999;
 	    width: 170px;
  	    left: 50%;
  	    top: 0;
  	    margin-left: -<?php echo ($content_width / 2 + 210); ?>px; /*half the width*/
	}
	#wrapper.floated-header.fixed #header  { position: fixed; }
	#wrapper.floated-header #logo, #wrapper.floated-header hgroup, #wrapper.floated-header #navigation, #wrapper.floated-header .search_main  { float: none!important; }
	#wrapper.floated-header #logo  { width: 100%; padding: 2em 0; text-align: center; }
	#wrapper.floated-header hgroup  { margin: 1em 0; width: 100%; text-align: center; }
	#wrapper.floated-header #navigation  { top: 0; margin: 0 0 10px; padding: 0 0 5px; }
	#wrapper.floated-header #navigation li  { float: none!important; margin: 0!important; }
	#wrapper.floated-header #navigation li a  { border-radius: 0; -moz-border-radius: 0; -webkit-border-radius: 0; }
	#wrapper.floated-header #navigation li ul  { position: relative; width: 150px; border-radius: 0; -moz-border-radius: 0; -webkit-border-radius: 0; }
	#wrapper.floated-header #navigation li ul a  { width: 160px; }
	#wrapper.floated-header #navigation li ul a:after { right: 10px; }
	#wrapper.floated-header #navigation li ul ul  { position: absolute; margin-left: 160px; border-radius: 0 3px 3px 3px; -moz-border-radius: 0 3px 3px 3px; -webkit-border-radius: 0 3px 3px 3px; }
	#wrapper.floated-header #navigation li ul.fixed-hover  { display: block; }
	#wrapper.floated-header .search_main  { top: 0; margin: 0 0 10px; padding: 10px; }
	#wrapper.floated-header .search_main input.s  { padding-right: 0; width: 60%; }
	#wrapper.floated-header .comments.bubble  { display: none; }
	#wrapper.floated-header .post-more .comments  { display: inline; }
	#wrapper.floated-header .post blockquote,
  	#wrapper.floated-header .type-page blockquote  { margin: 1em 0 2em 0; padding: 15px 20px 1px 50px; }
  	#wrapper.floated-header ul.mini-cart  { top: 0; }
	#wrapper.floated-header ul.mini-cart a.cart-parent  { float: none; }
	#wrapper.floated-header ul.mini-cart ul.cart_list  { position: relative; top: 0; left: 0; width: auto; background: none; font-size: 0.8em; }
}
.ie8 #wrapper #main.fullwidth, .ie8 #wrapper .layout-full #main, .ie8 #wrapper .col-full { max-width: <?php echo $content_width; ?>px; }
