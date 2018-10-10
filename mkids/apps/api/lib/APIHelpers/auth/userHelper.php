<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 7/22/14
 * Time: 10:48 AM
 * To change this template use File | Settings | File Templates.
 */

class userHelper
{
  /**
   * Thực hiện generate token và keyRefresh theo username hoặc số điện thoại
   * @param $username
   * @return array
   * @author NghiaLD <nghiald@viettel.com>
   * @modifier Tiennx6
   * @created_at: 4/14/14 8:26 AM
   */
  public static function generateToken($username, $osType)
  {
    try {
      // Kiem tra token tuong ung voi so dien thoai hoac tai khoan da ton tai trong bang VtTokenSession chua
      $tokenSession = TblTokenSessionTable::getInstance()->checkExistAccount($username);
      if (!$tokenSession) {
        $tokenSession = new TblTokenSession();
        // Luu tai khoan
        $tokenSession->setAccount($username);
      }
      //khoi tao du lieu
      $expireTime = date('Y-m-d H:i:s', time() + sfConfig::get('app_token_expired', 3600));

      $tokenPair = array(
        'token' => mobileHelper::generateGuid(),
        'keyRefresh' => mobileHelper::generateGuid(),
      );

      // Neu user da dang ky tai khoan luu them ID cua user
      $user = TblUserTable::getInstance()->getUserByEmail($username);
      if ($user) {
        $tokenSession->setUserId($user['id']);
        $tokenSession->setMsisdn($user['msisdn']);
        $tokenSession->setUserType($user['type']);
      }

      $tokenSession->setToken($tokenPair['token']);
      $tokenSession->setKeyRefresh($tokenPair['keyRefresh']);
      $tokenSession->setExpiredTime($expireTime);
      $tokenSession->setOsType($osType);
      $tokenSession->save();
      return $tokenPair;
    } catch (Exception $exc) {
      /**
       * @todo Thực hiện ghi log khi tao token
       */
      echo $exc->getMessage();
      return null;
    }
  }
}