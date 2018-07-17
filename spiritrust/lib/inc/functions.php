<?php
/* GET POST ID ($post->ID) OR BLOG HOME PAGE ID (get_option('page_for_posts')) */
if (!function_exists('get_post_or_blog_page_id')) {
	function get_post_or_blog_page_id() {
		global $post;

		if (get_post_type($post) == 'careers') {
			$page = get_page_by_path('/careers/career-listings/');
			return $page->ID;;
		} else if (is_home()) {
			return get_option('page_for_posts');
		}
		return $post->ID;
	}
}

/* GET CALLOUTS */
if (!function_exists('get_callouts')) {
	function get_callouts() {
		global $post;
		$hasCallouts = false;

		$id = get_post_or_blog_page_id();

		if (get_field('callout', $id)) {
			$hasCallouts = true;
		}
		return $hasCallouts;
	}
}

/* GET BLOG HOME PAGE URL (ASSUMES STATIC HOME PAGE) */
if (!function_exists('get_blog_url')) {
	function get_blog_url() {
		$posts_page_id  = get_option('page_for_posts');
		$posts_page_url = get_page_uri($posts_page_id);

		return get_home_url() . "/" . $posts_page_url;
	}
}

/* GET SIDEBAR NAVIGATION */
if (!function_exists('get_sidebar_navigation')) {
	function get_sidebar_navigation() {
		global $post;

		$careersListingID = '';
		$aside_navigation = '';
		$main_menu_sidebar = wp_nav_menu(
			array(
				'container'      => '',
				'items_wrap'     => '%3$s',
				'theme_location' => 'main-menu',
				'echo'           => false,
				'walker'         => new MainMenuSidebar_Walker()
			)
		);

		if ($main_menu_sidebar) {
			/* PAGE IS PART OF MAIN MENU, RETURN RELATIVE SECTION */
			$aside_navigation = $main_menu_sidebar;
		} else {
			/* PAGE IS NOT PART OF MAIN MENU, GET TOP MOST ANCESTOR, RETURN LANDING PAGE OPTIONS (ASSUMES TOP MOST PAGE IS A LANDING PAGE TEMPLATE) */
			$id = $post->ID;

			// IF WE'RE ON CAREER LISTINGS PAGE, GRAB PARENT PAGE 'CAREERS'
			if (get_post_type($post) == 'careers') {
				$careersID = url_to_postid('/careers/');
				$careersListingID = url_to_postid('/careers/career-listings/');

				if ($careersID != 0) {
					$id = $careersID;
				}
			}

			if ($post->post_parent) {
				$id = $post->post_parent;

				if ($post->ancestors) {
					$id = end($post->ancestors);
				}
			}

			if (have_rows('landing_page_modules', $id)) {
				while (have_rows('landing_page_modules', $id)) {
					the_row();
					$title         = get_sub_field('title');
					$link_type     = get_sub_field('link_type');
					$internal_link = get_sub_field('internal_link');
					$external_link = get_sub_field('external_link');
					$link          = ($link_type == 1) ? $external_link : $internal_link;
					$target        = (get_sub_field('target') == 1) ? ' target="_blank"' : '';
					$class         = '';
					$liClass       = '';
					$page_id       = url_to_postid($internal_link);

					// OR SEE CHECK IF THE CAREER LISTINGS PAGE IS A MATCH
					if ($post->ID == $page_id || $page_id == $careersListingID) {
						$liClass = ' class="current_page_item"';
					}
					if ($target != '') {
						$class = ' class="external"';
					}

					$aside_navigation .= '<li' . $liClass . '>';
					$aside_navigation .= '<a href="' . $link . '"' . $class . $target . '>';
					$aside_navigation .= $title;
					$aside_navigation .= '</a>';

					$hasChildPages = null;
					if ($page_id != 0) {
						$hasChildPages = wp_list_pages("title_li=&child_of=" . $page_id . "&echo=0");
					}
					if ($hasChildPages) {
						$aside_navigation .= '<ul>' . $hasChildPages . '</ul>';
					}
					$aside_navigation .= '</li>';
				}
			}
		}
		return $aside_navigation;
	}
}

/* NEW LINES TO PARAGRAPHS */
if (!function_exists('nl2p')) {
	function nl2p($string, $line_breaks = true, $xml = true) {

	$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

	// It is conceivable that people might still want single line-breaks
	// without breaking into a new paragraph.
	if ($line_breaks == true)
		return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'), trim($string)).'</p>';
	else
		return '<p>'.preg_replace(
		array("/([\n]{2,})/i", "/([\r\n]{3,})/i","/([^>])\n([^<])/i"),
		array("</p>\n<p>", "</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'),

		trim($string)).'</p>';
	}
}

/* WRAP REGISTER MARKS */
if (!function_exists('wrapRegInSup')) {
	function wrapRegInSup($string) {
		if ($string != '') {
			$string = preg_replace('#®(?!\s*</sup>|[^<]*>)#','<sup>®</sup>', $string);
			$string = preg_replace('#&reg;(?!\s*</sup>|[^<]*>)#','<sup>&reg;</sup>', $string);
		}
		return $string;
	}
}

/* TRIM TEXT */
if (!function_exists('trim_text')) {
	function trim_text($input, $length, $ellipses = true, $strip_html = true) {
		//strip tags, if desired
		if ($strip_html) {
			$input = strip_tags($input);
		}
		//no need to trim, already shorter than trim length
		if(strlen($input) <= $length){
			return $input;
		}
		//find last space within length
		$last_space = strrpos(substr($input, 0, $length), ' ');
		$trimmed_text = substr($input, 0, $last_space);
		//add ellipses (...)
		if ($ellipses) {
			$trimmed_text .= ' ...';
		}
		return $trimmed_text;
	}
}
?>