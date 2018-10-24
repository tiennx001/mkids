<?php

/**
 * TblNotificationHisTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TblNotificationHisTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object TblNotificationHisTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('TblNotificationHis');
  }

  public function getActiveQuery($alias)
  {
    return $this->createQuery($alias)
      ->where($alias . '.status = 1');
  }

  public function getNewNotification($userId, $lastUpdate, $dateView)
  {
    return $this->getActiveQuery('a')
      ->andWhere('a.receiver_id = ?', $userId)
      ->andWhere('a.created_at > ?', $lastUpdate)
      ->andWhere('a.created_at <= ?', $dateView)
      ->count();
  }

  public function getListNotification($userId, $pageSize)
  {
    return $this->getActiveQuery('a')
      ->andWhere('a.receiver_id = ?', $userId)
      ->orderBy('created_at DESC')
      ->limit($pageSize)
      ->execute();
  }

  public function getListNotificationByDate($userId, $offset, $pageSize, $dateGetNotify)
  {
    return $this->getActiveQuery('a')
      ->andWhere('a.receiver_id = ?', $userId)
      ->andWhere('a.created_at <= ?', $dateGetNotify)
      ->orderBy('created_at DESC')
      ->offset($offset)
      ->limit($pageSize)
      ->execute();
  }

}