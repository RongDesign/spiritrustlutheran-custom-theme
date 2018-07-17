<?php
/* register the "homeheroes" post type */
function spiritrust_register_post_type_homeheroes() {
	$labels = array(
		'name'                => 'Home Heroes',
		'singular_name'       => 'Home Hero',
		'add_new'             => 'Add Home Hero',
		'add_new_item'        => 'Add Home Hero',
		'edit_item'           => 'Edit Home Hero',
		'new_item'            => 'New Home Hero',
		'all_items'           => 'All Home Heroes',
		'view_item'           => 'View Home Heroes',
		'search_items'        => 'Search Home Heroes',
		'not_found'           => 'No Home Heroes found',
		'not_found_in_trash'  => 'No Home Heroes found in the Trash',
		'parent_item_colon'   => '',
		'menu_name'           => 'Home Heroes'
	);
	$args = array(
		'labels'             => $labels,
		'description'        => 'Contains all of the home page hero options.',
		'exclude_from_search'=> true,
		'public'             => true,
		'publicly_queryable' => false,
		'show_in_nav_menus'  => false,
		'menu_icon'          => 'dashicons-images-alt',
		'menu_position'      => 20,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'homeheroes')
	);
	register_post_type('homeheroes', $args);
}

/* register the "homecallouts" post type */
function spiritrust_register_post_type_homecallouts() {
	$labels = array(
		'name'               => 'Home Callouts',
		'singular_name'      => 'Home Callout',
		'add_new'            => 'Add Home Callout',
		'add_new_item'       => 'Add Home Callout',
		'edit_item'          => 'Edit Home Callout',
		'new_item'           => 'New Home Callout',
		'all_items'          => 'All Home Callouts',
		'view_item'          => 'View Home Callouts',
		'search_items'       => 'Search Home Callouts',
		'not_found'          => 'No Home Callouts found',
		'not_found_in_trash' => 'No Home Callouts found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Home Callouts'
	);
	$args = array(
		'labels'             => $labels,
		'description'        => 'Contains the three home page callouts.',
		'exclude_from_search'=> true,
		'public'             => true,
		'publicly_queryable' => false,
		'show_in_nav_menus'  => false,
		'menu_icon'          => 'dashicons-id-alt',
		'menu_position'      => 21,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'homecallouts')
	);
	register_post_type('homecallouts', $args);
}

/* register the "homeimagecallouts" post type */
function spiritrust_register_post_type_homeimagecallouts() {
	$labels = array(
		'name'               => 'Home Image Callouts',
		'singular_name'      => 'Home Image Callout',
		'add_new'            => 'Add Home Image Callout',
		'add_new_item'       => 'Add Home Image Callout',
		'edit_item'          => 'Edit Home Image Callout',
		'new_item'           => 'New Home Image Callout',
		'all_items'          => 'All Home Image Callouts',
		'view_item'          => 'View Home Image Callouts',
		'search_items'       => 'Search Home Image Callouts',
		'not_found'          => 'No Home Image Callouts found',
		'not_found_in_trash' => 'No Home Image Callouts found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Home Image Callouts'
	);
	$args = array(
		'labels'             => $labels,
		'description'        => 'Contains the home page image only callouts.',
		'exclude_from_search'=> true,
		'public'             => true,
		'publicly_queryable' => false,
		'show_in_nav_menus'  => false,
		'menu_icon'          => 'dashicons-images-alt2',
		'menu_position'      => 22,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'homeimagecallouts')
	);
	register_post_type('homeimagecallouts', $args);
}

/* register the "partners" post type */
function spiritrust_register_post_type_partners() {
	$labels = array(
		'name'               => 'Partners',
		'singular_name'      => 'Partner',
		'add_new'            => 'Add Partner',
		'add_new_item'       => 'Add Partner',
		'edit_item'          => 'Edit Partner',
		'new_item'           => 'New Partner',
		'all_items'          => 'All Partners',
		'view_item'          => 'View Partners',
		'search_items'       => 'Search Partners',
		'not_found'          => 'No Partners found',
		'not_found_in_trash' => 'No Partners found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Partners'
	);
	$args = array(
		'labels'             => $labels,
		'description'        => 'Listing of SpiriTrust Partners.',
		'exclude_from_search'=> true,
		'public'             => true,
		'publicly_queryable' => false,
		'show_in_nav_menus'  => false,
		'menu_icon'          => 'dashicons-groups',
		'menu_position'      => 35,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'sp_affiliates')
	);
	register_post_type('sp_affiliates', $args);
}

/* register the "callouts" post type */
function spiritrust_register_post_type_callouts() {
	$labels = array(
		'name'               => 'Callouts',
		'singular_name'      => 'Callout',
		'add_new'            => 'Add Callout',
		'add_new_item'       => 'Add Callout',
		'edit_item'          => 'Edit Callout',
		'new_item'           => 'New Callout',
		'all_items'          => 'All Callouts',
		'view_item'          => 'View Callouts',
		'search_items'       => 'Search Callouts',
		'not_found'          => 'No Callouts found',
		'not_found_in_trash' => 'No Callouts found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Callouts'
	);
	$args = array(
		'labels'             => $labels,
		'description'        => 'SpiriTrust Page Callouts.',
		'exclude_from_search'=> true,
		'public'             => true,
		'publicly_queryable' => false,
		'show_in_nav_menus'  => false,
		'menu_icon'          => 'dashicons-tablet',
		'menu_position'      => 40,
		'supports'           => array('title'),
		'hierarchical'       => false,
		'has_archive'        => false,
		'rewrite'            => array('slug' => 'callouts')
	);
	register_post_type('callouts', $args);
}

/* register the "jobs" post type */
function spiritrust_register_post_type_jobs() {
	$labels = array(
		'name'               => 'Careers',
		'singular_name'      => 'Career',
		'add_new'            => 'Add Career Listing',
		'add_new_item'       => 'Add Career Listing',
		'edit_item'          => 'Edit Career Listing',
		'new_item'           => 'New Career Listing',
		'all_items'          => 'All Careers',
		'view_item'          => 'View Careers',
		'search_items'       => 'Search Careers',
		'not_found'          => 'No Careers found',
		'not_found_in_trash' => 'No Careers found in the Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Careers'
	);
	$capabilities = array(
		'edit_post'          => 'edit_career',
		'read_post'          => 'read_career',
		'delete_post'        => 'delete_career',
		'edit_posts'         => 'edit_careers',
		'edit_others_posts'  => 'edit_others_careers',
		'publish_posts'      => 'publish_careers',
		'read_private_posts' => 'read_private_careers',
		'delete_posts'       => 'delete_careers',
		'delete_others_posts'=> 'delete_others_careers'
	);
	$args = array(
		'labels'             => $labels,
		'capabilities'       => $capabilities,
		'description'        => 'SpiriTrust Career Listings.',
		'exclude_from_search'=> false,
		'public'             => true,
		'publicly_queryable' => true,
		'show_in_nav_menus'  => false,
		'menu_icon'          => 'dashicons-clipboard',
		'menu_position'      => 35,
		'supports'           => array('title'),
		'hierarchical'       => true,
		'has_archive'        => true,
		'rewrite'            => array('slug' => 'careers/career-listings')
	);
	register_post_type('careers', $args);
}

/* register spiritrust custom post types */
function spiritrust_register_post_types() {
	spiritrust_register_post_type_homeheroes();
	spiritrust_register_post_type_homecallouts();
	spiritrust_register_post_type_homeimagecallouts();
	spiritrust_register_post_type_partners();
	spiritrust_register_post_type_callouts();
	spiritrust_register_post_type_jobs();
}
add_action('init', 'spiritrust_register_post_types');
?>
