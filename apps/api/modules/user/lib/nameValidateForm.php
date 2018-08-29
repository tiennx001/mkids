<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 8/12/14
 * Time: 10:11 AM
 * To change this template use File | Settings | File Templates.
 */

class NameValidateForm extends VtUserForm
{

  public function configure()
  {
    parent::setup();
    $this->useFields(array('name'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->widgetSchema['name'] = new sfWidgetFormInputText();
    $this->validatorSchema['name'] = new sfValidatorRegex(array(
      'trim' => true,
      'pattern' => sfConfig::get('app_not_special_characters_pattern'),
      'min_length' => 3,
      'max_length' => 30
    ), array(
      'min_length' => $i18n->__("Username min length 3 char"),
      'max_length' => $i18n->__("Username max length 30 char"),
      'invalid' => $i18n->__("Username does not contain special characters")
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorPass());
    $this->disableCSRFProtection();
  }

}