<?php

/**
 * VtAdvertise form base class.
 *
 * @method VtAdvertise getObject() Returns the current form's model object
 *
 * @package    IpCamera
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVtAdvertiseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'media_path'    => new sfWidgetFormInputText(),
      'url'           => new sfWidgetFormInputText(),
      'is_active'     => new sfWidgetFormInputCheckbox(),
      'is_flash'      => new sfWidgetFormInputCheckbox(),
      'start_time'    => new sfWidgetFormDateTime(),
      'end_time'      => new sfWidgetFormDateTime(),
      'priority'      => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'location_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'VtAdvertiseLocation')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 200)),
      'media_path'    => new sfValidatorString(array('max_length' => 255)),
      'url'           => new sfValidatorString(array('max_length' => 255)),
      'is_active'     => new sfValidatorBoolean(array('required' => false)),
      'is_flash'      => new sfValidatorBoolean(array('required' => false)),
      'start_time'    => new sfValidatorDateTime(),
      'end_time'      => new sfValidatorDateTime(),
      'priority'      => new sfValidatorInteger(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'location_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'VtAdvertiseLocation', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vt_advertise[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VtAdvertise';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['location_list']))
    {
      $this->setDefault('location_list', $this->object->Location->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveLocationList($con);

    parent::doSave($con);
  }

  public function saveLocationList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['location_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Location->getPrimaryKeys();
    $values = $this->getValue('location_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Location', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Location', array_values($link));
    }
  }

}
