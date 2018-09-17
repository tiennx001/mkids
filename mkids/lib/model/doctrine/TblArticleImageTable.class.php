<?php

/**
 * TblArticleImageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TblArticleImageTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object TblArticleImageTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TblArticleImage');
    }

    public function getActiveQuery($alias) {
        return $this->createQuery('a')
          ->where($alias . '.status = 1')
          ->andWhere($alias . '.is_delete = 0');
    }

    public function getImageByIdAndUserId($id, $userId)
    {
        return $this->getActiveQuery('a')
          ->leftJoin('a.TblArticle b')
          ->andWhere('a.id = ?', $id)
          ->andWhere('b.user_id = ?', $userId)
          ->fetchOne();
    }
}