<?php
/* limit excerpt char length */
function new_excerpt_length($length) {
	return 32;
}
add_filter('excerpt_length', 'new_excerpt_length');

/* customize what excerpt more returns */
function new_excerpt_more($more) {
	global $post;
	return '...';
	//return '... <a class="more" href="' . get_permalink($post->ID) . '">Read More</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

/* wrap any register marks in the title in <sup> script */
function wrap_title_register_in_sup_tag($title) {
	return wrapRegInSup($title);
}
add_filter('the_title','wrap_title_register_in_sup_tag');

function my_map_meta_cap( $caps, $cap, $user_id, $args ) {

	/* If editing, deleting, or reading a movie, get the post and post type object. */
	if ( 'edit_career' == $cap || 'delete_career' == $cap || 'read_career' == $cap ) {
		$post = get_post( $args[0] );
		$post_type = get_post_type_object( $post->post_type );

		/* Set an empty array for the caps. */
		$caps = array();
	}

	/* If editing a movie, assign the required capability. */
	if ( 'edit_career' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->edit_posts;
		else
			$caps[] = $post_type->cap->edit_others_posts;
	}

	/* If deleting a movie, assign the required capability. */
	elseif ( 'delete_career' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->delete_posts;
		else
			$caps[] = $post_type->cap->delete_others_posts;
	}

	/* If reading a private movie, assign the required capability. */
	elseif ( 'read_career' == $cap ) {

		if ( 'private' != $post->post_status )
			$caps[] = 'read';
		elseif ( $user_id == $post->post_author )
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
	}

	/* Return the capabilities required by the user. */
	return $caps;
}
add_filter( 'map_meta_cap', 'my_map_meta_cap', 10, 4 );
?>
