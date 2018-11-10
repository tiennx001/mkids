<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 8/12/14
 * Time: 10:11 AM
 * To change this template use File | Settings | File Templates.
 */

class PassValidateForm extends TblUserForm
{
  public function configure()
  {
    parent::setup();
    $this->useFields(array('password'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->widgetSchema['current_password'] = new sfWidgetFormInputText();
    $this->validatorSchema['current_password'] = new sfValidatorString(array(
      'trim' => true,
      'required' => true
    ), array(
      'required' => $i18n->__('Vui lòng nhập mật khẩu hiện tại')
    ));

    $this->widgetSchema['password'] = new sfWidgetFormInputText();
    $this->validatorSchema['password'] = new sfValidatorString(array(
      'trim' => true,
      'required' => true
    ), array(
      'required' => $i18n->__('Vui lòng nhập mật khẩu mới')
    ));

//    $this->validatorSchema['password'] = new sfValidatorRegex(array(
//      'required' => true,
//      'pattern' => trim(sfConfig::get("app_strong_password_pattern")),
//      'min_length' => 8,
//      'max_length' => 30,
//      'trim' => true
//    ), array(
//      'invalid' => $i18n->__('Your password must have at least 8 characters, include letter, number and special characters.'),
//      'min_length' => $i18n->__("Password min length 8 char"),
//      'max_length' => $i18n->__("Password max length 30 char")
//    ));

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
      'callback' => array($this, 'checkPassword')
    )));
    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::NOT_EQUAL, 'current_password', array(), array(
      'invalid' => sfContext::getInstance()->getI18N()->__('Mật khẩu mới không được trùng mật khẩu hiện tại')
    )));
    $this->disableCSRFProtection();
  }

  public function checkPassword($validator, $values) {
    if (isset($values['current_password']) && $values['current_password']) {
      if (!$this->getObject()->checkPassword($values['current_password'])) {
        $errSchema = array('current_password' => new sfValidatorError($validator, sfContext::getInstance()->getI18N()->__('Mật khẩu hiện tại không đúng')));
        throw new sfValidatorErrorSchema($validator, $errSchema);
      }
    }
    return $values;
  }
}