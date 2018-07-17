<?php
/**
 * Template Name: Home
 */
$heroes        = get_field('collection_of_heroes');
$callouts      = get_field('collection_of_callouts');
$imagecallouts = get_field('collection_of_image_callouts');
?>
<?php get_header(); ?>

<?php if ($heroes): ?>
<!-- HOME PAGE: HEROES -->
<div id="home-page-hero-wrapper">
	<div id="home-page-hero">
		<div class="container">
			<p class="home-page-hero-nav home-page-hero-prev">
				<a href="#previous" rel="nofollow" data-button="prev">
					<span class="txt">Previous</span>
					<span class="icon icon-angle-left"></span>
				</a>
			</p>

			<?php
			$i = 1;
			?>
			<?php foreach($heroes as $hero): ?>
			<?php
				$id       = $hero['hero']->ID;
				$title    = get_the_title($id);
				$image    = get_field( "image", $id);
				$copy     = wrapRegInSup(get_field( "copy", $id));
				$imagesrc = wp_get_attachment_image_src($image,'homepage-hero');
				$active   = '';

				if ($i == 1) {
					$active = ' hero-section-active';
				}
			?>
			<!-- HERO <?php echo $i; ?> -->
			<div class="hero-section hero-section<?php echo $i . $active; ?>">
				<div class="hero-photo" style="background-image: url(<?php echo $imagesrc[0]; ?>);">
					<div class="hero-title">
						<h2><?php echo $title; ?></h2>
						<p class="btn-wrapper">
							<a href="#show-details" class="btn explore-hero">
								<span class="bg"></span>
								<span class="txt">
									Explore
									<span class="icon icon-arrow-circle-right"></span>
								</span>
							</a>
						</p>
					</div>
				</div>
				<div class="hero-content">
					<div class="hero-content-inner">
						<a href="#hide-details" class="hide-hero-details" rel="nofollow">
							<span class="icon icon-times-circle"></span>
						</a>

						<p><?php echo $copy; ?></p>

						<?php if (have_rows('suppporting_links', $id)): ?>
							<!-- SUPPORTING LINKS -->
							<ul class="hero-content-list clist cf">
								<?php while(have_rows('suppporting_links', $id)): the_row(); ?>
								<?php
									$link          = get_sub_field('text');
									$text          = get_sub_field('text');
									$link_type     = get_sub_field('link_type');
									$internal_link = get_sub_field('internal_link');
									$external_link = get_sub_field('external_link');
									$target        = (get_sub_field( "target") == 1) ? ' target="_blank"' : '';
									$link          = $internal_link;
									$icon          = '<span class="icon icon-arrow-circle-right"></span>';

									/* if external link */
									if ($link_type == 1) {
										$link = $external_link;
										$icon = '<span class="icon icon-external-link"></span>';
									}
								?>
								<li>
									<a href="<?php echo $link; ?>">
										<?php echo $icon; ?>
										<?php echo $text; ?>
									</a>
								</li>
								<?php endwhile; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
			$i++;
			?>
			<?php endforeach; ?>

			<p class="home-page-hero-nav home-page-hero-next">
				<a href="#next" rel="nofollow" data-button="next">
					<span class="txt">Next</span>
					<span class="icon icon-angle-right"></span>
				</a>
			</p>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- HOME PAGE: SEARCH -->
<form id="home-search-wrapper" action="/" method="get">
	<div class="container">
		<label>I’m looking for</label>
		<div class="input-wrapper">
			<input id="home-search" name="s" type="text" placeholder="Type your answer">
		</div>
		<button type="submit" class="btn btn-outline">
			<span class="bg"></span>
			<span class="txt">
				Find It
				<span class="icon icon-arrow-circle-right"></span>
			</span>
		</button>
	</div>
</form>

<?php if ($callouts): ?>
<!-- HOME PAGE: CALLOUTS -->
<div id="home-callouts-wrapper" class="cf">
	<div class="container">
		<?php
		$calloutsClass = '';
		if (!$imagecallouts) {
			$calloutsClass = 'full-column ';
		}
		?>
		<div id="home-page-callouts" class="<?php echo $calloutsClass; ?>cf">
			<?php
			$i = 1;
			?>
			<?php foreach($callouts as $callout): ?>
			<?php
				$id            = $callout['callout']->ID;
				$title         = get_the_title($id);
				$image         = get_field('image', $id);
				$imagesrc      = wp_get_attachment_image_src($image,'homepage-callout');
				$copy          = wrapRegInSup(get_field('copy', $id));
				$link_text     = get_field('link_text', $id);
				$link_type     = get_field('link_type', $id);
				$internal_link = get_field('internal_link', $id);
				$external_link = get_field('external_link', $id);
				$target        = (get_field('target', $id) == 1) ? ' target="_blank"' : '';
				$link          = ($link_type == 1) ? $external_link : $internal_link;
			?>
			<!-- CALLOUT <?php echo $i; ?> -->
			<div class="home-callout">
				<p class="img"><img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo esc_html($title); ?>"></p>
				<h3>
					<span><?php echo $title; ?></span>
				</h3>
				<div class="copy">
					<p><?php echo $copy; ?></p>
					<p class="cta">
						<a href="<?php echo $link; ?>" class="btn btn-green"<?php echo $target; ?>>
							<span class="bg"></span>
							<span class="txt">
								<?php echo $link_text; ?>
								<span class="icon icon-arrow-circle-right"></span>
							</span>
						</a>
					</p>
				</div>
			</div>
			<?php
			$i++;
			?>
			<?php endforeach; ?>
		</div>

		<?php if ($imagecallouts): ?>
			<?php foreach($imagecallouts as $imagecallout): ?>
			<?php
				$id            = $imagecallout['image_callout']->ID;
				$title         = get_the_title($id);
				$image         = get_field('image', $id);
				$imagesrc      = wp_get_attachment_image_src($image,'homepage-image-callout');
				$link_type     = get_field('link_type', $id);
				$internal_link = get_field('internal_link', $id);
				$external_link = get_field('external_link', $id);
				$target        = (get_field('target', $id) == 1) ? ' target="_blank"' : '';
				$link          = ($link_type == 1) ? $external_link : $internal_link;
			?>
			<div id="home-standalone-callout">
				<?php if ($link_type): ?>
				<a href="<?php echo $link; ?>">
				<?php endif; ?>
					<img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo $title; ?>">
				<?php if ($link_type): ?>
				</a>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>

<?php get_footer(); ?>
