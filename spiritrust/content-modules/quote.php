<?php
$text   = wrapRegInSup(get_sub_field('text'));
$author = wrapRegInSup(get_sub_field('author'));
?>
<!-- MODULE: QUOTE -->
<div class="module module-quote cf">
	<p class="quote"><?php echo $text; ?></p>
	<p class="author"><?php echo "&ndash; " . $author; ?></p>
</div>
