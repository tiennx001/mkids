<?php

/**
 * TblGroupTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TblGroupTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object TblGroupTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TblGroup');
    }

    public function getActiveGroupBySchoolId($schoolId){
      return self::getInstance()->createQuery()
        ->where('status = 1')
        ->andWhere('school_id = ?', $schoolId)
        ->fetchArray();
    }

    public static function getActiveGroupByIdAndSchoolId($id,$schoolId){
      return self::getInstance()->createQuery()
        ->where('status = 1')
        ->andWhere('id = ?', $id)
        ->andWhere('school_id = ?', $schoolId)
        ->fetchArray();
    }
}