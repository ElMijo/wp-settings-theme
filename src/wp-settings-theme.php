<?php

/**
 * Class Name: wp-settings-theme
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 1.0
 * Author: Jerry Anselmi <jerry.anselmi@gmaail.com>
 * License: MIT
 * License URI: http://opensource.org/licenses/MIT
 */

define("WPSTDOMAIN", "wpsettingstheme");

abstract class WPSettingsThemeBase
{

}

class WPSettingsThemeAdmin
{
    /**
     * Objeto con la infomación del tema
     * @var WP_Theme object
     */
    private $theme_data;
    /**
     * Opciones para crear la pagina de configuración del tema
     * @var array
     */
    private $theme_page_data;

    function __construct()
    {
        //add_action( 'init', 'ilc_admin_init' );
        add_action( 'admin_menu', array($this,'settings_page_init') );
        $this->theme_data = wp_get_theme();
        $this->theme_page_data = array(
            "page_title" => __(sprintf('%s Theme Settings',$this->theme_data->get('Name')),WPSTDOMAIN),
            "menu_title" => __("Settings",WPSTDOMAIN),
            "capability" => "edit_theme_options",
            "menu_slug"  => "theme-settings",
            "function"   => array($this,'settings_page')
        );

    }
    
    /**
     * Este metodo permite agregar una opción al menu de los temas
     * @return void
     */
    final public function settings_page_init() {
        extract($this->theme_page_data);       
        $settings_page = add_theme_page($page_title, $menu_title, $capability, $menu_slug, $function );
        //add_action( "load-{$settings_page}", 'ilc_load_settings_page' );
    }

    /**
     * Este metodo se encarga de renderizar las opciones del tema
     * @return void
     */
    final public function settings_page()
    {
        
    }


}

$WPSTA = new WPSettingsThemeAdmin();