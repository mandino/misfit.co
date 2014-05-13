<?php 

/* Template Name: Submit Page

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

	<?php include(TEMPLATEPATH . '/library/navigation.php'); ?>
			
		<div class="wrapper home">
		
			<div class="innerwrapper">
			
				<div class="stage pages">
				
					<div class="contentarena">
					
						<div class="logowelcome">
							
							<!-- <a href="/misfit-press/misfit-journal/">
								<h1>Misfit</h1>
								<h2>Journal</h2>
								<p class="edition">Edition I</p>
							</a> -->
						
						</div>
					
					</div>
					
					<div class="pagecontainer woocommerce">
					
						<?php if ( !sizeof( $woocommerce->cart->cart_contents ) == 0 ) { ?>
							<a href="<?php bloginfo ('url'); ?>/checkout/">Checkout</a>
							<a href="<?php bloginfo ('url'); ?>/cart">View Cart</a>
						<?php } ?>
					
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
						
						<h1><?php the_title(); ?></h1>
						<h2>edition 4</h2>
						
						<?php the_content(); ?>
						
						<?php endwhile; endif; wp_reset_query(); ?>	
						
						<iframe id="podioWebForm548349779168" class="podio-webform-frame" scrolling="no" height="770" frameborder="0" src="https://podio.com/webforms/7149759/548349?e=true#http%3A%2F%2Faj-leon.com%2Fmisfit-press%2Fmisfit-journal%2Fsubmit%2F" allowtransparency="true">
						</iframe>
						
					</div>
					
				</div>
				
				<div id="background"></div>
			    <div id="midground"></div>
				
			</div><!-- end innerwrapper-->
			
		</div><!-- end wrapper -->
		
<?php include(TEMPLATEPATH . '/library/lower-navigation.php'); ?>

<?php get_footer(); ?>