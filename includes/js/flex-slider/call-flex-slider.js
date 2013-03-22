jQuery(document).ready(function($){
	
	//Get the localized variables using the global_slider_num variable at the end because they are numbered
	var mp_call_flex_slider_script_vars = eval('mp_call_flex_slider_script_vars' + global_slider_num );
	var mp_slide_thumbnail_width = mp_call_flex_slider_script_vars.mp_slide_thumbnail_width;
	
	//Create the carousel for this slider
	$('#carousel_' + mp_call_flex_slider_script_vars.mp_slide_id).flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 100,
		itemMargin: 5,
		asNavFor: '#slider_' + mp_call_flex_slider_script_vars.mp_slide_id
	});
	
	//Create the slider for this slider
	$('#slider_' + mp_call_flex_slider_script_vars.mp_slide_id).flexslider({
		animation: mp_call_flex_slider_script_vars.mp_slide_animation,
		controlNav: mp_call_flex_slider_script_vars.mp_slide_control_nav,
		slideshowSpeed: mp_call_flex_slider_script_vars.mp_slide_slideshow_speed,
		animationLoop: mp_call_flex_slider_script_vars.mp_slide_slideshow_loop,
		slideshow: mp_call_flex_slider_script_vars.mp_slide_slideshow,
		sync: "#carousel",
		start: function(slider){
			$('body').removeClass('loading');
		}
	});
	
	//iframe sizes on home pages - we remove them so that the css can set them to be 100% width and height
	jQuery("#slider_" + mp_call_flex_slider_script_vars.mp_slider_id + " iframe").removeAttr('width');
	jQuery("#slider_" + mp_call_flex_slider_script_vars.mp_slider_id + " iframe").removeAttr('height');
	
	//remove previous and next text from buttons
	jQuery(".flex-prev").html('');
	jQuery(".flex-next").html('');
	jQuery(".flex-control-nav li a").html('');
	
	//increment the global_slider_num to prepare for the next slider
	global_slider_num = global_slider_num + 1;
  
});