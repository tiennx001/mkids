<?php

/**
 * VtNews filter form base class.
 *
 * @package    IpCamera
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseVtNewsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'header'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'content'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'published_time' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'is_active'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'image_path'     => new sfWidgetFormFilterInput(),
      'author'         => new sfWidgetFormFilterInput(),
      'promotion_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Promotion'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'          => new sfValidatorPass(array('required' => false)),
      'header'         => new sfValidatorPass(array('required' => false)),
      'content'        => new sfValidatorPass(array('required' => false)),
      'published_time' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'is_active'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'image_path'     => new sfValidatorPass(array('required' => false)),
      'author'         => new sfValidatorPass(array('required' => false)),
      'promotion_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Promotion'), 'column' => 'id')),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vt_news_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VtNews';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'title'          => 'Text',
      'header'         => 'Text',
      'content'        => 'Text',
      'published_time' => 'Date',
      'is_active'      => 'Boolean',
      'image_path'     => 'Text',
      'author'         => 'Text',
      'promotion_id'   => 'ForeignKey',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'slug'           => 'Text',
    );
  }
}
