<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblNotificationHis', 'doctrine');

/**
 * BaseTblNotificationHis
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $sender_id
 * @property integer $receiver_id
 * @property string $receiver_phone
 * @property string $content
 * @property tinyint $type
 * @property integer $article_id
 * @property integer $status
 * @property string $response
 * @property TblUser $Sender
 * @property TblUser $Receiver
 * @property TblArticle $TblArticle
 * 
 * @method string             getSenderId()       Returns the current record's "sender_id" value
 * @method integer            getReceiverId()     Returns the current record's "receiver_id" value
 * @method string             getReceiverPhone()  Returns the current record's "receiver_phone" value
 * @method string             getContent()        Returns the current record's "content" value
 * @method tinyint            getType()           Returns the current record's "type" value
 * @method integer            getArticleId()      Returns the current record's "article_id" value
 * @method integer            getStatus()         Returns the current record's "status" value
 * @method string             getResponse()       Returns the current record's "response" value
 * @method TblUser            getSender()         Returns the current record's "Sender" value
 * @method TblUser            getReceiver()       Returns the current record's "Receiver" value
 * @method TblArticle         getTblArticle()     Returns the current record's "TblArticle" value
 * @method TblNotificationHis setSenderId()       Sets the current record's "sender_id" value
 * @method TblNotificationHis setReceiverId()     Sets the current record's "receiver_id" value
 * @method TblNotificationHis setReceiverPhone()  Sets the current record's "receiver_phone" value
 * @method TblNotificationHis setContent()        Sets the current record's "content" value
 * @method TblNotificationHis setType()           Sets the current record's "type" value
 * @method TblNotificationHis setArticleId()      Sets the current record's "article_id" value
 * @method TblNotificationHis setStatus()         Sets the current record's "status" value
 * @method TblNotificationHis setResponse()       Sets the current record's "response" value
 * @method TblNotificationHis setSender()         Sets the current record's "Sender" value
 * @method TblNotificationHis setReceiver()       Sets the current record's "Receiver" value
 * @method TblNotificationHis setTblArticle()     Sets the current record's "TblArticle" value
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblNotificationHis extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_notification_his');
        $this->hasColumn('sender_id', 'string', 16, array(
             'type' => 'string',
             'comment' => 'ID của người gửi thông báo',
             'length' => 16,
             ));
        $this->hasColumn('receiver_id', 'integer', 8, array(
             'type' => 'integer',
             'comment' => 'ID của người nhận thông báo',
             'length' => 8,
             ));
        $this->hasColumn('receiver_phone', 'string', 16, array(
             'type' => 'string',
             'comment' => 'SĐT của người nhận thông báo',
             'length' => 16,
             ));
        $this->hasColumn('content', 'string', 1024, array(
             'type' => 'string',
             'comment' => 'Nội dung thông báo',
             'length' => 1024,
             ));
        $this->hasColumn('type', 'tinyint', 2, array(
             'type' => 'tinyint',
             'default' => 0,
             'comment' => 'Loại thông báo (0 - Notification; 1 - Notification + SMS)',
             'length' => 2,
             ));
        $this->hasColumn('article_id', 'integer', 8, array(
             'type' => 'integer',
             'comment' => 'ID bài viết',
             'length' => 8,
             ));
        $this->hasColumn('status', 'integer', 2, array(
             'type' => 'integer',
             'comment' => 'Trạng thái push notification (0 - Không có registration_ids; 1 - Thành công; 2 - Thất bại)',
             'length' => 2,
             ));
        $this->hasColumn('response', 'string', 1024, array(
             'type' => 'string',
             'comment' => 'Response của server',
             'length' => 1024,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('TblUser as Sender', array(
             'local' => 'sender_id',
             'foreign' => 'id'));

        $this->hasOne('TblUser as Receiver', array(
             'local' => 'receiver_id',
             'foreign' => 'id'));

        $this->hasOne('TblArticle', array(
             'local' => 'article_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             'updated' => 
             array(
              'disabled' => true,
             ),
             ));
        $this->actAs($timestampable0);
    }
}