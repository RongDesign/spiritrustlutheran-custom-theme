<?php get_header(); ?>
<!-- PAGE CONTENT -->
<div id="main-content-wrapper" class="cf">
	<div class="container">
		<?php if (have_posts()): ?>
			<!-- MAIN CONTENT -->
			<div id="main-content">
				<!-- POST CONTENT -->
				<div id="post-content">
					<?php
					while (have_posts()) {
						the_post();

						// CONTENT TEMPLATE (e.g. content.php)
						get_template_part('content', get_post_format());
					}
					?>

					<?php if ($wp_query->max_num_pages > 1): ?>
					<div id="post-footer" class="cf">
						<p class="nav-newer">
							<?php echo get_previous_posts_link('Newer Posts <span class="icon icon-arrow-circle-right"></span>'); ?>
						</p>
						<p class="nav-older">
							<?php echo get_next_posts_link('<span class="icon icon-arrow-circle-left"></span> Older Posts'); ?>
						</p>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		<?php else: ?>
			<?php
				// NOT FOUND TEMPLATE (content-none.php)
				get_template_part('content', 'none');
			?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
