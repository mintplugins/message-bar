<?php
/*
Plugin Name: Message Bar
Plugin URI: http://moveplugins.com
Description: Puts a message bar at the top of your WordPress theme
Version: 1.0
Author: Phil Johnston
Author URI: http://moveplugins.com
Text Domain: message-bar
Domain Path: languages
License: GPL2
*/

/*  Copyright 2012  Phil Johnston  (email : phil@moveplugins.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

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
if( !defined( 'MOVEPLUGINS_MSG_BAR_VERSION' ) )
	define( 'MOVEPLUGINS_MSG_BAR_VERSION', '1.0.0.0' );

// Plugin Folder URL
if( !defined( 'MOVEPLUGINS_MSG_BAR_PLUGIN_URL' ) )
	define( 'MOVEPLUGINS_MSG_BAR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Plugin Folder Path
if( !defined( 'MOVEPLUGINS_MSG_BAR_PLUGIN_DIR' ) )
	define( 'MOVEPLUGINS_MSG_BAR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Plugin Root File
if( !defined( 'MOVEPLUGINS_MSG_BAR_PLUGIN_FILE' ) )
	define( 'MOVEPLUGINS_MSG_BAR_PLUGIN_FILE', __FILE__ );

/*
|--------------------------------------------------------------------------
| GLOBALS
|--------------------------------------------------------------------------
*/

//None at the moment

/*
|--------------------------------------------------------------------------
| INTERNATIONALIZATION
|--------------------------------------------------------------------------
*/

function moveplugins_msg_bar_textdomain() {

	// Set filter for plugin's languages directory
	$moveplugins_msg_bar_lang_dir = dirname( plugin_basename( MOVEPLUGINS_MSG_BAR_PLUGIN_FILE ) ) . '/languages/';
	$moveplugins_msg_bar_lang_dir = apply_filters( 'moveplugins_msg_bar_languages_directory', $moveplugins_msg_bar_lang_dir );


	// Traditional WordPress plugin locale filter
	$locale        = apply_filters( 'plugin_locale',  get_locale(), 'message-bar' );
	$mofile        = sprintf( '%1$s-%2$s.mo', 'message-bar', $locale );

	// Setup paths to current locale file
	$mofile_local  = $moveplugins_msg_bar_lang_dir . $mofile;
	$mofile_global = WP_LANG_DIR . '/message-bar/' . $mofile;

	if ( file_exists( $mofile_global ) ) {
		// Look in global /wp-content/languages/message-bar folder
		load_textdomain( 'message-bar', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) {
		// Look in local /wp-content/plugins/message_bar/languages/ folder
		load_textdomain( 'message-bar', $mofile_local );
	} else {
		// Load the default language files
		load_plugin_textdomain( 'message-bar', false, $moveplugins_msg_bar_lang_dir );
	}

}
add_action( 'init', 'moveplugins_msg_bar_textdomain', 1 );

/*
|--------------------------------------------------------------------------
| INCLUDES
|--------------------------------------------------------------------------
*/

include_once( MOVEPLUGINS_MSG_BAR_PLUGIN_DIR . 'includes/enqueue-scripts-styles.php' );
include_once( MOVEPLUGINS_MSG_BAR_PLUGIN_DIR . 'includes/display-message-bar.php' );
include_once( MOVEPLUGINS_MSG_BAR_PLUGIN_DIR . 'includes/custom-hooks.php' );
include_once( MOVEPLUGINS_MSG_BAR_PLUGIN_DIR . 'includes/admin-settings-api.php' );
if( is_admin() ) {
	//none at the moment
} else {
	//none at the moment
}