<?php

/**
 * Shortcode which is used to display the HTML content on a post
 */
function mp_slide_display_slider( $atts ) {
	
	$vars =  shortcode_atts( array('group' => NULL), $atts );
	
	$args = array(
		'source' => 'post', // options: 'post', 'taxonomy' Future add-ons: 'instagram', 'facebook', 'twitter', 'tumblr'
		'slider_id' => get_the_id(), // options: post_id, NULL, custom_id <--if using custom option for source, this wil be the action hook for custom source: mp_display_slider_slider_id <-- slider_id = your_id
		'show_slider' => 'anything', //options: NULL, 'anything' <-- This is controlled through a checkbox
		'show_carousel' => 'anything', //options: NULL, 'anything' <-- This is controlled through a checkbox
	);
	
	return mp_slider($args);
	
}
add_shortcode( 'slider', 'mp_slide_display_slider' );

/**
 * Shortcode slider width
 *
function mp_slide_shortcode_width_loader(){
	function mp_slide_shortcode_width(){
		return 500;
	}
	add_filter('mp_slide_slider_width_' . get_the_id(), 'mp_slide_shortcode_width');
}
add_action('wp_head', 'mp_slide_shortcode_width_loader');

/**
 * Shortcode slider height
 *
function mp_slide_shortcode_height_loader(){
	function mp_slide_shortcode_height(){
		return 100;
	}
	add_filter('mp_slide_slider_height_' . get_the_id(), 'mp_slide_shortcode_height');
}
add_action('wp_head', 'mp_slide_shortcode_height_loader');
