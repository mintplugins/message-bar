<?php
/**
 * Enqueue scripts and styles
 */
if ( ! function_exists( 'moveplugins_msg_bar_scripts' ) ):
	function moveplugins_msg_bar_scripts() {
		if (moveplugins_msg_bar_get_plugin_option( 'show-hide' ) != "1"){//theme option to show or hide
			if ($_COOKIE['showmessagebar'] != "false"){//cookie option to show or hide
				wp_enqueue_style( 'moveplugins_msg_bar_css', plugins_url() . '/message-bar/includes/css/style.css' );
				wp_enqueue_script( 'load_moveplugins_msg_bar_cookie', plugins_url( '/js/load_msg_bar.js', __FILE__ ), array( 'jquery' ) );
			}
		}
	}
endif; //moveplugins_msg_bar_scripts
add_action( 'wp_enqueue_scripts', 'moveplugins_msg_bar_scripts' );