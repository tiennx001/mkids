<?php

/**
 * TblMember filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblMemberFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'birthday'                      => new sfWidgetFormFilterInput(),
      'height'                        => new sfWidgetFormFilterInput(),
      'weight'                        => new sfWidgetFormFilterInput(),
      'description'                   => new sfWidgetFormFilterInput(),
      'image_path'                    => new sfWidgetFormFilterInput(),
      'class_id'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TblClass'), 'add_empty' => true)),
      'status'                        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_delete'                     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'tbl_user_list'                 => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblUser')),
      'tbl_menu_list'                 => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblMenu')),
      'tbl_notification_program_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblNotificationProgram')),
      'tbl_article_list'              => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblArticle')),
    ));

    $this->setValidators(array(
      'name'                          => new sfValidatorPass(array('required' => false)),
      'birthday'                      => new sfValidatorPass(array('required' => false)),
      'height'                        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'weight'                        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'description'                   => new sfValidatorPass(array('required' => false)),
      'image_path'                    => new sfValidatorPass(array('required' => false)),
      'class_id'                      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TblClass'), 'column' => 'id')),
      'status'                        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_delete'                     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'tbl_user_list'                 => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblUser', 'required' => false)),
      'tbl_menu_list'                 => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblMenu', 'required' => false)),
      'tbl_notification_program_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblNotificationProgram', 'required' => false)),
      'tbl_article_list'              => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblArticle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tbl_member_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids_team\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids_team\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
TblUserListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.TblMemberUserRef TblMemberUserRef')
      ->andWhereIn('TblMemberUserRef.user_id', $values)
    ;
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids_team\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids_team\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
TblMenuListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.TblMenuRef TblMenuRef')
      ->andWhereIn('TblMenuRef.menu_id', $values)
    ;
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids_team\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids_team\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
TblNotificationProgramListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.TblNotificationProgramRef TblNotificationProgramRef')
      ->andWhereIn('TblNotificationProgramRef.program_id', $values)
    ;
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids_team\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids_team\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
TblArticleListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.TblArticleRef TblArticleRef')
      ->andWhereIn('TblArticleRef.article_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'TblMember';
  }

  public function getFields()
  {
    return array(
      'id'                            => 'Number',
      'name'                          => 'Text',
      'birthday'                      => 'Text',
      'height'                        => 'Number',
      'weight'                        => 'Number',
      'description'                   => 'Text',
      'image_path'                    => 'Text',
      'class_id'                      => 'ForeignKey',
      'status'                        => 'Boolean',
      'is_delete'                     => 'Boolean',
      'created_at'                    => 'Date',
      'updated_at'                    => 'Date',
      'tbl_user_list'                 => 'ManyKey',
      'tbl_menu_list'                 => 'ManyKey',
      'tbl_notification_program_list' => 'ManyKey',
      'tbl_article_list'              => 'ManyKey',
    );
  }
}
