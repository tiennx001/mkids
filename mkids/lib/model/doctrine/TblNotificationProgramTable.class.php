<?php

/**
 * TblNotificationProgramTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TblNotificationProgramTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object TblNotificationProgramTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('TblNotificationProgram');
  }

  public function getActiveQuery($alias) {
    return $this->createQuery($alias)
      ->where($alias . '.status = 1');
  }

  public function getProgByIdAndUserId($id, $userId)
  {
    return $this->getActiveQuery('a')
      ->andWhere('a.id = ?', $id)
      ->andWhere('a.user_id = ?', $userId)
      ->fetchOne();
  }

  public function getListNotificationProgs($kw, $offset, $limit, $userId)
  {
    $q = $this->getActiveQuery('a')
      ->andWhere('a.user_id = ?', $userId);
    if ($kw) {
      $q->andWhere('a.name LIKE ?', '%' . $kw . '%');
    }
    return $q->offset($offset)
      ->limit($limit)
      ->execute();
  }
}