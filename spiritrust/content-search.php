<div id="post-<?php the_ID(); ?>" class="post cf">
	<?php
		$excerpt = '';
		if (!get_the_excerpt()) {
			/* no excerpt, get ACF field 'intro_copy' */
			$intro_copy = get_field('intro_copy');
			if ($intro_copy != '') {
				$excerpt = wp_trim_words($intro_copy,$num_words = 32, $more = '...');
			}
		} else {
			$excerpt = get_the_excerpt();
		}

		if ($excerpt == '') {
			the_title(sprintf('<h2 class="title no-excerpt"><a href="%s">', esc_url(get_permalink())), '</a></h2>');
		} else {
			the_title(sprintf('<h2 class="title"><a href="%s">', esc_url(get_permalink())), '</a></h2>');
			echo "<p>" . wrapRegInSup($excerpt) . "</p>";
		}
	?>
</div>
