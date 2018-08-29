<?php

/**
 * TblSetting filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'   => new sfWidgetFormFilterInput(),
      'type'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'text' => 'text', 'boolean' => 'boolean', 'select' => 'select', 'textarea' => 'textarea', 'number' => 'number', 'datetime' => 'datetime'))),
      'cfg_type'      => new sfWidgetFormChoice(array('choices' => array('' => '', 'ALL' => 'ALL', 'CMS' => 'CMS', 'WEB' => 'WEB', 'WAP' => 'WAP', 'SMS' => 'SMS'))),
      'value'         => new sfWidgetFormFilterInput(),
      'params'        => new sfWidgetFormFilterInput(),
      'group_name'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'default_value' => new sfWidgetFormFilterInput(),
      'credentials'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'description'   => new sfValidatorPass(array('required' => false)),
      'type'          => new sfValidatorChoice(array('required' => false, 'choices' => array('text' => 'text', 'boolean' => 'boolean', 'select' => 'select', 'textarea' => 'textarea', 'number' => 'number', 'datetime' => 'datetime'))),
      'cfg_type'      => new sfValidatorChoice(array('required' => false, 'choices' => array('ALL' => 'ALL', 'CMS' => 'CMS', 'WEB' => 'WEB', 'WAP' => 'WAP', 'SMS' => 'SMS'))),
      'value'         => new sfValidatorPass(array('required' => false)),
      'params'        => new sfValidatorPass(array('required' => false)),
      'group_name'    => new sfValidatorPass(array('required' => false)),
      'default_value' => new sfValidatorPass(array('required' => false)),
      'credentials'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tbl_setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblSetting';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'name'          => 'Text',
      'description'   => 'Text',
      'type'          => 'Enum',
      'cfg_type'      => 'Enum',
      'value'         => 'Text',
      'params'        => 'Text',
      'group_name'    => 'Text',
      'default_value' => 'Text',
      'credentials'   => 'Text',
    );
  }
}
