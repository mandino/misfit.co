<?php
/**
 * Template Name: Share Page
 */

 get_header();
 global $woo_options;
 
 $postid = get_the_ID();
 global $postid;
 
?>

	<div class="wrapper">
		<div class="stripes"></div>
		
		<header>
		
			<h2><?php the_field('share_header_title', $postid); ?></h2>
			
		</header>
		
		<div class="inner-wrapper">
		
		<div class="share-content">
		
			<div class="text-container">
					<img src="<?php the_field('share_aj_image', $postid); ?>" />
					
					<div class="text-head">
						<h1><?php the_field('share_content_title_one', $postid); ?></h1>
						<h2><?php the_field('share_content_title_two', $postid); ?></h2>
					</div>
			</div>
			
			<p><?php the_field('share_content_text', $postid); ?><span><?php the_field('share_content_signature', $postid); ?></span></p>
			
			<div class="progress">
			
				<h2>20%</h2>
				
			</div>
			
			<div class="share-box">
			
				<ul>
					<div class="hborder"></div>
					
					<li class="facebook">
						<h1><?php the_field('share_facebook_title_one', $postid); ?></h1>
						<h2><?php the_field('share_facebook_title_two', $postid); ?></h2>
						<div>
							<a href="<?php the_field('share_facebook_link', $postid); ?>"><div class="background-share" style="background-image: url('<?php the_field('share_facebook_icon', $postid); ?>')"></div><span><?php the_field('share_facebook_text', $postid); ?></span></a>
						</div>
					</li>
					
					<div class="hborder"></div>
					
					<li class="twitter">
						<h1><?php the_field('share_twitter_title_one', $postid); ?></h1>
						<h2><?php the_field('share_twitter_title_two', $postid); ?></h2>
						<div>
							<a href="<?php the_field('share_twitter_link', $postid); ?>"><div class="background-share" style="background-image: url('<?php the_field('share_twitter_icon', $postid); ?>')"></div><span><?php the_field('share_twitter_text', $postid); ?></span></a>
						</div>
					</li>
					
					<div class="hborder"></div>
					
					<li class="youtube">
						<h1><?php the_field('share_youtube_title_one', $postid); ?></h1>
						<h2><?php the_field('share_youtube_title_two', $postid); ?></h2>
						<div>
							<a href="<?php the_field('share_youtube_link', $postid); ?>"><div class="background-share" style="background-image: url('<?php the_field('share_youtube_icon', $postid); ?>')"></div><span><?php the_field('share_youtube_text', $postid); ?></span></a>
						</div>
					</li>
				</ul>
				
			</div>
		</div>

<?php get_footer(); ?>