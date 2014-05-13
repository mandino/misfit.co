<?php
/**
 * The template for displaying the footer.
 *
**/
?>

	
	<?php wp_footer(); ?>
	
	<!-- Map Box -->
	<script src='//api.tiles.mapbox.com/mapbox.js/v1.6.1/mapbox.js'></script>
	<script type="text/javascript">
		var map = L.mapbox.map('map', 'melissaleon.haj74972')
			.setView([36.809, -100.107], 4);
	</script>
	
	<!-- Facebook -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1450884048460359";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<!-- Animated Border Menus -->
	<script type="text/javascript" src="<?php bloginfo ('template_url'); ?>/js/borderMenu.js"></script>
	<script type="text/javascript" src="<?php bloginfo ('template_url'); ?>/js/classie.js"></script>
	
	<!-- Fancybox -->
	<script type="text/javascript" src="<?php bloginfo ('template_url'); ?>/js/jquery.fancybox.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo ('template_url'); ?>/css/jquery.fancybox.css" media="screen" />
	<script type="text/javascript">
		$(document).ready(function() {
			$(".homebutton.social-button").click(function() {
				type : 'iframe',
				padding : 5,
				widthL '300px',
				heightL '200px',
			});
		});
	</script>
	
	<!-- primarynav fix function -->
	<script type="text/javascript">
		window.onload = function() {
			$('.primarynav li:eq(0) .upswing h1').text('Why we Fail');
			$('.primarynav li:eq(1) .upswing h1').text('Waiting for Kerouac');
			$('.primarynav li:eq(2) .upswing h1').text('The Last Birthday');
			$('.primarynav li:eq(3) .upswing h1').text('Artsy Collection');
		};
	</script>
	
	<!-- Distributors page function -->
	<script type="text/javascript">
		/*
		function distheight() {
		
			var mapheight = $( window ).height();
			var topdivheight = $('#map-desc').height();
			var titleh2height = $('.map-container .title-wrap').height();
			var mapheight = mapheight - topdivheight - titleh2height;
			
			$('.map-container').css('height', mapheight);
		}
		
		$(document).ready(function() {
			distheight();
			$(window).bind('resize', distheight);
		});
		*/
	</script>
	
	<!-- Circle Navigation Effect -->
	<script type="text/javascript" src="<?php bloginfo ('template_url'); ?>/js/jquery.slideshow.js"></script>
	<script type="text/javascript" src="<?php bloginfo ('template_url'); ?>/js/jquery.tmpl.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$('#cn-slideshow').slideshow();
		});
	</script>
</body>
</html>