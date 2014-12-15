<?php

/**
* 
*/
abstract class WPSettingsThemeFieldFactory
{
    protected $wpst_attr_text_format  = '%s="%s" ';
    protected $wpst_desc_text_format  = '<br/><span class="description">%s</span>';
    protected $setting_group = NULL;
    function __construct($setting_group)
    {
        $this->id    = !!isset($this->id)?sanitize_title($this->id):'setting-'.uniqid();
        $this->args  = !!isset($this->args)&&is_array($this->args)?$this->args:array();
        $this->type  = !!is_null($this->type)?'text':$this->type;
        $this->name  = $setting_group.'_'.$this->title;
        $this->value = get_option($this->name,isset($this->defaultValue)?$this->defaultValue:'');
        $this->setting_group = $setting_group;
    }

    protected function descToText()
    {
        return sprintf($this->wpst_desc_text_format,$this->desc);
    }

    protected function attrsToText()
    {
        $attrs_text = '';
        foreach ($this->args as $key => $value)
        {
            $attrs_text.= sprintf($this->wpst_attr_text_format,$key,$value);
        }
        return trim($attrs_text);
    }

    protected function renderDescField()
    {
        if(!!isset($this->desc))
        {
            echo $this->descToText();
        }
        return $this;
    }
    
    final public function renderField()
    {
        echo $this->textField();
        return $this;
    }

    abstract protected function textField();
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