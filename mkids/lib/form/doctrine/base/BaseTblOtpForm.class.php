<?php

/**
 * TblOtp form base class.
 *
 * @method TblOtp getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblOtpForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'account'      => new sfWidgetFormInputText(),
      'otp'          => new sfWidgetFormInputText(),
      'is_lock'      => new sfWidgetFormInputCheckbox(),
      'lock_time'    => new sfWidgetFormInputText(),
      'expired_time' => new sfWidgetFormDateTime(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'account'      => new sfValidatorString(array('max_length' => 255)),
      'otp'          => new sfValidatorString(array('max_length' => 100)),
      'is_lock'      => new sfValidatorBoolean(array('required' => false)),
      'lock_time'    => new sfValidatorInteger(array('required' => false)),
      'expired_time' => new sfValidatorDateTime(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('tbl_otp[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblOtp';
  }

}
