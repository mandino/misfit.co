<?php 

/* 

Template Name Posts: Why We Fail

*/


get_header(); ?>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	
	
	<!-- <script src="<?php // bloginfo('template_url'); ?>/js/jquery.columnizer.js" type="text/javascript" charset="utf-8"></script> -->
	<script type="text/javascript">
		/*$(function(){
			$('.columnized').columnize({width:400});
			$('.thin').columnize({width:200});
		});*/
	</script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery-scrolltofixed.js" type="text/javascript"></script>
	<script>
	    $(document).ready(function() {
	
	        // Dock the header to the top of the window when scrolled past the banner.
	        // This is the default behavior.
	
	        $('.header').scrollToFixed();
	
	
	        // Dock the footer to the bottom of the page, but scroll up to reveal more
	        // content if the page is scrolled far enough.
	
	        $('.footer').scrollToFixed( {
	            bottom: 0,
	            limit: $('.authorbox').offset().top
	        });
	
	
	        // Dock each summary as it arrives just below the docked header, pushing the
	        // previous summary up the page.
	
	        var summaries = $('.earthscribbling');
	        summaries.each(function(i) {
	            var summary = $(summaries[i]);
	            var next = summaries[i + 1];
	
	            summary.scrollToFixed({
	                marginTop: $('.topnav').outerHeight(true) + 10,
	                limit: function() {
	                    var limit = 0;
	                    if (next) {
	                        limit = $(next).addClass('fn').offset().top - $(this).outerHeight(true) + 510;
	                      
	                    } else {
	                        limit = $('.end').offset().top - $(this).outerHeight(true) - 10;
	                    }
	                    return limit;
	                },
	                zIndex: 999
	            });
	        });
	    });
	</script>
	<script src="<?php bloginfo('template_url'); ?>/js/view.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		
			$('blockquote').bind('inview', function (event, visible) {
			  if (visible == true) {
			    	$(this).addClass("appearman")
				  	$(".earthscribble").addClass("eartharrive")
				 				 
			  	} else {
			  		
			  		$(this).removeClass("appearman")
				  	$(".earthscribble").removeClass("eartharrive")
			  }
			});


			$(window).scroll(function(){
			     var top = $(this).scrollTop();
			     var shortfraction = ($(window).scrollTop() / 2);
			     var fraction = ($(window).scrollTop() / 5);
			     if(top > 0){
			        $('.topscribble').css('left', fraction + 'px')
			        $('.topscribble').css('top', '-' + shortfraction + 'px')  
			     }
			     
			     if(top > 400){
			        
			        
			     }
			   
			    
			});	
			
				

		});
	</script>
	
<!-- height set -->
	
	<script id="barTmpl" type="text/x-jquery-tmpl">
		<div class="cn-bar">
			<div class="cn-nav">
				<a href="/misfit-press/misfit-journal/project/waiting-for-kerouac/" class="cn-nav-next">
					<span>Next</span>
					<div style="background-image:url(${nextSource});"></div>
				</a>
			</div><!-- cn-nav -->
			<div class="cn-nav-content">
				<div class="cn-nav-content-next">
					<span>${nextTitle}</span>
					<h3>Waiting for Kerouac</h3>
				</div>
			</div><!-- cn-nav-content -->
		</div><!-- cn-bar -->
	</script>


</head>
<body id="fail">



	<?php include(TEMPLATEPATH . '/library/navigation.php'); ?>

	<div class="wrapper whyfail">
		
			<div class="topscribble"></div>
			
			<div class="leftscribble"></div>
			
			<div class="earthscribbler">
			
			
			
			</div>
			
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			
			<div class="container">
				
				<h1 class="failheader"><?php the_title(); ?></h1>
				
				<h3 class="authmeta"><?php echo get_post_meta($post->ID, 'cebo_authorname', true); ?></h3>
				
				<h2 class="tagger">Education, A Failed System</h2>

				<div class="social-share-like">
					
					<ul>
						<li><div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></li>
						<li><a href="https://twitter.com/share" class="twitter-share-button" data-via="misfit_inc" data-hashtags="misfitjournal">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
					</ul>

				</div>
				
				<div class="inner">
				
					<div class="columnized">
					
					
						<?php the_content(); ?>					
				
					</div>
					
				</div>

			</div>
			
			<?php endwhile; endif; wp_reset_query(); ?>
			
			<div class="authorbox">
				
				<div class="container">
				
					<div class="pichalf">
						<img src="<?php echo get_post_meta($post->ID, 'cebo_authorpic', true); ?>" />
					</div>
					
					<div class="contenthalf">
					
						<h2><?php echo get_post_meta($post->ID, 'cebo_authorname', true); ?></h2>
						
						<p class="authmeta"><?php echo get_post_meta($post->ID, 'cebo_authorbio', true); ?></p>
					
					</div>
					
					<div class="clear"></div>
				
				</div>
				
			</div>
			
			<div class="cn-container">
				<div class="cn-wrapper">
					<div id="cn-slideshow" class="cn-slideshow">
						<div class="cn-images">
							<img src="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/1.jpg" alt="Non-Fiction" title="Non-Fiction" data-thumb="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/1.jpg"/>
							<img src="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/waiting-for-kerouac.png" alt="Poetry" title="Poetry" data-thumb="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/waiting-for-kerouac.png"/>
						</div><!-- cn-images -->
					</div><!-- cn-slideshow -->
				</div>
			</div>
			
		</div><!-- end fail wrapper -->
		


	<?php get_footer(); ?>
	
	