<?php 

/* Template Name: Edition 1 Home

*/
 get_header(); ?>

<!-- javascript -->
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.min.js"></script>


<!-- height set -->

<script type="text/javascript">
	$(document).ready(function(){
		 
		 function thirty_pc() {
			    var height = $(window).height();
			    var thirtypc = (100 * height) / 100 - 70;
				var fiddypc = thirtypc + 12;
				// 92 Default
			    thirtypc = parseInt(thirtypc) + 'px';
			    $(".innerwrapper").css('height',thirtypc);
				$(".stage").css('height',fiddypc);
			}
			
			$(document).ready(function() {
			    thirty_pc();
			    $(window).bind('resize', thirty_pc);
			});
			
			// $(".contentarena").hover(function() {
		 // 		$(".littlehenry").stop().animate({ left: "20%" }, 300);
		 // 		$(".dragon").stop().animate({ width: "952px"  }, 600);
		 		
		 // 		},function(){
		 // 		$(".dragon").stop().animate({ width: "912px" }, 600);
		 // 		$(".littlehenry").stop().animate({ left: "25%" }, 300);
		 
		 // 	});
		 	
		 	// $(".subscribe").hover(function() {
		 	// 	$(".littlehenry").stop().animate({ left: "30%" }, 600);
		 	// 	$(".dragon").stop().animate({ width: "842px"  }, 600);
		 		
		 	// 	},function(){
		 	// 	$(".dragon").stop().animate({ width: "912px" }, 600);
		 	// 	$(".littlehenry").stop().animate({ left: "20%" }, 600);
		 
		 	// });
	});
</script>


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
<body id="home" class="front-page">
	
	
	<?php include(TEMPLATEPATH . '/library/navigation.php'); ?>
			
		<div class="wrapper home">
		
			
		
			<div class="innerwrapper">
			
			
				<div class="stage">
				
				
				
					<div class="contentarena">
					
						<div class="logowelcome">
							
							<h1>Misfit</h1>
							<!-- <h2>Journal</h2> -->
							
							<p class="edition">Edition I</p>
						
						</div>
						
						<ul class="linkers">
							
							
							<?php // query_posts('post_type=article'); if(have_posts()) : while(have_posts()) : the_post(); ?>
							<!--<li><a href="<?php // the_permalink(); ?>"><?php // the_title(); ?></a><span><?php // echo get_post_meta($post->ID, 'cebo_authorname', true); ?></span></li> -->
							
							<?php // endwhile; endif; wp_reset_query(); ?>	
							
							<p>A tri-annual creative arts journal dedicated to showcasing the work of artistic Misfits. This site gives you a sneak peek into the pages of our beautiful Journal. If you would like to support this piece of work you can can purchase a digital or print subscription.</p>
							
						</ul>
					
					</div>
				
					<div class="dragon">
					
					
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
		
		
		<?php include(TEMPLATEPATH . '/library/lower-navigation.php'); ?>


		<?php get_footer(); ?>