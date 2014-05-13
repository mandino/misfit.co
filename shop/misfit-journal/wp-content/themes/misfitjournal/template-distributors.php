<?php
/* Template Name: Distributors Page */
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
	
		<div class="map-container">
			
			<h2>Misfit Journal Around the World</h2>
			
			<div id="map-content-area">
			
				<div class="map-wrap">
					<div id="map"></div>
				</div>
				
				<div class="map-podio-form">
					<p>Misfit Press products are sold exclusively in independent, artisan shops because we&lsquo;re an independent, artisan Publishing House. We are building up physical distributors and are accepting requests from independent shops and bookstores all around the world. If you like what you see here and you are a business owner, don&lsquo;t hesitate to reach out.</p>
				
					<script src="https://podio.com/webforms/5618089/440811.js"></script>
					<script type="text/javascript">
						_podioWebForm.render("440811")
					</script>
				</div>
			</div>
		
		</div>
			
		<div id="background"></div>
		<div id="midground"></div>
		
	<?php include(TEMPLATEPATH . '/library/lower-navigation.php'); ?>
		
<?php get_footer(); ?>