<?php
$title                 = wrapRegInSup(get_sub_field('title'));
$text                  = wrapRegInSup(get_sub_field('text'));
$add_call_to_action    = get_sub_field('add_call_to_action');
$call_to_action_text   = get_sub_field('call_to_action_text');
$link_type             = get_sub_field('link_type');
$internal_link         = get_sub_field('internal_link');
$external_link         = get_sub_field('external_link');
$call_to_action_link   = ($link_type == 1) ? $external_link : $internal_link;
$call_to_action_target = get_sub_field('call_to_action_target');
$target                = (get_sub_field('call_to_action_target') == 1) ? ' target="_blank"' : '';
?>
<!-- MODULE: GENERAL -->
<div class="module cf">
	<?php if ($title != ''): ?>
	<h2><?php echo $title; ?></h2>
	<?php endif; ?>

	<?php echo $text; ?>

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
</div>
