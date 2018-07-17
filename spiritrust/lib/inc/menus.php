<?php
/* WALKER: MAIN MENU */
class MainMenu_Walker extends Walker_Nav_Menu {
	/* create private variable to be used across this walker's functions */
	private $curItem;

	/* START LEVEL */
	function start_lvl(&$output, $depth = 0, $args = array()) {
		/*
			The page ID (or object ID, since a menu item can link to any object) is stored in the postmeta table,
			with the key '_menu_item_object_id', the following will return the page ID
		*/

		if ($depth == 0) {
			$menu_id  = $this->curItem->ID;
			$page_id  = get_post_meta($menu_id, '_menu_item_object_id', true);
			$image    = get_field('page_feature_image', $page_id);
			$imagesrc = wp_get_attachment_image_src($image,'dropdown-image');

			$output .= '<div class="dropdown">';
			$output .= '<div class="dropdown-photo" data-src="' . $imagesrc[0] . '" data-alt="' . esc_html($this->curItem->title) . '"></div>';
			$output .= '<ul class="dropdown-nav clist cf">';
			$output .= '<li class="mobile-only"><a href="' . $this->curItem->url . '">Overview</a></li>';
		} else {
			$output .= '<ul class="clist cf">';
		}
	}

	/* END LEVEL */
	function end_lvl(&$output, $depth = 0, $args = array()) {
		if ($depth == 0) {
			$output .= '</ul>';
			$output .= '</div>';
		} else {
			$output .= '</ul>';
		}
	}

	/* START ITEM */
	function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0) {
		/* store object into private var for use inside the 'start_lvl' function */
		$this->curItem = $object;
		parent::start_el($output, $object, $depth, $args);
	}
}

/* WALKER: MAIN MENU (SIDEBAR) */
class MainMenuSidebar_Walker extends Walker_Nav_Menu {
	/* create private variables to be used across this walker's functions */
	private $startLevels = false;
	private $levelTotal = 0;

	/* START LEVEL */
	function start_lvl(&$output, $depth = 0, $args = array()) {
		if ($this->startLevels == true) {
			/* output the start level after our first instance (since we're not showing the ancestor) */
			if ($this->levelTotal > 0) {
				$output .= '<ul>';
			}
			$this->levelTotal = $this->levelTotal + 1;
		}
	}

	/* END LEVEL */
	function end_lvl(&$output, $depth = 0, $args = array()) {
		if ($this->startLevels == true) {
			if ($this->levelTotal > 1) {
				$output .= '</ul>';
			}
			$this->levelTotal = $this->levelTotal - 1;

			/* once we matched all our opening levels with closing levels, reset startLevels variable to prevent further output */
			if ($this->levelTotal == 0) {
				$this->startLevels = false;
			}
		}
	}

	/* START ITEM */
	function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
		/* we've encountered the page ancestor, let's build out its children/grandchildren (not including the ancestor) */
		if (in_array('current-page-ancestor', $item->classes)) {
			/* create private variable to be used across the walker so that it knows to start a level */
			$this->startLevels = true;
		}

		/* only start showing items below the ancestor */
		if ($this->startLevels && $this->levelTotal > 0) {
			parent::start_el($output, $item, $depth, $args);
		}
	}

	/* END ITEM */
	function end_el(&$output, $item, $depth = 0, $args = array()) {
		/* only start showing items below the ancestor */
		if ($this->startLevels && $this->levelTotal > 0) {
			parent::end_el($output, $item, $depth, $args);
		}
	}
}
?>
