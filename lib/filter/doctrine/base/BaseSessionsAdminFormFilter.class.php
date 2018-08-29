<?php

/**
 * SessionsAdmin filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSessionsAdminFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'sess_data'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sess_time'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sess_userid' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'sess_data'   => new sfValidatorPass(array('required' => false)),
      'sess_time'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sess_userid' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('sessions_admin_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SessionsAdmin';
  }

  public function getFields()
  {
    return array(
      'sess_id'     => 'Text',
      'sess_data'   => 'Text',
      'sess_time'   => 'Number',
      'sess_userid' => 'Number',
    );
  }
}
