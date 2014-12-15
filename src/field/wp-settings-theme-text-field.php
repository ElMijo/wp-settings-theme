<?php

/**
* 
*/
class WPSettingsThemeTextField extends WPSettingsThemeFieldFactory
{
    
    protected $wpst_field_text_format = '<input type="%s" name="%s" value="%s" %s />';

    protected function textField()
    {
        return sprintf($this->wpst_field_text_format,$this->type,$this->name,$this->value,$this->attrsToText());
    }
}