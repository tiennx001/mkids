<?php

/**
 * VtFAQs form base class.
 *
 * @method VtFAQs getObject() Returns the current form's model object
 *
 * @package    IpCamera
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVtFAQsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'question'   => new sfWidgetFormTextarea(),
      'answer'     => new sfWidgetFormTextarea(),
      'is_active'  => new sfWidgetFormInputCheckbox(),
      'priority'   => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'question'   => new sfValidatorString(array('max_length' => 500)),
      'answer'     => new sfValidatorString(),
      'is_active'  => new sfValidatorBoolean(array('required' => false)),
      'priority'   => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('vt_fa_qs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VtFAQs';
  }

}
