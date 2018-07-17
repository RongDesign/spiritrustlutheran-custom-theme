<?php
/* DEFAULT IMAGE SIZES: /wp-admin/options-media.php */
/*
	add_image_size('thumb',          150,  150, false);
	add_image_size('thumbnail',      150,  150, false);
	add_image_size('post-thumbnail', 150,  150, false);
	add_image_size('medium',         300,  300, false);
	add_image_size('large',         1280,  853, false);
*/
/* CUSTOM IMAGE SIZES */
add_image_size('page-hero',              1400,  600, true );
add_image_size('homepage-hero',           450,  465, true );
add_image_size('homepage-callout',        364,  230, true );
add_image_size('homepage-image-callout',  360,  480, true );
add_image_size('landing-image',           374,  350, true );
add_image_size('slideshow-image',         774,  516, true );
add_image_size('slideshow-thumb',         140,   93, true );
add_image_size('dropdown-image',          465,  310, true );
add_image_size('affiliate-logo',          440,  150, false);
add_image_size('callout',                 588, 9999, false); // double width of the available space in the sidebar (294)

function my_custom_sizes($sizes) {
	return array_merge( $sizes, array(
		'page-hero'              => __('Page Hero'),
		'homepage-hero'          => __('Home Page Hero'),
		'homepage-callout'       => __('Home Page Callout'),
		'homepage-image-callout' => __('Home Page Image Callout'),
		'landing-image'          => __('Landing Page Image'),
		'slideshow-image'        => __('Slideshow Image'),
		'slideshow-thumb'        => __('Slideshow Thumbnail'),
		'dropdown-image'         => __('Dropdown Menu Image'),
		'affiliate-logo'         => __('Affiliate Logo'),
		'callout'                => __('Sidebar Callout')
	) );
}
add_filter('image_size_names_choose','my_custom_sizes');
?>
