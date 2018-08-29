<?php
/**
 * User: os_vuongch
 * Date: 13 Dec 2012
 * Time: 3:49 PM
 */
class VtGuardChangePasswordForm extends BaseForm
{

  public function setup()
  {
    $i18n = sfContext::getInstance()->getI18N();

    $this->setWidgets(array(
      'username' => new sfWidgetFormInputText(array(), array('style' => 'width: 200px')),
      'password' => new sfWidgetFormInputPassword(array('type' => 'password'),array('max_length' => 250)),
    ));

    $this->setValidators(array(
      'username' => new sfValidatorString(),
      'password' => new sfValidatorString(array('trim' => true, 'required' => true),array()),
    ));
    $this->setDefault('username', sfContext::getInstance()->getUser()->getGuardUser()->getUsername());
    $this->widgetSchema['username']->setAttribute('readonly', true);

    $this->widgetSchema['new_password'] = new sfWidgetFormInputPassword(array('type' => 'password'),array('max_length' => 250));

    $this->validatorSchema['new_password'] = new sfValidatorRegex(
      array('pattern' => '/^.*(?=.{8,})(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[a-zA-Z]).*$/', 'required' => true, 'trim' => true,),
      array('invalid' => $i18n->__('Your password must have at least 8 characters, include number and special characters.'))
    );

    $this->widgetSchema['repeat_password'] = clone $this->widgetSchema['new_password'];

    $this->validatorSchema['repeat_password'] = clone $this->validatorSchema['new_password'];

    $this->widgetSchema->moveField('repeat_password', 'after', 'new_password');

    $this->widgetSchema->setLabels(array(
      'password' => $i18n->__('Current Password'),
      'new_password' => $i18n->__('New Password'),
      'repeat_password' => $i18n->__('Repeat Password'),
    ));

    $this->validatorSchema->setPostValidator(new validatorChangePassUser());
	  $newPass = $this->getValue('new_password');
	  $rePass = $this->getValue('repeat_password');
		if(isset($newPass)){
			$this->mergePostValidator(new sfValidatorSchemaCompare('new_password',
				sfValidatorSchemaCompare::NOT_EQUAL, 'password', array(), array('invalid' => $i18n->__('New password must be different than the old one.'))));
		}
		if(isset($rePass)){
			$this->mergePostValidator(new sfValidatorSchemaCompare('repeat_password',
				sfValidatorSchemaCompare::EQUAL, 'new_password', array(), array('invalid' => $i18n->__('Please enter the same password as above.'))));
		}
    $this->widgetSchema->setNameFormat('password[%s]');
  }
}
