<?php

/**
 * TblArticle form base class.
 *
 * @method TblArticle getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblArticleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'title'           => new sfWidgetFormInputText(),
      'content'         => new sfWidgetFormTextarea(),
      'image_path'      => new sfWidgetFormInputText(),
      'type'            => new sfWidgetFormInputText(),
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'), 'add_empty' => false)),
      'status'          => new sfWidgetFormInputCheckbox(),
      'is_delete'       => new sfWidgetFormInputCheckbox(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'tbl_group_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblGroup')),
      'tbl_class_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblClass')),
      'tbl_member_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblMember')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'           => new sfValidatorString(array('max_length' => 255)),
      'content'         => new sfValidatorString(array('max_length' => 65535)),
      'image_path'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'type'            => new sfValidatorPass(array('required' => false)),
      'user_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblUser'))),
      'status'          => new sfValidatorBoolean(array('required' => false)),
      'is_delete'       => new sfValidatorBoolean(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'tbl_group_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblGroup', 'required' => false)),
      'tbl_class_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblClass', 'required' => false)),
      'tbl_member_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblMember', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tbl_article[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblArticle';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['tbl_group_list']))
    {
      $this->setDefault('tbl_group_list', $this->object->TblGroup->getPrimaryKeys());
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
    $this->saveTblGroupList($con);
    $this->saveTblClassList($con);
    $this->saveTblMemberList($con);

    parent::doSave($con);
  }

  public function saveTblGroupList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tbl_group_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->TblGroup->getPrimaryKeys();
    $values = $this->getValue('tbl_group_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('TblGroup', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('TblGroup', array_values($link));
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
