<?php
/*
Plugin Name: MP Slide
Plugin URI: http://moveplugins.com
Description: Create sliders and display them with shortcodes, functions, or widgets
Version: 1.0
Author: Move Plugins
Author URI: http://moveplugins.com
Text Domain: mp_slide
Domain Path: languages
License: GPL2
*/

/*  Copyright 2012  Phil Johnston  (email : phil@moveplugins.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Move Plugins Core.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
// Plugin version
if( !defined( 'MP_SLIDE_VERSION' ) )
	define( 'MP_SLIDE_VERSION', '1.0.0.0' );

// Plugin Folder URL
if( !defined( 'MP_SLIDE_PLUGIN_URL' ) )
	define( 'MP_SLIDE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Plugin Folder Path
if( !defined( 'MP_SLIDE_PLUGIN_DIR' ) )
	define( 'MP_SLIDE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Plugin Root File
if( !defined( 'MP_SLIDE_PLUGIN_FILE' ) )
	define( 'MP_SLIDE_PLUGIN_FILE', __FILE__ );

/*
|--------------------------------------------------------------------------
| GLOBALS
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| INTERNATIONALIZATION
|--------------------------------------------------------------------------
*/

function mp_slide_textdomain() {

	// Set filter for plugin's languages directory
	$mp_slide_lang_dir = dirname( plugin_basename( MP_SLIDE_PLUGIN_FILE ) ) . '/languages/';
	$mp_slide_lang_dir = apply_filters( 'mp_slide_languages_directory', $mp_slide_lang_dir );


	// Traditional WordPress plugin locale filter
	$locale        = apply_filters( 'plugin_locale',  get_locale(), 'mp-slide' );
	$mofile        = sprintf( '%1$s-%2$s.mo', 'mp-slide', $locale );

	// Setup paths to current locale file
	$mofile_local  = $mp_slide_lang_dir . $mofile;
	$mofile_global = WP_LANG_DIR . '/mp-slide/' . $mofile;

	if ( file_exists( $mofile_global ) ) {
		// Look in global /wp-content/languages/mp-slide folder
		load_textdomain( 'mp_slide', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) {
		// Look in local /wp-content/plugins/mp-slide/languages/ folder
		load_textdomain( 'mp_slide', $mofile_local );
	} else {
		// Load the default language files
		load_plugin_textdomain( 'mp_slide', false, $mp_slide_lang_dir );
	}

}
add_action( 'init', 'mp_slide_textdomain', 1 );

/*
|--------------------------------------------------------------------------
| INCLUDES
|--------------------------------------------------------------------------
*/
function mp_slide_include_files(){
	/**
	 * If mp_core isn't active, stop and install it now
	 */
	if (!function_exists('mp_core_textdomain')){
		
		/**
		 * Include Plugin Checker
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/plugin-checker/class-plugin-checker.php' );
		
		/**
		 * Check if mp_core in installed
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/plugin-checker/included-plugins/mp-core-check.php' );
		
	}
	/**
	 * Otherwise, if mp_core is active, carry out the plugin's functions
	 */
	else{
		
		/**
		 * Update script - keeps this plugin up to date
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/updater/mp-slide-update.php' );
		
		/**
		 * Enqueue Scripts for mp_slide <-- this contains a javascript global variable called global_slider_num
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/misc-functions/enqueue-scripts.php' );
		
		/**
		 * Display slider function
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/misc-functions/mp-slider.php' );
		
		/**
		 * Settings for mp_slide
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/settings/settings/settings-options.php' );
		
		/**
		 * Instructions metabox for mp_slide
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/metaboxes/mp-slide-instructions/mp-slide-instructions.php' );
					
		/**
		 * Options metabox for mp_slide
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/metaboxes/mp-slide-options/mp-slide-options.php' );
		
		/**
		 * Sample metabox for cpt
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/metaboxes/sample-cpt/sample-cpt.php' );
		
		/**
		 * Slide Custom Post Type
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/custom-post-types/slide.php' );
		
		/**
		 * Slide shortcode
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/misc-functions/shortcode.php' );
		
		/**
		 * Slide widget
		 */
		require( MP_SLIDE_PLUGIN_DIR . 'includes/widgets/slide.php' );
				
	}
}
add_action('plugins_loaded', 'mp_slide_include_files', 9);