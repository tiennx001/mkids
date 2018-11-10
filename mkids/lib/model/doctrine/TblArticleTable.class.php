<?php

/**
 * TblArticleTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TblArticleTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object TblArticleTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('TblArticle');
  }

  public function getActiveQuery($alias)
  {
    return $this->createQuery($alias)
      ->where($alias . '.status = 1')
      ->andWhere($alias . '.is_delete = 0');
  }

  public function getArticleByIdAndUserId($id, $userId)
  {
    return $this->getActiveQuery('a')
      ->andWhere('a.id = ?', $id)
      ->andWhere('a.user_id = ?', $userId)
      ->fetchOne();
  }

  public function getListArticles($kw, $offset, $limit, $schoolIds, $groupIds, $classIds, $memberIds)
  {
    $q = $this->getActiveQuery('a')
      ->leftJoin('a.TblArticleRef ar')
      ->andWhere(sprintf('ar.school_id IN (%s) OR ar.group_id IN (%s) OR ar.class_id IN (%s) OR ar.member_id IN (%s)',
        implode(',', $schoolIds),
        implode(',', $groupIds),
        implode(',', $classIds),
        implode(',', $memberIds)
      ));

    if ($kw) {
      $q->andWhere('a.title LIKE ?', '%' . $kw . '%');
    }

    return $q->offset($offset)
      ->limit($limit)
      ->orderBy('a.id DESC')
      ->execute();
  }

  public function getArticleById($id)
  {
    return $this->getActiveQuery('a')
      ->andWhere('a.id = ?', $id)
      ->fetchOne();
  }

  public function checkArticleForSchool($id, $schoolIds)
  {
    return $this->getActiveQuery('a')
      ->leftJoin('a.TblArticleRef ar')
      ->andWhere('a.id = ?', $id)
      ->andWhereIn('ar.school_id', $schoolIds)
      ->count();
  }

  public function checkArticleForGroups($id, $groupIds)
  {
    return $this->getActiveQuery('a')
      ->leftJoin('a.TblArticleRef ar')
      ->andWhere('a.id = ?', $id)
      ->andWhereIn('ar.group_id', $groupIds)
      ->count();
  }

  public function checkArticleForClasses($id, $classIds)
  {
    return $this->getActiveQuery('a')
      ->leftJoin('a.TblArticleRef ar')
      ->andWhere('a.id = ?', $id)
      ->andWhereIn('ar.class_id', $classIds)
      ->count();
  }

  public function checkArticleForMembers($id, $memberIds)
  {
    return $this->getActiveQuery('a')
      ->leftJoin('a.TblArticleRef ar')
      ->andWhere('a.id = ?', $id)
      ->andWhereIn('ar.member_id', $memberIds)
      ->count();
  }

  public function checkArticleCredentials($id, $articleType, $userId, $userType)
  {
    switch ($articleType) {
      case ArticleTypeEnum::ALL:
        $schoolIds = TblSchoolTable::getInstance()->getActiveSchoolIdsByUserId($userId, $userType);
        if ($schoolIds) {
          return $this->checkArticleForSchool($id, $schoolIds);
        }
        break;
      case ArticleTypeEnum::GROUPS:
        $groupIds = TblGroupTable::getInstance()->getActiveGroupIdsByUserId($userId, $userType);
        if ($groupIds && count($groupIds)) {
          return $this->checkArticleForGroups($id, $groupIds);
        }
        break;
      case ArticleTypeEnum::CLASSES:
        $classIds = TblClassTable::getInstance()->getActiveClassIdsByUserId($userId, $userType);
        if ($classIds && count($classIds)) {
          return $this->checkArticleForClasses($id, $classIds);
        }
        break;
      case ArticleTypeEnum::MEMBERS:
        $memberIds = TblMemberTable::getInstance()->getActiveMemberIdsByUserId($userId, $userType);
        if ($memberIds && count($memberIds)) {
          return $this->checkArticleForMembers($id, $memberIds);
        }
        break;
    }
    return false;
  }
}