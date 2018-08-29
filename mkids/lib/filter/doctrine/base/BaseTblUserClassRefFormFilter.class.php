<?php

/**
 * TblUserClassRef filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblUserClassRefFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'), 'add_empty' => true)),
      'class_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblClass'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'user_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblUser'), 'column' => 'id')),
      'class_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblClass'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('tbl_user_class_ref_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblUserClassRef';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'user_id'  => 'ForeignKey',
      'class_id' => 'ForeignKey',
    );
  }
}
