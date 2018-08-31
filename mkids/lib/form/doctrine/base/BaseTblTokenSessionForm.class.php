<?php

/**
 * TblTokenSession form base class.
 *
 * @method TblTokenSession getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblTokenSessionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'), 'add_empty' => true)),
      'account'      => new sfWidgetFormInputText(),
      'msisdn'       => new sfWidgetFormInputText(),
      'token'        => new sfWidgetFormInputText(),
      'expired_time' => new sfWidgetFormDateTime(),
      'key_refresh'  => new sfWidgetFormInputText(),
      'os_type'      => new sfWidgetFormInputText(),
      'user_type'    => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'), 'required' => false)),
      'account'      => new sfValidatorString(array('max_length' => 255)),
      'msisdn'       => new sfValidatorString(array('max_length' => 15)),
      'token'        => new sfValidatorString(array('max_length' => 255)),
      'expired_time' => new sfValidatorDateTime(),
      'key_refresh'  => new sfValidatorString(array('max_length' => 255)),
      'os_type'      => new sfValidatorInteger(array('required' => false)),
      'user_type'    => new sfValidatorPass(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'TblTokenSession', 'column' => array('user_id'))),
        new sfValidatorDoctrineUnique(array('model' => 'TblTokenSession', 'column' => array('account'))),
        new sfValidatorDoctrineUnique(array('model' => 'TblTokenSession', 'column' => array('msisdn'))),
      ))
    );

    $this->widgetSchema->setNameFormat('tbl_token_session[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblTokenSession';
  }

}
