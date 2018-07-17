<?php
$intro_title = get_sub_field('intro_title');
$intro_text  = get_sub_field('intro_text');
$i           = 1;
?>
<?php if (have_rows('expandcollapse_list')): ?>
	<!-- MODULE: EXPAND/COLLAPSE -->
	<div class="module module-expand-collapse cf">
		<?php if ($intro_title != ''): ?>
		<h2><?php echo $intro_title; ?></h2>
		<?php endif; ?>

		<?php echo $intro_text; ?>

		<?php while(have_rows('expandcollapse_list')): the_row(); ?>
			<?php
			$title   = wrapRegInSup(get_sub_field('title'));
			$details = get_sub_field('details');
			?>
				<div class="expand-collapse-item cf">
					<p class="ec-title">
						<a href="#item<?php echo $i; ?>" title="Show Details">
							<span class="txt"><?php echo $title; ?></span>
							<span class="icon icon-angle-down"></span>
						</a>
					</p>
					<div class="ec-details cf">
						<?php echo $details; ?>
					</div>
				</div>
			<?php $i++; ?>
		<?php endwhile; ?>
	</div>
<?php endif; ?>
