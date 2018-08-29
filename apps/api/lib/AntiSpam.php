<?php

/**
 * Created by PhpStorm.
 * User: tiennx6
 * Date: 12/10/2015
 * Time: 9:32 SA
 */
class AntiSpam
{

  public static function isSpam($uniqueParam)
  {
    $redis = sfRedis::getClient();
    $redis->select(sfConfig::get('app_anti_spam_redis_db', 2));

    $keyRoot = 'antiSpam';
    $key = $keyRoot . ':' . $uniqueParam;
    $value = $redis->get($key);
    if ($value) {
      if ($value == sfConfig::get('app_spam_lock_in_turn', 5)) {
        $redis->expire($key, sfConfig::get('app_spam_lock_account_time', 86400));
      } else {
        $redis->incr($key);
        $redis->expire($key, sfConfig::get('app_spam_max_time_per_request', 3));
      }
      return true;
    } else {
      $redis->set($key, 1);
      $redis->expire($key, sfConfig::get('app_spam_max_time_per_request', 3));
    }
    return false;
  }

  public static function getLimited($uniqueParam)
  {
    $redis = sfRedis::getClient();
    $redis->select(sfConfig::get('app_anti_spam_redis_db', 2));

    $keyRoot = 'limit';
    $key = $keyRoot . ':' . $uniqueParam;
    $value = $redis->get($key);
    if ($value == sfConfig::get('app_get_sms_limit', 3)) {
      return true;
    } else {
      $value = $redis->incr($key);
      if ($value == 1) {
        $redis->expire($key, sfConfig::get('app_get_sms_limit_time', 3600));
      }
    }
    return false;
  }

}