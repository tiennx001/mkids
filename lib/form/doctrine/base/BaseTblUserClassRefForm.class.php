<?php

/**
 * TblUserClassRef form base class.
 *
 * @method TblUserClassRef getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblUserClassRefForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'), 'add_empty' => false)),
      'class_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblClass'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'))),
      'class_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblClass'))),
    ));

    $this->widgetSchema->setNameFormat('tbl_user_class_ref[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblUserClassRef';
  }

}
