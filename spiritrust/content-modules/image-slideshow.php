<?php
$slideshow_title      = wrapRegInSup(get_sub_field('slideshow_title'));
$slideshow_intro_copy = wrapRegInSup(get_sub_field('slideshow_intro_copy'));
$show_titles          = get_sub_field('show_titles');
$show_captions        = get_sub_field('show_captions');
$slide_total          = count(get_sub_field('slideshow_images'));
$i                    = 1;
$classname            = '';
$html                 = '';

if (!$show_captions && !$show_titles) {
	// DON'T SHOW TITLE/CAPTION BOX
	$classname = ' slideshow-notext';
}
?>
<?php if (have_rows('slideshow_images')): ?>
	<!-- MODULE: IMAGE SLIDESHOW -->
	<div class="module module-image-slideshow cf">
		<?php if ($slideshow_title != ''): ?>
		<h2><?php echo $slideshow_title; ?></h2>
		<?php endif; ?>

		<?php if ($slideshow_intro_copy != ''): ?>
		<p><?php echo $slideshow_intro_copy; ?></p>
		<?php endif; ?>

		<?php while(have_rows('slideshow_images')): the_row(); ?>
			<?php
			$image         = get_sub_field('slideshow_image');
			$image_url     = $image['url'];
			$image_title   = $image['title'];
			$image_caption = $image['caption'];
			$image_width   = $image['width'];
			$image_height  = $image['height'];

			$size_slideshow         = 'slideshow-image';
			$image_slideshow        = $image['sizes'][$size_slideshow];
			$image_slideshow_width  = $image['sizes'][$size_slideshow . '-width'];
			$image_slideshow_height = $image['sizes'][$size_slideshow . '-height'];

			$size                   = 'slideshow-thumb';
			$image_thumbnail        = $image['sizes'][$size];
			$image_thumbnail_width  = $image['sizes'][$size . '-width'];
			$image_thumbnail_height = $image['sizes'][$size . '-height'];

			if ($i == 1) {
				$initial_image_title   = $image_title;
				$initial_image_caption = $image_caption;

				$initial_image_slideshow        = $image_slideshow;
				$initial_image_slideshow_width  = $image_slideshow_width;
				$initial_image_slideshow_height = $image_slideshow_height;

				$activeclass           = ' class="active"';
			} else {
				$activeclass           = '';
			}

			$html .= '<li>';
			$html .= '<a href="' . $image_slideshow . '"' . $activeclass . '">';
			$html .= '<img src="' . $image_thumbnail . '" width="' . $image_thumbnail_width . '" height="' . $image_thumbnail_height . '" alt="' . esc_html($image_title) . '">';
			$html .= '<span class="caption">' . $image_caption . '</span>';
			$html .= '</a>';
			$html .= '</li>';
			$i++;
			?>
		<?php endwhile; ?>

		<div class="slideshow-wrapper"<?php echo $classname; ?>>
			<!-- SLIDE CONTENT -->
			<div class="slide-photo">
				<?php if ($slide_total > 1): ?>
				<p class="prev prev-top">
					<a href="#previous" rel="nofollow" data-button="prev">
						<span class="txt">Previous</span>
						<span class="icon icon-angle-left"></span>
					</a>
				</p>
				<?php endif; ?>

				<img src="<?php echo $initial_image_slideshow; ?>" alt="<?php echo $image_title; ?>" width="<?php echo $initial_image_slideshow_width; ?>" height="<?php echo $initial_image_slideshow_height; ?>" class="slideshow-photo">

				<?php if ($slide_total > 1): ?>
				<p class="next next-top">
					<a href="#next" rel="nofollow" data-button="next">
						<span class="txt">Next</span>
						<span class="icon icon-angle-right"></span>
					</a>
				</p>
				<div class="loader"></div>
				<?php endif; ?>
			</div>

			<?php if ($slide_total > 1): ?>
			<!-- SLIDESHOW THUMBNAILS -->
			<div class="slideshow-controls-wrapper">
				<div class="slideshow-controls">
					<p class="prev prev-bottom">
						<a href="#previous" rel="nofollow" class="inactive" data-button="prev">
							<span class="txt">Previous</span>
							<span class="icon icon-angle-left"></span>
						</a>
					</p>

					<div class="slideshow-thumbs-wrapper">
						<div class="slideshow-thumbs">
							<ul class="thumbs-list images-list clist cf">
								<?php echo $html; ?>
							</ul>
						</div>
					</div>

					<p class="next next-bottom">
						<a href="#next" rel="nofollow" data-button="next">
							<span class="txt">Next</span>
							<span class="icon icon-angle-right"></span>
						</a>
					</p>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($show_titles || $show_captions): ?>
			<!-- SLIDESHOW CAPTION -->
			<div class="slideshow-caption">
				<?php if ($show_titles != ''): ?>
				<h3><?php echo $initial_image_title; ?></h3>
				<?php endif; ?>

				<?php if ($show_captions != ''): ?>
				<p><?php echo $initial_image_caption; ?></p>
				<?php endif; ?>

				<?php if ($slide_total > 1): ?>
				<div class="slideshow-count">
					<span class="current">1</span>
					<span class="sep">/</span>
					<span class="total"><?php echo count(get_sub_field('slideshow_images')); ?></span>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
