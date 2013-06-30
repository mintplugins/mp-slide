<?php

/**
 * Show "Insert Shortcode" above posts
 */
function mp_slider_show_insert_shortcode(){
	
	$post_id = isset($_GET['post']) ? $_GET['post'] : NULL;
	
	$args = array(
		'shortcode_id' => 'mp_slider',
		'shortcode_title' => __('Slider', 'mp_core'),
		'shortcode_description' => __( 'Use the form below to insert the shortcode for a Slider ', 'mp_core' ),
		'shortcode_options' => array(
			array(
				'option_id' => 'source',
				'option_title' => 'Slider',
				'option_description' => 'Choose a slider',
				'option_type' => 'select',
				'option_value' => mp_core_get_all_terms_by_tax('mp_sliders'),
			),
			array(
				'option_id' => 'showslider',
				'option_title' => 'Show slider?',
				'option_description' => 'Would you like to show the main slider?',
				'option_type' => 'checkbox',
				'option_value' => NULL,
			),
			array(
				'option_id' => 'showcarousel',
				'option_title' => 'Show carousel?',
				'option_description' => 'Would you like to show the carousel?',
				'option_type' => 'checkbox',
				'option_value' => NULL,
			)
		)
	); 
	
	//Check if this post has slider meta
	$slider_meta_check = get_post_meta( $post_id, 'mp_slider', true);
	
	//This post does have slider meta
	if ( !empty($slider_meta_check) ){
	
		//Set value for new source option value
		$option_value = __('Use slider from this post' , 'mp_core') . ' (' . get_the_title($post_id) . ')';
		
		//Add this post to the source array	<-- this keeps all the taxonomy items in the array	
		$args['shortcode_options'][0]['option_value'] = array($post_id . '-post' => $option_value) + $args['shortcode_options'][0]['option_value'];
				
	}
	
	//Shortcode args filter - This will be used by addons to include slider source options like "downloads" (CPT) or "stack groups" (Taxonomy)
	$args = has_filter('mp_slider_insert_shortcode_args') ? apply_filters('mp_slider_insert_shortcode_args', $args) : $args;
	
	new MP_CORE_Shortcode_Insert($args);	
}
add_action('init', 'mp_slider_show_insert_shortcode');

/**
 * Shortcode which is used to display the HTML content on a post
 */
function mp_slide_display_slider( $atts ) {
	
	//shortcode vars passed-in
	$vars =  shortcode_atts( array('source' => NULL, 'showslider' => false, 'showcarousel' => true), $atts );
	
	//set default args
	$args = array(); 
	
	//Post id 
	$post_id = get_the_id();
	
	//Check if this post has slider meta
	$slider_meta_check = get_post_meta( $post_id, 'mp_slider', true);
			
	//See if the string '-post' is found in the source var. If it does, that means the 'source' is a post, not a taxonomy of the mp_slide post type
	$type_post = explode('-', $vars['source'] );
				
	//The user has selected to use the slider meta info for the current post
	if ( !empty( $type_post[1] ) ) {
		$args = array(
			'source' => 'post', // options: 'post', 'taxonomy' Future add-ons: 'instagram', 'facebook', 'twitter', 'tumblr'
			'slider_id' => $type_post[0], // options: post_id, NULL, custom_id 
			'show_slider' => $vars['showslider'] == 'true' ? true : false, //options: true, false <-- This is controlled through a checkbox
			'show_carousel' => $vars['showcarousel'] == 'true' ? true : false, //options: true, false <-- This is controlled through a checkbox
		);
	}
	else{
		$args = array(
			'source' => 'taxonomy', // options: 'post', 'taxonomy' Future add-ons: 'instagram', 'facebook', 'twitter', 'tumblr'
			'slider_id' => $post_id . '_' . $vars['source'], // options: post_id, NULL, custom_id 
			'post_type' => 'mp_slide', //options: NULL, 'post_slug'
			'taxonomy' => 'mp_sliders', //options: NULL, 'tax_slug'
			'taxonomy_group' => $vars['source'], //options: NULL, 'tax_group_slug'
			'show_slider' => $vars['showslider'] == 'true' ? true : false, //options: true, false <-- This is controlled through a checkbox
			'show_carousel' => $vars['showcarousel'] == 'true' ? true : false, //options: true, false <-- This is controlled through a checkbox
		);	
	}
	
	
	if ( !empty( $args ) ){
		return mp_slider( $args );
	}
	
}
add_shortcode( 'mp_slider', 'mp_slide_display_slider' );

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
*/