<?php
$callouts         = get_field('callout', get_post_or_blog_page_id());
$aside_navigation = get_sidebar_navigation();
$blog             = false;
$search           = false;
$careers          = false;
$careers_match    = preg_match('/^\/careers\/career\-listings/',$_SERVER['REQUEST_URI']);

if (is_home() || is_single() || is_archive()) {
	$blog = true;

	if (get_post_type() == 'careers') {
		$careers = true;
	} elseif ($careers_match) {
		$careers = true;
	}
} elseif (is_search()) {
	$search = true;
} elseif ($careers_match) {
	$careers = true;
}
?>
<?php if ($callouts || $aside_navigation != '' || $blog || $search): ?>
<!-- SIDEBAR -->
<aside id="sidebar">
	<?php if (($aside_navigation != '' && !$search) || $blog): ?>
	<a rel="nofollow" id="aside-nav-menu" href="#jump-to-menu">
		Jump To
		<span class="icon icon-angle-down"></span>
	</a>
	<?php endif; ?>
	<?php if ($careers): ?>
		<!-- SIDEBAR: PAGE NAVIGATION (CAREERS) -->
		<ul id="aside-nav" class="clist cf">
			<?php echo $aside_navigation; ?>
		</ul>
	<?php elseif ($blog): ?>
		<!-- SIDEBAR: BLOG NAVIGATION -->
		<h3 class="callout-title aside-nav-title">Categories</h3>
		<ul id="aside-nav" class="clist cf">
			<?php
				wp_list_categories(
					array(
						'title_li' => ''
					)
				);
			?>
		</ul>
	<?php elseif ($aside_navigation != '' && !$search): ?>
		<!-- SIDEBAR: PAGE NAVIGATION -->
		<ul id="aside-nav" class="clist cf">
			<?php echo $aside_navigation; ?>
		</ul>
	<?php endif; ?>

	<?php if (!$careers): ?>
		<?php if ($search || $blog): ?>
			<!-- SIDEBAR: SEARCH FORM -->
			<h3 class="callout-title">Search</h3>
			<div class="callout callout-search cf">
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($callouts): ?>
		<!-- SIDEBAR: CALLOUTS -->
		<?php foreach($callouts as $callout) : ?>
			<?php
				$id            = $callout['callout_option']->ID;
				$title         = wrapRegInSup(get_the_title($id));
				$callout_type  = get_field('callout_type', $id);
			?>
			<?php if (have_rows('callout_type', $id)): ?>
				<?php while ( have_rows('callout_type', $id) ) : the_row(); ?>
					<?php if (get_row_layout() == 'image_callout'): ?>
						<?php /* LAYOUT: IMAGE CALLOUT */ ?>
						<?php
							$image                 = get_sub_field('image');
							$imagesrc              = wp_get_attachment_image_src($image,'callout');
							$text                  = get_sub_field('text');
							$call_to_action        = get_sub_field('call_to_action');
							$call_to_action_text   = get_sub_field('call_to_action_text');
							$link_type             = get_sub_field('link_type');
							$internal_link         = get_sub_field('internal_link');
							$external_link         = get_sub_field('external_link');
							$call_to_action_link   = ($link_type == 1) ? $external_link : $internal_link;
							$call_to_action_target = get_sub_field('call_to_action_target');
							$target                = (get_sub_field( "call_to_action_target") == 1) ? ' target="_blank"' : '';
						?>
						<div class="callout">
							<?php if ($imagesrc != ''): ?>
							<p class="callout-image">
								<?php if ($call_to_action): ?>
								<a href="<?php echo $call_to_action_link; ?>"<?php echo $target; ?>>
								<?php endif; ?>
									<img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo esc_html($title); ?>">
								<?php if ($call_to_action): ?>
								</a>
								<?php endif; ?>
							</p>
							<?php endif; ?>
							<h4><?php echo $title; ?></h4>

							<?php if ($text): ?>
							<div class="callout-copy">
								<?php echo $text; ?>
							</div>
							<?php endif; ?>

							<?php if ($call_to_action): ?>
							<p class="cta">
								<a href="<?php echo $call_to_action_link; ?>" class="btn btn-green"<?php echo $target; ?>>
									<span class="bg"></span>
									<span class="txt">
										<?php echo $call_to_action_text; ?>
										<span class="icon icon-arrow-circle-right"></span>
									</span>
								</a>
							</p>
							<?php endif; ?>
						</div>
					<?php elseif (get_row_layout() == 'video_callout'): ?>
						<?php /* LAYOUT: VIDEO CALLOUT */ ?>
						<?php
							$video_url             = get_sub_field('video_url');
							$poster                = 'https://img.youtube.com/vi/' . $video_url . '/sddefault.jpg';
							$text                  = get_sub_field('text');
							$call_to_action        = get_sub_field('call_to_action');
							$call_to_action_text   = get_sub_field('call_to_action_text');
							$link_type             = get_sub_field('link_type');
							$internal_link         = get_sub_field('internal_link');
							$external_link         = get_sub_field('external_link');
							$call_to_action_link   = ($link_type == 1) ? $external_link : $internal_link;
							$call_to_action_target = get_sub_field('call_to_action_target');
						?>
						<div class="callout callout-video">
							<p class="callout-image">
								<a href="//www.youtube.com/watch?v=<?php echo $video_url; ?>" class="ga-exclude" data-behavior="modalize" data-title="<?php echo esc_html($title); ?>">
									<img src="<?php echo $poster; ?>" alt="<?php echo esc_html($title); ?>">
									<span class="icon icon-play-circle"></span>
								</a>
							</p>
							<h4><?php echo $title; ?></h4>

							<?php if ($text): ?>
							<div class="callout-copy">
								<?php echo $text; ?>
							</div>
							<?php endif; ?>

							<?php if ($call_to_action): ?>
							<p class="cta">
								<a href="<?php echo $call_to_action_link; ?>" class="btn btn-green"<?php echo $target; ?>>
									<span class="bg"></span>
									<span class="txt">
										<?php echo $call_to_action_text; ?>
										<span class="icon icon-arrow-circle-right"></span>
									</span>
								</a>
							</p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</aside>
<?php endif; ?>
