<?php

class vtWidgetFormDatePicker extends sfWidgetFormDateTime{

    protected function configure($options = array(), $attributes = array()) {
        parent::configure($options, $attributes);
    }

    /**
     * @param  string $name        The element name
     * @param  string $value       The value selected in this widget
     * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
     * @param  array  $errors      An array of errors for the field
     *
     * @return string An HTML tag string
     *
     * @see sfWidgetForm
     */
    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        
        //$html = '<div style="display:none">'.parent::render($name, $value, $attributes, $errors).'</div>';
        return /*$html.*/$this->renderDateTimePicker($name, $value, $attributes, $errors);
        
    }
    
    protected function renderDateTimePicker($name, $value, $attributes, $errors) 
    {  
        $widget = new sfWidgetFormInput();
        if (!empty($value))
        {
          $value = str_replace('/', '-', $value);
          $value = date('d/m/Y', strtotime($value));
        }
        
        return $widget->render($name, $value, array_merge($attributes, array("class"=>"vtdatepicker")), $errors); //"style"=>"width:150px;"
    }

    public function getJavaScripts() {
        $javascripts = array(
            '/dmCorePlugin/lib/jquery-ui/js/minified/jquery.ui.datepicker.min.js',
            '/dmCorePlugin/lib/jquery-ui/js/i18n/jquery.ui.datepicker-'.sfContext::getInstance()->getUser()->getCulture().'.js',
            'admin',
            '/dmCorePlugin/lib/jquery-ui/js/minified/jquery.ui.core.min.js',
            '/dmCorePlugin/lib/jquery-ui/js/minified/jquery.ui.widget.min.js',
            '/dmCorePlugin/lib/jquery-ui/js/minified/jquery.ui.mouse.min.js',
            '/dmDateTimePickerPlugin/js/datetimepicker.js',
            '/dmDateTimePickerPlugin/js/launcher.js'
            );
         return array_merge(parent::getJavascripts(), $javascripts);
    }
    public function getStylesheets(){
        $styleSheets = array(
            '/dmDateTimePickerPlugin/css/datetimepicker.css' => 'all',
            '/dmDateTimePickerPlugin/css/jquery-ui-datepicker.css' => 'all',
            '/dmDateTimePickerPlugin/css/jquery-ui.custom.css' => 'all'
            );
         return array_merge(parent::getStylesheets(), $styleSheets);
    }

}
