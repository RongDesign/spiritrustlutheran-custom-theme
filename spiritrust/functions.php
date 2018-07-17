<?php
function spiritrust_setup_theme() {
	require 'lib/inc/init.php';
	require 'lib/inc/functions.php';
	require 'lib/inc/formatting.php';
	require 'lib/inc/acf.php';
	require 'lib/inc/menus.php';
	require 'lib/inc/post-types.php';
	require 'lib/inc/shortcodes.php';
	require 'lib/inc/image-sizes.php';
	require 'lib/inc/scheduled-events.php';
	require 'lib/inc/admin.php';
}
add_action('after_setup_theme', 'spiritrust_setup_theme');
