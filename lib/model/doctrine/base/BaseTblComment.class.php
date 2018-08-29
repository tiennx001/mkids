<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblComment', 'doctrine');

/**
 * BaseTblComment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $content
 * @property integer $parent_id
 * @property boolean $status
 * @property TblUser $TblUser
 * @property TblComment $TblComment
 * 
 * @method integer    getUserId()     Returns the current record's "user_id" value
 * @method string     getContent()    Returns the current record's "content" value
 * @method integer    getParentId()   Returns the current record's "parent_id" value
 * @method boolean    getStatus()     Returns the current record's "status" value
 * @method TblUser    getTblUser()    Returns the current record's "TblUser" value
 * @method TblComment getTblComment() Returns the current record's "TblComment" value
 * @method TblComment setUserId()     Sets the current record's "user_id" value
 * @method TblComment setContent()    Sets the current record's "content" value
 * @method TblComment setParentId()   Sets the current record's "parent_id" value
 * @method TblComment setStatus()     Sets the current record's "status" value
 * @method TblComment setTblUser()    Sets the current record's "TblUser" value
 * @method TblComment setTblComment() Sets the current record's "TblComment" value
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblComment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_comment');
        $this->hasColumn('user_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'ID người bình luận',
             'length' => 8,
             ));
        $this->hasColumn('content', 'string', 1023, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Nội dung bình luận',
             'length' => 1023,
             ));
        $this->hasColumn('parent_id', 'integer', 8, array(
             'type' => 'integer',
             'comment' => 'ID bình luận gốc',
             'length' => 8,
             ));
        $this->hasColumn('status', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             'comment' => 'Trạng thái kích hoạt (0: không kích hoạt; 1: kích hoạt)',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('TblUser', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('TblComment', array(
             'local' => 'parent_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}