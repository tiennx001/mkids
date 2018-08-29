<?php

/**
 * VtAdvertiseLocation form base class.
 *
 * @method VtAdvertiseLocation getObject() Returns the current form's model object
 *
 * @package    IpCamera
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVtAdvertiseLocationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'name'                    => new sfWidgetFormInputText(),
      'template'                => new sfWidgetFormInputText(),
      'advertise_location_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'VtAdvertise')),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                    => new sfValidatorString(array('max_length' => 200)),
      'template'                => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'advertise_location_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'VtAdvertise', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vt_advertise_location[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VtAdvertiseLocation';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['advertise_location_list']))
    {
      $this->setDefault('advertise_location_list', $this->object->AdvertiseLocation->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveAdvertiseLocationList($con);

    parent::doSave($con);
  }

  public function saveAdvertiseLocationList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['advertise_location_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->AdvertiseLocation->getPrimaryKeys();
    $values = $this->getValue('advertise_location_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('AdvertiseLocation', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('AdvertiseLocation', array_values($link));
    }
  }

}
