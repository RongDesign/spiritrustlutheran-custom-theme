<?php get_header(); ?>

<!-- PAGE CONTENT -->
<div id="main-content-wrapper" class="cf">
	<div class="container">
		<?php if (have_posts()): ?>
			<?php
			$callouts         = get_callouts();;
			$aside_navigation = get_sidebar_navigation();
			$fullColumnClass  = ($aside_navigation == '' && !$callouts) ? ' class="full-column"' : '';
			?>

			<!-- MAIN CONTENT -->
			<div id="main-content"<?php echo $fullColumnClass; ?>>
				<?php
				while (have_posts()): the_post();
					// PAGE TEMPLATE (content-page.php)
					get_template_part('content','page');
				endwhile;
				?>
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
