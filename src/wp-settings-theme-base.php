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

class WPSettingsThemeBase
{
    function __construct()
    {
        $this->id   = !!isset($this->id)?sanitize_title($this->id):'setting-'.uniqid();
        $this->args = !!isset($this->args)&&is_array($this->args)?$this->args:array();
        $this->type = !!is_null($this->type)?'text':$this->type;
    }
/*    final public function render($args)
    {
        switch ($this->type)
        {
            case 'text':
            case 'color':
            case 'date':
            case 'datetime':
            case 'datetime-local':
            case 'email':
            case 'month':
            case 'number':
            case 'password':
            case 'range':
            case 'search':
            case 'tel':
            case 'time':
            case 'url':
            case 'week':
                
                $this->renderTextField();
                break;
            
        }
        $this->renderDescField();
    }*/
}
/*
types:

button
checkbox
file
hidden
image
radio
reset
submit
text
*/


/*
accept
align
alt
 */