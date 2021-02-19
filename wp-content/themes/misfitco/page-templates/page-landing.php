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
					$add_mobile_content = get_sub_field('add_mobile_content');
					$center_content = get_sub_field('center_content');
					$text_color = get_sub_field('text_color');
					$content_width = get_sub_field('content_width');

					$title = [
						'text' => get_sub_field('title'),
						'html_tag' => acf_html_tag(get_sub_field('title_html_tag'), 'h1')
					];

					$content = get_sub_field('content');
					$mobile_content = get_sub_field('mobile_content');
					$background_image_desktop = get_sub_field('background_image_desktop');
					$background_image_mobile = get_sub_field('background_image_mobile');

					if ( !$background_image_mobile ) :
						$background_image_mobile = $background_image_desktop;
					endif;
			?>
				<li class="slide__item slide__item--slide<?= $counter; ?> slide__item--color-<?= str_replace( '_', '-', $text_color ); ?> <?= ( $counter == 1 ) ? 'slide__item--active' : '' ?> <?= ( $center_content ) ? 'slider__item--center-content' : '' ?>">
					<div class="slide__item-background show-desktop" style="background-image: url(<?= $background_image_desktop['url']; ?>);"></div>
					<div class="slide__item-background show-mobile" style="background-image: url(<?= $background_image_mobile['url']; ?>);"></div>
					<div class="slide__content content-<?= $counter; ?> content-<?= $content_width; ?> <?= ( $counter != 1 ) ? 'slide__content--down' : ''; ?>">
						<?php if ( $title['text'] ) : ?>
							<<?= $title['html_tag']; ?> class="slide__title"><?= $title['text']; ?></<?= $title['html_tag']; ?>>
						<?php endif; ?>

						<?php if ( $content ) : ?>
							<div class="slide__text <?= ( $add_mobile_content ) ? 'show-desktop' : '' ?>"><?= $content; ?></div>
						<?php endif; ?>

						<?php if ( $mobile_content && $add_mobile_content ) : ?>
							<div class="slide__text <?= ( $add_mobile_content ) ? 'show-mobile' : '' ?>"><?= $mobile_content; ?></div>
						<?php endif; ?>
					</div>

					<div class="slide__logo">
						<span class="slide__logo-text">misfit.co</span>
					</div>
				</li>
			<?php $counter++; endwhile; endif; ?>
		</ul>

		<div class="slide__nav">
			<div class="slide__nav-inner">
				<div class="slide__nav-wrapper">
					<ul class="slide__nav-list">
						<?php
							$counter = 1;

							if ( have_rows('menu', 'options') ) : while ( have_rows('menu', 'options') ) : the_row();
								$navigation_label = get_sub_field('navigation_label');

								if ( $navigation_label ) :
						?>
							<li class="slide__nav-item">
								<a href="#" class="slide__nav-button button-<?= $counter; ?>">
									<div class="slide__nav-highlight highlight-<?= $counter; ?>"></div>
									<div class="highlight__stick highlight__stick-<?= $counter; ?> <?= ( $counter == 1 ) ? 'highlight--active' : '' ?>" ></div>

									<?php
										if ( have_rows('initial_type') ) : while ( have_rows('initial_type') ) : the_row();
											if ( get_row_layout() == 'letter' ) :
												$letter = get_sub_field('letter');
									?>
										<h4 class="slide__nav-text slide__nav-text--left"><?= $letter; ?></h4>
									<?php
										elseif ( get_row_layout() == 'image' ) :
											$image_desktop = acf_get_image( get_sub_field('image_desktop') );
											$image_mobile = acf_get_image( get_sub_field('image_mobile') );

											if ( !$image_mobile ) :
												$image_mobile = $image_desktop;
											endif;
									?>
										<div class="slide__nav-iconwrap show-desktop">
											<img class="slide__nav-icon" src="<?= $image_desktop['url']; ?>" alt="<?= $image_desktop['alt']; ?>">
										</div>

										<div class="slide__nav-iconwrap show-mobile">
											<img class="slide__nav-icon" src="<?= $image_mobile['url']; ?>" alt="<?= $image_mobile['alt']; ?>">
										</div>
									<?php endif; endwhile; endif; ?>

									<h4 class="slide__nav-text slide__nav-text--right text-<?= $counter; ?>"><?= $navigation_label; ?></h4>
								</a>
							</li>
						<?php endif; $counter++; endwhile; endif; ?>
					</ul>
				</div>

				<ul class="slide__nav-social">
					<?php
						if ( have_rows('social', 'options') ) : while ( have_rows('social', 'options') ) : the_row();
							$icon_class = get_sub_field('icon_class');
							$link = get_sub_field('link');
					?>
						<li class="slide__nav-social-ico">
							<a href="<?= $link; ?>" target="_blank">
								<i class="<?= $icon_class; ?>"></i>
							</a>
						</li>
					<?php endwhile; endif; ?>
				</ul>
			</div>
		</div>

	</div>
</div>

<?php get_footer(); ?>