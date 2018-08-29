<?php

/**
 * VtNews form base class.
 *
 * @method VtNews getObject() Returns the current form's model object
 *
 * @package    IpCamera
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVtNewsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'title'          => new sfWidgetFormInputText(),
      'header'         => new sfWidgetFormTextarea(),
      'content'        => new sfWidgetFormTextarea(),
      'published_time' => new sfWidgetFormDateTime(),
      'is_active'      => new sfWidgetFormInputCheckbox(),
      'image_path'     => new sfWidgetFormInputText(),
      'author'         => new sfWidgetFormTextarea(),
      'promotion_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Promotion'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'slug'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'          => new sfValidatorString(array('max_length' => 200)),
      'header'         => new sfValidatorString(array('max_length' => 500)),
      'content'        => new sfValidatorString(),
      'published_time' => new sfValidatorDateTime(array('required' => false)),
      'is_active'      => new sfValidatorBoolean(array('required' => false)),
      'image_path'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'author'         => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'promotion_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Promotion'), 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'slug'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'VtNews', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('vt_news[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VtNews';
  }

}
