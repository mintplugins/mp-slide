<?php
/**
 * Enqueue Flex Slider Scripts
 */
function mp_slide_enqueue_scripts(){
	
	//Global variable for Flexslider js
	wp_enqueue_script( 'mp_slide_global_slider_num', plugins_url( 'js/flex-slider/global_slider_num.js', dirname(__FILE__)),  array( 'jquery' ) );
	
	//Styles for the Flexslider
	wp_enqueue_style( 'mp_flex_slider_css', plugins_url( 'css/flexslider.css', dirname(__FILE__)) );
	wp_enqueue_style( 'mp_slide_icon_font', plugins_url( 'css/mp-slide-icon-font.css', dirname(__FILE__)) );
}
add_action('wp_enqueue_scripts', 'mp_slide_enqueue_scripts');