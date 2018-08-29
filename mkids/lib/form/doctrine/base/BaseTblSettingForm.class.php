<?php

/**
 * TblSetting form base class.
 *
 * @method TblSetting getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblSettingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'description'   => new sfWidgetFormInputText(),
      'type'          => new sfWidgetFormChoice(array('choices' => array('text' => 'text', 'boolean' => 'boolean', 'select' => 'select', 'textarea' => 'textarea', 'number' => 'number', 'datetime' => 'datetime'))),
      'cfg_type'      => new sfWidgetFormChoice(array('choices' => array('ALL' => 'ALL', 'CMS' => 'CMS', 'WEB' => 'WEB', 'WAP' => 'WAP', 'SMS' => 'SMS'))),
      'value'         => new sfWidgetFormTextarea(),
      'params'        => new sfWidgetFormTextarea(),
      'group_name'    => new sfWidgetFormInputText(),
      'default_value' => new sfWidgetFormTextarea(),
      'credentials'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 127)),
      'description'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'type'          => new sfValidatorChoice(array('choices' => array(0 => 'text', 1 => 'boolean', 2 => 'select', 3 => 'textarea', 4 => 'number', 5 => 'datetime'), 'required' => false)),
      'cfg_type'      => new sfValidatorChoice(array('choices' => array(0 => 'ALL', 1 => 'CMS', 2 => 'WEB', 3 => 'WAP', 4 => 'SMS'), 'required' => false)),
      'value'         => new sfValidatorString(array('max_length' => 1023, 'required' => false)),
      'params'        => new sfValidatorString(array('max_length' => 1023, 'required' => false)),
      'group_name'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'default_value' => new sfValidatorString(array('max_length' => 1023, 'required' => false)),
      'credentials'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'TblSetting', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('tbl_setting[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblSetting';
  }

}
