<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblAbsenceTicket', 'doctrine');

/**
 * BaseTblAbsenceTicket
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $member_id
 * @property date $date
 * @property string $reason
 * @property integer $user_id
 * @property tinyint $status
 * @property boolean $is_delete
 * @property integer $approver_id
 * @property TblMember $TblMember
 * @property TblUser $TblUser
 * 
 * @method integer          getMemberId()    Returns the current record's "member_id" value
 * @method date             getDate()        Returns the current record's "date" value
 * @method string           getReason()      Returns the current record's "reason" value
 * @method integer          getUserId()      Returns the current record's "user_id" value
 * @method tinyint          getStatus()      Returns the current record's "status" value
 * @method boolean          getIsDelete()    Returns the current record's "is_delete" value
 * @method integer          getApproverId()  Returns the current record's "approver_id" value
 * @method TblMember        getTblMember()   Returns the current record's "TblMember" value
 * @method TblUser          getTblUser()     Returns the current record's "TblUser" value
 * @method TblAbsenceTicket setMemberId()    Sets the current record's "member_id" value
 * @method TblAbsenceTicket setDate()        Sets the current record's "date" value
 * @method TblAbsenceTicket setReason()      Sets the current record's "reason" value
 * @method TblAbsenceTicket setUserId()      Sets the current record's "user_id" value
 * @method TblAbsenceTicket setStatus()      Sets the current record's "status" value
 * @method TblAbsenceTicket setIsDelete()    Sets the current record's "is_delete" value
 * @method TblAbsenceTicket setApproverId()  Sets the current record's "approver_id" value
 * @method TblAbsenceTicket setTblMember()   Sets the current record's "TblMember" value
 * @method TblAbsenceTicket setTblUser()     Sets the current record's "TblUser" value
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblAbsenceTicket extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_absence_ticket');
        $this->hasColumn('member_id', 'integer', 8, array(
             'type' => 'integer',
             'comment' => 'ID học sinh',
             'length' => 8,
             ));
        $this->hasColumn('date', 'date', null, array(
             'type' => 'date',
             'comment' => 'Ngày nghỉ',
             ));
        $this->hasColumn('reason', 'string', 255, array(
             'type' => 'string',
             'comment' => 'Lý do nghỉ',
             'length' => 255,
             ));
        $this->hasColumn('user_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'ID người tạo',
             'length' => 8,
             ));
        $this->hasColumn('status', 'tinyint', 2, array(
             'type' => 'tinyint',
             'notnull' => true,
             'default' => 0,
             'comment' => 'Trạng thái (0: chưa phê duyệt; 1: đã phê duyệt; 2: hủy)',
             'length' => 2,
             ));
        $this->hasColumn('is_delete', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             'comment' => 'Trạng thái xóa (0: chưa xóa - 1: đã xóa)',
             ));
        $this->hasColumn('approver_id', 'integer', 8, array(
             'type' => 'integer',
             'comment' => 'ID người phê duyệt hoặc từ chối',
             'length' => 8,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('TblMember', array(
             'local' => 'member_id',
             'foreign' => 'id'));

        $this->hasOne('TblUser', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}