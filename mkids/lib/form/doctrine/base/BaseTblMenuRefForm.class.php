<?php

/**
 * TblMenuRef form base class.
 *
 * @method TblMenuRef getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblMenuRefForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'member_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'add_empty' => true)),
      'class_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblClass'), 'add_empty' => true)),
      'group_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblGroup'), 'add_empty' => true)),
      'menu_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblMenu'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'member_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblMember'), 'required' => false)),
      'class_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblClass'), 'required' => false)),
      'group_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblGroup'), 'required' => false)),
      'menu_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblMenu'))),
    ));

    $this->widgetSchema->setNameFormat('tbl_menu_ref[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblMenuRef';
  }

}
