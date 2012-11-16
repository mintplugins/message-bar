<?php
/*
Plugin Name: Message Bar
Plugin URI: http://mintplugins.com
Description: Puts a message bar at the top of your WordPress theme
Version: 1.0
Author: Phil Johnston
Author URI: http://mintplugins.com
License: GPL2
*/

/*  Copyright 2012  Phil Johnston  (email : phil@mintplugins.com)

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

/* To use this function put the following on any archive page
if ( function_exists( 'mintthemes_msg_bar' ) ): 
	mintthemes_msg_bar(); 
endif;
*/


/**
 * Enqueue scripts and styles
 */
if ( ! function_exists( 'mintthemes_msg_bar_scripts' ) ):
	function mintthemes_msg_bar_scripts() {
		wp_enqueue_style( 'mintthemes_msg_bar_css', plugins_url() . '/message-bar/css/style.css' );
		wp_enqueue_script( 'load_mintthemes_msg_bar_cookie', plugins_url( '/js/load_msg_bar.js', __FILE__ ) );
	}
endif; //mintthemes_msg_bar_scripts
add_action( 'wp_enqueue_scripts', 'mintthemes_msg_bar_scripts' );

/**
 * Hook Function for Message Bar
 */
if ( ! function_exists( 'mintthemes_msg_bar' ) ):
	function mintthemes_msg_bar(){
		if (mintthemes_msg_bar_get_plugin_option( 'show-hide' ) != "1"){//theme option to show or hide
			if (!isset($_COOKIE['showmessagebar'])){//cookie option to show or hide
				echo ('<div class="mint-themes-promo-bar ' . strtolower(mintthemes_msg_bar_get_plugin_option( 'color' )) .'">
							<div class="container">
								<p><a href="' . mintthemes_msg_bar_get_plugin_option( 'url' ) . '">' . mintthemes_msg_bar_get_plugin_option( 'text' ) .  '</a></p>
						
								<span class="close"><a id="close_sale" href="#" class="ss-icon">close</a></span>
							</div>
						</div>');
			}
		}
	}
endif; //mintthemes_msg_bar

add_action("wp_footer", "mintthemes_msg_bar");

/**
 * Admin Page and options
 */ 

function mintthemes_msg_bar_plugin_options_init() {
	register_setting(
		'mintthemes_msg_bar_options',
		'mintthemes_msg_bar_options',
		'mintthemes_msg_bar_plugin_options_validate'
	);
	//
	add_settings_section(
		'settings',
		__( 'Settings', 'mintthemes_msg_bar' ),
		'__return_false',
		'mintthemes_msg_bar_options'
	);
	
	add_settings_field(
		'color',
		__( 'Color', 'mintthemes_msg_bar' ), 
		'mintthemes_msg_bar_settings_field_textbox',
		'mintthemes_msg_bar_options',
		'settings',
		array(
			'name'        => 'color',
			'value'       => mintthemes_msg_bar_get_plugin_option( 'color' ),
			'description' => __( 'Color', 'mintthemes_msg_bar' )
		)
	);
	//
	add_settings_field(
		'text',
		__( 'Coupon Text', 'mintthemes_msg_bar' ), 
		'mintthemes_msg_bar_settings_field_textbox',
		'mintthemes_msg_bar_options',
		'settings',
		array(
			'name'        => 'text',
			'value'       => mintthemes_msg_bar_get_plugin_option( 'text' ),
			'description' => __( 'The text you would like to display', 'mintthemes_msg_bar' )
		)
	);
	
	//
	add_settings_field(
		'url',
		__( 'URL', 'mintthemes_msg_bar' ), 
		'mintthemes_msg_bar_settings_field_textbox',
		'mintthemes_msg_bar_options',
		'settings',
		array(
			'name'        => 'url',
			'value'       => mintthemes_msg_bar_get_plugin_option( 'url' ),
			'description' => __( 'Enter a link.', 'mintthemes_msg_bar' )
		)
	);
	//
	add_settings_field(
		'show-hide',
		__( 'Show or Hide', 'mintthemes_msg_bar' ), 
		'mintthemes_msg_bar_settings_field_select',
		'mintthemes_msg_bar_options',
		'settings',
		array(
			'name'        => 'show-hide',
			'value'       => mintthemes_msg_bar_get_plugin_option( 'show-hide' ),
			'options'     => array('show','hide'),
			'description' => __( 'Show or Hide the message bar', 'mintthemes_msg_bar' )
		)
	);
	

	
}
add_action( 'admin_init', 'mintthemes_msg_bar_plugin_options_init' );

/**
 * Change the capability required to save the 'mintthemes_msg_bar_options' options group.
 *
 * @see mintthemes_msg_bar_plugin_options_init() First parameter to register_setting() is the name of the options group.
 * @see mintthemes_msg_bar_plugin_options_add_page() The manage_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function mintthemes_msg_bar_option_page_capability( $capability ) {
	return 'manage_options';
}
add_filter( 'option_page_capability_mintthemes_msg_bar_options', 'mintthemes_msg_bar_option_page_capability' );

/**
 * Add our plugin options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_plugin_options_add_page() {
	 add_options_page(
		__( 'Message Bar Options', 'mintthemes_msg_bar' ),
		__( 'Message Bar Options', 'mintthemes_msg_bar' ),
		'manage_options',
		'mintthemes_msg_bar_options',
		'mintthemes_msg_bar_plugin_options_render_page'
	);
	
}
add_action( 'admin_menu', 'mintthemes_msg_bar_plugin_options_add_page' );

/**
 * Returns the options array for Message Bar.
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_get_plugin_options() {
	$saved = (array) get_option( 'mintthemes_msg_bar_options' );
	
	$defaults = array(
		'color'     => '',
		'text' 	=> '',
		'url' 	=> '',
		'show-hide' 	=> '',
	);

	$defaults = apply_filters( 'mintthemes_msg_bar_default_plugin_options', $defaults );

	$options = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );

	return $options;
}

/**
 * Get a single plugin option
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_get_plugin_option( $key ) {
	$options = mintthemes_msg_bar_get_plugin_options();
	
	if ( isset( $options[ $key ] ) )
		return $options[ $key ];
		
	return false;
}

/**
 * Renders the Theme Options administration screen.
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_plugin_options_render_page() {
	
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( 'Message Bar Options', 'mintthemes_msg_bar' ), 'mintthemes_msg_bar' ); ?></h2>
		<?php settings_errors(); ?>

		<form action="options.php" method="post">
			<?php
				settings_fields( 'mintthemes_msg_bar_options' );
				do_settings_sections( 'mintthemes_msg_bar_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see mintthemes_msg_bar_plugin_options_init()
 * @todo set up Reset Options action
 *
 * @param array $input Unknown values.
 * @return array Sanitized plugin options ready to be stored in the database.
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_plugin_options_validate( $input ) {
	$output = array();
	
	
	if ( isset ( $input[ 'color' ] ) )
		$output[ 'color' ] = esc_attr( $input[ 'color' ] );
		
	if ( isset ( $input[ 'text' ] ) )
		$output[ 'text' ] = esc_attr( $input[ 'text' ] );
		
	if ( isset ( $input[ 'url' ] ) )
		$output[ 'url' ] = esc_attr( $input[ 'url' ] );
		
	if ( $input[ 'show-hide' ] == 0 || array_key_exists( $input[ 'show-hide' ], mintthemes_msg_bar_get_categories() ) )
		$output[ 'show-hide' ] = $input[ 'show-hide' ];
		
		
	
	$output = wp_parse_args( $output, mintthemes_msg_bar_get_plugin_options() );	
		
	return apply_filters( 'mintthemes_msg_bar_plugin_options_validate', $output, $input );
}

/* Fields ***************************************************************/
 
/**
 * Number Field
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_settings_field_number( $args = array() ) {
	$defaults = array(
		'menu'        => '', 
		'min'         => 1,
		'max'         => 100,
		'step'        => 1,
		'name'        => '',
		'value'       => '',
		'description' => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	$id   = esc_attr( $name );
	$name = esc_attr( sprintf( 'mintthemes_msg_bar_options[%s]', $name ) );
?>
	<label for="<?php echo esc_attr( $id ); ?>">
		<input type="number" min="<?php echo absint( $min ); ?>" max="<?php echo absint( $max ); ?>" step="<?php echo absint( $step ); ?>" name="<?php echo $name; ?>" id="<?php echo $id ?>" value="<?php echo esc_attr( $value ); ?>" />
		<?php echo $description; ?>
	</label>
<?php
} 

/**
 * Textarea Field
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_settings_field_textarea( $args = array() ) {
	$defaults = array(
		'name'        => '',
		'value'       => '',
		'description' => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	$id   = esc_attr( $name );
	$name = esc_attr( sprintf( 'mintthemes_msg_bar_options[%s]', $name ) );
?>
	<label for="<?php echo $id; ?>">
		<textarea name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="code large-text" rows="3" cols="30"><?php echo esc_textarea( $value ); ?></textarea>
		<br />
		<?php echo $description; ?>
	</label>
<?php
} 

/**
 * Image Upload Field
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_settings_field_image_upload( $args = array() ) {
	$defaults = array(
		'name'        => '',
		'value'       => '',
		'description' => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	$id   = esc_attr( $name );
	$name = esc_attr( sprintf( 'mintthemes_msg_bar_options[%s]', $name ) );
?>
	<label for="<?php echo $id; ?>">
		<input type="text" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr( $value ); ?>">
        <input id="upload_image_button" type="button" value="<?php echo __( 'Upload Image', 'mintthemes_msg_bar' ); ?>" />
		<br /><?php echo $description; ?>
	</label>
<?php
} 

/**
 * Textbox Field
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_settings_field_textbox( $args = array() ) {
	$defaults = array(
		'name'        => '',
		'value'       => '',
		'description' => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	$id   = esc_attr( $name );
	$name = esc_attr( sprintf( 'mintthemes_msg_bar_options[%s]', $name ) );
?>
	<label for="<?php echo $id; ?>">
		<input type="text" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr( $value ); ?>">
		<br /><?php echo $description; ?>
	</label>
<?php
} 

/**
 * Single Checkbox Field
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_settings_field_checkbox_single( $args = array() ) {
	$defaults = array(
		'name'        => '',
		'value'       => '',
		'compare'     => 'on',
		'description' => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	$id   = esc_attr( $name );
	$name = esc_attr( sprintf( 'mintthemes_msg_bar_options[%s]', $name ) );
?>
	<label for="<?php echo esc_attr( $id ); ?>">
		<input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr( $value ); ?>" <?php checked( $compare, $value ); ?>>
		<?php echo $description; ?>
	</label>
<?php
} 

/**
 * Radio Field
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_settings_field_radio( $args = array() ) {
	$defaults = array(
		'name'        => '',
		'value'       => '',
		'options'     => array(),
		'description' => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	$id   = esc_attr( $name );
	$name = esc_attr( sprintf( 'mintthemes_msg_bar_options[%s]', $name ) );
?>
	<?php foreach ( $options as $option_id => $option_label ) : ?>
	<label title="<?php echo esc_attr( $option_label ); ?>">
		<input type="radio" name="<?php echo $name; ?>" value="<?php echo $option_id; ?>" <?php checked( $option_id, $value ); ?>>
		<?php echo esc_attr( $option_label ); ?>
	</label>
		<br />
	<?php endforeach; ?>
<?php
}

/**
 * Select Field
 *
 * @since Message Bar 1.0
 */
function mintthemes_msg_bar_settings_field_select( $args = array() ) {
	$defaults = array(
		'name'        => '',
		'value'       => '',
		'options'     => array(),
		'description' => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	$id   = esc_attr( $name );
	$name = esc_attr( sprintf( 'mintthemes_msg_bar_options[%s]', $name ) );
?>
	<label for="<?php echo $id; ?>">
		<select name="<?php echo $name; ?>">
			<?php foreach ( $options as $option_id => $option_label ) : ?>
			<option value="<?php echo esc_attr( $option_id ); ?>" <?php selected( $option_id, $value ); ?>>
				<?php echo esc_attr( $option_label ); ?>
			</option>
			<?php endforeach; ?>
		</select>
		<?php echo $description; ?>
	</label>
<?php
}

/* Helpers ***************************************************************/

function mintthemes_msg_bar_get_categories() {
	$output = array();
	$terms  = get_terms( array( 'category' ), array( 'hide_empty' => 0 ) );
	
	foreach ( $terms as $term ) {
		$output[ $term->term_id ] = $term->name;
	}
	
	return $output;
}
