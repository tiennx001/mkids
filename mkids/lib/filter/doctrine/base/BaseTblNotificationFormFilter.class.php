<?php

/**
 * TblNotification filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblNotificationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'sender_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sender'), 'add_empty' => true)),
      'receiver_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Receiver'), 'add_empty' => true)),
      'receiver_phone' => new sfWidgetFormFilterInput(),
      'content'        => new sfWidgetFormFilterInput(),
      'type'           => new sfWidgetFormFilterInput(),
      'article_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblArticle'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'sender_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sender'), 'column' => 'id')),
      'receiver_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Receiver'), 'column' => 'id')),
      'receiver_phone' => new sfValidatorPass(array('required' => false)),
      'content'        => new sfValidatorPass(array('required' => false)),
      'type'           => new sfValidatorPass(array('required' => false)),
      'article_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblArticle'), 'column' => 'id')),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('tbl_notification_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblNotification';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'sender_id'      => 'ForeignKey',
      'receiver_id'    => 'ForeignKey',
      'receiver_phone' => 'Text',
      'content'        => 'Text',
      'type'           => 'Text',
      'article_id'     => 'ForeignKey',
      'created_at'     => 'Date',
    );
  }
}
