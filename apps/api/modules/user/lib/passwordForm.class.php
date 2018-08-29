<?php

/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 8/12/14
 * Time: 10:11 AM
 * To change this template use File | Settings | File Templates.
 */
class PasswordForm extends TblUserForm
{

  public function configure()
  {
    parent::setup();
    $this->useFields(array('email', 'msisdn', 'password'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->widgetSchema['email'] = new sfWidgetFormInputText();
    $this->validatorSchema['email'] = new sfValidatorEmail(array(
      'trim' => true,
      'required' => true
    ), array(
      'required' => $i18n->__('Required'),
      'invalid' => $i18n->__('Invalid Email')
    ));

    $this->widgetSchema['msisdn'] = new sfWidgetFormInputText();
    $this->validatorSchema['msisdn'] = new sfValidatorPass();

    $this->widgetSchema['password'] = new sfWidgetFormInputText();
    $this->validatorSchema['password'] = new sfValidatorString(array(
      'trim' => true,
      'required' => true
    ), array(
      'required' => $i18n->__('Required')
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

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorDoctrineUnique(array(
        'model' => 'TblUser',
        'column' => 'email'
      ), array(
        'invalid' => $i18n->__('Email has already existed.')
      )),
      new sfValidatorDoctrineUnique(array(
        'model' => 'TblUser',
        'column' => 'msisdn'
      ), array(
        'invalid' => $i18n->__('Phone number has already existed.')
      ))
    )));
    $this->disableCSRFProtection();
  }

  public function processValues($values)
  {
    $values = parent::processValues($values);

    $values['salt'] = md5(rand(100000, 999999) . $values['email']);
    $values['password'] = sha1($values['salt'] . $values['password']);
    $values['status'] = 1;

    return $values;
  }

}