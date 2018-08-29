<?php

/**
 * TblArticleRef form base class.
 *
 * @method TblArticleRef getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblArticleRefForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'member_id'  => new sfWidgetFormInputText(),
      'class_id'   => new sfWidgetFormInputText(),
      'group_id'   => new sfWidgetFormInputText(),
      'article_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblArticle'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'member_id'  => new sfValidatorInteger(array('required' => false)),
      'class_id'   => new sfValidatorInteger(array('required' => false)),
      'group_id'   => new sfValidatorInteger(array('required' => false)),
      'article_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblArticle'))),
    ));

    $this->widgetSchema->setNameFormat('tbl_article_ref[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblArticleRef';
  }

}
