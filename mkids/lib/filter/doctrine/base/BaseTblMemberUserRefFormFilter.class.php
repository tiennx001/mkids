<?php

/**
 * TblMemberUserRef filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblMemberUserRefFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'member_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'add_empty' => true)),
      'user_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'member_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblMember'), 'column' => 'id')),
      'user_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblUser'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('tbl_member_user_ref_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblMemberUserRef';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'member_id' => 'ForeignKey',
      'user_id'   => 'ForeignKey',
    );
  }
}
