<?php

/**
 * Wordpress Settings Theme - WPSettingsThemeBase
 *
 * Esta clase define los metodos base para poder administrar las opciones
 *
 * @author Jerry Anselmi <jerry.anselmi@ gmail.com>
 * @package WPSettingsTheme
 * 
 */

abstract class WPSettingsThemeSectionBase
{
    /**
     * Arreglo que contiene instancias de WPSettingsThemeBase
     * @var array
     */
    protected $settings;

    function __construct()
    {
        $this->id       = isset($this->id)?sanitize_title($this->id):'section-'.uniqid();
        $this->settings = array();
    }


    final public function addSetting($settings)
    {
        array_push($this->settings, $settings);
    }

    final public function render()
    {
        // echo "<h2>".$this->title."</h2>";
    }

    final public function getSettings()
    {
        return $this->settings;
    }
}

class DefaultSection extends WPSettingsThemeSectionBase
{
    public $id    = "default-settings";
    public $title = "Default Settings";
}