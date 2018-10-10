<?php

/**
 * TblUser form base class.
 *
 * @method TblUser getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'gender'          => new sfWidgetFormInputText(),
      'email'           => new sfWidgetFormInputText(),
      'facebook'        => new sfWidgetFormInputText(),
      'address'         => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextarea(),
      'image_path'      => new sfWidgetFormInputText(),
      'msisdn'          => new sfWidgetFormInputText(),
      'password'        => new sfWidgetFormInputText(),
      'salt'            => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormInputCheckbox(),
      'token_id'        => new sfWidgetFormInputText(),
      'last_update'     => new sfWidgetFormDateTime(),
      'is_lock'         => new sfWidgetFormInputCheckbox(),
      'lock_time'       => new sfWidgetFormInputText(),
      'type'            => new sfWidgetFormInputText(),
      'is_delete'       => new sfWidgetFormInputCheckbox(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'tbl_school_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblSchool')),
      'tbl_class_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblClass')),
      'tbl_member_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblMember')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'gender'          => new sfValidatorPass(array('required' => false)),
      'email'           => new sfValidatorString(array('max_length' => 255)),
      'facebook'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'     => new sfValidatorString(array('required' => false)),
      'image_path'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'msisdn'          => new sfValidatorString(array('max_length' => 18, 'required' => false)),
      'password'        => new sfValidatorString(array('max_length' => 255)),
      'salt'            => new sfValidatorString(array('max_length' => 255)),
      'status'          => new sfValidatorBoolean(array('required' => false)),
      'token_id'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'last_update'     => new sfValidatorDateTime(array('required' => false)),
      'is_lock'         => new sfValidatorBoolean(array('required' => false)),
      'lock_time'       => new sfValidatorInteger(array('required' => false)),
      'type'            => new sfValidatorPass(array('required' => false)),
      'is_delete'       => new sfValidatorBoolean(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'tbl_school_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblSchool', 'required' => false)),
      'tbl_class_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblClass', 'required' => false)),
      'tbl_member_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblMember', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'TblUser', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('tbl_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblUser';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['tbl_school_list']))
    {
      $this->setDefault('tbl_school_list', $this->object->TblSchool->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['tbl_class_list']))
    {
      $this->setDefault('tbl_class_list', $this->object->TblClass->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['tbl_member_list']))
    {
      $this->setDefault('tbl_member_list', $this->object->TblMember->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveTblSchoolList($con);
    $this->saveTblClassList($con);
    $this->saveTblMemberList($con);

    parent::doSave($con);
  }

  public function saveTblSchoolList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tbl_school_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->TblSchool->getPrimaryKeys();
    $values = $this->getValue('tbl_school_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('TblSchool', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('TblSchool', array_values($link));
    }
  }

  public function saveTblClassList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tbl_class_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->TblClass->getPrimaryKeys();
    $values = $this->getValue('tbl_class_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('TblClass', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('TblClass', array_values($link));
    }
  }

  public function saveTblMemberList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tbl_member_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->TblMember->getPrimaryKeys();
    $values = $this->getValue('tbl_member_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('TblMember', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('TblMember', array_values($link));
    }
  }

}
