<?php
if (function_exists('bcn_display')): ?>
<!-- PAGE BREADCRUMBS -->
<div id="breadcrumbs">
	<div class="container">
		<?php bcn_display(); ?>

		<?php if (!is_search()): ?>
			<?php
				$protocol   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
				$path       = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$url        = $protocol . $path;

				if (is_archive()) {
					$title = get_the_title(get_option('page_for_posts'));
				} else {
					$title = get_the_title(get_post_or_blog_page_id());
				}
			?>
			<div id="social-share-icons">
				<ul class="clist cf social-links-list">
					<li>
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" class="ga-exclude facebook" data-network="Facebook" data-action="Share" target="_blank">
						Share
						</a>
					</li>
					<li>
						<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($url); ?>&title=<?php echo rawurlencode($title); ?>" class="ga-exclude linkedin" data-network="LinkedIn" data-action="Share" target="_blank">
						Share
						</a>
					</li>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
