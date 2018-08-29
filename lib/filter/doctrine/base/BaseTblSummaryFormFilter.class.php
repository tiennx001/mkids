<?php

/**
 * TblSummary filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblSummaryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'member_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'add_empty' => true)),
      'date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'week'        => new sfWidgetFormFilterInput(),
      'summary'     => new sfWidgetFormFilterInput(),
      'learning'    => new sfWidgetFormFilterInput(),
      'behavior'    => new sfWidgetFormFilterInput(),
      'attendance'  => new sfWidgetFormFilterInput(),
      'description' => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'member_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblMember'), 'column' => 'id')),
      'date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'week'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'summary'     => new sfValidatorPass(array('required' => false)),
      'learning'    => new sfValidatorPass(array('required' => false)),
      'behavior'    => new sfValidatorPass(array('required' => false)),
      'attendance'  => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('tbl_summary_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblSummary';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'member_id'   => 'ForeignKey',
      'date'        => 'Date',
      'week'        => 'Number',
      'summary'     => 'Text',
      'learning'    => 'Text',
      'behavior'    => 'Text',
      'attendance'  => 'Text',
      'description' => 'Text',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
