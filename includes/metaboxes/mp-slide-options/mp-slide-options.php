<?php
/**
 * Function which creates new Meta Box
 *
 */
function mp_slide_options_create_meta_box(){	
	/**
	 * Array which stores all info about the new metabox
	 *
	 */
	$mp_slide_options_add_meta_box = array(
		'metabox_id' => 'mp_slide_options_metabox', 
		'metabox_title' => __( 'Slide Options', 'mp_slide'), 
		'metabox_posttype' => 'mp_slide', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'low' 
	);
	
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_slide_options_items_array = array(
		array(
			'field_id'			=> 'mp_slide_options_link_url',
			'field_title' 	=> __( 'Link URL (Optional)', 'mp_slide'),
			'field_description' 	=> 'Enter the URL this slide should go to when clicked.',
			'field_type' 	=> 'url',
			'field_value' => ''
		),
		array(
			'field_id'			=> 'mp_slide_options_video_url',
			'field_title' 	=> __( 'Video URL (Optional)', 'mp_slide'),
			'field_description' 	=> 'Enter the URL to the video page.',
			'field_type' 	=> 'url',
			'field_value' => ''
		)
	);
	
	
	/**
	 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	 */
	$mp_slide_options_add_meta_box = has_filter('mp_slide_options_meta_box_array') ? apply_filters( 'mp_slide_options_meta_box_array', $mp_slide_options_add_meta_box) : $mp_slide_options_add_meta_box;
	
	/**
	 * Custom filter to allow for add on plugins to hook in their own extra fields 
	 */
	$mp_slide_options_items_array = has_filter('mp_slide_options_items_array') ? apply_filters( 'mp_slide_options_items_array', $mp_slide_options_items_array) : $mp_slide_options_items_array;
	
	
	/**
	 * Create Metabox class
	 */
	global $mp_slide_options_meta_box;
	$mp_slide_options_meta_box = new MP_CORE_Metabox($mp_slide_options_add_meta_box, $mp_slide_options_items_array);
}
add_action('plugins_loaded', 'mp_slide_options_create_meta_box');