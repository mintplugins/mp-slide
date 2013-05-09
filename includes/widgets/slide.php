<?php
/**
 * Extends MP_CORE_Widget to create custom widget class.
 */
class MP_SLIDE_Widget extends MP_CORE_Widget {
		
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'mp_slide_widget', // Base ID
			'Slider', // Name
			array( 'description' => __( 'Display slider.', 'mp_slide' ), ) // Args
		);
		
		//enqueue scripts defined in MP_CORE_Widget
		add_action( 'admin_enqueue_scripts', array( $this, 'mp_widget_enqueue_scripts' ) );
				
		$this->_form = array (
			"field1" => array(
				'field_id' 			=> 'title',
				'field_title' 	=> __('Title:', 'mp_slide'),
				'field_description' 	=> NULL,
				'field_type' 	=> 'textbox',
			),
			"field2" => array(
				'field_id' 			=> 'slide_cat',
				'field_title' 	=> __('Select the slider to use:', 'mp_slide'),
				'field_description' 	=> NULL,
				'field_type' 	=> 'select',
				'field_select_values' => mp_core_get_all_posts_by_tax('mp_sliders'),
			),
			"field3" => array(
				'field_id' 			=> 'show_slider',
				'field_title' 	=> __('Show the main slider?:', 'mp_slide'),
				'field_description' 	=> NULL,
				'field_type' 	=> 'checkbox',
			),
			"field4" => array(
				'field_id' 			=> 'show_carousel',
				'field_title' 	=> __('Show the carousel?:', 'mp_slide'),
				'field_description' 	=> NULL,
				'field_type' 	=> 'checkbox',
			),
		);
		
		//Filter for addons
		$this->_form = has_filter( 'mp_slide_widget_form' ) ? apply_filters( 'mp_slide_widget_form', $this->_form) : $this->_form;
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		//Load the current number of the slider 
		global $global_slider_num;
		
		//Extract the args
		extract( $args );
		$title = apply_filters( 'mp_slide_widget_title', isset($instance['title']) ? $instance['title'] : '' );
		
		/**
		 * Links Before Hook
		 */
		 do_action('mp_slide_before_widget');
		
		/**
		 * Widget Start and Title
		 */
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		/**
		 * Widget Body
		 */
		
		//Set args for mp_slider
		$slider_args = array(
			'source' => 'taxonomy', // options: 'post', 'taxonomy' Future add-ons: 'instagram', 'facebook', 'twitter', 'tumblr'
			'slider_id' => 'widget', // options: post_id, NULL, custom_id 
			'post_type' => 'mp_slide', //options: NULL, 'post_slug'
			'taxonomy' => 'mp_sliders', //options: NULL, 'tax_slug'
			'taxonomy_group' => $instance['slide_cat'], //options: NULL, 'tax_group_slug'
			'show_slider' => !empty($instance['show_slider']) ? true : false, //options: true, false <-- This is controlled through a checkbox
			'show_carousel' => !empty($instance['show_carousel']) ? true : false, //options: true, false <-- This is controlled through a checkbox
		);
		
			
		//Display the slider
		echo mp_slider($slider_args);
			
		/**
		 * Widget End
		 */
		echo $after_widget;
		
		/**
		 * Links After Hook
		 */
		 do_action('mp_slide_after_widget');
	}
}

add_action( 'register_sidebar', create_function( '', 'register_widget( "MP_SLIDE_Widget" );' ) );