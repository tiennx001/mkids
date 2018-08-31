<?php

/**
 * TblClassTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TblClassTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object TblClassTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TblClass');
    }

    public function getActiveClassInGroupQuery($groupId,$schoolId){
      $query = $this->createQuery('c')
        ->select('c.id id, c.name name, c.description description, c.group_id group_id, g.name group_name')
        ->innerJoin('c.TblGroup g')
        ->where('c.status = 1')
        ->andWhere('g.school_id = ?', $schoolId);
      if($groupId)
        $query->andWhere('c.group_id = ?', $groupId);

      return $query;
    }

  public function getActiveClassInGroup($groupId,$schoolId){
    $query = $this->getActiveClassInGroupQuery($groupId,$schoolId);
    return $query->fetchArray();
  }
  public function getActiveClassByIdAndGroupId($id,$groupId,$schoolId){
    $query = $this->getActiveClassInGroupQuery($groupId,$schoolId)
      ->addWhere('c.id = ?', $id);

    return $query->fetchOne();
  }
}