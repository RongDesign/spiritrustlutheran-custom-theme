<?php get_header(); ?>

<!-- PAGE CONTENT -->
<div id="main-content-wrapper" class="cf">
	<div class="container">

		<!-- MAIN CONTENT -->
		<div id="main-content">
			<!-- POST CONTENT -->
			<div id="post-content">
				<?php if (have_posts()): ?>
					<?php
					while (have_posts()) {
						the_post();

						// SEARCH TEMPLATE (content-search.php)
						get_template_part('content','search');
					}
					?>
					<?php if ($wp_query->max_num_pages > 1): ?>
					<div id="post-footer" class="search-results-footer cf">
						<?php
							// SEARCH RESULTS PAGINATION
							the_posts_pagination(
								array(
									'prev_text'          => __('<span class="icon icon-arrow-circle-left"></span> Previous Page', 'spiritrust'),
									'next_text'          => __('Next Page <span class="icon icon-arrow-circle-right"></span>', 'spiritrust'),
									'before_page_number' => '',
									'mid_size'           => '3'
								)
							);
						?>
					</div>
					<?php endif; ?>
				<?php else: ?>
					<h2 class="title">No Results</h2>
					<p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
				<?php endif; ?>
			</div>
		</div>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>
