<?php

/**
 * TblMemberActivity form base class.
 *
 * @method TblMemberActivity getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblMemberActivityForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'member_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'add_empty' => false)),
      'date'        => new sfWidgetFormDate(),
      'type'        => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'health'      => new sfWidgetFormInputText(),
      'height'      => new sfWidgetFormInputText(),
      'weight'      => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'member_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'))),
      'date'        => new sfValidatorDate(),
      'type'        => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'health'      => new sfValidatorPass(array('required' => false)),
      'height'      => new sfValidatorInteger(array('required' => false)),
      'weight'      => new sfValidatorInteger(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('tbl_member_activity[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblMemberActivity';
  }

}
