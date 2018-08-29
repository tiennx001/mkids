<?php

/**
 * TblMenu filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblMenuFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image_path'      => new sfWidgetFormFilterInput(),
      'type'            => new sfWidgetFormFilterInput(),
      'status'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'tbl_group_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblGroup')),
      'tbl_class_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblClass')),
      'tbl_member_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblMember')),
    ));

    $this->setValidators(array(
      'title'           => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'image_path'      => new sfValidatorPass(array('required' => false)),
      'type'            => new sfValidatorPass(array('required' => false)),
      'status'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'tbl_group_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblGroup', 'required' => false)),
      'tbl_class_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblClass', 'required' => false)),
      'tbl_member_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblMember', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tbl_menu_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\PHP\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\PHP\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
TblGroupListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('TblMenuRef.group_id', $values)
    ;
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\PHP\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\PHP\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
TblClassListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('TblMenuRef.class_id', $values)
    ;
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\PHP\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\PHP\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
TblMemberListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('TblMenuRef.member_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'TblMenu';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'title'           => 'Text',
      'description'     => 'Text',
      'image_path'      => 'Text',
      'type'            => 'Text',
      'status'          => 'Boolean',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'tbl_group_list'  => 'ManyKey',
      'tbl_class_list'  => 'ManyKey',
      'tbl_member_list' => 'ManyKey',
    );
  }
}
