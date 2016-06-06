<?php
/* Template Name: Team Page */
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
	
	<?php include (TEMPLATEPATH . '/library/navigation-sidebar.php'); ?>
	
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
						
						<div class="quickbuttons">		
							<a href="<?php bloginfo ('url'); ?>/checkout/">Checkout</a>
							<a href="<?php bloginfo ('url'); ?>/cart">View Cart</a>
						</div>
						
						<?php } ?>
					
						<div id="team-page">
						
							<div class="team-desc">
								<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
								
									<?php the_content(); ?>
								
								<?php endwhile; endif; wp_reset_query(); ?>
							</div>
							
							<!-- TEAM MISFIT -->
							
							<?php if(get_field('team_repeater')): ?>
							
							<ul class="team-misfit">
								<?php $i = 0; while(has_sub_field('team_repeater')): $i++; ?>
								<li class="<?php if($i % 5 == 0) { echo 'team-list five';} ?>">
									<div class="ch-grid">
										<div class="ch-item" style="background-image:url('<?php the_sub_field('member_photo'); ?>');">
											<div class="ch-info">
												<h3><?php the_sub_field('member_name'); ?></h3>
												<?php if (get_sub_field('member_twitter_account') || (get_sub_field('member_instagram_account'))) { ?>
												
												<ul>
													<?php if (get_sub_field('member_twitter_account')) { ?>
													
													<li class="team-twitter">
														<a target="_blank" class="<?php if (get_sub_field('member_instagram_account')) {} else { echo 'nomedia'; }?> fa fa-twitter" href="<?php the_sub_field('member_twitter_account'); ?>">
															<!-- <span><?php // the_sub_field('member_twitter_handle'); ?></span> -->
														</a>
													</li>
													
													<?php } ?>
													
													<?php if (get_sub_field('member_instagram_account')) { ?>
													
													<li class="team-instagram">
														<a target="_blank" class="<?php if (get_sub_field('member_twitter_account')) {} else { echo 'nomedia'; }?> fa fa-instagram" href="<?php the_sub_field('member_instagram_account'); ?>">
															<!-- <span><?php // the_sub_field('member_instagram_handle'); ?></span>-->
														</a>
													</li>
													
													<?php } ?>
												</ul>
												
												<?php } ?>
											</div>
										</div>
									</div>
									
									<div class="team-mem-text">
										<p class="job-title"><?php the_sub_field('member_position'); ?></p>
										<p><?php the_sub_field('member_description'); ?></p>
									</div>
								</li>
								
								<?php if($i % 5 == 0) { ?><div class="clear"></div><?php } ?>
								<?php endwhile; ?>
							</ul>
							<?php endif; ?>
							
							<!-- ADVISOR MISFIT -->
							
							<h1 style="text-align: center; margin-top: 20px; margin-bottom: 50px;">Advisors</h1>
							
							<?php if(get_field('advisor_repeater')): ?>
							
							<ul class="team-misfit">
								<?php $i = 0; while(has_sub_field('advisor_repeater')): $i++; ?>
								<li class="<?php if($i % 5 == 0) { echo 'team-list five';} ?>">
									<div class="ch-grid">
										<div class="ch-item" style="background-image:url('<?php the_sub_field('advisor_photo'); ?>');">
											<div class="ch-info">
												<h3><?php the_sub_field('advisor_name'); ?></h3>
												<?php if (get_sub_field('advisor_twitter_account') || (get_sub_field('advisor_instagram_account'))) { ?>
												
												<ul>
													<?php if (get_sub_field('advisor_twitter_account')) { ?>
													
													<li class="team-twitter">
														<a target="_blank" class="<?php if (get_sub_field('advisor_instagram_account')) {} else { echo 'nomedia'; }?> fa fa-twitter" href="<?php the_sub_field('advisor_twitter_account'); ?>">
															<span><?php the_sub_field('advisor_twitter_handle'); ?></span>
														</a>
													</li>
													
													<?php } ?>
													
													<?php if (get_sub_field('advisor_instagram_account')) { ?>
													
													<li class="team-instagram">
														<a target="_blank" class="<?php if (get_sub_field('advisor_twitter_account')) {} else { echo 'nomedia'; }?> fa fa-instagram" href="<?php the_sub_field('advisor_instagram_account'); ?>">
															<span><?php the_sub_field('advisor_instagram_handle'); ?></span>
														</a>
													</li>
													
													<?php } ?>
												</ul>
												
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="team-mem-text">
										<p><?php the_sub_field('advisor_position'); ?></p>
										<p><?php the_sub_field('advisor_description'); ?></p>
									</div>
								</li>
								
								<?php if($i % 5 == 0) { ?><div class="clear"></div><?php } ?>
								<?php endwhile; ?>
							</ul>
							<?php endif; ?>
							
							
						</div>
					
					</div>
				</div>
				
				<!-- floating clouds -->
				
				<div id="background"></div>
			    <div id="midground"></div>
				
			</div><!-- end innerwrapper-->
		</div><!-- end wrapper -->
		
<?php include(TEMPLATEPATH . '/library/lower-navigation.php'); ?>
		
<?php get_footer(); ?>