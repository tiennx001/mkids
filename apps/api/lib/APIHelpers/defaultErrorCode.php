<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 7/22/14
 * Time: 9:54 AM
 * To change this template use File | Settings | File Templates.
 */

abstract class defaultErrorCode
{

  const SUCCESS = 200;
  const CREATED = 201;
  const ACCEPTED = 202;
  const BAD_REQUEST = 400;
  const UNAUTHORIZED = 401;
  const FORBIDDEN = 403;
  const NOT_FOUND = 404;
  const METHOD_NOT_ALLOWED = 405;
  const REQUEST_TIMEOUT = 408;
  const INTERNAL_SERVER_ERROR = 500;
  const BAD_GATEWAY = 502;
  const SERVICE_UNAVAILABLE = 503;
  public static $message = array(
    200 => 'Success',
    201 => 'Created',
    202 => 'Accepted',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    408 => 'Request Timeout',
    500 => 'Internal Server Error',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable'
  );

  public static function getMessage($errorCode) {
    $i18n = sfContext::getInstance()->getI18N();
    if (array_key_exists($errorCode, self::$message))
      return $i18n->__(self::$message[$errorCode]);
    return null;
  }

}