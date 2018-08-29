<?php

/**
 * TblTokenSessionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TblTokenSessionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object TblTokenSessionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TblTokenSession');
    }

    public function getInfoByToken($token) {
        return $this->createQuery('a')
            ->where('a.token = ?', $token)
            ->andWhere('a.expired_time > ?', date('Y-m-d H:i:s'))
            ->fetchOne();
    }

    public function getInfoByTokenNotExpired($token) {
        return $this->createQuery('a')
          ->where('a.token = ?', $token)
          ->fetchOne();
    }

    public function checkExistAccount($account) {
        return $this->createQuery('a')
            ->where('a.account = ?', $account)
            ->fetchOne();
    }

    public function deleteSession($userId) {
        return $this->createQuery('a')
          ->update()
          ->set('a.expired_time', '?', date('Y-m-d H:i:s'))
          ->where('a.user_id = ?', $userId)
          ->execute();
    }
}