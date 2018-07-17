<?php
$title  = wrapRegInSup(get_sub_field('title'));
$text   = wrapRegInSup(get_sub_field('text'));
$url    = get_sub_field('url');
$height = get_sub_field('height');
?>
<!-- MODULE: IFRAME -->
<div class="module module-iframe cf">
	<?php if ($title != ''): ?>
	<h2><?php echo $title; ?></h2>
	<?php endif; ?>

	<?php echo $text; ?>

	<iframe src="<?php echo $url; ?>" width="100%" height="<?php echo $height; ?>"></iframe>
</div>
