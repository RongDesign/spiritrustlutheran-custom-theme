<?php
/**
 * Template Name: Landing
 */
?>
<?php get_header(); ?>

<!-- PAGE CONTENT -->
<div id="main-content-wrapper" class="cf">
	<div class="container">

		<!-- MAIN CONTENT -->
		<div id="main-content" class="full-column">
			<?php if ($post->post_content != ""): ?>
				<!-- MODULE: LANDING PAGE -->
				<div class="module module-landing-page cf">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

			<?php if (have_rows('landing_page_modules')): ?>
				<div id="landing-page-wrapper">
					<ul id="landing-page-list" class="clist cf">
						<?php while(have_rows('landing_page_modules')): the_row(); ?>
						<?php
							$title         = get_sub_field('title');
							$image         = get_sub_field('image');
							$imagesrc      = wp_get_attachment_image_src($image,'landing-image');
							$text          = wrapRegInSup(get_sub_field('text'));
							$link_text     = get_sub_field('link_text');
							$link_type     = get_sub_field('link_type');
							$internal_link = get_sub_field('internal_link');
							$external_link = get_sub_field('external_link');
							$link          = ($link_type == 1) ? $external_link : $internal_link;
							$target        = (get_sub_field('target') == 1) ? ' target="_blank"' : '';
							$class         = '';

							if ($target != '') {
								$class = ' class="external"';
							}
						?>
						<li>
							<div class="img-wrapper">
								<a href="<?php echo $link; ?>"<?php echo $class . $target; ?>>
									<div class="img">
										<img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo esc_html($title); ?>">
										<div class="overlay-wrapper">
											<div class="overlay">
												<h2><?php echo $title; ?></h2>
												<p><?php echo $text; ?></p>
												<p class="btn btn-green">
													<span class="bg"></span>
													<span class="txt">
														<?php echo $link_text; ?>
														<span class="icon icon-arrow-circle-right"></span>
													</span>
												</p>
											</div>
										</div>
									</div>

									<h2 class="title">
										<?php echo $title; ?>
									</h2>
								</a>
							</div>
						</li>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
