<?php
if (is_archive() && get_post_type() != 'careers') {
	// NEWS/EVENTS
	$page_feature_image = get_field('page_feature_image', get_option('page_for_posts'));
	$intro_copy = '';
} else if (get_post_type() == 'careers') {
	$page_feature_image = get_field('career_listings_feature_image', 'option');

	if (is_archive()) {
		// CAREERS ARCHIVE (LANDING PAGE)
		$intro_copy = get_field('career_listings_intro_copy', 'option');
	} else {
		// CAREERS (DETAILS PAGE)
		$intro_copy = '';
	}
} else if (is_search()) {
	// SEARCH PAGE
	$page_feature_image = get_field('page_feature_image', 'option');
	$intro_copy = get_field('intro_copy', 'option');
} else {
	// STANDARD PAGE
	$page_feature_image = get_field('page_feature_image', get_post_or_blog_page_id());
	$intro_copy = get_field('intro_copy', get_post_or_blog_page_id());
}
$imagesrc = wp_get_attachment_image_src($page_feature_image,'page-hero');
?>
<!-- PAGE HERO -->
<div id="page-hero-wrapper">
	<div id="page-hero-inner-wrapper">
		<div id="page-hero" style="background-image: url('<?php echo $imagesrc[0]; ?>')"></div>

		<div class="container">
			<div id="page-hero-copy-wrapper">
				<div id="page-hero-bg"></div>
				<div id="page-hero-copy">
					<h1>
						<?php
						if (is_archive()) {
							if (get_post_type() == 'careers') {
								echo get_field('career_listings_page_title', 'option');
							} else {
								echo get_the_title(get_option('page_for_posts'));
								the_archive_title('<span class="category">','</span>');
							}
						} else if (is_search()) {
							echo get_field('search_page_title', 'option');
						} else {
							echo get_the_title(get_post_or_blog_page_id());
						}
						?>
					</h1>

					<?php if ($intro_copy != ''): ?>
					<p><?php echo wrapRegInSup($intro_copy); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
