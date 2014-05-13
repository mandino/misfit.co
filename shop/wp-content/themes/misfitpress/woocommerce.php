<?php 

/* Template Name: Woo

*/

global $post;
$terms = wp_get_post_terms( $post->ID, 'product_cat' );
foreach ( $terms as $term ) $categories[] = $term->slug;

?>

 <?php if ( is_product_category('misfit-journal') || in_array( 'misfit-journal', $categories ) ) { ?>

 	<?php get_header('misfit-journal'); ?>

 	<?php get_template_part('misfit-journal/misfit-journal-woocommerce') ?>

 	<?php get_footer('misfit-journal'); ?>

 <?php } elseif ( is_product_category('remarkable-misfit') || in_array( 'remarkable-misfit', $categories ) ) { ?>

 	<?php get_header('remarkable-misfit'); ?>

 	<?php get_template_part('remarkable-misfit/remarkable-misfit-woocommerce') ?>

 	<?php get_footer('remarkable-misfit'); ?>

 <?php } else { ?>

 	<?php get_header(); ?>

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


	</head>
	<body id="home" class="misfit-commerce">
		
		
		<?php include(TEMPLATEPATH . '/library/navigation.php'); ?>
				
			<div class="wrapper home">

				
				
			
				<div class="innerwrapper">
				
				
					<div class="stage pages">
					
						<div class="contentarena">
						
							<div class="logowelcome">
								
								<h1>Misfit</h1>
								<h2>Journal</h2>
								
								<p class="edition">Edition I</p>
							
							</div>
							
						
						</div>
						
						
						
						<div class="pagecontainer <?php if(is_product()) { echo 'woocommerce'; } ?>">
							
							
							<?php if ( !sizeof( $woocommerce->cart->cart_contents ) == 0 ) { ?>
						
						<div class="quickbuttons">		
							<a href="<?php bloginfo ('url'); ?>/checkout/">Checkout</a>
							<a href="<?php bloginfo ('url'); ?>/cart">View Cart</a>
						</div>
						
						<?php } ?>
				
				
							<?php woocommerce_content(); ?>	
							
							<div class="clear"></div>
						
						</div>
						
						
					<div class="littlehenry">
						
						
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

 <?php } ?>