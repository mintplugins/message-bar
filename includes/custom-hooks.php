<?php
/**
 * Attach Message Bar to footer
 */
if ( ! function_exists( 'moveplugins_msg_bar' ) ):
	function moveplugins_msg_bar(){
		if (moveplugins_msg_bar_get_plugin_option( 'show-hide' ) != "1"){//theme option to show or hide
			if ($_COOKIE['showmessagebar'] != "false"){//cookie option to show or hide
				echo ('<div class="moveplugins-promo-bar">
							<div class="moveplugins-container">
								<p>');
								
								if (moveplugins_msg_bar_get_plugin_option( 'url' ) != ""){ 
									echo '<a href="' . moveplugins_msg_bar_get_plugin_option( 'url' ) . '">' . moveplugins_msg_bar_get_plugin_option( 'text' ) .  '</a>'; }
								else{
									echo moveplugins_msg_bar_get_plugin_option( 'text' );
								}
								
								echo ('</p>
								<span class="close"><a id="moveplugins-promo-bar-close_sale" href="#"><div class="move_plugins_cancel"></div></a></span>
							</div>
						</div>');
			}
		}
	}
endif; //moveplugins_msg_bar

add_action("wp_footer", "moveplugins_msg_bar");