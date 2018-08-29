<?php

/**
 * TldIntroduction form.
 *
 * @package    pixshare
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class TldIntroductionForm extends BaseForm
{
  public function configure()
  {
    parent::configure();
    $i18n = sfContext::getInstance()->getI18N();
    // lay gia tri tu file config
    $yamlFile = dirname(__FILE__). '/../config/introData.yml';
    $introData = sfYaml::load($yamlFile);

    $this->widgetSchema['body'] = new sfWidgetFormCKEditor(array(
      'default' => $introData['body']
    ));
    $this->validatorSchema['body'] = new sfValidatorString(array(
      'max_length' => 65000,
      'required'	 => true,
      'trim'			 => true), array(
      'max_length' => $i18n->__('Nội dung không được vượt quá 65000 kí tự.')
    ));


    $this->widgetSchema->setNameFormat('intro[%s]');
  }
}