<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblClass', 'doctrine');

/**
 * BaseTblClass
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $description
 * @property integer $group_id
 * @property boolean $status
 * @property boolean $is_delete
 * @property TblGroup $TblGroup
 * @property Doctrine_Collection $TblUser
 * @property Doctrine_Collection $TblUserClassRef
 * @property Doctrine_Collection $TblMember
 * @property Doctrine_Collection $TblMenu
 * @property Doctrine_Collection $TblNotificationProgram
 * @property Doctrine_Collection $TblArticle
 * 
 * @method string              getName()                   Returns the current record's "name" value
 * @method string              getDescription()            Returns the current record's "description" value
 * @method integer             getGroupId()                Returns the current record's "group_id" value
 * @method boolean             getStatus()                 Returns the current record's "status" value
 * @method boolean             getIsDelete()               Returns the current record's "is_delete" value
 * @method TblGroup            getTblGroup()               Returns the current record's "TblGroup" value
 * @method Doctrine_Collection getTblUser()                Returns the current record's "TblUser" collection
 * @method Doctrine_Collection getTblUserClassRef()        Returns the current record's "TblUserClassRef" collection
 * @method Doctrine_Collection getTblMember()              Returns the current record's "TblMember" collection
 * @method Doctrine_Collection getTblMenu()                Returns the current record's "TblMenu" collection
 * @method Doctrine_Collection getTblNotificationProgram() Returns the current record's "TblNotificationProgram" collection
 * @method Doctrine_Collection getTblArticle()             Returns the current record's "TblArticle" collection
 * @method TblClass            setName()                   Sets the current record's "name" value
 * @method TblClass            setDescription()            Sets the current record's "description" value
 * @method TblClass            setGroupId()                Sets the current record's "group_id" value
 * @method TblClass            setStatus()                 Sets the current record's "status" value
 * @method TblClass            setIsDelete()               Sets the current record's "is_delete" value
 * @method TblClass            setTblGroup()               Sets the current record's "TblGroup" value
 * @method TblClass            setTblUser()                Sets the current record's "TblUser" collection
 * @method TblClass            setTblUserClassRef()        Sets the current record's "TblUserClassRef" collection
 * @method TblClass            setTblMember()              Sets the current record's "TblMember" collection
 * @method TblClass            setTblMenu()                Sets the current record's "TblMenu" collection
 * @method TblClass            setTblNotificationProgram() Sets the current record's "TblNotificationProgram" collection
 * @method TblClass            setTblArticle()             Sets the current record's "TblArticle" collection
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblClass extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_class');
        $this->hasColumn('name', 'string', 127, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Tên lớp',
             'length' => 127,
             ));
        $this->hasColumn('description', 'string', 1023, array(
             'type' => 'string',
             'comment' => 'Mô tả chung',
             'length' => 1023,
             ));
        $this->hasColumn('group_id', 'integer', 5, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'ID khối',
             'length' => 5,
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
        $this->hasOne('TblGroup', array(
             'local' => 'group_id',
             'foreign' => 'id'));

        $this->hasMany('TblUser', array(
             'refClass' => 'TblUserClassRef',
             'local' => 'class_id',
             'foreign' => 'user_id'));

        $this->hasMany('TblUserClassRef', array(
             'local' => 'id',
             'foreign' => 'class_id'));

        $this->hasMany('TblMember', array(
             'local' => 'id',
             'foreign' => 'class_id'));

        $this->hasMany('TblMenu', array(
             'refClass' => 'TblMenuRef',
             'local' => 'class_id',
             'foreign' => 'menu_id'));

        $this->hasMany('TblNotificationProgram', array(
             'refClass' => 'TblNotificationProgramRef',
             'local' => 'class_id',
             'foreign' => 'program_id'));

        $this->hasMany('TblArticle', array(
             'refClass' => 'TblArticleRef',
             'local' => 'class_id',
             'foreign' => 'article_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}