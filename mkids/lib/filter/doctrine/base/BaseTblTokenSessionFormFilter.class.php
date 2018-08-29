<?php

/**
 * TblTokenSession filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblTokenSessionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'), 'add_empty' => true)),
      'account'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'msisdn'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'token'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'expired_time' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'key_refresh'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'os_type'      => new sfWidgetFormFilterInput(),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblUser'), 'column' => 'id')),
      'account'      => new sfValidatorPass(array('required' => false)),
      'msisdn'       => new sfValidatorPass(array('required' => false)),
      'token'        => new sfValidatorPass(array('required' => false)),
      'expired_time' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'key_refresh'  => new sfValidatorPass(array('required' => false)),
      'os_type'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('tbl_token_session_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblTokenSession';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'user_id'      => 'ForeignKey',
      'account'      => 'Text',
      'msisdn'       => 'Text',
      'token'        => 'Text',
      'expired_time' => 'Date',
      'key_refresh'  => 'Text',
      'os_type'      => 'Number',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
