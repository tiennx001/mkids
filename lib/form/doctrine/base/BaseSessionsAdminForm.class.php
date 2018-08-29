<?php

/**
 * SessionsAdmin form base class.
 *
 * @method SessionsAdmin getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSessionsAdminForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'sess_id'     => new sfWidgetFormInputHidden(),
      'sess_data'   => new sfWidgetFormTextarea(),
      'sess_time'   => new sfWidgetFormInputText(),
      'sess_userid' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'sess_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('sess_id')), 'empty_value' => $this->getObject()->get('sess_id'), 'required' => false)),
      'sess_data'   => new sfValidatorString(),
      'sess_time'   => new sfValidatorInteger(),
      'sess_userid' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sessions_admin[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SessionsAdmin';
  }

}
