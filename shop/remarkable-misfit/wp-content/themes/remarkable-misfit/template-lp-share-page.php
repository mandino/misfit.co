<?php
/**
 * Template Name: LP Share Page
 */


get_header('lp');

?>
			 
		<!-- #content Starts -->
		<div id="content" class="col-full">

			<div class="profile-title">

						<?php if( get_field( "share_page_ajs_photo" , $postid) ) { ?>
	 
							 <img class="fl" src="<?php the_field("share_page_ajs_photo", $postid); ?>" alt="Photo" />
	 
						<?php } ?>
	 
					 <div class="fl profile-title-content">

						<?php if( get_field( "common_lp_sub_title" , 'options') ) { ?>
					
							<h2><?php the_field('common_lp_sub_title', 'options'); ?></h2>
					
						<?php } ?>

						<?php if( get_field( "common_lp_title" , 'options') ) { ?>
									
							<h1><?php the_field('common_lp_title', 'options'); ?></h1>
					
						<?php } ?>

					</div>
			</div>
			 
			 <div class="profile-divider-line"></div>

				<div class="lp-content">

						<?php if( get_field( "common_lp_content" , 'options') ) { ?>
			 
							 <?php the_field('common_lp_content', 'options'); ?>
			 
						<?php } ?>

				</div>

				<div id="progressbar" class="progress-bar">
						<?php
						// example of how to modify HTML contents
						//include('includes/simple_html_dom.php');

						// get DOM from URL or file
						//$html = file_get_html('http://www.kickstarter.com/projects/774786282/stolen-child-tarot-complete-the-78-card-deck?ref=discover_rec');

						//$html = find('#pledged div')->plaintext;

						//echo $html;

						?>

						<?php

							// $percent_completed = get_field('share_page_percent_completed',$postid);

							// if ($percent_completed <= 3) { $percent_completed = 25; }
							// else {
							// 	$percent_completed = $percent_completed/100;
							// 	$percent_completed = $percent_completed*900;
							// }

						?>

						<!-- <div class="progress-percent" style="width: <?php //echo $percent_completed; ?>px;"><?php //the_field('share_page_percent_completed',$postid); ?>%</div> --> 
				</div>

				<?php if( get_field( 'common_lp_share_areas' , 'options') ): ?>

					<ul class="share-area">
						<?php while( has_sub_field('common_lp_share_areas' , 'options') ): ?>

							<li class="share-area-<?php the_sub_field('name_of_share_area'); ?>">

								<h2><?php the_sub_field('share_area_title'); ?></h2>
								<h3><?php the_sub_field('share_area_sub_title'); ?></h3>

								<a target="_blank" href="<?php the_sub_field('share_area_share_parameters'); ?>" onclick="<?php the_sub_field('share_area_event_tracking_code'); ?> $( '#progressbar' ).progressbar({ value: <?php the_sub_field('share_area_progress_amount'); ?> }); var href = $(this).attr('href'); setTimeout(function() {window.open(href,'_newtab'); }, 800); return false;">
									<button class="<?php the_sub_field('name_of_share_area'); ?>">
										<img class="fl ico" src="<?php the_sub_field('share_area_text_icon'); ?>" alt="<?php the_sub_field('name_of_share_area'); ?> Icon"/>
										<img class="fr text" src="<?php the_sub_field('share_area_text'); ?>" alt="<?php the_sub_field('name_of_share_area'); ?> Button"/>
									</button>
								</a>

							</li>

						<?php endwhile; ?>

					</ul>

				<?php endif; ?>
		

		</div><!-- /#content -->

<?php get_footer('lp'); ?>