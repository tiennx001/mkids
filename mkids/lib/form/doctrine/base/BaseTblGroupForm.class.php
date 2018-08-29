<?php

/**
 * TblGroup form base class.
 *
 * @method TblGroup getObject() Returns the current form's model object
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTblGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                            => new sfWidgetFormInputHidden(),
      'name'                          => new sfWidgetFormInputText(),
      'description'                   => new sfWidgetFormTextarea(),
      'school_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblSchool'), 'add_empty' => false)),
      'status'                        => new sfWidgetFormInputCheckbox(),
      'created_at'                    => new sfWidgetFormDateTime(),
      'updated_at'                    => new sfWidgetFormDateTime(),
      'tbl_menu_list'                 => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblMenu')),
      'tbl_notification_program_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblNotificationProgram')),
      'tbl_article_list'              => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblArticle')),
    ));

    $this->setValidators(array(
      'id'                            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                          => new sfValidatorString(array('max_length' => 127)),
      'description'                   => new sfValidatorString(array('max_length' => 1023, 'required' => false)),
      'school_id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TblSchool'))),
      'status'                        => new sfValidatorBoolean(array('required' => false)),
      'created_at'                    => new sfValidatorDateTime(),
      'updated_at'                    => new sfValidatorDateTime(),
      'tbl_menu_list'                 => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblMenu', 'required' => false)),
      'tbl_notification_program_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblNotificationProgram', 'required' => false)),
      'tbl_article_list'              => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblArticle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tbl_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TblGroup';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['tbl_menu_list']))
    {
      $this->setDefault('tbl_menu_list', $this->object->TblMenu->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['tbl_notification_program_list']))
    {
      $this->setDefault('tbl_notification_program_list', $this->object->TblNotificationProgram->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['tbl_article_list']))
    {
      $this->setDefault('tbl_article_list', $this->object->TblArticle->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveTblMenuList($con);
    $this->saveTblNotificationProgramList($con);
    $this->saveTblArticleList($con);

    parent::doSave($con);
  }

  public function saveTblMenuList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tbl_menu_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->TblMenu->getPrimaryKeys();
    $values = $this->getValue('tbl_menu_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('TblMenu', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('TblMenu', array_values($link));
    }
  }

  public function saveTblNotificationProgramList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tbl_notification_program_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->TblNotificationProgram->getPrimaryKeys();
    $values = $this->getValue('tbl_notification_program_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('TblNotificationProgram', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('TblNotificationProgram', array_values($link));
    }
  }

  public function saveTblArticleList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['tbl_article_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->TblArticle->getPrimaryKeys();
    $values = $this->getValue('tbl_article_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('TblArticle', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('TblArticle', array_values($link));
    }
  }

}
