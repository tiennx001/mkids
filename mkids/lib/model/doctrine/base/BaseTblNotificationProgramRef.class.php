<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblNotificationProgramRef', 'doctrine');

/**
 * BaseTblNotificationProgramRef
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $member_id
 * @property integer $class_id
 * @property integer $group_id
 * @property integer $school_id
 * @property integer $program_id
 * 
 * @method integer                   getMemberId()   Returns the current record's "member_id" value
 * @method integer                   getClassId()    Returns the current record's "class_id" value
 * @method integer                   getGroupId()    Returns the current record's "group_id" value
 * @method integer                   getSchoolId()   Returns the current record's "school_id" value
 * @method integer                   getProgramId()  Returns the current record's "program_id" value
 * @method TblNotificationProgramRef setMemberId()   Sets the current record's "member_id" value
 * @method TblNotificationProgramRef setClassId()    Sets the current record's "class_id" value
 * @method TblNotificationProgramRef setGroupId()    Sets the current record's "group_id" value
 * @method TblNotificationProgramRef setSchoolId()   Sets the current record's "school_id" value
 * @method TblNotificationProgramRef setProgramId()  Sets the current record's "program_id" value
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblNotificationProgramRef extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_notification_program_ref');
        $this->hasColumn('member_id', 'integer', 8, array(
             'type' => 'integer',
             'comment' => 'ID học sinh',
             'length' => 8,
             ));
        $this->hasColumn('class_id', 'integer', 8, array(
             'type' => 'integer',
             'comment' => 'ID lớp học',
             'length' => 8,
             ));
        $this->hasColumn('group_id', 'integer', 8, array(
             'type' => 'integer',
             'comment' => 'ID khối',
             'length' => 8,
             ));
        $this->hasColumn('school_id', 'integer', 8, array(
             'type' => 'integer',
             'comment' => 'ID trường',
             'length' => 8,
             ));
        $this->hasColumn('program_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'ID chương trình',
             'length' => 8,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable(array(
             'created' => 
             array(
              'disabled' => true,
             ),
             'updated' => 
             array(
              'disabled' => true,
             ),
             ));
        $this->actAs($timestampable0);
    }
}