<?php

/**
 * TblNotificationProgramRef form base class.
 *
 * @method TblNotificationProgramRef getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblNotificationProgramRefForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'member_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'add_empty' => true)),
      'class_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblClass'), 'add_empty' => true)),
      'group_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblGroup'), 'add_empty' => true)),
      'program_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblNotificationProgram'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'member_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'required' => false)),
      'class_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblClass'), 'required' => false)),
      'group_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblGroup'), 'required' => false)),
      'program_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblNotificationProgram'))),
    ));

    $this->widgetSchema->setNameFormat('tbl_notification_program_ref[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblNotificationProgramRef';
  }

}
