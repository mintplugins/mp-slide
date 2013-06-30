<?php
/*
* Slider Function
*
*
* Sample args:

$args = array(
	'source' => 'post', // options: 'post', 'taxonomy' Future add-ons: 'instagram', 'facebook', 'twitter', 'tumblr'
	'slider_id' => 789, // options: post_id, NULL, custom_id <--if using custom option for source, this wil be the action hook for custom source: mp_display_slider_slider_id <-- slider_id = your_id
	'post_type' => 'product', //options: NULL, 'post_slug'
	'taxonomy' => 'mp_sliders', //options: NULL, 'tax_slug'
	'taxonomy_group' => 'mytaxslug', //options: NULL, 'tax_group_slug'
	'show_slider' => 'anything', //options: NULL, 'anything' <-- This is controlled through a checkbox
	'show_carousel' => 'anything', //options: NULL, 'anything' <-- This is controlled through a checkbox
);

*
*
*/

	
/**
 * Display the slider
 */
function mp_slider($args){
	
	/**
	 * Add 1 to the global slider num - 
	 * The javascript variable increments as well so it matches a new set of variables for additional sliders 
	 * Notice the localized variable number below
	 */
	global $global_slider_num;
	$global_slider_num = $global_slider_num + 1;
	
	//Flexslider js
	wp_enqueue_script( 'mp_flex_slider', plugins_url( 'js/flex-slider/jquery.flexslider-min.js', dirname(__FILE__)),  array( 'jquery' ) );
	//Create URL to call felx slider
	$mp_call_flex_url = add_query_arg( 'slider_id', $args['slider_id'], plugins_url( 'js/flex-slider/call-flex-slider.js', dirname(__FILE__) ) );
	//Call Flexslider
	wp_enqueue_script( 'mp_call_flex_slider' . $args['slider_id'] . $global_slider_num, $mp_call_flex_url,  array( 'jquery', 'mp_flex_slider') );
	
	//Variables
	$mp_slide_control_nav = mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_control_nav' );
	$mp_slide_slideshow = mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_slideshow' );
	$mp_slide_animation = mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_animation' );
	$mp_slide_slideshow_loop = mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_slideshow_loop' );
	$mp_slide_slideshow_speed = mp_core_get_option( 'mp_slide_settings_general',  'mp_slide_slideshow_speed' );
	
	wp_localize_script('mp_call_flex_slider' . $args['slider_id'] . $global_slider_num, 'mp_call_flex_slider_script_vars' . $global_slider_num , array(
			'mp_slide_id' => $args['slider_id'] . '_' . $global_slider_num,
			'mp_slide_control_nav' => !empty($mp_slide_control_nav) ? true : false, //<-- this works because it's a checkbox which is empty when deselected 
			'mp_slide_slideshow' => !empty($mp_slide_slideshow) ? true : false, //<-- this works because it's a checkbox which is empty when deselected
			'mp_slide_slideshow_loop' => !empty($mp_slide_slideshow_loop) ? true : false, //<-- this works because it's a checkbox which is empty when deselected
			'mp_slide_slideshow_speed' => !empty($mp_slide_slideshow_speed) ? $mp_slide_slideshow_speed : 7000, //<-- this works because it's a checkbox which is empty when deselected
			'mp_slide_animation' => !empty($mp_slide_animation) ? $mp_slide_animation : 'slide',
			'mp_slide_carousel_width' => has_filter( 'mp_slide_carousel_width' ) ? apply_filters( 'mp_slide_carousel_width', 120) : 120, 
		)
	);		
	
	//Html Output variable
	$html_output = NULL;
	
	//Filters for the size of the sider
	$slide_width = has_filter('mp_slide_slider_width_' . $args['slider_id']) ? apply_filters('mp_slide_slider_width_' . $args['slider_id'], '') : 1000;
	$slide_height = has_filter('mp_slide_slider_height_' . $args['slider_id']) ? apply_filters('mp_slide_slider_height_' . $args['slider_id'], '') : 562;
	
	//Filters for the size of the carousel
	$carousel_width = has_filter('mp_slide_carousel_width_' . $args['slider_id']) ? apply_filters('mp_slide_carousel_width_' . $args['slider_id'], '') : 100;
	$carousel_height = has_filter('mp_slide_carousel_height_' . $args['slider_id']) ? apply_filters('mp_slide_carousel_height_' . $args['slider_id'], '') : 100;
			
	/**
	 * The source type is taxonomy so loop through the posts in 
	 * the set taxonomy
	 */
	if ($args['source'] == 'taxonomy'){
		//Set the args for the new query
		$slide_args = array(
			'post_type' => $args['post_type'],
			'posts_per_page' => 0,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => $args['taxonomy'],
					'field'    => 'id',
					'terms'    => array( $args['taxonomy_group'] ),
					'operator' => 'IN'
				)
			)
		);	
		
		//Create new query for sliders
		$sliders = new WP_Query( apply_filters( 'slide_args', $slide_args ) );
			
		//Loop through the sliders		
		if ( $sliders->have_posts() ) : 
		
			//CSS for this slider
			echo '<style scoped>';
			echo '#slider_container_' . $args['slider_id'] . ' {max-width:' . $slide_width . 'px;}';
			echo '#slider_' . $args['slider_id'] . '_' . $global_slider_num . ' {max-height:' . $slide_height . 'px;}';
			echo '</style>';
			
			$html_output .= '<div id="slider_container_' . $args['slider_id'] . '" class="slider">';
				//Show the Main Slider 
				if ($args['show_slider'] == true){
					$html_output .= '<div id="slider_' . $args['slider_id'] . '_' . $global_slider_num . '" class="flexslider">';
						$html_output .= '<ul class="slides">';
						while( $sliders->have_posts() ) : $sliders->the_post(); 
							
							//Get the link url for this slide
							$link_url = get_post_meta( get_the_id(), 'mp_slide_options_link_url', true);
							
							//Get the video url for this slide
							$video_url = get_post_meta( get_the_id(), 'mp_slide_options_video_url', true);
														
							//If there is a video URL, show the video. We put a placeholder image behind the video so it resizes responsively and with aspect ratio
							if ( !empty( $video_url ) ){
								$html_output .= '<li>';
								$html_output .= !empty( $link_url ) ?'<a href="' . $link_url . '">' : NULL;
								$html_output .= '<img class="ratio" src="' . plugins_url( 'css/images/16x9.gif', dirname(__FILE__)) . '"/>' . wp_oembed_get($video_url);
								$html_output .= !empty( $link_url ) ?'</a>' : NULL;
								$html_output .= '</li>';
							} 
							//If there is no video URL, show the featured image instead
							else {
								$html_output .= '<li>';
								$html_output .= !empty( $link_url ) ?'<a href="' . $link_url . '">' : NULL;
								$html_output .= '<img src="' . mp_core_the_featured_image(get_the_id(), $slide_width, $slide_height) . '" />';
								$html_output .= !empty( $link_url ) ?'</a>' : NULL;
								$html_output .= '</li>';
							} 
							
						endwhile; 
						$html_output .= '</ul>';
					$html_output .= '</div>';
				}
				//Show the Carousel 
				if ($args['show_carousel'] == true){ 
				
					$html_output .= '<div id="carousel_' . $args['slider_id'] . '_' . $global_slider_num . '" class="flexslider">';
						$html_output .= '<ul class="slides">';
							while( $sliders->have_posts() ) : $sliders->the_post(); 
								$html_output .= '<li><img src="' . mp_core_the_featured_image(get_the_id(), $carousel_width, $carousel_height) . '" width="' . $carousel_width . 'px" height="' . $carousel_height . 'px" /></li>';
							endwhile;
						$html_output .= '</ul>';
					$html_output .= '</div>';
				
				}
			$html_output .= '</div>';
		endif; 
	} //Endif (source == taxonomy)
	
	/**
	 * Display slider using information from a post
	 * 
	 */
	elseif ($args['source'] == 'post'){
		
		//Get the repeater that contains the slider 
		$slides = get_post_meta( $args['slider_id'], 'mp_slider', true);
		
		if (!empty($slides)){ 
		
			//CSS for this slider
			echo '<style scoped>';
			echo '#slider_container_' . $args['slider_id'] . ' {max-width:' . $slide_width . 'px;}';
			echo '#slider_' . $args['slider_id'] . '_' . $global_slider_num . ' {max-height:' . $slide_height . 'px;}';
			echo '</style>';
			
			$html_output .= '<section id="slider_container_' . $args['slider_id'] . '" class="slider">';
				//Show the Main Slider 
				if ($args['show_slider'] == true){
					$html_output .= '<div id="slider_' . $args['slider_id'] . '_' . $global_slider_num . '" class="flexslider">';
						$html_output .= '<ul class="slides">';
						
						//Loop through each repeater
						foreach($slides as $slide){
							
							$html_output .= '<li>';
							
							//If there is a link, wrap this in an a tag
							if ( !empty( $slide['mp_slide_link_url'] ) ){
								$html_output .= '<a href="' . $slide['mp_slide_link_url'] . '">';
							}
															
							//If there is a video URL, show the video. We put a placeholder image behind the video so it resizes responsively and with aspect ratio
							if ( !empty( $slide['mp_slide_video_url'] ) ){
								$html_output .= '<img class="ratio" src="' . plugins_url( 'css/images/16x9.gif', dirname(__FILE__)) . '"/>' . wp_oembed_get($slide['mp_slide_video_url']);
							} 
							//If there is no video URL, show the featured image instead
							else {
								$html_output .= '<img src="' . mp_aq_resize($slide['mp_slide_image_url'], $slide_width, $slide_height, true) . '" />';
							} 
							
							//If there is a link, finish wrapping this in an a tag
							if ( !empty( $slide['mp_slide_link_url'] ) ){
								$html_output .= '</a>';
							}
							
							$html_output .= '</li>';
							
						}
						$html_output .= '</ul>';
					$html_output .= '</div>';
				}
				//Show the Carousel 
				if ($args['show_carousel'] == true){ 
					$html_output .= '<div id="carousel_' . $args['slider_id'] . '_' . $global_slider_num . '" class="flexslider">';
						$html_output .= '<ul class="slides">';
							
							//Loop through each repeater
							foreach($slides as $slide){
								$html_output .= '<li><img src="' . mp_aq_resize($slide['mp_slide_image_url'], $carousel_width, $carousel_height, true) . '" width="' . $carousel_width . 'px" height="' . $carousel_height . 'px" /></li>';
							}
						$html_output .= '</ul>';
					$html_output .= '</div>';
				 }
			$html_output .= '</section>';
		}
	}
	//Display slider using information from the 'mp_display_slider_slider_id' action hook
	else{
		do_action( 'mp_display_slider_' . $args['slider_id'], $args);	
	}
	
	return $html_output;
	
}