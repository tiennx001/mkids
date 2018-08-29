<?php

/**
 * VtAdvertiseLocationItem form base class.
 *
 * @method VtAdvertiseLocationItem getObject() Returns the current form's model object
 *
 * @package    IpCamera
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVtAdvertiseLocationItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'advertise_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Advertise'), 'add_empty' => true)),
      'location_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'advertise_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Advertise'), 'required' => false)),
      'location_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vt_advertise_location_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VtAdvertiseLocationItem';
  }

}
