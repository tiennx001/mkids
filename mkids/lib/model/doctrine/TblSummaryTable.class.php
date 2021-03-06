<?php

/**
 * TblSummaryTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TblSummaryTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object TblSummaryTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('TblSummary');
  }

  public function getActiveQuery($alias)
  {
    return $this->createQuery($alias)
      ->where($alias . '.status = 1')
      ->andWhere($alias . '.is_delete = 0');
  }

  public function getSummaryByIdAndUserId($id, $userId)
  {
    return $this->getActiveQuery('a')
      ->andWhere('a.id = ?', $id)
      ->andWhere('a.user_id = ?', $userId)
      ->fetchOne();
  }

  public function getSummaryList($memberId, $date, $week, $offset, $limit, $memberIds)
  {
    $q = $this->getActiveQuery('a')
      ->leftJoin('a.TblMember')
      ->andWhere('a.member_id = ?', $memberId);
    if ($date) {
      $q->andWhere('a.date = ?', $date);
    }
    if ($week) {
      $q->andWhere('a.week = ?', $week);
    }
    if ($memberIds) {
      $q->andWhereIn('a.member_id', $memberIds);
    }
    return $q->offset($offset)
      ->limit($limit)
      ->execute();
  }

  public function checkDateAndWeekExist($memberId, $date, $week)
  {
    $q = $this->getActiveQuery('a')
      ->andWhere('a.member_id = ?', $memberId)
      ->andWhere('a.date = ? OR a.week = ?', array($date, $week));
    return $q->count();
  }
}