<?php
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(
		array(
			'page_title' => 'SpiriTrust Lutheran Site Settings',
			'menu_title' => 'Site Settings',
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'manage_options', // default: edit_posts
			'redirect'   => false
		)
	);
	/*
	acf_add_options_sub_page(
		array(
			'page_title'  => 'Theme Social Settings',
			'menu_title'  => 'Social',
			'parent_slug' => 'theme-general-settings',
		)
	);
	*/
}
?>
