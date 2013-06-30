<?php			
/**
 * This is the code that will create a new tab of settings for your page.
 * To create a new tab and set up this page:
 * Step 1. Duplicate this page and include it in the "class initialization function".
 * Step 1. Do a find-and-replace for the term 'mp_slide_settings' and replace it with the slug you set when initializing this class
 * Step 2. Do a find and replace for 'general' and replace it with your desired tab slug
 * Step 3. Go to line 17 and set the title for this tab.
 * Step 4. Begin creating your custom options on line 30
 * Go here for full setup instructions: 
 * http://moveplugins.com/settings-class/
 */

/**
* Create new tab
*/
function mp_slide_settings_general_new_tab( $active_tab ){
	
	//Create array containing the title and slug for this new tab
	$tab_info = array( 'title' => __('Slider Settings' , 'mp_slide'), 'slug' => 'general' );
	
	global $mp_slide_settings; $mp_slide_settings->new_tab( $active_tab, $tab_info );
		
}
//Hook into the new tab hook filter contained in the settings class in the Move Plugins Core
add_action('mp_slide_settings_new_tab_hook', 'mp_slide_settings_general_new_tab');

/**
* Create the options for this tab
*/
function mp_slide_settings_general_create(){
	
	//This variable must be the name of the variable that stores the class.
	global $mp_slide_settings_class;
	
	register_setting(
		'mp_slide_settings_general',
		'mp_slide_settings_general',
		'mp_core_settings_validate'
	);
	
	add_settings_section(
		'general_settings',
		__( 'General Settings', 'mp_slide' ),
		'__return_false',
		'mp_slide_settings_general'
	);
	
	add_settings_field(
		'mp_slide_control_nav',
		__( 'Control Navigation', 'mp_slide' ), 
		'mp_core_checkbox',
		'mp_slide_settings_general',
		'general_settings',
		array(
			'name'        => 'mp_slide_control_nav',
			'value'       => mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_control_nav' ),
			'preset_value'       => "controlnav",
			'description' => __( 'Do you want to display the control navigation for sliders? (Not recommended if using video in sliders as it could block the video\'s navigation)', 'mp_slide' ),
			'registration'=> 'mp_slide_settings_general',
		)
	);
	
	add_settings_field(
		'mp_slide_slideshow',
		__( 'Slideshow', 'mp_slide' ), 
		'mp_core_checkbox',
		'mp_slide_settings_general',
		'general_settings',
		array(
			'name'        => 'mp_slide_slideshow',
			'value'       => mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_slideshow' ),
			'preset_value'       => "slideshow",
			'description' => __( 'Do you want your sliders to automatically transition through images?', 'mp_slide' ),
			'registration'=> 'mp_slide_settings_general',
		)
	);
	
	add_settings_field(
		'mp_slide_slideshow_loop',
		__( 'Slideshow Loop', 'mp_slide' ), 
		'mp_core_checkbox',
		'mp_slide_settings_general',
		'general_settings',
		array(
			'name'        => 'mp_slide_slideshow_loop',
			'value'       => mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_slideshow_loop' ),
			'preset_value'       => "slideshow",
			'description' => __( 'Do you want your slideshows loop when finished?', 'mp_slide' ),
			'registration'=> 'mp_slide_settings_general',
		)
	);
	
	add_settings_field(
		'mp_slide_slideshow_speed',
		__( 'Slideshow Speed', 'mp_slide' ), 
		'mp_core_number',
		'mp_slide_settings_general',
		'general_settings',
		array(
			'name'        => 'mp_slide_slideshow_speed',
			'value'       => mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_slideshow_speed' ),
			'description' => __( 'Enter the speed this slideshow should run at in milliseconds (EG: 7000 = 7 Seconds', 'mp_slide' ),
			'registration'=> 'mp_slide_settings_general',
		)
	);
	
	add_settings_field(
		'mp_slide_animation',
		__( 'Animation Style', 'mp_slide' ), 
		'mp_core_select',
		'mp_slide_settings_general',
		'general_settings',
		array(
			'name' => 'mp_slide_animation',
			'value' => mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_animation' ),
			'preset_value' => "slideshow",
			'description' => __( 'Do you want your slideshows to automatically slide through images?', 'mp_slide' ),
			'registration'=> 'mp_slide_settings_general',
			'options'=> array('slide' => 'Slide', 'fade' => 'Fade')
		)
	);
		
	//additional general settings
	do_action('mp_slide_settings_additional_general_settings_hook');
}
add_action( 'admin_init', 'mp_slide_settings_general_create' );