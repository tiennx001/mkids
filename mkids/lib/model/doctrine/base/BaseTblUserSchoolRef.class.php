<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblUserSchoolRef', 'doctrine');

/**
 * BaseTblUserSchoolRef
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $school_id
 * 
 * @method integer          getUserId()    Returns the current record's "user_id" value
 * @method integer          getSchoolId()  Returns the current record's "school_id" value
 * @method TblUserSchoolRef setUserId()    Sets the current record's "user_id" value
 * @method TblUserSchoolRef setSchoolId()  Sets the current record's "school_id" value
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblUserSchoolRef extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_user_school_ref');
        $this->hasColumn('user_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'ID user',
             'length' => 8,
             ));
        $this->hasColumn('school_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'ID trường',
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