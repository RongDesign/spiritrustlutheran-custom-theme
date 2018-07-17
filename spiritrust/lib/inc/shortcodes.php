<?php
/* add button short code */
function spiritrust_button($atts) {
	$text = ($atts['text'] == '') ? "Read More" : $atts['text'];
	$blankwindow = ($atts['blankwindow'] == '') ? "" : ' target="_blank"';
	$inline = ($atts['inline'] == 'true') ? true : false;
	$inlineClass = ($inline) ? ' btn-inline' : '';
	$color = ($atts['color'] == '') ? "green" : $atts['color'];
	$href = $atts['href'];
	$content = '';

	if ($href != '') {
		if (!$inline) {
			$content .= '<p class="cta">';
		}
		$content .= '<a class="btn btn-' . $color . $inlineClass . '" href="' . $href . '"' . $blankwindow . '>';
		$content .= '<span class="bg"></span>';
		$content .= '<span class="txt">';
		$content .= $text . " ";
		$content .= '<span class="icon icon-arrow-circle-right"></span>';
		$content .= '</span>';
		$content .= '</a>';
		if (!$inline) {
			$content .= '</p>';
		}
	}
	return $content;
}
add_shortcode('button', 'spiritrust_button');

/* add blackbaud form short code */
function spiritrust_blackbaud($atts) {
	$id = $atts['id'];
	$content = '';

	if ($id != '') {
		$content .= '<div id="bbox-root"></div>';
		$content .= '<script type="text/javascript">';
		$content .= 'window.bboxInit = function () {';
		$content .= "bbox.showForm('" . $id . "');";
		$content .= '};';
		$content .= '(function () {';
		$content .= "var e = document.createElement('script'); e.async = true;";
		$content .= "e.src = 'https://bbox.blackbaudhosting.com/webforms/bbox-min.js';";
		$content .= "document.getElementsByTagName('head')[0].appendChild(e);";
		$content .= '} ());';
		$content .= '</script>';
	}
	return $content;
}
add_shortcode('blackbaud', 'spiritrust_blackbaud');

/* add video modal link short code */
function spiritrust_videomodallink($atts) {
	$ytID  = $atts['id'];
	$title = $atts['title'];
	$text  = $atts['text'];
	$content = '';

	if ($ytID != '' && $text != '') {
		$content .= '<a href="https://www.youtube.com/watch?v=' . $ytID . '" class="ga-exclude" data-behavior="modalize" data-title="' . esc_html($title) . '" target="_blank">';
		$content .= $text;
		$content .= '</a>';
	}
	return $content;
}
add_shortcode('videomodallink', 'spiritrust_videomodallink');
?>
