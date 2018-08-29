<?php

class AuthenticateErrorCode extends defaultErrorCode
{
  //danh sách mã lỗi

  const AUTHENTICATE_SUCCESS = 0;
  const AUTHENTICATE_FAIL = 1;
  const MISSING_PARAMETERS = 2;
  const INVALID_PARAMETER_VALUE = 3;
  const PHONE_NUMBER_UNDETECTED = 4;

  //danh sách message tương ứng
  public static $extMessages = array(
    0 => "Authenticate Success",
    1 => "Authenticate Fail",
    2 => "Missing Parameters",
    3 => "Invalid Parameter Value",
    4 => "User Has Not Registered Yet"
  );

  public static function getMessage($errorCode) {
    $i18n = sfContext::getInstance()->getI18N();
    if (array_key_exists($errorCode, self::$extMessages))
      return $i18n->__(self::$extMessages[$errorCode]);
    return parent::getMessage($errorCode);
  }

}

?>
