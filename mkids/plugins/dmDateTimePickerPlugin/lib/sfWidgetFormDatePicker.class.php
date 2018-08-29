<?php

/**
 * Replaces standard Symfony UI date with jQuery date picker
 *
 * @author TheCelavi
 */
class sfWidgetFormDatePicker extends sfWidgetFormDate {

    public function __construct($options = array(), $attributes = array()) {
        parent::__construct($options, $attributes);
        $this->addOption('widget_width', sfConfig::get('dm_dmDatePicker_default_widget_width'));
    }

    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        // This could be nice if we can use Front layout helper :)
        return sprintf('
            <div class="dm dmDateTimePickerPlugin sfWidgetFormDatePicker">
                <input readonly="true" class="inputField" type="text" style="width:%s;" />
                <ul>
                    <li class="ui-state-default ui-corner-all button-show-picker">
                        <span class="ui-icon ui-icon-calendar"></span>
                    </li>
                    <li class="ui-state-default ui-corner-all button-reset-picker">
                        <span class="ui-icon ui-icon-close"></span>
                    </li>
                </ul>
                <span style="display:none">%s</span>
            </div>', $this->getOption('widget_width'), parent::render($name, $value, $attributes, $errors));
    }

    public function getJavaScripts() {
        $subcultures = sfConfig::get('dm_dmDateTimePickerPlugin_subcultures');
        $culture = sfContext::getInstance()->getUser()->getCulture();
        if (isset($subcultures[$culture]))
            $culture = $subcultures[$culture];
        $javascripts = array();
        $javascripts[] = '/dmCorePlugin/lib/jquery-ui/js/minified/jquery.ui.core.min.js';
        $javascripts[] = '/dmCorePlugin/lib/jquery-ui/js/minified/jquery.ui.datepicker.min.js';
        if ($culture != 'en') {
            $javascripts[] = sprintf('/dmCorePlugin/lib/jquery-ui/js/i18n/jquery.ui.datepicker-%s.js', $culture);
        }
        $javascripts[] = '/dmDateTimePickerPlugin/js/dmDatePickerPlugin.js';
        return $javascripts;
    }

    public function getStylesheets() {
        return array_merge(parent::getStylesheets(), array(
            '/dmDateTimePickerPlugin/css/jquery-ui.custom.css' => null,
            '/dmDateTimePickerPlugin/css/jquery-ui-datepicker.css' => null,
            '/dmDateTimePickerPlugin/css/dmDateTimePickerPlugin.css'=>null
        ));
    }

}

?>
