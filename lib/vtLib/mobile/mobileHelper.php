<?php

/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 7/22/14
 * Time: 10:50 AM
 * To change this template use File | Settings | File Templates.
 */
class mobileHelper
{

//  public static function getMsisdnFromAgent()
//  {
//    $ipaddr = GpUtil::getRemoteIp();
//    return self::getGprsMsisdn($ipaddr);
//  }
//
//  /**
//   * Goi Radius de lay so dien thoai Viettel
//   * @author DucDA2
//   * @created on Oct 10, 2012
//   * @param $ip
//   * @return string
//   */
//  public static function getGprsMsisdn($ip) {
//    $folder = sfConfig::get('app_vaaa_log_url', '/etc/temp');
//    $filePath = $folder . '/vaaa-system-log' . date('Ymd') . '.log';
//    if (!is_dir($folder)) {
//      mkdir($folder, 0777, true);
//    }
//    if (empty($ip)) {
//      error_log('{VAAA} Loi lay MSISDN do thieu IP' . PHP_EOL, 3, $filePath);
//      return '';
//    }
//    error_log('{VAAA} Nhan dang IP = ' . $ip . PHP_EOL, 3, $filePath);
//    $wsUrl = $arrService = sfConfig::get('app_vaaa_ws_url', '');
//    $username = $arrService = sfConfig::get('app_vaaa_username', '');
//    $password = $arrService = sfConfig::get('app_vaaa_password', '');
//    $options = array('connect_timeout' => 5, 'timeout' => 5);
//    $client = new SoapClient($wsUrl, $options);
//    $result = null;
//    try {
//      $result = $client->__soapCall('getMSISDN', array(array('username' => $username, 'password' => $password, 'ip' => $ip)));
//    } catch (Exception $e) {
//      error_log('{VAAA} Lay MSISDN gap ngoai le: ' . $e->getMessage() . PHP_EOL, 3, $filePath);
//    }
//    if (is_object($result)) {
//      error_log('{VAAA}: ' . $ip . ' -> ' . $result->return->desc . PHP_EOL, 3, $filePath);
//      if ($result->return->code == 0) {
//        return $result->return->desc;
//      } else {
//        return '';
//      }
//    } else {
//      sfContext::getInstance()->getUser()->setAttribute('allowCallRadius', FALSE);
//      error_log('{VAAA}: ' . $ip . ' -> response no object!' . PHP_EOL, 3, $filePath);
//      return '';
//    }
//  }

  public static function getMsisdnFromAgent()
  {
    return ;
    $folder = sfConfig::get('app_vaaa_log_url', '/etc/temp');
    $filePath = $folder . '/vaaa-system-log' . date('Ymd') . '.log';
    if (!is_dir($folder)) {
      mkdir($folder, 0777, true);
    }

    $ipaddr = GpUtil::getRemoteIp();
    // Lay gia tri tu file config
    $yamlFile = sfConfig::get('sf_config_dir') . '/ipPools.yml';
    $ipLst = sfYaml::load($yamlFile);
    if (is_array($ipLst)) {
      $ipLst = $ipLst['ip_pools'];
    }
    $pass = false;
    foreach ($ipLst as $ipCIDR) {
      if ($ipCIDR && GpUtil::ipCIDRCheck($ipaddr, $ipCIDR)) {
        error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- ' . 'Pass with rule ' . $ipCIDR . PHP_EOL, 3, $filePath);
        GpUtil::debug('Pass with rule ' . $ipCIDR);
        $pass = true;
        break;
      }
    }

    //3G
    if ($pass) {
      if (isset($_SERVER['MSISDN'])) {
        error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- IP: ' . $ipaddr . ' --- MSISDN: ' . $_SERVER['MSISDN'] . PHP_EOL, 3, $filePath);
        return $_SERVER['MSISDN'];
      }
      if (isset($_SERVER['HTTP_X_WAP_MSISDN'])) {
        error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- IP: ' . $ipaddr . ' --- HTTP_X_WAP_MSISDN: ' . $_SERVER['HTTP_X_WAP_MSISDN'] . PHP_EOL, 3, $filePath);
        return $_SERVER['HTTP_X_WAP_MSISDN'];
      }
      if (isset($_SERVER['X_WAP_MSISDN'])) {
        error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- IP: ' . $ipaddr . ' --- X_WAP_MSISDN: ' . $_SERVER['X_WAP_MSISDN'] . PHP_EOL, 3, $filePath);
        return $_SERVER['X_WAP_MSISDN'];
      }
      if (isset($_SERVER['HTTP_MSISDN'])) {
        error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- IP: ' . $ipaddr . ' --- HTTP_MSISDN: ' . $_SERVER['HTTP_MSISDN'] . PHP_EOL, 3, $filePath);
        return $_SERVER['HTTP_MSISDN'];
      }
    }
    /* 2G */
    if ($pass) {
      try {
        $client = new SoapClient(sfConfig::get('app_vaaa_ws_url'));
        $response = $client->__call('getMSISDN', array(array('username' => sfConfig::get('app_vaaa_username'), 'password' => sfConfig::get('app_vaaa_password'), 'ip' => $ipaddr)));

        $stdClass = $response->return;
        if ($stdClass->code == 0) {
          error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- IP: ' . $ipaddr . ' --- RETURN: ' . $stdClass->code . ' --- DESC: ' . $stdClass->desc . PHP_EOL, 3, $filePath);
          return GpUtil::convertMsisdn($stdClass->desc);
        } else {
          error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- IP: ' . $ipaddr . ' --- RETURN: ' . $stdClass->code . ' --- DESC: ' . $stdClass->desc . PHP_EOL, 3, $filePath);
          return '';
        }
      } catch (Exception $ex) {
        error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- IP: ' . $ipaddr . ' --- ERROR: ' . $ex->getMessage() . PHP_EOL, 3, $filePath);
        return '';
      };
    } else {
      error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- ' . 'IP NOT IN RANGER ' . $ipaddr . PHP_EOL, 3, $filePath);
      //get msisdn from opera mini
      if (GpUtil::ipCIDRCheck($ipaddr, '141.0.0.0/16')) {
        error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- ' . "IP from operamini " . $ipaddr . ' --> ' . @$_SERVER['HTTP_X_FORWARDED_FOR'] . PHP_EOL, 3, $filePath);
        GpUtil::debug("IP from operamini " . $ipaddr . ' --> ' . @$_SERVER['HTTP_X_FORWARDED_FOR']);
        $ipaddr = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $client = new SoapClient(sfConfig::get('app_vaaa_ws_url'));
        $response = $client->__call('getMSISDN', array(array('username' => sfConfig::get('app_vaaa_username'), 'password' => sfConfig::get('app_vaaa_password'), 'ip' => $ipaddr)));
        $stdClass = $response->return;
        if ($stdClass->code == 0) {
          error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- IP: ' . $ipaddr . ' --- RETURN: ' . $stdClass->code . ' --- DESC: ' . $stdClass->desc . PHP_EOL, 3, $filePath);
          return GpUtil::convertMsisdn($stdClass->desc);
        } else {
          error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- IP: ' . $ipaddr . ' --- RETURN: ' . $stdClass->code . ' --- DESC: ' . $stdClass->desc . PHP_EOL, 3, $filePath);
          return '';
        }
      } else {
        error_log('[' . date('Y-m-d H:i:s') . '] VAAA System Log --- ' . 'IP not from Opera Proxy' . PHP_EOL, 3, $filePath);
        GpUtil::debug("IP not from Opera Proxy");
      }
    }
  }

  /**
   * ham thuc hien generate ra unique token
   * @author: thongnq1
   * @created at: 08/05/2013
   * @param bool $include_braces
   * @return string $guid
   */
  public static function generateGuid($include_braces = false)
  {
    if (function_exists('com_create_guid')) {
      if ($include_braces === true) {
        return com_create_guid();
      } else {
        return substr(com_create_guid(), 1, 36);
      }
    } else {
      mt_srand((double)microtime() * 10000);
      $charid = strtoupper(md5(uniqid(rand(), true)));

      $guid = substr($charid, 0, 8) . '-' .
        substr($charid, 8, 4) . '-' .
        substr($charid, 12, 4) . '-' .
        substr($charid, 16, 4) . '-' .
        substr($charid, 20, 12);

      if ($include_braces) {
        $guid = '{' . $guid . '}';
      }

      return $guid;
    }
  }

}