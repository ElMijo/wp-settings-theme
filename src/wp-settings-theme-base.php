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

abstract class WPSettingsThemeBase
{
    protected $settings_group;

    function __construct()
    {

    }

    abstract protected function get_settings_fields();
}