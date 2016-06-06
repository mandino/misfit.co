<?php 

/* 

Template Name Posts: Kerouac

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

	<script id="barTmpl" type="text/x-jquery-tmpl">
		<div class="cn-bar">
			<div class="cn-nav">
				<a href="/misfit-press/misfit-journal/project/why-we-fail/" class="cn-nav-prev">
					<span>Previous</span>
					<div style="background-image:url(${prevSource});"></div> 
				</a>
				<a href="/misfit-press/misfit-journal/project/the-last-birthday/" class="cn-nav-next">
					<span>Next</span>
					<div style="background-image:url(${nextSource});"></div>
				</a>
			</div><!-- cn-nav -->
			<div class="cn-nav-content">
				<div class="cn-nav-content-prev">
					<span>${prevTitle}</span>
					<h3>Why we Fail</h3>
				</div>
				<div class="cn-nav-content-next">
					<span>${nextTitle}</span>
					<h3>The Last Birthday</h3>
				</div>
			</div><!-- cn-nav-content -->
		</div><!-- cn-bar -->
	</script>

</head>
<body id="kerouac">

<?php include(TEMPLATEPATH . '/library/navigation.php'); ?>

		<div class="wrapper kerouac">
			
			<div class="dean"></div>
			
			<div class="poetrycontainer">
			
				<h1 class="salparadise"></h1>

				<div class="social-share-like">
					
					<ul>
						<li><div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></li>
						<li><a href="https://twitter.com/share" class="twitter-share-button" data-via="misfit_inc" data-hashtags="misfitjournal">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
					</ul>

				</div>				 

				<?php if(have_posts()) : while(have_posts()) : the_post(); ?>					
				
				<?php the_content(); ?>
				
				<?php endwhile; endif; wp_reset_query(); ?>	
			
			</div>
			
		</div><!-- end kerouac wrapper -->

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
						<img src="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/waiting-for-kerouac.png" alt="Poetry" title="Poetry" data-thumb="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/waiting-for-kerouac.png"/>
						<img src="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/the-last-birthday.png" alt="Fiction" title="Fiction" data-thumb="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/the-last-birthday.png"/>
						<img src="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/why-we-fail.png" alt="Non-Fiction" title="Non-Fiction" data-thumb="<?php bloginfo ('template_url'); ?>/images/circlehover/thumbs/why-we-fail.png"/>
					</div><!-- cn-images -->
				</div><!-- cn-slideshow -->
			</div>
		</div>

	<?php get_footer(); ?>