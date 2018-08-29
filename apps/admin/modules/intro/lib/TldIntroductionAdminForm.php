<?php

/**
 * intro admin form
 *
 * @package    mnhm
 * @subpackage intro
 * @author     Your name here
 */
class TldIntroductionAdminForm extends BaseForm
{
  public function configure()
  {
    parent::configure();
    // lay gia tri tu file config
    $yamlFile = dirname(__FILE__). '/../config/introData.yml';
    $introData = sfYaml::load($yamlFile);

    $this->widgetSchema['body'] = new sfWidgetFormCKEditor();
    $this->validatorSchema['body'] = new sfValidatorString(array(
      'max_length' => 65000,
      'required'	 => true,
      'trim'			 => true), array(
      'max_length' => $i18n->__('Nội dung không được vượt quá 65000 kí tự.')
    ));

    $this->widgetSchema->setNameFormat('intro[%s]');
  }
  
}