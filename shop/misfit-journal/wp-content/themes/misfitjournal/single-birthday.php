<?php 

/* 

Template Name Posts: Birthday

*/

get_header(); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	
	
	<script src="<?php bloginfo('template_url'); ?>/js/jquery.columnizer.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(function(){
			$('.columnized').columnize({width:400});
			$('.thin').columnize({width:200});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(window).scroll(function(){
			     var top = $(this).scrollTop();
			     var shortfraction = ($(window).scrollTop() / 2);
			     var fraction = ($(window).scrollTop() / 5);
			     if(top > 0){
			        $('.dean').css('left', '-' + fraction + 'px')
			        $('.topscribble').css('top', '-' + shortfraction + 'px')  
			     }
			     
			     if(top > 150){
			       $('.earthscribble').addClass('earthslide')
			     } else {
			     	 $('.earthscribble').removeClass('earthslide')
			     }
			});		
		});
	</script>

<!-- height set -->


    		<script type="text/javascript">
			$(document).ready(function(){
			
				
				
				
				$(window).bind('scroll',function(e){
			   		parallaxScroll();
			   	});
			   	
			   	
			   	function parallaxScroll(){
			   		var scrolledY = $(window).scrollTop();
			   		var scrollBottom = $(window).scrollTop() + $(window).height();

					$('.bgWrapper').css('background-position','center -'+((scrolledY*0.2))+'px');
					//$('.birthday').css('top','-'+((scrolledY*0.1))+'px');
					$('.nibiru').css('margin-top','-'+((scrolledY*0.1))+'px');
					$('.spacecloud').css('top','-'+((scrolledY*0.3))+'px');
					$('.earth').css('top','-'+((scrolledY*0.2))+'px');
			   	}
			   	

			   	
			});
		</script>
		
<!-- height set -->

	<script id="barTmpl" type="text/x-jquery-tmpl">
		<div class="cn-bar">
			<div class="cn-nav">
				<a href="/misfit-press/misfit-journal/project/waiting-for-kerouac/" class="cn-nav-prev">
					<span>Previous</span>
					<div style="background-image:url(${prevSource});"></div> 
				</a>
				<a href="/misfit-press/misfit-journal/project/artsy-collection/" class="cn-nav-next">
					<span>Next</span>
					<div style="background-image:url(${nextSource});"></div>
				</a>
			</div><!-- cn-nav -->
			<div class="cn-nav-content">
				<div class="cn-nav-content-prev">
					<span>${prevTitle}</span>
					<h3>Waiting for Kerouac</h3>
				</div>
				<div class="cn-nav-content-next">
					<span>${nextTitle}</span>
					<h3>Art & Photography</h3>
				</div>
			</div><!-- cn-nav-content -->
		</div><!-- cn-bar -->
	</script>

</head>
<body id="birthday">

<?php include(TEMPLATEPATH . '/library/navigation.php'); ?>

		<div class="wrapper birthday">
			
			
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			
			<div class="earth"></div>
			
			
			<div class="title"></div>

			<div class="social-share-like">
					
				<ul>
					<li><div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></li>
					<li><a href="https://twitter.com/share" class="twitter-share-button" data-via="misfit_inc" data-hashtags="misfitjournal">Tweet</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
				</ul>

			</div>
						
			<p class="helloearth">Dear Earth,</p>
			
			
			<div class="narrowmarrow">
			
			
			<?php the_content(); ?>
			
			
			</div>
			
			
			<p class="helloearth">Best Wishes,</p>
			
			<div class="pandora">Pandora</div>
			
			
			<div class="spacecloud"></div>
			
			<div class="nibiru"></div>
			
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
							<img src="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/the-last-birthday.png" alt="Fiction" title="Fiction" data-thumb="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/the-last-birthday.png"/>
							<img src="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/various-pieces.png" alt="Various Pieces" title="Various Pieces" data-thumb="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/various-pieces.png"/>
							<img src="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/waiting-for-kerouac.png" alt="Poetry" title="Poetry" data-thumb="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/waiting-for-kerouac.png"/>
						</div><!-- cn-images -->
					</div><!-- cn-slideshow -->
				</div>
			</div>
			
		</div><!-- end birthday wrapper -->	
	


	<?php get_footer(); ?>
	
	