<?php

/**
 * TblSummary form base class.
 *
 * @method TblSummary getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblSummaryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'member_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'add_empty' => true)),
      'date'        => new sfWidgetFormDate(),
      'week'        => new sfWidgetFormInputText(),
      'summary'     => new sfWidgetFormInputText(),
      'learning'    => new sfWidgetFormInputText(),
      'behavior'    => new sfWidgetFormInputText(),
      'attendance'  => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'member_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'required' => false)),
      'date'        => new sfValidatorDate(array('required' => false)),
      'week'        => new sfValidatorInteger(array('required' => false)),
      'summary'     => new sfValidatorPass(array('required' => false)),
      'learning'    => new sfValidatorPass(array('required' => false)),
      'behavior'    => new sfValidatorPass(array('required' => false)),
      'attendance'  => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('tbl_summary[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblSummary';
  }

}
