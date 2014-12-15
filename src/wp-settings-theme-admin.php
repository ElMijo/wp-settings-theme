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
     * Arreglo con las clases que extienden de WPSettingsThemeSectionBase
     * @var array
     */
    private $settings_sections_class;

    /**
     * Arreglo con las clases que extienden de WPSettingsThemeBase
     * @var array
     */
    private $settings_class;

    /**
     * Nombre que se le asignara al grupo de opciones del tema
     * @var string
     */
    private $theme_option_group;

    /**
     * Cadena de texto con el nombre de la pagina de opciones
     * @var string
     */
    private $theme_option_page;

    /**
     * Slug de las opciones
     * @var string
     */
    private $theme_slug;

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
            $this->themes_slug        = sanitize_title($this->theme_data->get('Name'));
            $this->theme_option_group = '_'.$this->themes_slug.'_setting';
            $this->theme_option_page  = 'options-'.$this->themes_slug.'.php';

            add_action( 'admin_menu', array($this,'settings_page_init') );
            add_action( 'admin_init', array($this,'register_settings') );

            $this->include_settings_files()
                 ->init_settings_section_class()
                 ->init_settings_class()                 
            ;

        }
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

    final public function register_settings()
    {
        foreach ($this->settings_sections_class as $section)
        {
            foreach ($section->getSettings() as $setting)
            {
                register_setting($this->theme_option_group, $setting->name);
                add_settings_field( $setting->id, $setting->title, array($setting,'renderField'), $this->theme_option_page, $section->id);
            }

            add_settings_section($section->id, $section->title, array($section,'render') , $this->theme_option_page);
        }
    }
    /**
     * Este metodo permite obtener todos los archivos de configuraciones que se encuentran en la ruta de configuraciones
     * @return array
     */
    private function get_settings_files()
    {
        return is_dir($this->settings_path)?glob($this->settings_path."/*.php"):array();
    }

    /**
     * Permite incluir los archivos  que contienen las clases de opciones
     * @return self
     */
    private function include_settings_files()
    {
        $classes = get_declared_classes();

        foreach ($this->get_settings_files() as $file)
        {
            include_once $file;
        }

        $diff = array_diff(get_declared_classes(), $classes);
        
        reset($diff);

        $this->settings_class = $diff;

        return $this;   
    }

    /**
     * Permite crear una instancia de la clase que contiene la opción
     * @return self
     */
    private function init_settings_class()
    {
        foreach ($this->settings_class as $class)
        {
            if (!!is_subclass_of($class,'WPSettingsThemeFieldFactory'))
            {
                $instanceClass = new $class($this->theme_option_group);
                $section = $this->get_section_name($instanceClass);
                $this->settings_sections_class[$section]->addSetting($instanceClass);
            }
        }
        return $this;
    }
    
    /**
     * Permite crear una instancia de la clase que contiene la sección de opciónes
     * @return self
     */
    private function init_settings_section_class()
    {

        $this->settings_sections_class = array();

        foreach (get_declared_classes() as $class)
        {
            if (get_parent_class($class) == 'WPSettingsThemeSectionBase')
            {
                $this->settings_sections_class[$class] = new $class;
            }
        }
        return $this;
    }

    private function get_section_name($class)
    {
        return !!isset($class->section)&&class_exists($class->section)?$class->section:'DefaultSection';
    }
}

$WPSTA = new WPSettingsThemeAdmin();