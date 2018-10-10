<?php

/**
 * TblUser filter form base class.
 *
 * @package    xcode
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTblUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'gender'          => new sfWidgetFormFilterInput(),
      'email'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'facebook'        => new sfWidgetFormFilterInput(),
      'address'         => new sfWidgetFormFilterInput(),
      'description'     => new sfWidgetFormFilterInput(),
      'image_path'      => new sfWidgetFormFilterInput(),
      'msisdn'          => new sfWidgetFormFilterInput(),
      'password'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'salt'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'token_id'        => new sfWidgetFormFilterInput(),
      'last_update'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'is_lock'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'lock_time'       => new sfWidgetFormFilterInput(),
      'type'            => new sfWidgetFormFilterInput(),
      'is_delete'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'tbl_school_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblSchool')),
      'tbl_class_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblClass')),
      'tbl_member_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'TblMember')),
    ));

    $this->setValidators(array(
      'name'            => new sfValidatorPass(array('required' => false)),
      'gender'          => new sfValidatorPass(array('required' => false)),
      'email'           => new sfValidatorPass(array('required' => false)),
      'facebook'        => new sfValidatorPass(array('required' => false)),
      'address'         => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'image_path'      => new sfValidatorPass(array('required' => false)),
      'msisdn'          => new sfValidatorPass(array('required' => false)),
      'password'        => new sfValidatorPass(array('required' => false)),
      'salt'            => new sfValidatorPass(array('required' => false)),
      'status'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'token_id'        => new sfValidatorPass(array('required' => false)),
      'last_update'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'is_lock'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'lock_time'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'type'            => new sfValidatorPass(array('required' => false)),
      'is_delete'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'tbl_school_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblSchool', 'required' => false)),
      'tbl_class_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblClass', 'required' => false)),
      'tbl_member_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TblMember', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tbl_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
TblSchoolListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.TblUserSchoolRef TblUserSchoolRef')
      ->andWhereIn('TblUserSchoolRef.school_id', $values)
    ;
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
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
      ->leftJoin($query->getRootAlias().'.TblUserClassRef TblUserClassRef')
      ->andWhereIn('TblUserClassRef.class_id', $values)
    ;
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in D:\Projects\mkids\mkids\lib\vendor\symfony\lib\util\sfToolkit.class.php on line 362
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
      ->leftJoin($query->getRootAlias().'.TblMemberUserRef TblMemberUserRef')
      ->andWhereIn('TblMemberUserRef.member_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'TblUser';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'name'            => 'Text',
      'gender'          => 'Text',
      'email'           => 'Text',
      'facebook'        => 'Text',
      'address'         => 'Text',
      'description'     => 'Text',
      'image_path'      => 'Text',
      'msisdn'          => 'Text',
      'password'        => 'Text',
      'salt'            => 'Text',
      'status'          => 'Boolean',
      'token_id'        => 'Text',
      'last_update'     => 'Date',
      'is_lock'         => 'Boolean',
      'lock_time'       => 'Number',
      'type'            => 'Text',
      'is_delete'       => 'Boolean',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'tbl_school_list' => 'ManyKey',
      'tbl_class_list'  => 'ManyKey',
      'tbl_member_list' => 'ManyKey',
    );
  }
}
