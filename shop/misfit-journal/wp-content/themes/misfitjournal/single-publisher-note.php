<?php 

/* 

Template Name: Publisher Note 

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
<body id="home" class="publisher-note">
	
	
	<?php include(TEMPLATEPATH . '/library/navigation.php'); ?>
			
		<div class="wrapper home">

			
			
		
			<div class="innerwrapper">
			
			
				<div class="stage pages">
				
					<div class="contentarena">
					
						<div class="logowelcome">
							
							<a href="/misfitjournal.com">
								<h1>Misfit</h1>
								<h2>Journal</h2>
								
								<p class="edition">Edition I</p>
							</a>
						
						</div>
						
					
					</div>

					<div class="pagecontainer woocommerce">
					
					
					<?php if ( !sizeof( $woocommerce->cart->cart_contents ) == 0 ) { ?>
					
					<div class="quickbuttons">		
						<a href="<?php bloginfo ('url'); ?>/checkout/">Checkout</a>
						<a href="<?php bloginfo ('url'); ?>/cart">View Cart</a>
					</div>
					
					<?php } ?>
					
						
					
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
						
						<h1 style="text-align: center; margin-bottom: 20px;"><?php the_title(); ?></h1>
						
							<?php the_content(); ?>
						
						<?php endwhile; endif; wp_reset_query(); ?>	
						
						
					
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

		<?php include(TEMPLATEPATH . '/library/lower-navigation.php'); ?>
				
			</div><!-- end innerwrapper-->
			
		</div><!-- end wrapper -->	

		<?php get_footer(); ?>