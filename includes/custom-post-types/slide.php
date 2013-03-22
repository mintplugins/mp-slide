<?php
/**
 * Custom Post Types
 *
 * @package mp_slide
 * @since mp_slide 1.0
 */

/**
 * Slide Custom Post Type
 */
function mp_slide_post_type() {
	
	if (mp_core_get_option( 'mp_slide_settings_general',  'enable_disable' ) != 'disabled' ){
		$slide_labels =  apply_filters( 'mp_slide_slide_labels', array(
			'name' 				=> 'Slides',
			'singular_name' 	=> 'Slide Item',
			'add_new' 			=> __('Add New', 'mp_slide'),
			'add_new_item' 		=> __('Add New Slide', 'mp_slide'),
			'edit_item' 		=> __('Edit Slide', 'mp_slide'),
			'new_item' 			=> __('New Slide', 'mp_slide'),
			'all_items' 		=> __('All Slides', 'mp_slide'),
			'view_item' 		=> __('View Slides', 'mp_slide'),
			'search_items' 		=> __('Search Slides', 'mp_slide'),
			'not_found' 		=>  __('No Slides found', 'mp_slide'),
			'not_found_in_trash'=> __('No Slides found in Trash', 'mp_slide'), 
			'parent_item_colon' => '',
			'menu_name' 		=> __('Slides', 'mp_slide')
		) );
		
			
		$slide_args = array(
			'labels' 			=> $slide_labels,
			'public' 			=> true,
			'publicly_queryable'=> true,
			'show_ui' 			=> true, 
			'show_in_menu' 		=> true,
			'show_in_nav_menus' => false, 
			'menu_position'		=> 5,
			'query_var' 		=> true,
			'rewrite' 			=> array( 'slug' => 'slider' ),
			'capability_type' 	=> 'post',
			'has_archive' 		=> true, 
			'hierarchical' 		=> false,
			'supports' 			=> apply_filters('mp_slide_slide_supports', array( 'title', 'thumbnail' ) ),
		); 
		register_post_type( 'mp_slide', apply_filters( 'mp_slide_slide_post_type_args', $slide_args ) );
	}
}
add_action( 'init', 'mp_slide_post_type', 100 );
 
 /**
 * Slider Cat taxonomy
 */
function mp_slide_taxonomy() {  
	if (mp_core_get_option( 'mp_slide_settings_general',  'enable_disable' ) != 'disabled' ){
		
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'                => __( 'Sliders', 'mp_core' ),
			'singular_name'       => __( 'Slider', 'mp_core' ),
			'search_items'        => __( 'Search Sliders', 'mp_core' ),
			'all_items'           => __( 'All Sliders', 'mp_core' ),
			'parent_item'         => __( 'Parent Slider', 'mp_core' ),
			'parent_item_colon'   => __( 'Parent Slider:', 'mp_core' ),
			'edit_item'           => __( 'Edit Slider', 'mp_core' ), 
			'update_item'         => __( 'Update Slider', 'mp_core' ),
			'add_new_item'        => __( 'Add New Slider', 'mp_core' ),
			'new_item_name'       => __( 'New Slider Name', 'mp_core' ),
			'menu_name'           => __( 'Sliders', 'mp_core' ),
		); 	
  
		register_taxonomy(  
			'mp_sliders',  
			'mp_slide',  
			array(  
				'hierarchical' => true,  
				'label' => 'Sliders',  
				'labels' => $labels,  
				'query_var' => true,  
				'with_front' => false, 
				'rewrite' => array('slug' => 'sliders')  
			)  
		);  
	}
}  
add_action( 'load_textdomain', 'mp_slide_taxonomy' );  

/**
 * Change default title
 */
function mp_slide_change_default_title( $title ){
     $screen = get_current_screen();
 
     if  ( 'mp_slide' == $screen->post_type ) {
          $title = __('Enter the Slide\'s Title', 'mp_sermons');
     }
 
     return $title;
}
//add_filter( 'enter_title_here', 'mp_slide_change_default_title' );