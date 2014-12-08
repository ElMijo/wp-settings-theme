<?php

/**
 * Wordpress Settings Theme
 * 
 * Wordpress Settings Theme es un conjunto de clases desarrollaadas para desarrolladores 
 * que necesitan agregar opciones opciones de configuración a un tema.
 *
 * @version 1.0
 * @author Jerry Anselmi <jerry.anselmi@ gmail.com>
 * @copyright 2014 Jerry Anselmi Todos los derechos reservados
 * @license https://raw.githubusercontent.com/ElMijo/wp-settings-theme/master/LICENSE The MIT License (MIT)
 * @link https://github.com/ElMijo/wp-settings-theme Wordpress Settings Theme
 * @package WPSettingsTheme
 * 
 */

define("WPST_DIR", dirname( __file__));
define("WPST_DOMAIN", "wpsettingstheme");

include_once WPST_DIR."/src/wp-settings-theme-base.php";
include_once WPST_DIR."/src/wp-settings-theme-admin.php";
// include_once WPST_DIR."/src/wp-settings-theme.php";


/**
 * Register the settings to use on the theme options page
 */
add_action( 'admin_init', 'pu_register_settings' );

/**
 * Function to register the settings
 */
function pu_register_settings()
{
    // Register the settings with Validation callback
    register_setting( 'pu_theme_options', 'pu_theme_options', 'pu_validate_settings' );

    // Add settings section
    add_settings_section( 'pu_text_section', 'Text box Title', 'pu_display_section', 'pu_theme_options.php' );

    // Create textbox field
    $field_args = array(
      'type'      => 'text',
      'id'        => 'pu_textbox',
      'name'      => 'pu_textbox',
      'desc'      => 'Example of textbox description',
      'std'       => '',
      'label_for' => 'pu_textbox',
      'class'     => 'css_class'
    );

    add_settings_field( 'example_textbox', 'Example Textbox', 'pu_display_setting', 'pu_theme_options.php', 'pu_text_section', $field_args );
    add_settings_field( 'example_textbox2', 'Example Textbox2', 'pu_display_setting', 'pu_theme_options.php', 'pu_text_section', $field_args );
}

function pu_display_section($section)
{ 
    var_dump($section);
}
function pu_display_setting($args)
{
    extract( $args );

    $option_name = 'pu_theme_options';

    $options = get_option( $option_name );

    switch ( $type ) {  
          case 'text':  
              $options[$id] = stripslashes($options[$id]);  
              $options[$id] = esc_attr( $options[$id]);  
              echo "<input class='regular-text$class' type='text' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";  
              echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
          break;  
    }
}


/*

// * Displays all messages registered to 'your-settings-error-slug'
function your_admin_notices_action() {
    settings_errors( 'your-settings-error-slug' );
}
add_action( 'admin_notices', 'your_admin_notices_action' );



 */