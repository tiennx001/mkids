<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TblMemberActivity', 'doctrine');

/**
 * BaseTblMemberActivity
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $member_id
 * @property date $date
 * @property tinyint $type
 * @property string $description
 * @property tinyint $health
 * @property integer $height
 * @property integer $weight
 * @property TblMember $TblMember
 * 
 * @method integer           getMemberId()    Returns the current record's "member_id" value
 * @method date              getDate()        Returns the current record's "date" value
 * @method tinyint           getType()        Returns the current record's "type" value
 * @method string            getDescription() Returns the current record's "description" value
 * @method tinyint           getHealth()      Returns the current record's "health" value
 * @method integer           getHeight()      Returns the current record's "height" value
 * @method integer           getWeight()      Returns the current record's "weight" value
 * @method TblMember         getTblMember()   Returns the current record's "TblMember" value
 * @method TblMemberActivity setMemberId()    Sets the current record's "member_id" value
 * @method TblMemberActivity setDate()        Sets the current record's "date" value
 * @method TblMemberActivity setType()        Sets the current record's "type" value
 * @method TblMemberActivity setDescription() Sets the current record's "description" value
 * @method TblMemberActivity setHealth()      Sets the current record's "health" value
 * @method TblMemberActivity setHeight()      Sets the current record's "height" value
 * @method TblMemberActivity setWeight()      Sets the current record's "weight" value
 * @method TblMemberActivity setTblMember()   Sets the current record's "TblMember" value
 * 
 * @package    xcode
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTblMemberActivity extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tbl_member_activity');
        $this->hasColumn('member_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'comment' => 'ID học sinh',
             'length' => 8,
             ));
        $this->hasColumn('date', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             'comment' => 'Ngày hoạt động',
             ));
        $this->hasColumn('type', 'tinyint', 2, array(
             'type' => 'tinyint',
             'notnull' => true,
             'default' => 0,
             'comment' => 'Loạt hoạt động (0: Đi học; 1: Nghỉ học; 2: Đi dã ngoại; 3: Hoạt động văn nghệ; 4: Khai giảng; 5: Bế giảng; 6: Bắt đầu đi học; 7: Nghỉ hẳn)',
             'length' => 2,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'comment' => 'Thông tin hoạt động',
             'length' => 255,
             ));
        $this->hasColumn('health', 'tinyint', 2, array(
             'type' => 'tinyint',
             'default' => 0,
             'comment' => 'Sức khỏe (0: Ốm; 1: Bình thường; 2: Khỏe mạnh)',
             'length' => 2,
             ));
        $this->hasColumn('height', 'integer', 5, array(
             'type' => 'integer',
             'comment' => 'Chiều cao (cm)',
             'length' => 5,
             ));
        $this->hasColumn('weight', 'integer', 5, array(
             'type' => 'integer',
             'comment' => 'Cân nặng (kg)',
             'length' => 5,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('TblMember', array(
             'local' => 'member_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}