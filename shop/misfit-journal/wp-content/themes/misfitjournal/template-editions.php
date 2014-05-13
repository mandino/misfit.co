<?php
/*
Template Name: Editions Page
*/
get_header(); ?>

<!-- javascript -->
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.min.js"></script>

<!-- moving clouds -->

<script type="text/javascript" charset="utf-8">
	var scrollSpeed = 70;
	var step = 1;
	var steps = 3;
	var current = 100;
	var currents =  800;
	var currenta = 100;
	var imageWidth = 2247;
	var headerWidth = 800;		

	var restartPosition = -(imageWidth - headerWidth);

	function scrollBg(){
		current -= step;
		if (current == restartPosition){
			current = 0;
		}
			
		currents -= step;
		if (currents == restartPosition){
			currents = 0;
		}	
		currenta -= steps;
		if (currenta == restartPosition){
			currenta = 0;
			
		}

		$('#background').css("background-position",-current+"px 5%");
		//$('#foreground').css("background-position",currents+"px 0");
		//$('#midground').css("background-position",-currenta+"px 0");
	}

	var init = setInterval("scrollBg()", scrollSpeed);
</script>

</head>

<body id="home" <?php body_class(); ?>>

	<?php include (TEMPLATEPATH . '/library/navigation-sidebar.php'); ?>
	
	<section id="section-4">
	
		<div class="edition-header-text">
			<p>The Misfit is a tri-annual creative arts journal dedicated to showcasing the work of artistic Misfits.<br>
			We are a home for the scribblers, sketchers and snappers who are in it for the love of the craft.</p>
		</div>
	
		<div class="portfoliocontainer">
			<!-- div class portfolio item -->
			
			<div class="portfolio-item">
				<div class="portfolio-shade"></div>
				<a href="#"></a>
				<div class="portimg" style="background-image: url('<?php bloginfo ('template_url'); ?>/images/editions/misfit-edition-one.png');"></div>
				<h3>Edition 1</h3>
				<h1>Available Now</h1>
				
				<div class="overlay">
					<div class="smallview">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-pinterest"></i></a>
						<a href="/misfit-press/product/misfit-journal-digital-subscription"><i class="fa fa-shopping-cart"></i></a>
					</div>
							
					<div class="bigview">
						<a href="#"><i class="fa fa-chevron-right"></i></a>
					</div>
					
					<div class="clear"></div>
				</div>
			</div>
			
			<!-- div class portfolio item -->
			
			<div class="portfolio-item">
				<div class="portfolio-shade"></div>
				<a href="#"></a>
				<div class="portimg" style="background-image: url('<?php bloginfo ('template_url'); ?>/images/editions/misfit-edition-two.png');"></div>
				<h3>Edition 2</h3>
				<h1>Coming in March 2014</h1>
				
				<div class="overlay">
					<div class="smallview">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-pinterest"></i></a>
					</div>
					
					<div class="bigview">
						<a href="#"><i class="fa fa-chevron-right"></i></a>
					</div>
					
					<div class="clear"></div>
				</div>
			</div>
			
			<!-- div class portfolio item -->
			
			<div class="portfolio-item">
				<div class="portfolio-shade"></div>
				<a href="#"></a>
				<div class="portimg" style="background-image: url('<?php bloginfo ('template_url'); ?>/images/editions/misfit-edition-three.png');"></div>
				<h3>Edition 3</h3>
				<h1>Coming in May 2014</h1>
				
				<div class="overlay">
					<div class="smallview">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-pinterest"></i></a>
					</div>
					
					<div class="bigview">
						<a href="#"><i class="fa fa-chevron-right"></i></a>
					</div>
					
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</section>
	
	<div id="background"></div>
	<div id="midground"></div>
	
	<!-- Editions page function -->
	<script type="text/javascript">
		/*
		function distheight() {
		
			var mapheight = $( window ).height();
			var bottomheight = $('.bottomnav').height();
			var mapheight = mapheight - bottomheight - 35;
			
			$('#section-4').css('height', mapheight);
		}
		
		$(document).ready(function() {
			distheight();
			$(window).bind('resize', distheight);
		});
		*/
	</script>
	
	<?php include(TEMPLATEPATH . '/library/lower-navigation.php'); ?>
	
<?php get_footer(); ?>