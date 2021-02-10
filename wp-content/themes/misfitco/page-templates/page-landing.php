<?php
	/* Template Name: Landing */

	get_header();
?>

<div class="container">
	<div class="container__inner">
		<ul class="slide__container">
			<?php 
				$counter = 1;

				if ( have_rows('slider_item') ) : while ( have_rows('slider_item') ) : the_row();
					$center_content = get_sub_field('center_content');
					$text_color = get_sub_field('text_color');

					$title = [
						'text' => get_sub_field('title'),
						'html_tag' => acf_html_tag(get_sub_field('title_html_tag'), 'h1')
					];
				
					$content = get_sub_field('content');
					$background_image = get_sub_field('background_image');
			?>
				<li class="slide__item slide__item--slide<?= $counter; ?> slide__item--color-<?= str_replace( '_', '-', $text_color ); ?> <?= ( $counter == 1 ) ? 'slide__item--active' : '' ?> <?= ( $center_content ) ? 'slider__item--center-content' : '' ?>" style="background-image: url(<?= $background_image['url']; ?>);">
					<div class="slide__content content-<?= $counter; ?> content-large <?= ( $counter != 1 ) ? 'slide__content--down' : ''; ?>">
						<?php if ( $title['text'] ) : ?>
							<<?= $title['html_tag']; ?> class="slide__title"><?= $title['text']; ?></<?= $title['html_tag']; ?>>
						<?php endif; ?>
						
						<?php if ( $content ) : ?>
							<div class="slide__text"><?= $content; ?></div>
						<?php endif; ?>
					</div>

					<div class="slide__logo">
						<span class="slide__logo-text">studiomisfit.co</span>
					</div>
				</li>
			<?php $counter++; endwhile; endif; ?>
		</ul>
			
		<div class="slide__nav">
			<div class="slide__nav-inner">
				<div class="slide__nav-wrapper">
					<ul class="slide__nav-list">
						<li class="slide__nav-item">
							<a href="#" class="slide__nav-button button-1">
								<div class="slide__nav-highlight highlight-1"></div>
								<div class="highlight__stick highlight__stick-1 highlight--active"></div>
								<div class="slide__nav-iconwrap show-desktop">
									<img class="slide__nav-icon" src="<?= get_stylesheet_directory_uri(); ?>/assets/images/studio_misfit_logo.png" alt="studio misfit logo">
								</div>
								<div class="slide__nav-iconwrap show-mobile">
									<img class="slide__nav-icon" src="<?= get_stylesheet_directory_uri(); ?>/assets/images/studio_misfit_asterisk-thin.png" alt="studio misfit logo">
								</div>
								<h4 class="slide__nav-text slide__nav-text--right text-1">studio misfit</h4>
							</a>
						</li>

						<li class="slide__nav-item">
							<a href="#" class="slide__nav-button button-2">
								<div class="slide__nav-highlight highlight-2"></div>
								<div class="highlight__stick highlight__stick-2"></div>
								<h4 class="slide__nav-text slide__nav-text--left">M</h4>
								<h4 class="slide__nav-text slide__nav-text--right text-2">who we are</h4>
							</a>
						</li>

						<li class="slide__nav-item">
							<a href="#" class="slide__nav-button button-3">
								<div class="slide__nav-highlight highlight-3"></div>
								<div class="highlight__stick highlight__stick-3"></div>
								<h4 class="slide__nav-text slide__nav-text--left">I</h4>
								<h4 class="slide__nav-text slide__nav-text--right text-3">what we do</h4>
							</a>
						</li>

						<li class="slide__nav-item">
							<a href="#" class="slide__nav-button button-4">
								<div class="slide__nav-highlight highlight-4"></div>
								<div class="highlight__stick highlight__stick-4"></div>
								<h4 class="slide__nav-text slide__nav-text--left">S</h4>
								<h4 class="slide__nav-text slide__nav-text--right text-4">who we work with</h4>
							</a>
						</li>

						<li class="slide__nav-item">
							<a href="#" class="slide__nav-button button-5">
								<div class="slide__nav-highlight highlight-5"></div>
								<div class="highlight__stick highlight__stick-5"></div>
								<h4 class="slide__nav-text slide__nav-text--left">F</h4>
								<h4 class="slide__nav-text slide__nav-text--right text-5">work with us</h4>
							</a>
						</li>

						<li class="slide__nav-item">
							<a href="#" class="slide__nav-button button-6">
								<div class="slide__nav-highlight highlight-6"></div>
								<div class="highlight__stick highlight__stick-6"></div>
								<h4 class="slide__nav-text slide__nav-text--left">I</h4>
								<h4 class="slide__nav-text slide__nav-text--right text-6">misfit worldwide</h4>
							</a>
						</li>

						<li class="slide__nav-item">
							<a href="#" class="slide__nav-button button-7">
								<div class="slide__nav-highlight highlight-7"></div>
								<div class="highlight__stick highlight__stick-7"></div>
								<h4 class="slide__nav-text slide__nav-text--left">T</h4>
								<h4 class="slide__nav-text slide__nav-text--right text-7">surprise</h4>
							</a>
						</li>
					</ul>
				</div>

				<div class="slide__nav-social">
					<div class="slide__nav-social-ico">
						<a href="https://www.instagram.com/studiomisfit/" target="_blank">
							<i class="fab fa-instagram"></i>
						</a>
					</div>
					<div class="slide__nav-social-ico">
						<a href="https://www.linkedin.com/company/misfit-co" target="_blank">
							<i class="fab fa-linkedin-in"></i>
						</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<?php get_footer(); ?>