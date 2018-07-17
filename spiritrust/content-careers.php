<?php
$pid = get_the_ID();
?>
<?php if (get_field("active_listing",$pid)): ?>
	<div id="post-<?php the_ID(); ?>" class="post cf">
		<?php
			$employer     = get_field('company', $pid);
			$referenceNumber = get_field('reference_number', $pid);
			$city         = get_field('city', $pid);
			$state        = get_field('state', $pid);
			$zip          = get_field('postal_code', $pid);
			$description  = trim_text(get_field('job_description', $pid),500,$ellipses = true, $strip_html = true);
			$job_type     = ucwords(str_replace('_', ' ', get_field('job_type', $pid)),' ');
			$job_category = get_field('job_category', $pid);
			$job_division = get_field('job_division', $pid);
			$source       = get_field('source_of_listing',$pid);
		?>
		<?php the_title(sprintf('<h2 class="title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
		<p class="date"><?php echo $city . ', ' . $state; ?><span class="positionType"><?php echo $job_type; ?></span></p>
		<p><?php echo $description; ?></p>

		<p class="cta">
			<a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-green">
				<span class="bg"></span>
				<span class="txt">
					Job Description
					<span class="icon icon-arrow-circle-right"></span>
				</span>
			</a>
		</p>
		<p class="cta">
			<a target="_blank" href="https://pm.healthcaresource.com/CareerSite/lutheran/job.aspx?jobid=<?php echo $referenceNumber ?>" class="btn btn-green">
				<span class="bg"></span>
				<span class="txt">
					Apply Now
					<span class="icon icon-arrow-circle-right"></span>
				</span>
			</a>
		</p>
	</div>
<?php endif; ?>
