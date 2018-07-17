<?php
/* FILTER THE URL OF THE LOGO IN WORDPRESS LOGIN PAGE */
function spiritrust_admin_headerurl() {
	return home_url();
}
add_filter('login_headerurl', 'spiritrust_admin_headerurl');

/* ADD/REMOVE ADMIN MENU ITEMS */
function spiritrust_admin_menu() {
	// REMOVE COMMENTS LINK
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'spiritrust_admin_menu');

/* REMOVE WORDPRESS LOGO/LINKS FROM ADMIN BAR */
function spiritrust_admin_bar_remove() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'spiritrust_admin_bar_remove');

/* REMOVE WORDPRESS SEO (YOAST) DASHBOARD WIDGET */
function spiritrust_hide_yoastseo() {
	if (!current_user_can('manage_options')) :
		remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'side');
	endif;
}
add_action('admin_init', 'spiritrust_hide_yoastseo');

/* TINYMCE BLOCK FORMAT UPDATES */
function spiritrust_format_tinyMCE($in) {
	$default_colors = '
		"FFFFFF", "White",
		"EEEEEE", "Light Gray",
		"666666", "Gray",
		"000000", "Black",
		"2A4f73", "Dark Blue",
		"25AAE1", "Blue",
		"89BC40", "Green",
		"2690B1", "Teal"
	';

	$in['block_formats'] = "Paragraph=p;Header 2=h2;Header 3=h3;Header 4=h4;Header 5=h5;Header 6=h6;Preformatted=pre";
	$in['textcolor_map'] = '[' . $default_colors . ']';

	return $in;
}
add_filter('tiny_mce_before_init', 'spiritrust_format_tinyMCE');

/* ENQUEUE ADMIN CSS */
function spiritrust_admin_login_css() {
?>
	<style type="text/css">
		#wp-admin-bar-wp-logo {
			display: none;
		}
		body.login {
			background: #2a4f73;
		}
		body.login h1 {
			background: #fff;
		}
		body.login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/lib/img/admin/logo.png);
			background-size: auto;
			background-position: center 5px;
			margin-bottom: 0px;
			padding-bottom: 0px;
			width: 100%;
		}
		body.login form {
			box-shadow: none;
			margin-top: 0px;
			padding-bottom: 26px;
		}
		body.login #nav {
			background: #fff;
			margin-top: 0px;
			padding-bottom: 10px;
		}
		body.login #backtoblog {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/lib/img/admin/bg-angle.png);
			background-position: right bottom;
			margin-top: 0px;
			padding-bottom: 40px;
			padding-top: 10px;
		}
		a {
			color: #89bc40;
		}
		a:active, a:hover {
			color: #78a933;
		}
		.login #backtoblog a:hover, .login #nav a:hover {
			color: #78a933;
		}
		.login .message {
			border-color: #89bc40;
		}
		.wp-core-ui .button-primary {
			background: #89bc40;
			border-color: #89bc40;
			box-shadow: none;
			text-shadow: none;
		}
		.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover,
		.wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover {
			background: #78a933;
			border-color: #78a933;
		}
		.wp-core-ui .button-primary.active, .wp-core-ui .button-primary.active:focus,
		.wp-core-ui .button-primary.active:hover, .wp-core-ui .button-primary:active {
			background: #78a933;
			border-color: #78a933;
		}
		.wp-core-ui .button-primary.active, .wp-core-ui .button-primary.active:focus,
		.wp-core-ui .button-primary.active:hover, .wp-core-ui .button-primary:active {
			box-shadow: none;
		}
	</style>
<?php
}
add_action('login_enqueue_scripts', 'spiritrust_admin_login_css');

/* ADMIN DASHBOARD WIDGET */
function spiritrust_dashboard_widget_function() {
?>
	<p>
		<strong>Logo</strong>
		<br><a href="/wp-content/themes/spiritrust/lib/img/logo/spiritrust-lutheran.png" class="logo" target="_blank"><img src="/wp-content/themes/spiritrust/lib/img/logo/spiritrust-lutheran.png" alt="SpiriTrust Lutheran Logo"></a>
	</p>
	<strong>Colors</strong>
	<table>
		<tr>
			<td style="background-color: #2a4f73">#2a4f73</td>
			<td style="background-color: #89bc40">#89bc40</td>
			<td style="background-color: #2690b1">#2690b1</td>
			<td style="background-color: #25aae1">#2690b1</td>

		</tr>
	</table>
	<?php if (current_user_can('manage_options')): ?>
	<p>
		<strong>Theme Settings</strong>
		<br>Update the SpiriTrust Lutheran <a href="/wp-admin/admin.php?page=theme-general-settings">Site Settings</a> here.
	</p>
	<?php endif; ?>
<?php
}

function spiritrust_dashboard_widget() {
	wp_add_dashboard_widget(
		'spiritrust_dashboard_widget',
		'SpiriTrust Lutheran Notes',
		'spiritrust_dashboard_widget_function'
	);
}
add_action('wp_dashboard_setup', 'spiritrust_dashboard_widget');

function spiritrust_admin_css() {
?>
	<style type="text/css">
		/* ACF: hide message title */
		#spiritrust_dashboard_widget .inside {
			position: relative;
		}
		#spiritrust_dashboard_widget .logo {
			display: block;
		}
		#spiritrust_dashboard_widget .logo img {
			height: auto;
			width: 100%;
		}
		#spiritrust_dashboard_widget table {
			width: 100%;
		}
		#spiritrust_dashboard_widget table td {
			color: #ffffff;
			padding: 15px 5px;
			text-align: center;
			width: 25%;
		}
	</style>
<?php
}
add_action('admin_head', 'spiritrust_admin_css');

/* CUSTOM TINYMCE BUTTON */
/* declare script for new button */
function spiritrust_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['spiritrust_mce_button'] = get_template_directory_uri() . '/lib/js/tinymce/button-shortcode.js';
	return $plugin_array;
}

/* register new button in the editor */
function spiritrust_register_mce_button( $buttons ) {
	array_push( $buttons, 'spiritrust_mce_button' );
	return $buttons;
}

/* hooks functions into the correct filters */
function spiritrust_add_mce_button() {
	// check user permissions
	if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
		return;
	}
	// check if WYSIWYG is enabled
	if (get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'spiritrust_add_tinymce_plugin');
		add_filter('mce_buttons', 'spiritrust_register_mce_button');
	}
}
add_action('admin_head', 'spiritrust_add_mce_button');

/* CLEAR W3TC PAGE CACHE WHEN CUSTOM POST TYPES ARE EDITED */
function spiritrust_flush_w3cache_from_customposttypes($post_ID) {
	if (function_exists('w3tc_pgcache_flush')) {
		/*
		homeheroes
		homecallouts
		homeimagecallouts
		sp_affiliates
		callouts
		careers
		*/
		if (get_post_type($post_id) == 'homeheroes' || get_post_type($post_id) == 'homecallouts' || get_post_type($post_id) == 'homeimagecallouts' || get_post_type($post_id) == 'sp_affiliates' || get_post_type($post_id) == 'callouts' || get_post_type($post_id) == 'careers') {
			// function w3tc_flush_all to broad, w3tc_pgcache_flush seems to be the best fit
			//w3tc_flush_all();
			w3tc_pgcache_flush();
		}
	}
	return $post_ID;
}
add_action('edit_post', 'spiritrust_flush_w3cache_from_customposttypes');
?>
