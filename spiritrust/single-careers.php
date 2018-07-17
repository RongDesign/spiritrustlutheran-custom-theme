<?php get_header(); ?>

<!-- PAGE CONTENT -->
<div id="main-content-wrapper" class="cf">
	<div class="container">
		<?php if (have_posts()): ?>
			<!-- MAIN CONTENT -->
			<div id="main-content">
				<!-- POST CONTENT -->
				<div id="post-content">
					<?php while (have_posts()): the_post(); ?>
						<?php
							$post_meta         = get_post_meta($post->ID);
							$location          = $post_meta['city'][0] . ', '.$post_meta['state'][0] . ' ' . $post_meta['postal_code'][0];
							$company           = $post_meta['company'][0];
							$job_type          = $post_meta['job_type'][0];
							$apply_url         = $post_meta['url'][0];
							$job_description   = nl2p($post_meta['job_description'][0]);
						?>
						<p class="cta">
							<a href="<?php echo $apply_url; ?>" class="btn btn-green" target="_blank">
								<span class="bg"></span>
								<span class="txt">
									Apply Now
									<span class="icon icon-arrow-circle-right"></span>
								</span>
							</a>
						</p>
						<p>
							<?php echo the_date('m/d/Y', '<strong>Date Posted: </strong>', ''); ?>
							<br><strong>Location: </strong> <?php echo $location; ?>
							<br><strong>Company: </strong> <?php echo $company; ?>
							<br><strong>Job Type: </strong> <?php echo $job_type; ?>
						</p>
						<div class="careers-job-description">
							<?php echo $job_description; ?>
						</div>
					<?php endwhile; ?>
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
