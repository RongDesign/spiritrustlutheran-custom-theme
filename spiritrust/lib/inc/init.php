<?php
/* THEME INITIALIZATION */
function spiritrust_init() {
	/* remove extraneous meta tags from <head> */
	remove_action('wp_head', 'feed_links_extra', 3);             // Removes the links to the extra feeds such as category feeds
	remove_action('wp_head', 'feed_links', 2);                   // Removes links to the general feeds: Post and Comment Feed
	remove_action('wp_head', 'rsd_link');                        // Removes the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action('wp_head', 'wlwmanifest_link');                // Removes the link to the Windows Live Writer manifest file.
	remove_action('wp_head', 'index_rel_link');                  // Removes the index link
	remove_action('wp_head', 'parent_post_rel_link');            // Removes the prev link
	remove_action('wp_head', 'start_post_rel_link');             // Removes the start link
	remove_action('wp_head', 'adjacent_posts_rel_link');         // Removes the relational links for the posts adjacent to the current post.
	remove_action('wp_head', 'wp_generator');                    // Removes the WordPress version i.e. - WordPress 2.8.4
	remove_action('wp_head', 'print_emoji_detection_script', 7); // Removes Emoji script, which was added in WordPress 4.2
	remove_action('wp_print_styles', 'print_emoji_styles');      // Removes Emoji css block, which was added in WordPress 4.2

	/* register menus */
	register_nav_menu('main-menu', __('Main Menu'));
	register_nav_menu('secondary-menu', __('Secondary Menu'));
	register_nav_menu('footer-menu-left', __('Footer Menu'));

	/* remove tags support from posts */
	unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'spiritrust_init');

/* ENQUEUE SCRIPTS AND STYLESHEETS */
function spiritrust_enqueue_scripts() {
	/* enqueue site stylesheet */
	wp_enqueue_style('spiritrust',   get_stylesheet_uri());
    
	/* dashicon stylesheet */
	wp_enqueue_style( 'dashicons' );

	/* remove default jquery */
	wp_deregister_script('jquery');

	/* enqueue site scripts */
	wp_enqueue_script('respond',     get_template_directory_uri() . '/lib/js/respond.min.js',                array(), '', true);
	wp_enqueue_script('jquery',      get_template_directory_uri() . '/lib/js/jquery-1.12.2.min.js',          array(), '', true);
	wp_enqueue_script('easing',      get_template_directory_uri() . '/lib/js/jquery.easing.1.3.min.js',      array(), '', true);
	wp_enqueue_script('simplemodal', get_template_directory_uri() . '/lib/js/jquery.simplemodal.js',         array(), '', true);
	wp_enqueue_script('hoverintent', get_template_directory_uri() . '/lib/js/jquery.hoverIntent.1.8.min.js', array(), '', true);
	wp_enqueue_script('script',      get_template_directory_uri() . '/lib/js/script.js',                     array(), '', true);
}
add_action('wp_enqueue_scripts', 'spiritrust_enqueue_scripts');

/* remove LD+JSON meta data (via wordpress seo) */
add_filter('disable_wpseo_json_ld_search', '__return_true');
?>
