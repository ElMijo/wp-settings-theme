<?php

/**
 * Wordpress Settings Theme - WPSettingsThemeFormValidate
 *
 * Esta clase contiene metodos que pueden ser utilizados para validar los valores de una opción
 *
 * @author Jerry Anselmi <jerry.anselmi@ gmail.com>
 * @package WPSettingsTheme
 * 
 */

class WPSettingsThemeFormValidate
{
    final public valid_email($val)
    {
        return filter_var($val, FILTER_VALIDATE_EMAIL));
    }
}