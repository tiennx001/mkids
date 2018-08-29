<?php

/**
 * VtSlideshow form base class.
 *
 * @method VtSlideshow getObject() Returns the current form's model object
 *
 * @package    IpCamera
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVtSlideshowForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'url'         => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormTextarea(),
      'file_path'   => new sfWidgetFormInputText(),
      'priority'    => new sfWidgetFormInputText(),
      'is_active'   => new sfWidgetFormInputCheckbox(),
      'is_flash'    => new sfWidgetFormInputCheckbox(),
      'start_time'  => new sfWidgetFormDateTime(),
      'end_time'    => new sfWidgetFormDateTime(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 200)),
      'url'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'file_path'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'priority'    => new sfValidatorInteger(array('required' => false)),
      'is_active'   => new sfValidatorBoolean(array('required' => false)),
      'is_flash'    => new sfValidatorBoolean(array('required' => false)),
      'start_time'  => new sfValidatorDateTime(),
      'end_time'    => new sfValidatorDateTime(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('vt_slideshow[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VtSlideshow';
  }

}
