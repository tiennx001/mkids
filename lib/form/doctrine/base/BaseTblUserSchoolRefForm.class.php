<?php

/**
 * TblUserSchoolRef form base class.
 *
 * @method TblUserSchoolRef getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblUserSchoolRefForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'user_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'), 'add_empty' => false)),
      'school_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblSchool'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'))),
      'school_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblSchool'))),
    ));

    $this->widgetSchema->setNameFormat('tbl_user_school_ref[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblUserSchoolRef';
  }

}
