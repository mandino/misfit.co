<?php
/**
 *
 * Description: Main Homepage template.
 *
 */

get_header(); ?>

	<div id="main">
	
		<?php
			$layout = $data['homepage_blocks']['enabled'];
		if ($layout):
		foreach ($layout as $key=>$value) {
			switch($key) {
			case 'quotes_bottom_block':
		?>
	
		<div id="section-divider-3">
		
			<div class="bg3"></div>
		
			<div class="container">
			
				<div class="text-container">
					
					<section class="latest-quotes">
						
						<ul class="quotes">
									
							<?php
							global $data;
							
							$args = array('post_type' => 'quotes', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1);
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post(); ?>
							
								<li>
									<blockquote><?php echo get_post_meta($post->ID, 'gt_quotes_quote', true) ?></blockquote>
									<a href="<?php the_field('speaker_twitter_link_quote', $post->ID); echo get_post_meta($post->ID, 'speaker_twitter_link_quote', true) ?>" target="_blank"><cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite></a>
								</li>
								
							<?php endwhile; ?>
				
						</ul><!-- end .quotes -->
					
					</section><!-- end .latest-quotes -->
				
				</div><!-- end .text-container -->
		
			</div><!-- end .container -->
		
		</div><!-- end #section-divider-3 -->

		<?php
		break;
		case 'work_block':
		?>
	
		<section id="latest-work">

			<div class="latest-work-background"><a class="photo-credit" href="http://www.jalanpaul.com/" target="_blank">Photo by J. Alan Paul Photography</a></div>
		
			<div class="container">
	
				<div class="row main-section">
				
					<h2 class="title"><?php echo $data['text_portfolio_title']; ?></h2>
					
					<div class="text-cppy"><p><?php echo do_shortcode(stripslashes($data['textarea_portfolio_overview'])); ?></p></div>

					<div class="divider"></div>
				
				</div><!-- end .row -->
				
				<div class="row photos">
				
					<div id="portfolio-filter">
									
						<ul id="filter">
							<li><a href="#" class="current" data-filter="*"><?php _e('Show all', 'kula'); ?></a></li>
							<?php
							$categories = get_categories(array(
							    'type' => 'post',
							    'taxonomy' => 'project-type'
							));
							foreach ($categories as $category) {
							    $group = $category->slug;
							    echo "<li class='project-type'><a href='#' data-filter='.$group'>" . $category->cat_name . "</a></li>";
							}
							?>
						</ul><!-- end #filter -->
						
					</div><!-- end #portfolio-filter -->
			
					<div id="portfolio-items">
					
						<?php
						query_posts(array(
						    'post_type' => 'portfolio',
						    'orderby' => 'menu_order',
						    'order' => 'ASC',
						    'posts_per_page' => -1
						));
						?>
						
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?php 
						    $terms =  get_the_terms( $post->ID, 'project-type' ); 
						    $term_list = '';
						    if( is_array($terms) ) {
						        foreach( $terms as $term ) {
							        $term_list .= urldecode($term->slug);
							        $term_list .= ' ';
							    }
						    }
						?>
						
						<div <?php post_class("$term_list one-third column"); ?> id="post-<?php the_ID(); ?>">
						
							<div class="project-item">
								
								<div class="project-image">
									<?php the_post_thumbnail('portfolio-thumb'); ?>
									<div class="overlay">
										<div class="details">
											<h2><?php if( get_field('rearreangeable_photo_url', $postid) ) { ?><a href="<?php the_field('rearreangeable_photo_url', $postid); ?>" target="_blank"><?php the_title(); ?></a><?php } else { the_title(); } ?></h2>
										</div>
									</div>
								</div><!-- end .project-image -->
		
							</div><!-- end .project-item -->
							
						</div><!-- end .one-third -->
						
					<?php endwhile; endif; ?>
						
					</div><!-- end #portfolio-items -->
					
				</div><!-- end .row -->
	
			</div><!-- end .container -->
		
		</section><!-- end #latest-work -->

		<?php
		break;
		case 'local_partners':
		?>
		
		<a id="excerpts"></a>
		<section id="local-partners">

			<div class="local-partners-background"><a class="photo-credit" href="http://www.jalanpaul.com/" target="_blank">Photo by J. Alan Paul Photography</a></div>
							
			<?php echo do_shortcode('[SlideDeck2 id=362]'); ?><!-- Desktop -->
			<?php echo do_shortcode('[SlideDeck2 id=393]'); ?><!-- 768 -->
			<?php echo do_shortcode('[SlideDeck2 id=389]'); ?><!-- 480 -->
			<?php echo do_shortcode('[SlideDeck2 id=397]'); ?><!-- 320 -->
							
		</section><!-- end #latest-work -->

		<?php
		break;
		case 'their_words':
		?>
		
		<section id="their-words">
		<a id="about"></a>

			<div class="their-words-background"></div>
		
			<div class="container">

				<img class="aj-history-photo" src="<?php the_field('aj_history_photo', 'options'); ?>" />
				
				<div class="text-container"><?php the_field('their_words_text', 'options'); ?></div>

				<div class="fb-like" data-href="http://www.facebook.com/pursuitofeverything" data-width="358" data-show-faces="true" data-send="false"></div>

				<h2 class="title"><?php the_field('their_words_title', 'options'); ?></h2>

				<div class="icon-divider"></div>

				<?php if(get_field('their_words_their_photos', 'options')) { ?>
						
					<ul class="their-words-photos">
			 
						<?php while(has_sub_field('their_words_their_photos', 'options')) { ?>
							<div <?php post_class("$term_list one-third column"); ?> >
						
							<div class="project-item">
								
								<div class="project-image">
									<img src="<?php echo get_template_directory_uri(); ?>/functions/thumb.php?src=<?php the_sub_field('their_words_their_photo'); ?>&w=300&h=300">
									<div class="overlay">
										<div class="details">
											<h2><?php if( get_sub_field('their_words_their_photo_url') ) { ?><a href="<?php the_sub_field('their_words_their_photo_url'); ?>" target="_blank"><?php the_sub_field('their_words_their_photo_text'); ?></a><?php } else { ?><?php the_sub_field('their_words_their_photo_text'); ?><?php } ?></h2>
										</div>
									</div>
								</div><!-- end .project-image -->
		
							</div><!-- end .project-item -->
							
						</div><!-- end .one-third -->
						<?php } ?>

					</ul>

				<?php } ?>
					
			</div><!-- end .container -->
		
		</section><!-- end #latest-work -->
		
		<?php
		break;
		case 'quotes_top_block':
		?>
	
		<div id="section-divider-1">
		
			<div class="bg1"><a class="photo-credit" href="http://www.jalanpaul.com/" target="_blank">Photo by J. Alan Paul Photography</a></div>
			
			<div class="container">
			
				<div class="text-container">
					
					<section class="latest-quotes">

						<h2>Our Speakers</h2>

						<div class="quote-divider"></div>
						
						<ul class="quotes">
							
							<?php
							global $data;
							
							$args = array('post_type' => 'quotes', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1);
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post(); ?>
							
								<li>
									<blockquote><?php echo get_post_meta($post->ID, 'gt_quotes_quote', true) ?></blockquote>
									<a href="<?php the_field('speaker_twitter_link_quote', $post->ID); ?>" target="_blank"><cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite></a>
								</li>
								
							<?php endwhile; ?>
				
						</ul><!-- end .quotes -->
					
					</section><!-- end .latest-quotes -->
				
				</div><!-- end .text-container -->
			
			</div><!-- end .container -->
		
		</div><!-- end #section-divider-1 -->
		
		<?php
		break;
		case 'services_block':
		?>
	
		<section id="services">
					
			<div class="container">
		
				<h1><?php echo $data['text_services_title']; ?><span>.</span></h1>
				
				<p><?php echo do_shortcode(stripslashes($data['textarea_services_overview'])); ?></p>
			
				<div id="all-services">
				
					<?php
					global $data;
					
					$args = array('post_type' => 'services', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => $data['select_services']);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) : $loop->the_post(); ?>
				
					<div class="service one-third column">
	
						<?php echo do_shortcode(get_post_meta($post->ID, 'gt_service_icon', $single = true)) ?>
	
						<h2><?php the_title(); ?><span>.</span></h2>
						
						<?php the_content(); ?>
						
						<?php if (get_post_meta($post->ID, 'gt_service_url', true)) { ?>
						<a class="read-more-btn" href="<?php echo get_post_meta($post->ID, 'gt_service_url', true) ?>"><?php _e('Read more', 'kula'); ?> <span>&rarr;</span></a>
						<?php } ?>
					
					</div><!-- end .service -->
					
					<?php endwhile; ?>
											
				</div><!-- end #all-services -->
				
			</div><!-- end .container -->
	
		</section><!-- end #services -->
		
		<?php
		break;
		case 'logos_block':
		?>
	
		<div id="section-divider-2">
			
			<div class="bg2"></div>
		
			<div class="container">
		
				<div class="text-container">
				
					<div class="logos sixteen columns">
					
						<h2><?php echo $data['text_client_logos_title']; ?></h2>
						
						<ul id="client-logos">
						<?php if($data["client_logo_one"]) { ?>
							<li><a href="<?php echo $data['client_logo_one_url']; ?>"><img src="<?php echo $data['client_logo_one']; ?>" alt="" /></a></li>
						<?php } if($data["client_logo_two"]){ ?>
							<li><a href="<?php echo $data['client_logo_two_url']; ?>"><img src="<?php echo $data['client_logo_two']; ?>" alt="" /></a></li>
						<?php } if($data["client_logo_three"]){ ?>
							<li><a href="<?php echo $data['client_logo_three_url']; ?>"><img src="<?php echo $data['client_logo_three']; ?>" alt="" /></a></li>
						<?php } if($data["client_logo_four"]){ ?>
							<li><a href="<?php echo $data['client_logo_four_url']; ?>"><img src="<?php echo $data['client_logo_four']; ?>" alt="" /></a></li>
						<?php } if($data["client_logo_five"]){ ?>
							<li><a href="<?php echo $data['client_logo_five_url']; ?>"><img src="<?php echo $data['client_logo_five']; ?>" alt="" /></a></li>
						<?php } ?>	
						</ul>
				
					</div><!-- end .logos -->
			
				</div><!-- end .text-container -->
		
			</div><!-- end .container -->
		
		</div><!-- end #section-divider-2 -->
		
		<?php
		break;
		case 'news_block':
		?>
	
		<section id="latest-news">
				
			<div class="container">
			
				<h1><?php echo $data['text_news_title']; ?><span>.</span></h1>
				
				<p><?php echo do_shortcode(stripslashes($data['textarea_news_overview'])); ?></p>
				
				<div id="articles">
				
					<?php
					global $data;
											
					$args = array('post_type' => 'post', 'posts_per_page' => $data['select_news']);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) : $loop->the_post(); ?>
				
					<article class="article one-third column">
					
						<div class="thumbnail">
							<?php the_post_thumbnail('latest-news-thumb'); ?>
						</div>
						
						<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?><span>.</span></a></h2>
						
						<div class="meta">
							<span><?php _e('Posted in -', 'kula'); ?> <?php the_category(' & '); ?><br />on <strong><?php the_time('F jS, Y'); ?></strong></span>
							<span><i class="icon-comment"></i> <a href="<?php the_permalink(); ?>#comments"><?php $commentscount = get_comments_number(); echo $commentscount; ?> <?php _e('Comments', 'kula'); ?></a></span>
						</div>
						
						<?php the_excerpt(); ?>
						
						<a class="read-more-btn" href="<?php the_permalink() ?>"><?php _e('Read more', 'kula'); ?> <span>&rarr;</span></a>
					
					</article><!-- end article -->
										
					<?php endwhile; ?>
				
				</div><!-- end #articles -->
			
			</div><!-- end .container -->
	
		</section><!-- end #latest-news -->

		<?php
		break;
		case 'quotes_block_1':
		?>
	
		<div id="section-divider-21" class="section quote">
		
			<div class="bg4"><a class="photo-credit" href="http://www.jalanpaul.com/" target="_blank">Photo by J. Alan Paul Photography</a></div>
		
			<div class="container">
			
				<div class="text-container">
					
					<section class="latest-quotes lower-area">

						<div class="quote-divider"></div>
						
						<ul class="quotes">
									
							<?php
							global $data;
							
							$args = array('post_type' => 'quotes', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1);
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post(); ?>
							
								<li>
									<blockquote><?php echo get_post_meta($post->ID, 'gt_quotes_quote', true) ?></blockquote>
									<?php if(get_field('speaker_twitter_link_quote', $post->ID) == 'noquote') { ?>
										<cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite>
									<?php } else { ?>
										<a href="<?php the_field('speaker_twitter_link_quote', $post->ID); ?>" target="_blank"><cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite></a>
									<?php } ?>
								</li>
								
							<?php endwhile; ?>
				
						</ul><!-- end .quotes -->
					
					</section><!-- end .latest-quotes -->
				
				</div><!-- end .text-container -->
		
			</div><!-- end .container -->
		
		</div><!-- end #section-divider-3 -->

		<?php
		break;
		case 'quotes_block_2':
		?>
	
		<div id="section-divider-22" class="section quote">
		
			<div class="bg5"><a class="photo-credit" href="http://www.jalanpaul.com/" target="_blank">Photo by J. Alan Paul Photography</a></div>
		
			<div class="container">
			
				<div class="text-container">
					
					<section class="latest-quotes lower-area">

						<div class="quote-divider"></div>
						
						<ul class="quotes">
									
							<?php
							global $data;
							
							$args = array('post_type' => 'quotes', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1);
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post(); ?>
							
								<li>
									<blockquote><?php echo get_post_meta($post->ID, 'gt_quotes_quote', true) ?></blockquote>
									<?php if(get_field('speaker_twitter_link_quote', $post->ID) == 'noquote') { ?>
										<cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite>
									<?php } else { ?>
										<a href="<?php the_field('speaker_twitter_link_quote', $post->ID); ?>" target="_blank"><cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite></a>
									<?php } ?>
								</li>
								
							<?php endwhile; ?>
				
						</ul><!-- end .quotes -->
					
					</section><!-- end .latest-quotes -->
				
				</div><!-- end .text-container -->
		
			</div><!-- end .container -->
		
		</div><!-- end #section-divider-3 -->

		<?php
		break;
		case 'quotes_block_3':
		?>
	
		<div id="section-divider-23" class="section quote">
		
			<div class="bg6"><a class="photo-credit" href="http://www.jalanpaul.com/" target="_blank">Photo by J. Alan Paul Photography</a></div>
		
			<div class="container">
			
				<div class="text-container">
					
					<section class="latest-quotes lower-area">

						<div class="quote-divider"></div>
						
						<ul class="quotes">
									
							<?php
							global $data;
							
							$args = array('post_type' => 'quotes', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1);
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post(); ?>
							
								<li>
									<blockquote><?php echo get_post_meta($post->ID, 'gt_quotes_quote', true) ?></blockquote>
									<a href="<?php the_field('speaker_twitter_link_quote', $post->ID); ?>" target="_blank"><cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite></a>
								</li>
								
							<?php endwhile; ?>
				
						</ul><!-- end .quotes -->
					
					</section><!-- end .latest-quotes -->
				
				</div><!-- end .text-container -->
		
			</div><!-- end .container -->
		
		</div><!-- end #section-divider-3 -->

		<?php
		break;
		case 'quotes_block_4':
		?>
	
		<div id="section-divider-24" class="section quote">
		
			<div class="bg7"><a class="photo-credit" href="http://www.jalanpaul.com/" target="_blank">Photo by J. Alan Paul Photography</a></div>
		
			<div class="container">
			
				<div class="text-container">
					
					<section class="latest-quotes lower-area">

						<div class="quote-divider"></div>
						
						<ul class="quotes">
									
							<?php
							global $data;
							
							$args = array('post_type' => 'quotes', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1);
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post(); ?>
							
								<li>
									<blockquote><?php echo get_post_meta($post->ID, 'gt_quotes_quote', true) ?></blockquote>
									<a href="<?php the_field('speaker_twitter_link_quote', $post->ID); ?>" target="_blank"><cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite></a>
								</li>
								
							<?php endwhile; ?>
				
						</ul><!-- end .quotes -->
					
					</section><!-- end .latest-quotes -->
				
				</div><!-- end .text-container -->
		
			</div><!-- end .container -->
		
		</div><!-- end #section-divider-3 -->

		<?php
		break;
		case 'the_people':
		?>
		
		<a id="tour"></a>
		<div id="the-people" class="section">
		
			<div class="the-people-background"><a class="photo-credit" href="http://www.jalanpaul.com/" target="_blank">Photo by J. Alan Paul Photography</a></div>
		
			<div class="container">
			
				<div class="text-container">
					
					<section>

						<h2 class="title non-image"><?php the_field('the_people_title', 'options') ?></h2>

						<div class="text-cppy">

							<div class="fl">

								<?php the_field('the_people_text', 'options') ?>

								<ul class="social-media">
									<li class="twitter">
										<a target="_blank" href="https://twitter.com/intent/tweet?hashtags=remarkablemisfit&original_referer=https%3A%2F%2Ftwitter.com%2Fabout%2Fresources%2Fbuttons&text=A%20small%20collection%20of%20essays%20about%20changing%20the%20world.&tw_p=tweetbutton&url=http%3A%2F%2Faj-leon.com%2Fbook%2Fremarkable-misfit%2F&via=ajleon"></a>
									</li>
									<li class="facebook">
										<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http://aj-leon.com/misfit-press/remarkable-misfit/"></a></li>
									<li class="google-plus">
										<a target="_blank" href="https://plus.google.com/share?url=http://aj-leon.com/misfit-press/remarkable-misfit/" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a>
									</li>
								</ul>

							</div>

							<div class="fr">

								<!-- Begin MailChimp Signup Form -->
								<link href="http://cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
								<style type="text/css">
								</style>
								<div id="mc_embed_signup">
								<form action="http://misfit-inc.us1.list-manage.com/subscribe/post?u=dab524f4886549dbf587dce02&amp;id=622ad58478" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
									
								<div class="mc-field-group">
									<input type="email" value="Email" name="EMAIL" class="required email" id="mce-EMAIL" onfocus="if (this.value == 'Email') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Email';}">
								</div>
								<div class="mc-field-group">
									<input type="text" value="Name" name="FNAME" class="" id="mce-FNAME" onfocus="if (this.value == 'Name') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Name';}">
								</div>
								
								<?php if(get_field('tour_dates_and_locations', 'options')) { ?>
				
									<div class="mc-field-group">
										<select name="group[3125]" class="REQ_CSS chzn-select" id="mce-group[3125]">
											<option value=""></option>
							 
											<?php $i=0; while(has_sub_field('tour_dates_and_locations', 'options')) { $i++ ?>
												<option value="<?php echo $i; ?>"><?php the_sub_field('tour_date_and_location'); ?></li>
											<?php } ?>
									 
										</select>
									</div>

								<?php } ?>

								<input type="submit" value="Sign Up" name="subscribe" id="mc-embedded-subscribe" class="button">
								
								<div id="mce-responses" class="clear">
									<div class="response" id="mce-error-response" style="display:none"></div>
									<div class="response" id="mce-success-response" style="display:none"></div>
								</div>
								
								</form>
								</div>
								
								<!--End mc_embed_signup-->
								
							</div>

						</div><!-- end .text-cppy -->

						<div class="clear"></div>

						<?php if(get_field('the_people_countries', 'options')) { ?>
						
							<ul class="poeple-countries">
					 
								<?php while(has_sub_field('the_people_countries', 'options')) { ?>
									<li><?php the_sub_field('the_people_country'); ?></li>
								<?php } ?>
							 
							</ul>

						<?php } ?>

						<?php if(get_field('the_people_states', 'options')) { ?>

							<ul class="poeple-states">

								<?php while(has_sub_field('the_people_states', 'options')) { ?>
									<li><?php the_sub_field('the_people_state'); ?></li>
								<?php } ?>

							</ul>

						<?php } ?>
					
					</section>
				
				</div><!-- end .text-container -->
		
			</div><!-- end .container -->
		
		</div><!-- end #section-divider-3 -->
		
		<?php
		break;
		case 'team_block':
		?>
	
		<section id="meet-the-team">
					
			<div class="container">
				
				<h2><?php echo $data['text_team_title']; ?></h2>
				
				<p><?php echo do_shortcode(stripslashes($data['textarea_team_overview'])); ?></p>
				
				<div id="team-members">
				
					<?php
					global $data;
					
					$args = array('post_type' => 'team', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => $data['select_team']);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) : $loop->the_post(); ?>
				
					<div class="team-member one-third column">
					
						<div class="thumbnail">
							<?php the_post_thumbnail('team-member-thumb'); ?>
						</div>

						<div class="team-hover">
	                    	<div class="team-social-media">
								<?php if (get_post_meta($post->ID, 'gt_member_twitter', true)) { ?>
									<a href="<?php echo get_post_meta($post->ID, 'gt_member_twitter', true) ?>" class="odd mk-social-twitter-alt" target="_blank"></a>
								<?php } if (get_post_meta($post->ID, 'gt_member_facebook', true)) { ?>
									<a href="<?php echo get_post_meta($post->ID, 'gt_member_facebook', true) ?>" class="even mk-social-facebook" target="_blank"></a>
								<?php } if (get_post_meta($post->ID, 'gt_member_linkedin', true)) { ?>
									<a href="<?php echo get_post_meta($post->ID, 'gt_member_linkedin', true) ?>" class="odd mk-social-linkedin" target="_blank"></a>
								<?php } if (get_post_meta($post->ID, 'gt_member_pinterest', true)) { ?>
									<a href="<?php echo get_post_meta($post->ID, 'gt_member_pinterest', true) ?>" class=" even mk-social-pinterest" target="_blank"></a>
								<?php } if (get_post_meta($post->ID, 'gt_member_googleplus', true)) { ?>
									<a href="<?php echo get_post_meta($post->ID, 'gt_member_googleplus', true) ?>" class="odd mk-social-googleplus" target="_blank"></a>
								<?php } if (get_post_meta($post->ID, 'gt_member_flickr', true)) { ?>
									<a href="<?php echo get_post_meta($post->ID, 'gt_member_flickr', true) ?>" class="even mk-social-flickr" target="_blank"></a>
								<?php } if (get_post_meta($post->ID, 'gt_member_dribbble', true)) { ?>
									<a href="<?php echo get_post_meta($post->ID, 'gt_member_dribbble', true) ?>" class="odd mk-social-dribbble" target="_blank"></a>
								<?php } if (get_post_meta($post->ID, 'gt_member_vimeo', true)) { ?>
									<a href="<?php echo get_post_meta($post->ID, 'gt_member_vimeo', true) ?>" class="even mk-social-vimeo" target="_blank"></a>
								<?php } if (get_post_meta($post->ID, 'gt_member_youtube', true)) { ?>
									<a href="<?php echo get_post_meta($post->ID, 'gt_member_youtube', true) ?>" class="odd mk-social-youtube" target="_blank"></a>
								<?php } ?>
							</div>
	                    </div>

						<h2><?php the_title(); ?></h2>
						
						<span class="speaker-title"><?php echo get_post_meta($post->ID, 'gt_member_email', true) ?></span>

						<div class="divider"></div>
						
						<?php the_content(); ?>
					
					</div><!-- end .team-member -->
					
					<?php endwhile; ?>
				
				</div><!-- end #team-members -->
				
			</div><!-- end .container -->
				
		</section><!-- end #meet-the-team -->
		
		<?php break; }
		} endif; ?>
	
	</div><!-- end #main -->

<?php get_footer(); ?>