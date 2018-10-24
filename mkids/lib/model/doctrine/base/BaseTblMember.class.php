<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblMember', 'doctrine');

/**
 * BaseTblMember
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $birthday
 * @property integer $height
 * @property integer $weight
 * @property string $description
 * @property string $image_path
 * @property integer $class_id
 * @property boolean $status
 * @property boolean $is_delete
 * @property TblClass $TblClass
 * @property Doctrine_Collection $TblUser
 * @property Doctrine_Collection $TblMemberUserRef
 * @property Doctrine_Collection $TblMenu
 * @property Doctrine_Collection $TblNotificationProgram
 * @property Doctrine_Collection $TblArticle
 * @property Doctrine_Collection $TblMemberActivity
 * @property Doctrine_Collection $TblSummary
 * 
 * @method string              getName()                   Returns the current record's "name" value
 * @method string              getBirthday()               Returns the current record's "birthday" value
 * @method integer             getHeight()                 Returns the current record's "height" value
 * @method integer             getWeight()                 Returns the current record's "weight" value
 * @method string              getDescription()            Returns the current record's "description" value
 * @method string              getImagePath()              Returns the current record's "image_path" value
 * @method integer             getClassId()                Returns the current record's "class_id" value
 * @method boolean             getStatus()                 Returns the current record's "status" value
 * @method boolean             getIsDelete()               Returns the current record's "is_delete" value
 * @method TblClass            getTblClass()               Returns the current record's "TblClass" value
 * @method Doctrine_Collection getTblUser()                Returns the current record's "TblUser" collection
 * @method Doctrine_Collection getTblMemberUserRef()       Returns the current record's "TblMemberUserRef" collection
 * @method Doctrine_Collection getTblMenu()                Returns the current record's "TblMenu" collection
 * @method Doctrine_Collection getTblNotificationProgram() Returns the current record's "TblNotificationProgram" collection
 * @method Doctrine_Collection getTblArticle()             Returns the current record's "TblArticle" collection
 * @method Doctrine_Collection getTblMemberActivity()      Returns the current record's "TblMemberActivity" collection
 * @method Doctrine_Collection getTblSummary()             Returns the current record's "TblSummary" collection
 * @method TblMember           setName()                   Sets the current record's "name" value
 * @method TblMember           setBirthday()               Sets the current record's "birthday" value
 * @method TblMember           setHeight()                 Sets the current record's "height" value
 * @method TblMember           setWeight()                 Sets the current record's "weight" value
 * @method TblMember           setDescription()            Sets the current record's "description" value
 * @method TblMember           setImagePath()              Sets the current record's "image_path" value
 * @method TblMember           setClassId()                Sets the current record's "class_id" value
 * @method TblMember           setStatus()                 Sets the current record's "status" value
 * @method TblMember           setIsDelete()               Sets the current record's "is_delete" value
 * @method TblMember           setTblClass()               Sets the current record's "TblClass" value
 * @method TblMember           setTblUser()                Sets the current record's "TblUser" collection
 * @method TblMember           setTblMemberUserRef()       Sets the current record's "TblMemberUserRef" collection
 * @method TblMember           setTblMenu()                Sets the current record's "TblMenu" collection
 * @method TblMember           setTblNotificationProgram() Sets the current record's "TblNotificationProgram" collection
 * @method TblMember           setTblArticle()             Sets the current record's "TblArticle" collection
 * @method TblMember           setTblMemberActivity()      Sets the current record's "TblMemberActivity" collection
 * @method TblMember           setTblSummary()             Sets the current record's "TblSummary" collection
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblMember extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_member');
        $this->hasColumn('name', 'string', 127, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Tên học sinh',
             'length' => 127,
             ));
        $this->hasColumn('birthday', 'string', 23, array(
             'type' => 'string',
             'comment' => 'Ngày sinh',
             'length' => 23,
             ));
        $this->hasColumn('height', 'integer', 5, array(
             'type' => 'integer',
             'comment' => 'Chiều cao (cm)',
             'length' => 5,
             ));
        $this->hasColumn('weight', 'integer', 5, array(
             'type' => 'integer',
             'comment' => 'Cân nặng (kg)',
             'length' => 5,
             ));
        $this->hasColumn('description', 'string', 1023, array(
             'type' => 'string',
             'comment' => 'Giới thiệu chung',
             'length' => 1023,
             ));
        $this->hasColumn('image_path', 'string', 255, array(
             'type' => 'string',
             'comment' => 'Ảnh đại diện của học sinh',
             'length' => 255,
             ));
        $this->hasColumn('class_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'ID lớp',
             'length' => 8,
             ));
        $this->hasColumn('status', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             'comment' => 'Trạng thái kích hoạt (0: không kích hoạt; 1: kích hoạt)',
             ));
        $this->hasColumn('is_delete', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             'comment' => 'Trạng thái xóa (0: chưa xóa - 1: đã xóa)',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('TblClass', array(
             'local' => 'class_id',
             'foreign' => 'id'));

        $this->hasMany('TblUser', array(
             'refClass' => 'TblMemberUserRef',
             'local' => 'member_id',
             'foreign' => 'user_id'));

        $this->hasMany('TblMemberUserRef', array(
             'local' => 'id',
             'foreign' => 'member_id'));

        $this->hasMany('TblMenu', array(
             'refClass' => 'TblMenuRef',
             'local' => 'member_id',
             'foreign' => 'menu_id'));

        $this->hasMany('TblNotificationProgram', array(
             'refClass' => 'TblNotificationProgramRef',
             'local' => 'member_id',
             'foreign' => 'program_id'));

        $this->hasMany('TblArticle', array(
             'refClass' => 'TblArticleRef',
             'local' => 'member_id',
             'foreign' => 'article_id'));

        $this->hasMany('TblMemberActivity', array(
             'local' => 'id',
             'foreign' => 'member_id'));

        $this->hasMany('TblSummary', array(
             'local' => 'id',
             'foreign' => 'member_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}