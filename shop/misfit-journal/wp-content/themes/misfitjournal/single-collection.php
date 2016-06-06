<?php 

/* 

Template Name Posts: Quarterly Collection

*/

get_header(); ?>




<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	<script src="<?php bloginfo('template_url'); ?>/js/view.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		
			$('.artmaker').bind('inview', function (event, visible) {
			  if (visible == true) {
			    	$(this).addClass("wendigo")
				 
				 				 
			  	} else {
			  		
			  		$(this).removeClass("wendigo")
				
			  }
			});	

		});
	</script>


  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.onepage-scroll.js"></script>
  <link href='<?php bloginfo('template_url'); ?>/js/onepage-scroll.css' rel='stylesheet' type='text/css'>
  <style>
    html {
      height: 100%;
    }

    .wrapper {
    	height: 100% !important;
    	height: 100%;
    	margin: 0 auto; 
    	overflow: hidden;
    }
    
    a {
      text-decoration: none;
    }
    
    
       .pointer {
      color: #9b59b6;
      font-family: 'Pacifico', cursive;
      font-size: 30px;
      margin-top: 15px;
    }
    code {
      margin: 20px 1%;
      float: left;
      width: 48%;
      height: 105px;
      background: rgba(0,0,0,0.1);
      border: rgba(0,0,0,0.05) 5px solid;
      border-radius: 5px;
      padding:5px;
      color: white;
      text-align: center;
      font-size: 15px;
      margin-top: 25px;
      display: block;
      box-sizing: border-box;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
    }
    code.html {
      color: #7EC9E6;
    }
    code.js {
      color: #FFAD00;
    }

    .main {
      float: left;
      width: 100%;
      margin: 0 auto;
    }
    
        .reload.bell {
      font-size: 12px;
      padding: 20px;
      width: 45px;
      text-align: center;
      height: 47px;
      border-radius: 50px;
      -webkit-border-radius: 50px;
      -moz-border-radius: 50px;
    }
    
    .reload.bell #notification {
      font-size: 25px;
      line-height: 140%;
    }
    
    .reload, .btn{
      display: inline-block;
      border: 4px solid #A2261E;
      border-radius: 5px;
      -moz-border-radius: 5px;
      -webkit-border-radius: 5px;
      background: #CC3126;
      display: inline-block;
      line-height: 100%;
      padding: 0.7em;
      text-decoration: none;
      color: #fff;
      width: 100px;
      line-height: 140%;
      font-size: 17px;
      font-family: open sans;
      font-weight: bold;
    }
    .reload:hover{
      background: #444;
    }
    .btn {
      width: 200px;
      color: rgb(255, 255, 255);
      border: 4px solid rgb(0, 0, 0);
      background: rgba(3, 3, 3, 0.75);
    }
    .clear {
      width: auto;
    }
    .btn:hover, .btn:hover {
      background: #444;
    }
    .btns {
      width: 410px;
      margin: 50px auto;
    }
    .credit {
      text-align: center;
      color: rgba(0,0,0,0.5);
      padding: 10px;
      width: 410px;
      clear: both;
    }
    .credit a {
      color: rgba(0,0,0,0.85);
      text-decoration: none;
      font-weight: bold;
      text-align: center;
    }
    
    .back {
      position: absolute;
      top: 0;
      left: 0;
      text-align: center;
      display: block;
      padding: 7px;
      width: 100%;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
      background: rgba(255, 255, 255, 0.25);
      font-weight: bold;
      font-size: 13px;
      color: #000;
      -webkit-transition: all 500ms ease-in-out;
      -moz-transition: all 500ms ease-in-out;
      -o-transition: all 500ms ease-in-out;
      transition: all 500ms ease-in-out;
    }
    .back:hover {
      color: black;
      background: rgba(255, 255, 255, 0.5);
    }
    
    header {
      position: relative;
      z-index: 10;
    }
    .main section .page_container {
      position: relative;
      top: 25%;
      margin: 0 auto 0;
      max-width: 950px;
      z-index: 3;
    }
    .main section  {
      overflow: hidden;
    }
    
    .main section > img {
      position: absolute;
      max-width: 100%;
      z-index: 1;
    }
    
    .main section.page1 {
      background:rgb(230, 217, 200);
    }
       .main section .page_container .btns {
      clear: both;
      float: left;
      text-align: center;
      width: 435px;
    }
    .main section .page_container .btns a{
      text-align: center;
    }
    .    .main section.page2 > img {
      position: absolute;
      top: -300px;
      left: 50%;
      margin-left: -1095px;
    }
    .main section.page2 .page_container {
      margin-top: 240px;
      overflow: hidden;
    }
   
    .viewing-page-2 .back{
      background: rgba(0, 0, 0, 0.25);
      color: #FFF;
      }
    
    .main section.page3 .page_container {
      overflow: hidden;
      width: 500px;
      right: -285px;
    }
    
	</style>
	<script>
	  $(document).ready(function(){
      $(".main").onepage_scroll({
        sectionContainer: "section"
      });
		});
		
	</script>

</head>
<body id="collection">


<?php include(TEMPLATEPATH . '/library/navigation.php'); ?>


  <div class="wrapper">
	  <div class="main">
	    
      <!-- <section class="page1">
        
        
        	<div class="collectionwelcome">
        	
        		<div class="social-share-like">
              
                  <ul>
                    <li><div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></li>
                    <li><a href="https://twitter.com/share" class="twitter-share-button" data-via="misfit_inc" data-hashtags="misfitjournal">Tweet</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
                  </ul>

                </div>

        		<h2>A Collection of Art & Photography</h2>
        		
        		<p>A small collection of a few of the amazing pieces published in this quarter's Misfit Journal. To see them all, grab the Printed edition or the digital.</p>
        		
        		<img class="sw" src="<?php // bloginfo('template_url'); ?>/images/collection_sword.png" />
        		
        		
        		<br>
        		
        		<br>
        		
        		<h4>Start Scrolling &hellip;</h4>
        	
        	
        	</div>        
        
      </section> -->
      
        
      <section class="page2">
        
            <div class="social-share-like">

              <ul>
                <li><div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></li>
                <li><a href="https://twitter.com/share" class="twitter-share-button" data-via="misfit_inc" data-hashtags="misfitjournal">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
              </ul>

            </div>
        
        	<div class="secback" style="background: url(<?php bloginfo('template_url'); ?>/images/collection_stripped.jpg) center top no-repeat; height: 100%; width: 100%; background-size: 100%;">
        	
        	
        		<h2 class="artmaker">Stripped<a href="http://www.flickr.com/photos/tkharpene/" target="_blank"><span>Fred Byrd</span></a></h2>
        	
        	
        	</div>
        
        
        
      </section>
	    
	    <section class="page3">

            <div class="social-share-like">

              <ul>
                <li><div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></li>
                <li><a href="https://twitter.com/share" class="twitter-share-button" data-via="misfit_inc" data-hashtags="misfitjournal">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
              </ul>

            </div>

	      <div class="secback" style="background: url(<?php bloginfo('template_url'); ?>/images/collection_faith.jpg) center top no-repeat; height: 100%; width: 100%; background-size: 100%;">
        	
        	
        	<h2 class="artmaker">Leap of Faith<a href="http://sursanchari.wordpress.com/" target="_blank"><span>Sanchari Sur</span></a></h2>
        	
        	
        	</div>
        </section>
	    
	    <section class="page4">

            <div class="social-share-like">

              <ul>
                <li><div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></li>
                <li><a href="https://twitter.com/share" class="twitter-share-button" data-via="misfit_inc" data-hashtags="misfitjournal">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
              </ul>

            </div>
	      
            <div class="secback" style="background: url(<?php bloginfo('template_url'); ?>/images/collection_spirit.jpg) center top no-repeat; height: 100%; width: 100%; background-size: 100%;">
        	
        	<h2 class="artmaker">Becoming a True Spirit<a href="http://www.coreybarksdale.com/" target="_blank"><span>Corey Barksdale</span></a></h2>
        	
        	</div>
  
        </section>
      
  	    <section class="page5">

            <div class="social-share-like">

              <ul>
                <li><div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></li>
                <li><a href="https://twitter.com/share" class="twitter-share-button" data-via="misfit_inc" data-hashtags="misfitjournal">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
              </ul>

            </div>
	      
	      <div class="secback" style="background: url(<?php bloginfo('template_url'); ?>/images/collection_pygmalion.jpg) center top no-repeat; height: 100%; width: 100%; background-size: 100%;">
        	
        	
        	<h2 class="artmaker">Pygmalion<a href="http://sursanchari.wordpress.com/" target="_blank"><span>Sanchari Sur</span></a></h2>
        	
        	
        	</div>
  
        </section>
      
       <!-- <section class="page6">

            <div class="social-share-like">

              <ul>
                <li><div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></li>
                <li><a href="https://twitter.com/share" class="twitter-share-button" data-via="misfit_inc" data-hashtags="misfitjournal">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
              </ul>

            </div>        
        
        	<div class="collectionwelcome">
        	
	
        		<div class="contentarena">
					
						<div class="logowelcome">
							
							<h1>Misfit</h1>
							<h2>Journal</h2>
							
							<p class="edition">Edition I</p>
						
						</div>
						
						<ul class="linkers">
							
							<?php query_posts('post_type=article'); if(have_posts()) : while(have_posts()) : the_post(); ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span><?php echo get_post_meta($post->ID, 'cebo_authorname', true); ?></span></li>
							
							<?php endwhile; endif; wp_reset_query(); ?>
						
						</ul>
					
					</div>
        	
        	</div>        
        
      </section> -->
    </div>




	<?php get_footer(); ?>
	
	