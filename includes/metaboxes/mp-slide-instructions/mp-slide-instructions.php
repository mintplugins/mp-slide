<?php
/**
 * Function which creates new Meta Box
 *
 */
function mp_slide_instructions_create_meta_box(){	
	/**
	 * Array which stores all info about the new metabox
	 *
	 */
	$mp_slide_instructions_add_meta_box = array(
		'metabox_id' => 'mp_slide_instructions_metabox', 
		'metabox_title' => __( 'Slider Instructions', 'mp_slide'), 
		'metabox_posttype' => 'mp_slide', 
		'metabox_context' => 'side', 
		'metabox_priority' => 'high' 
	);
	
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_slide_instructions_items_array = array(
		array(
			'field_id'			=> 'stack_url',
			'field_title' 	=> __( 'Slider Instructions', 'mp_slide'),
			'field_description' 	=> '<br /> 1. Put this slide in a slider (below). <br /><br /> 2. Go to the <a href="' . admin_url( 'widgets.php' ) . '" target="_blank">Widgets page</a> and add the "Slider" widget. <br /><br /> 3. Select the slider to use for that widget.',
			'field_type' 	=> 'basictext',
			'field_value' => ''
		)
	);
	
	
	/**
	 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	 */
	$mp_slide_instructions_add_meta_box = has_filter('mp_slide_instructions_meta_box_array') ? apply_filters( 'mp_slide_instructions_meta_box_array', $mp_slide_instructions_add_meta_box) : $mp_slide_instructions_add_meta_box;
	
	/**
	 * Custom filter to allow for add on plugins to hook in their own extra fields 
	 */
	$mp_slide_instructions_items_array = has_filter('mp_slide_instructions_items_array') ? apply_filters( 'mp_slide_instructions_items_array', $mp_slide_instructions_items_array) : $mp_slide_instructions_items_array;
	
	
	/**
	 * Create Metabox class
	 */
	global $mp_slide_instructions_meta_box;
	$mp_slide_instructions_meta_box = new MP_CORE_Metabox($mp_slide_instructions_add_meta_box, $mp_slide_instructions_items_array);
}
add_action('plugins_loaded', 'mp_slide_instructions_create_meta_box');