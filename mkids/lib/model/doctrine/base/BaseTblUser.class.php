<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblUser', 'doctrine');

/**
 * BaseTblUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property tinyint $gender
 * @property string $email
 * @property string $facebook
 * @property string $address
 * @property clob $description
 * @property string $image_path
 * @property string $msisdn
 * @property string $password
 * @property string $salt
 * @property boolean $status
 * @property string $token_id
 * @property timestamp $last_update
 * @property boolean $is_lock
 * @property integer $lock_time
 * @property tinyint $type
 * @property boolean $is_delete
 * @property Doctrine_Collection $TblTokenSession
 * @property Doctrine_Collection $TblSchool
 * @property Doctrine_Collection $TblClass
 * @property Doctrine_Collection $TblUserClassRef
 * @property Doctrine_Collection $TblMember
 * @property Doctrine_Collection $TblMemberUserRef
 * @property Doctrine_Collection $TblNotificationProgram
 * @property Doctrine_Collection $TblArticle
 * @property Doctrine_Collection $TblComment
 * @property Doctrine_Collection $TblNotification
 * @property Doctrine_Collection $TblNotificationHis
 * @property Doctrine_Collection $TblAbsenceTicket
 * @property Doctrine_Collection $TblReminder
 * 
 * @method string              getName()                   Returns the current record's "name" value
 * @method tinyint             getGender()                 Returns the current record's "gender" value
 * @method string              getEmail()                  Returns the current record's "email" value
 * @method string              getFacebook()               Returns the current record's "facebook" value
 * @method string              getAddress()                Returns the current record's "address" value
 * @method clob                getDescription()            Returns the current record's "description" value
 * @method string              getImagePath()              Returns the current record's "image_path" value
 * @method string              getMsisdn()                 Returns the current record's "msisdn" value
 * @method string              getPassword()               Returns the current record's "password" value
 * @method string              getSalt()                   Returns the current record's "salt" value
 * @method boolean             getStatus()                 Returns the current record's "status" value
 * @method string              getTokenId()                Returns the current record's "token_id" value
 * @method timestamp           getLastUpdate()             Returns the current record's "last_update" value
 * @method boolean             getIsLock()                 Returns the current record's "is_lock" value
 * @method integer             getLockTime()               Returns the current record's "lock_time" value
 * @method tinyint             getType()                   Returns the current record's "type" value
 * @method boolean             getIsDelete()               Returns the current record's "is_delete" value
 * @method Doctrine_Collection getTblTokenSession()        Returns the current record's "TblTokenSession" collection
 * @method Doctrine_Collection getTblSchool()              Returns the current record's "TblSchool" collection
 * @method Doctrine_Collection getTblClass()               Returns the current record's "TblClass" collection
 * @method Doctrine_Collection getTblUserClassRef()        Returns the current record's "TblUserClassRef" collection
 * @method Doctrine_Collection getTblMember()              Returns the current record's "TblMember" collection
 * @method Doctrine_Collection getTblMemberUserRef()       Returns the current record's "TblMemberUserRef" collection
 * @method Doctrine_Collection getTblNotificationProgram() Returns the current record's "TblNotificationProgram" collection
 * @method Doctrine_Collection getTblArticle()             Returns the current record's "TblArticle" collection
 * @method Doctrine_Collection getTblComment()             Returns the current record's "TblComment" collection
 * @method Doctrine_Collection getTblNotification()        Returns the current record's "TblNotification" collection
 * @method Doctrine_Collection getTblNotificationHis()     Returns the current record's "TblNotificationHis" collection
 * @method Doctrine_Collection getTblAbsenceTicket()       Returns the current record's "TblAbsenceTicket" collection
 * @method Doctrine_Collection getTblReminder()            Returns the current record's "TblReminder" collection
 * @method TblUser             setName()                   Sets the current record's "name" value
 * @method TblUser             setGender()                 Sets the current record's "gender" value
 * @method TblUser             setEmail()                  Sets the current record's "email" value
 * @method TblUser             setFacebook()               Sets the current record's "facebook" value
 * @method TblUser             setAddress()                Sets the current record's "address" value
 * @method TblUser             setDescription()            Sets the current record's "description" value
 * @method TblUser             setImagePath()              Sets the current record's "image_path" value
 * @method TblUser             setMsisdn()                 Sets the current record's "msisdn" value
 * @method TblUser             setPassword()               Sets the current record's "password" value
 * @method TblUser             setSalt()                   Sets the current record's "salt" value
 * @method TblUser             setStatus()                 Sets the current record's "status" value
 * @method TblUser             setTokenId()                Sets the current record's "token_id" value
 * @method TblUser             setLastUpdate()             Sets the current record's "last_update" value
 * @method TblUser             setIsLock()                 Sets the current record's "is_lock" value
 * @method TblUser             setLockTime()               Sets the current record's "lock_time" value
 * @method TblUser             setType()                   Sets the current record's "type" value
 * @method TblUser             setIsDelete()               Sets the current record's "is_delete" value
 * @method TblUser             setTblTokenSession()        Sets the current record's "TblTokenSession" collection
 * @method TblUser             setTblSchool()              Sets the current record's "TblSchool" collection
 * @method TblUser             setTblClass()               Sets the current record's "TblClass" collection
 * @method TblUser             setTblUserClassRef()        Sets the current record's "TblUserClassRef" collection
 * @method TblUser             setTblMember()              Sets the current record's "TblMember" collection
 * @method TblUser             setTblMemberUserRef()       Sets the current record's "TblMemberUserRef" collection
 * @method TblUser             setTblNotificationProgram() Sets the current record's "TblNotificationProgram" collection
 * @method TblUser             setTblArticle()             Sets the current record's "TblArticle" collection
 * @method TblUser             setTblComment()             Sets the current record's "TblComment" collection
 * @method TblUser             setTblNotification()        Sets the current record's "TblNotification" collection
 * @method TblUser             setTblNotificationHis()     Sets the current record's "TblNotificationHis" collection
 * @method TblUser             setTblAbsenceTicket()       Sets the current record's "TblAbsenceTicket" collection
 * @method TblUser             setTblReminder()            Sets the current record's "TblReminder" collection
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_user');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Họ tên người dùng',
             'length' => 255,
             ));
        $this->hasColumn('gender', 'tinyint', 1, array(
             'type' => 'tinyint',
             'default' => 0,
             'comment' => 'Giới tính (0: Nữ; 1: Nam)',
             'length' => 1,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'comment' => 'Email người dùng',
             'length' => 255,
             ));
        $this->hasColumn('facebook', 'string', 255, array(
             'type' => 'string',
             'comment' => 'Địa chỉ facebook',
             'length' => 255,
             ));
        $this->hasColumn('address', 'string', 255, array(
             'type' => 'string',
             'comment' => 'Địa điểm',
             'length' => 255,
             ));
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             'comment' => 'Mô tả',
             ));
        $this->hasColumn('image_path', 'string', 255, array(
             'type' => 'string',
             'comment' => 'Ảnh đại diện cho người dùng',
             'length' => 255,
             ));
        $this->hasColumn('msisdn', 'string', 18, array(
             'type' => 'string',
             'comment' => 'Số điện thoại của người dùng',
             'length' => 18,
             ));
        $this->hasColumn('password', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Mật khẩu (đã được mã hóa)',
             'length' => 255,
             ));
        $this->hasColumn('salt', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Chuỗi mã hóa mật khẩu',
             'length' => 255,
             ));
        $this->hasColumn('status', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             'comment' => 'Trạng thái kích hoạt (0: bị khóa; 1: kích hoạt)',
             ));
        $this->hasColumn('token_id', 'string', 255, array(
             'type' => 'string',
             'comment' => 'registration_ids để gửi notification',
             'length' => 255,
             ));
        $this->hasColumn('last_update', 'timestamp', null, array(
             'type' => 'timestamp',
             'comment' => 'Thoi gian gan nhat nguoi dung xem notification',
             ));
        $this->hasColumn('is_lock', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             'comment' => 'Đã khóa account hay chưa',
             ));
        $this->hasColumn('lock_time', 'integer', 20, array(
             'type' => 'integer',
             'comment' => 'Thời gian khóa',
             'length' => 20,
             ));
        $this->hasColumn('type', 'tinyint', 2, array(
             'type' => 'tinyint',
             'comment' => 'Loại user (0: Hiệu trưởng - 1: Giáo viên - 2: Phụ huynh',
             'length' => 2,
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
        $this->hasMany('TblTokenSession', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('TblSchool', array(
             'refClass' => 'TblUserSchoolRef',
             'local' => 'user_id',
             'foreign' => 'school_id'));

        $this->hasMany('TblClass', array(
             'refClass' => 'TblUserClassRef',
             'local' => 'user_id',
             'foreign' => 'class_id'));

        $this->hasMany('TblUserClassRef', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('TblMember', array(
             'refClass' => 'TblMemberUserRef',
             'local' => 'user_id',
             'foreign' => 'member_id'));

        $this->hasMany('TblMemberUserRef', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('TblNotificationProgram', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('TblArticle', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('TblComment', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('TblNotification', array(
             'local' => 'id',
             'foreign' => 'sender_id'));

        $this->hasMany('TblNotificationHis', array(
             'local' => 'id',
             'foreign' => 'sender_id'));

        $this->hasMany('TblAbsenceTicket', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('TblReminder', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}