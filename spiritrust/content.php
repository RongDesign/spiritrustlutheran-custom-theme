<?php if (is_single()): ?>
	<div id="post-<?php the_ID(); ?>" class="post post-single cf">
		<?php the_content(__('Read More', 'spiritrust')); ?>
	</div>
<?php else: ?>
	<div id="post-<?php the_ID(); ?>" class="post cf">
	<?php
		if (is_home()) {
			$categories = get_the_category();
			if (!empty($categories)) {
				$separator = '';
				$categorylist = '';

				foreach($categories as $category) {
					$categorylist .= $separator . esc_html($category->name);
					$separator = ',';
				}
			}
			echo '<p class="category">' . $categorylist . '</p>';
		}
		the_title(sprintf('<h2 class="title"><a href="%s">', esc_url(get_permalink())), '</a></h2>');
		the_date('m/d/Y', '<p class="date">', '</p>');
		the_excerpt();
	?>
	</div>
<?php endif; ?>
