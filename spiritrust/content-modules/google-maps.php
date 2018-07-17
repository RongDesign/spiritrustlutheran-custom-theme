<?php
$title           = wrapRegInSup(get_sub_field('title'));
$text            = wrapRegInSup(get_sub_field('text'));
$use_labels      = get_sub_field('use_labels');
$use_label_text  = '';
$label_type      = get_sub_field('label_type');
$label_type_text = '';
$labeltext       = '';
$locations_total = count(get_sub_field('map_locations'));
$classname       = '';
$i               = 0;

if ($use_labels) {
	$use_label_text = ' data-use-label="true"';
	if ($label_type == '1') {
		$labeltext = '123456789';
	} else {
		$labeltext = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	}
}
?>
<?php if (have_rows('map_locations')): ?>
	<!-- MODULE: MAP -->
	<div class="module module-map cf">
		<?php if ($title != ''): ?>
		<h2><?php echo $title; ?></h2>
		<?php endif; ?>

		<?php if ($text != ''): ?>
		<p><?php echo $text; ?></p>
		<?php endif; ?>

		<div class="map-wrapper">
			<div class="map-canvas-wrapper">
				<div class="map-canvas"></div>
			</div>

			<ul class="map-list clist cf"<?php echo $use_label_text; ?>>
				<?php while(have_rows('map_locations')): the_row(); ?>
					<?php
					$location_title        = wrapRegInSup(get_sub_field('location_title'));
					$latitude              = get_sub_field('latitude');
					$longitude             = get_sub_field('longitude');
					$address               = wrapRegInSup(get_sub_field('address'));
					$add_call_to_action    = get_sub_field('add_call_to_action');
					$call_to_action_text   = get_sub_field('call_to_action_text');
					$link_type             = get_sub_field('link_type');
					$internal_link         = get_sub_field('internal_link');
					$external_link         = get_sub_field('external_link');
					$call_to_action_link   = ($link_type == 1) ? $external_link : $internal_link;
					$call_to_action_target = get_sub_field('call_to_action_target');
					$target                = (get_sub_field('call_to_action_target') == 1) ? ' target="_blank"' : '';

					if ($labeltext != '') {
						if ($i > strlen($labeltext)) {
							$i = 0;
						}
						$char = substr($labeltext, $i, 1);
						$label_type_text = ' data-label="' . $char . '"';
					}
					?>
					<li class="location"<?php echo $label_type_text; ?>>
						<p class="name"><?php echo $location_title; ?></p>
						<p class="latlng">
							<span class="lng"><?php echo $longitude; ?></span>
							<span class="sep">,</span>
							<span class="lat"><?php echo $latitude; ?></span>
						</p>
						<p class="address"><?php echo $address; ?></p>

						<?php if ($add_call_to_action): ?>
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
					</li>
					<?php $i++; ?>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>
