<?php

/**
 * TblMemberHealthTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TblMemberHealthTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object TblMemberHealthTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('TblMemberHealth');
  }

  public function getActiveQuery($alias)
  {
    return $this->createQuery($alias)
      ->where($alias . '.status = 1')
      ->andWhere($alias . '.is_delete = 0');
  }

  public function getHealthByMemberIdAndDate($memberId, $date)
  {
    return $this->createQuery()
      ->where('is_delete = 0')
      ->andWhere('member_id = ?', $memberId)
      ->andWhere('date = ?', $date)
      ->fetchOne();
  }

  public function getMemberHealth($fromDate, $toDate, $memberId, $classIds, $memberIds, $offset, $limit)
  {
    $q = $this->getActiveQuery('a')
      ->leftJoin('a.TblMember m')
      ->andWhere('a.member_id = ?', $memberId);

    if ($classIds) {
      $q->leftJoin('m.TblClass c')
        ->andWhereIn('c.id', $classIds);
    }

    if ($memberIds) {
      $q->andWhereIn('a.member_id', $memberIds);
    }

    if ($fromDate) {
      $q->andWhere('a.date >= ?', $fromDate);
    }

    if ($toDate) {
      $q->andWhere('a.date <= ?', $toDate);
    }

    return $q->offset($offset)
      ->limit($limit)
      ->execute();
  }
}