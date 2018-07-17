<?php
/**
 * Template Name: Landing Banner
 */
$landing_page_intro_title = wrapRegInSup(get_field('landing_page_intro_title'));
$landing_page_intro_copy  = wrapRegInSup(get_field('landing_page_intro_copy'));
?>
<?php get_header(); ?>

<!-- HOME PAGE: HEROES -->
<div id="landing-banner-page-wrapper">
	<div class="container">

		<?php if ($landing_page_intro_title): ?>
			<h1 id="landing-banner-page-intro-title"><?php echo $landing_page_intro_title; ?></h1>
		<?php endif; ?>

		<?php if ($landing_page_intro_copy): ?>
			<p id="landing-banner-page-intro-copy"><?php echo $landing_page_intro_copy; ?></p>
		<?php endif; ?>

		<?php if (have_rows('landing_page_modules')): ?>
			<ul id="landing-banner-page-list" class="clist cf">
				<?php while(have_rows('landing_page_modules')): the_row(); ?>
				<?php
					$title         = get_sub_field('title');
					$image         = get_sub_field('image');
					$imagesrc      = wp_get_attachment_image_src($image,'homepage-hero');
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
		<?php endif; ?>


	</div>
</div>

<?php get_footer(); ?>
