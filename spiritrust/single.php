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

						// DYNAMICALLY GET CONTENT TEMPLATE (e.g. content.php, etc)
						get_template_part('content', get_post_format());
					}
					?>
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
