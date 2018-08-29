<?php

/**
 * TblNotificationHis form base class.
 *
 * @method TblNotificationHis getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblNotificationHisForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'sender_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sender'), 'add_empty' => true)),
      'receiver_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Receiver'), 'add_empty' => true)),
      'receiver_phone' => new sfWidgetFormInputText(),
      'content'        => new sfWidgetFormTextarea(),
      'type'           => new sfWidgetFormInputText(),
      'article_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblArticle'), 'add_empty' => true)),
      'status'         => new sfWidgetFormInputText(),
      'response'       => new sfWidgetFormTextarea(),
      'created_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'sender_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sender'), 'required' => false)),
      'receiver_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Receiver'), 'required' => false)),
      'receiver_phone' => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'content'        => new sfValidatorString(array('max_length' => 1024, 'required' => false)),
      'type'           => new sfValidatorPass(array('required' => false)),
      'article_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblArticle'), 'required' => false)),
      'status'         => new sfValidatorInteger(array('required' => false)),
      'response'       => new sfValidatorString(array('max_length' => 1024, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('tbl_notification_his[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblNotificationHis';
  }

}
