<?php 

/* 404 Page Template 

*/
 get_header(); ?>


<!-- javascript -->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

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

		$('#background').css("background-position",-current+"px 0");
		$('#foreground').css("background-position",currents+"px 0");
		$('#midground').css("background-position",-currenta+"px 0");
	}

	var init = setInterval("scrollBg()", scrollSpeed);
</script>

<link rel="stylesheet" type="text/css" href="/shop/misfit-journal/wp-content/themes/misfitjournal/css/style.css">
<link rel="stylesheet" type="text/css" href="/shop/misfit-journal/wp-content/themes/misfitjournal/css/media.css">

</head>

<body id="the-dragon-ate-our-page">
			
		<div class="wrapper home">
			<div class="innerwrapper">
				<div class="stage pages">
					<div class="pagecontainer woocommerce">

						<div class="dragon" style="width: 912px;"></div>					
						
						<h1 style="text-align: center; margin-bottom: 20px;">Sorry! We think the dragon ate it. ;)</h1>
						
						<p>That big meanie dragon up there probably ate the page that you were looking for. You could visit the following pages below instead.</p>
						
						<a class="back" href="http://misfit.co/shop/shop/">Click here to go back</a>
						
						<script>
						$(document).ready(function(){
							$('a.back').click(function(){
								parent.history.back();
								return false;
							});
						});
						</script>

						<?php wp_nav_menu( array( 'theme_location' => 'page-list' ) ); ?>

					</div>
					
				</div>
				
				<!-- floating clouds -->
				
				<div id="background"></div>
			    <div id="midground"></div>
			    <div id="foreground"></div>
				
				<!-- end floating clouds -->
				
			</div><!-- end innerwrapper-->
			
		</div><!-- end wrapper -->	

		<!-- end floating clouds -->
				
			</div><!-- end innerwrapper-->
			
		</div><!-- end wrapper -->	

		<?php get_footer('404'); ?>