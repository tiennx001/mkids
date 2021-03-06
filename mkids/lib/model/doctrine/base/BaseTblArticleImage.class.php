<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblArticleImage', 'doctrine');

/**
 * BaseTblArticleImage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $title
 * @property string $image_path
 * @property integer $article_id
 * @property boolean $status
 * @property boolean $is_delete
 * @property TblArticle $TblArticle
 * 
 * @method string          getTitle()      Returns the current record's "title" value
 * @method string          getImagePath()  Returns the current record's "image_path" value
 * @method integer         getArticleId()  Returns the current record's "article_id" value
 * @method boolean         getStatus()     Returns the current record's "status" value
 * @method boolean         getIsDelete()   Returns the current record's "is_delete" value
 * @method TblArticle      getTblArticle() Returns the current record's "TblArticle" value
 * @method TblArticleImage setTitle()      Sets the current record's "title" value
 * @method TblArticleImage setImagePath()  Sets the current record's "image_path" value
 * @method TblArticleImage setArticleId()  Sets the current record's "article_id" value
 * @method TblArticleImage setStatus()     Sets the current record's "status" value
 * @method TblArticleImage setIsDelete()   Sets the current record's "is_delete" value
 * @method TblArticleImage setTblArticle() Sets the current record's "TblArticle" value
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblArticleImage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_article_image');
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'comment' => 'Tiêu đề',
             'length' => 255,
             ));
        $this->hasColumn('image_path', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Đường dẫn ảnh',
             'length' => 255,
             ));
        $this->hasColumn('article_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'ID bài viết',
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
        $this->hasOne('TblArticle', array(
             'local' => 'article_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}