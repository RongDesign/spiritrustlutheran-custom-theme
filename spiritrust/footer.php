<?php
$affiliates = get_field('affiliates', 'option');
$copyright  = get_field('copyright', 'option');
$copyright_link  = get_field('copyright_link', 'option');
?>
	</section>

	<?php if (!is_404()): ?>
	<!-- FOOTER -->
	<footer id="footer">
		<!-- NEWSLETTER SIGNUP -->
		<div id="newsletter-wrapper">
			<div class="container cf">
				<p class="title">Stay In Touch</p>
				<p class="label">Sign up for our newsletters here.</p>

				<a href="/newsletters/" class="btn btn-green">
					<span class="bg"></span>
					<span class="txt">
						Continue
						<span class="icon icon-arrow-circle-right"></span>
					</span>
				</a>
			</div>
		</div>

		<?php if ($affiliates && !is_page_template('page-templates/affiliates.php')): ?>
		<!-- AFFILIATES -->
		<div id="affiliates-wrapper">
			<div class="container cf">
				<ul id="affiliates-list" class="clist cf">
					<?php foreach($affiliates as $affiliate): ?>
					<?php
						$id            = $affiliate['affiliate']->ID;
						$title         = get_the_title($id);
						$image         = get_field('image', $id);
						$imagesrc      = wp_get_attachment_image_src($image,'affiliate-logo');
						$link_type     = get_field('link_type', $id);
						$internal_link = get_field('internal_link', $id);
						$external_link = get_field('external_link', $id);
						$link          = ($link_type == 1) ? $external_link : $internal_link;
						$target        = (get_field( "target", $id) == 1) ? ' target="_blank"' : '';
					?>
					<li>
						<?php if ($link_type): ?>
						<a href="<?php echo $link; ?>"<?php echo $target; ?>>
						<?php else: ?>
							<span class="nolink">
						<?php endif; ?>
							<img src="<?php echo $imagesrc[0]; ?>" width="<?php echo $imagesrc[1]; ?>" height="<?php echo $imagesrc[2]; ?>" alt="<?php echo esc_html($title); ?>">
						<?php if ($link_type): ?>
						</a>
						<?php else: ?>
						</span>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>

					<li>
						<a href="/partners/">
							View All
							<span class="icon icon-arrow-circle-right"></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php endif; ?>

		<!-- COPYRIGHT -->
		<div id="copyright">
			<div class="container cf">
				<div class="footer-list-wrapper cf">
					<!-- FOOTER LINKS -->
					<?php
						wp_nav_menu(
							array(
								'container'      => '',
								'items_wrap'     => '<ul class="footer-list clist cf">%3$s</ul>',
								'theme_location' => 'footer-menu-left',
								'link_before'    => '<span class="bg"></span><span class="txt">',
								'link_after'     => '</span>'
							)
						);
					?>
				</div>

				<p id="copyright-tagline">
					<?php if ($copyright_link): ?>
						<a href="<?php echo $copyright_link; ?>" rel="nofollow">
					<?php endif; ?>
					Copyright &copy; <?php echo date('Y'); ?> <?php echo wrapRegInSup($copyright); ?>
					<?php if ($copyright_link): ?>
						</a>
					<?php endif; ?>
				</p>
			</div>
		</div>
	</footer>
	<?php endif; ?>

	<?php wp_footer(); ?>
</body>
</html>
