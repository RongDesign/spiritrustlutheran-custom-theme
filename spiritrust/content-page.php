<?php if ($post->post_content != ""): ?>
	<!-- MODULE: DEFAULT -->
	<div class="module module-content cf">
		<?php the_content(); ?>
	</div>
<?php endif; ?>

<?php
if (have_rows('modules')) {
	while (have_rows('modules')) {
		the_row();

		switch (get_row_layout()) {
			/* LAYOUT: GENERAL CONTENT */
			case 'content_area':
				require 'content-modules/general.php';
				break;

			/* LAYOUT: EXPAND COLLAPSE */
			case 'expand_collapse_list':
				require 'content-modules/expand-collapse.php';
				break;

			/* LAYOUT: QUOTE */
			case 'quote':
				require 'content-modules/quote.php';
				break;

			/* LAYOUT: IMAGE SLIDESHOW */
			case 'image_slideshow':
				require 'content-modules/image-slideshow.php';
				break;

			/* LAYOUT: VIDEO SLIDESHOW */
			case 'video_slideshow':
				require 'content-modules/video-slideshow.php';
				break;

			/* LAYOUT: GOOGLE MAPS */
			case 'google_maps':
				require 'content-modules/google-maps.php';
				break;

			/* LAYOUT: IFRAME */
			case 'iframe':
				require 'content-modules/iframe.php';
				break;
		}
	}
}
?>
