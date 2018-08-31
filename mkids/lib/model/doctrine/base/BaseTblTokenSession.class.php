<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblTokenSession', 'doctrine');

/**
 * BaseTblTokenSession
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $account
 * @property string $msisdn
 * @property string $token
 * @property timestamp $expired_time
 * @property string $key_refresh
 * @property integer $os_type
 * @property tinyint $user_type
 * @property TblUser $TblUser
 * 
 * @method integer         getUserId()       Returns the current record's "user_id" value
 * @method string          getAccount()      Returns the current record's "account" value
 * @method string          getMsisdn()       Returns the current record's "msisdn" value
 * @method string          getToken()        Returns the current record's "token" value
 * @method timestamp       getExpiredTime()  Returns the current record's "expired_time" value
 * @method string          getKeyRefresh()   Returns the current record's "key_refresh" value
 * @method integer         getOsType()       Returns the current record's "os_type" value
 * @method tinyint         getUserType()     Returns the current record's "user_type" value
 * @method TblUser         getTblUser()      Returns the current record's "TblUser" value
 * @method TblTokenSession setUserId()       Sets the current record's "user_id" value
 * @method TblTokenSession setAccount()      Sets the current record's "account" value
 * @method TblTokenSession setMsisdn()       Sets the current record's "msisdn" value
 * @method TblTokenSession setToken()        Sets the current record's "token" value
 * @method TblTokenSession setExpiredTime()  Sets the current record's "expired_time" value
 * @method TblTokenSession setKeyRefresh()   Sets the current record's "key_refresh" value
 * @method TblTokenSession setOsType()       Sets the current record's "os_type" value
 * @method TblTokenSession setUserType()     Sets the current record's "user_type" value
 * @method TblTokenSession setTblUser()      Sets the current record's "TblUser" value
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblTokenSession extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_token_session');
        $this->hasColumn('user_id', 'integer', 8, array(
             'type' => 'integer',
             'unique' => true,
             'comment' => 'ID tai khoan dang ky su dung app',
             'length' => 8,
             ));
        $this->hasColumn('account', 'string', 255, array(
             'type' => 'string',
             'unique' => true,
             'notnull' => true,
             'comment' => 'Tai khoan cua nguoi dung',
             'length' => 255,
             ));
        $this->hasColumn('msisdn', 'string', 15, array(
             'type' => 'string',
             'unique' => true,
             'notnull' => true,
             'comment' => 'So dien thoai cua nguoi dung',
             'length' => 15,
             ));
        $this->hasColumn('token', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Token xac thuc',
             'length' => 255,
             ));
        $this->hasColumn('expired_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             'comment' => 'Thoi gian token co hien luc',
             ));
        $this->hasColumn('key_refresh', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Key refresh phuc vu lay lai token',
             'length' => 255,
             ));
        $this->hasColumn('os_type', 'integer', 3, array(
             'type' => 'integer',
             'default' => 0,
             'comment' => 'Loại HĐH (0: Android; 1: iOS)',
             'length' => 3,
             ));
        $this->hasColumn('user_type', 'tinyint', 2, array(
             'type' => 'tinyint',
             'comment' => 'Loại user (0: Hiệu trưởng - 1: Giáo viên - 2: Phụ huynh',
             'length' => 2,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('TblUser', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}