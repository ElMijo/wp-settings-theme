<?php

/**
 * Wordpress Settings Theme - WPSettingsThemeAdmin
 *
 * Esta clase permite manejar todo lo relacionado con la viistaa ad ministrativa de las configuraciones del tema
 *
 * @author Jerry Anselmi <jerry.anselmi@ gmail.com>
 * @package WPSettingsTheme
 * 
 */
class WPSettingsThemeAdmin
{
    /**
     * Objeto con la infomación del tema
     * @var WP_Theme object
     */
    private $theme_data;
    /**
     * Configuraciones para crear la pagina de configuración del tema
     * @var array
     */
    private $theme_page_data;

    /**
     * Ruta Absoluta donde se encuetran las configuraciones 
     * @var string
     */
    private $settings_path;

    /**
     * Arreglo con las clases que extienden de WPSettingsThemeBase
     * @var array
     */
    private $settings_class;

    function __construct()
    {
        if(defined('WPST_SETTINGS_PATH'))
        {
            $this->settings_path  = WPST_SETTINGS_PATH;
            $this->theme_data = wp_get_theme();
            $this->theme_page_data = array(
                "page_title" => __(sprintf('%s Theme Settings',$this->theme_data->get('Name')),WPST_DOMAIN),
                "menu_title" => __("Settings",WPST_DOMAIN),
                "capability" => "edit_theme_options",
                "menu_slug"  => "theme-settings",
                "function"   => array($this,'settings_page')
            );

            add_action( 'admin_menu', array($this,'settings_page_init') );

            $this->include_settings_files()
                 ->init_settings_class()
            ;

        }

        //add_action( 'init', 'ilc_admin_init' );

/*        $setting_folder = dir($settings_path);


        
        
*/

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
     * Este metodo se encarga de renderizar las configuraciones del tema
     * @return void
     */
    final public function settings_page()
    {
        include WPST_DIR."/src/views/admin-page.php";
    }

    /**
     * Este metodo permite obtener todos los archivos de configuraciones que se encuentran en la ruta de configuraciones
     * @return array
     */
    private function get_settings_files()
    {
        return is_dir($this->settings_path)?glob($this->settings_path."/*.php"):array();
    }

    private function include_settings_files()
    {
        foreach ($this->get_settings_files() as $file)
        {
            include_once $file;
        }

        return $this;   
    }

    private function init_settings_class()
    {

        $this->settings_class = array();

        foreach (get_declared_classes() as $class)
        {
            if (get_parent_class($class) == 'WPSettingsThemeBase')
            {
                array_push($this->settings_class, new $class);
            }
        }
        return $this;
    }


}

$WPSTA = new WPSettingsThemeAdmin();