<?php

/**
 * TblSchool form base class.
 *
 * @method TblSchool getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblSchoolForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'phone'         => new sfWidgetFormInputText(),
      'email'         => new sfWidgetFormInputText(),
      'website'       => new sfWidgetFormInputText(),
      'address'       => new sfWidgetFormInputText(),
      'description'   => new sfWidgetFormTextarea(),
      'status'        => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'tbl_user_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblUser')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 127)),
      'phone'         => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'email'         => new sfValidatorString(array('max_length' => 63, 'required' => false)),
      'website'       => new sfValidatorString(array('max_length' => 127, 'required' => false)),
      'address'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'   => new sfValidatorString(array('max_length' => 1023, 'required' => false)),
      'status'        => new sfValidatorBoolean(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'tbl_user_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tbl_school[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblSchool';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['tbl_user_list']))
    {
      $this->setDefault('tbl_user_list', $this->object->TblUser->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveTblUserList($con);

    parent::doSave($con);
  }

  public function saveTblUserList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tbl_user_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->TblUser->getPrimaryKeys();
    $values = $this->getValue('tbl_user_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('TblUser', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('TblUser', array_values($link));
    }
  }

}
