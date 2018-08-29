<?php

/**
 * TblMenuRef filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblMenuRefFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'member_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'add_empty' => true)),
      'class_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblClass'), 'add_empty' => true)),
      'group_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblGroup'), 'add_empty' => true)),
      'menu_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblMenu'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'member_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblMember'), 'column' => 'id')),
      'class_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblClass'), 'column' => 'id')),
      'group_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblGroup'), 'column' => 'id')),
      'menu_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblMenu'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('tbl_menu_ref_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblMenuRef';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'member_id' => 'ForeignKey',
      'class_id'  => 'ForeignKey',
      'group_id'  => 'ForeignKey',
      'menu_id'   => 'ForeignKey',
    );
  }
}
