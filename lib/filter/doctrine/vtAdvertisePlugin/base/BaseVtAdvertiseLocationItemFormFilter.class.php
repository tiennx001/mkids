<?php

/**
 * VtAdvertiseLocationItem filter form base class.
 *
 * @package    IpCamera
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseVtAdvertiseLocationItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'advertise_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Advertise'), 'add_empty' => true)),
      'location_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'advertise_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Advertise'), 'column' => 'id')),
      'location_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Location'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('vt_advertise_location_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VtAdvertiseLocationItem';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'advertise_id' => 'ForeignKey',
      'location_id'  => 'ForeignKey',
    );
  }
}
