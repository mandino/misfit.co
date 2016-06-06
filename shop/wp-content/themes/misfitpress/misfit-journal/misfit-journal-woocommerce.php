<?php 

/* Template Name: Journal Product

*/

?>

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

			$('#background').css("background-position",-current+"px 0");
			//$('#midground').css("background-position",-currenta+"px 0");
			//$('#foreground').css("background-position",currents+"px 0");
		}

		var init = setInterval("scrollBg()", scrollSpeed);
	</script>


	</head>
	<body id="home" class="misfit-commerce commerce <?php if (is_shop()) { echo 'shop-commerce'; } elseif(is_product()) { echo 'product-single'; } else {} ?>">
	
	<?php if (is_shop()) { include(TEMPLATEPATH . '/misfit-journal/shop-additionals.php'); } ?>
		
		<?php if (is_shop()) {}
			  elseif (get_the_ID($product_id) == '46' OR '47') {}
			  else { include(TEMPLATEPATH . '/library/navigation.php');
		} ?>
		
		<?php if (is_shop()) {} else { ?>
		
			<div class="wrapper home">
			
				<div class="innerwrapper">
				
					<div class="stage pages">
					
						<div class="contentarena">
						
							<!-- <div class="logowelcome">
								
								<h1>Misfit</h1>
								<h2>Journal</h2>
								<p class="edition">Edition I</p>
							
							</div> -->
							
						
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
						
						
					<!-- <div class="littlehenry"></div> -->
					
					</div>
					
					<!-- floating clouds -->
					
					<?php if (is_shop()) {} elseif(is_product()) {} else {
						echo '<div id="background"></div><div id="background"></div><div id="midground"></div>';
					} ?>
					
					<!-- end floating clouds -->
					
				</div><!-- end innerwrapper-->
				
			</div><!-- end wrapper -->	

			<!-- end floating clouds -->
			
			
			<?php if (get_the_ID($product_id) == '46' OR '47') {}
				  else { include(TEMPLATEPATH . '/library/lower-navigation.php');
			} ?>
			
		<?php } ?>
