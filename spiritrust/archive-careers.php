<?php get_header(); ?>
<!-- PAGE CONTENT -->
<div id="main-content-wrapper" class="cf">
	<div class="container">
		<?php if (have_posts()): ?>
			<!-- MAIN CONTENT -->
			<div id="main-content">

				<!-- CAREERS ARCHIVE CONTENT -->
				<?php echo do_shortcode( '[searchandfilter slug="careers-search"]' ); ?>

				<div id="post-content">
					<?php
					while (have_posts()) {
						the_post();
						// ARCHIVE TEMPLATE (content-careers.php)
						get_template_part('content','careers');
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
