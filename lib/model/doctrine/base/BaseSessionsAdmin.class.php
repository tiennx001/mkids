<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('SessionsAdmin', 'doctrine');

/**
 * BaseSessionsAdmin
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $sess_id
 * @property clob $sess_data
 * @property integer $sess_time
 * @property integer $sess_userid
 * 
 * @method string        getSessId()      Returns the current record's "sess_id" value
 * @method clob          getSessData()    Returns the current record's "sess_data" value
 * @method integer       getSessTime()    Returns the current record's "sess_time" value
 * @method integer       getSessUserid()  Returns the current record's "sess_userid" value
 * @method SessionsAdmin setSessId()      Sets the current record's "sess_id" value
 * @method SessionsAdmin setSessData()    Sets the current record's "sess_data" value
 * @method SessionsAdmin setSessTime()    Sets the current record's "sess_time" value
 * @method SessionsAdmin setSessUserid()  Sets the current record's "sess_userid" value
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSessionsAdmin extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sessions_admin');
        $this->hasColumn('sess_id', 'string', 64, array(
             'type' => 'string',
             'primary' => true,
             'comment' => 'ID session',
             'length' => 64,
             ));
        $this->hasColumn('sess_data', 'clob', null, array(
             'type' => 'clob',
             'notnull' => true,
             'comment' => 'Session data',
             ));
        $this->hasColumn('sess_time', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'Thoi diem luu session',
             'length' => 11,
             ));
        $this->hasColumn('sess_userid', 'integer', 20, array(
             'type' => 'integer',
             'comment' => 'ID cua nguoi dung tuong ung voi session',
             'length' => 20,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}