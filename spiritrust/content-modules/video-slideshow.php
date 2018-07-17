<?php
$slideshow_title      = wrapRegInSup(get_sub_field('slideshow_title'));
$slideshow_intro_copy = wrapRegInSup(get_sub_field('slideshow_intro_copy'));
$slide_total          = count(get_sub_field('slideshow_videos'));
$i                    = 1;
$html                 = '';
?>
<?php if (have_rows('slideshow_videos')): ?>
	<!-- MODULE: VIDEO SLIDESHOW -->
	<div class="module module-video-slideshow cf">
		<?php if ($slideshow_title != ''): ?>
		<h2><?php echo $slideshow_title; ?></h2>
		<?php endif; ?>

		<?php if ($slideshow_intro_copy != ''): ?>
		<p><?php echo $slideshow_intro_copy; ?></p>
		<?php endif; ?>

		<?php while(have_rows('slideshow_videos')): the_row(); ?>
			<?php
			$youtube_id = get_sub_field('youtube_id');
			$poster     = 'https://img.youtube.com/vi/' . $youtube_id . '/maxresdefault.jpg';
			$thumb      = 'https://img.youtube.com/vi/' . $youtube_id . '/hqdefault.jpg';
			$url        = 'https://www.youtube.com/watch?v=' . $youtube_id;

			if ($i == 1) {
				$initial_url    = $url;
				$initial_poster = $poster;
				$activeclass    = ' class="active"';
			} else {
				$activeclass    = '';
			}

			$html .= '<li>';
			$html .= '<a href="' . $url . '"' . $activeclass . '" data-poster="' . $poster . '">';
			$html .= '<img src="' . $thumb . '" width="140" height="93" alt="YouTube Video">';
			$html .= '<span class="icon icon-play-circle"></span>';
			$html .= '</a>';
			$html .= '</li>';
			$i++;
			?>
		<?php endwhile; ?>

		<div class="slideshow-wrapper">
			<!-- SLIDE CONTENT -->
			<div class="video-wrapper">
				<?php if ($slide_total > 1): ?>
				<p class="prev prev-top">
					<a href="#previous" rel="nofollow" data-button="prev">
						<span class="txt">Previous</span>
						<span class="icon icon-angle-left"></span>
					</a>
				</p>
				<?php endif; ?>

				<div class="videos-module-mask">
					<div class="ytplayer"></div>
				</div>
				<p class="videos-module-poster">
					<a href="<?php echo $initial_url; ?>" target="_blank">
						<img src="<?php echo $initial_poster; ?>" width="774" height="435" alt="YouTube Video" class="slideshow-poster">
						<span class="icon icon-play-circle"></span>
					</a>
				</p>

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
							<ul class="thumbs-list videos-list clist cf">
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
		</div>
	</div>
<?php endif; ?>
