<?php

/**
 * TblOtp filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblOtpFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'account'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'otp'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_lock'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'lock_time'    => new sfWidgetFormFilterInput(),
      'expired_time' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'account'      => new sfValidatorPass(array('required' => false)),
      'otp'          => new sfValidatorPass(array('required' => false)),
      'is_lock'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'lock_time'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'expired_time' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('tbl_otp_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblOtp';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'account'      => 'Text',
      'otp'          => 'Text',
      'is_lock'      => 'Boolean',
      'lock_time'    => 'Number',
      'expired_time' => 'Date',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
