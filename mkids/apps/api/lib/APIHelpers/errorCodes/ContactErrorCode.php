<?php

class ContactErrorCode extends defaultErrorCode
{
  //danh sách mã lỗi

  const SUCCESS = 0;
  const NO_RESULTS = 1;
  const MISSING_PARAMETERS = 2;
  const INVALID_PARAMETER_VALUE = 3;
  const IDENTICAL_PHONE_NUMBER = 11;
  const ADDITIONAL_PHONE_NUMBER_EXIST = 12;

  //danh sách message tương ứng
  public static $extMessages = array(
    0 => "Success",
    1 => "No Results",
    2 => "Missing Parameters",
    3 => "Invalid Parameter Value",
    11 => "Additional phone number cannot be identical to the main phone number",
    12 => "Additional phone number has already exist"
  );

  public static function getMessage($errorCode)
  {
    $i18n = sfContext::getInstance()->getI18N();
    if (array_key_exists($errorCode, self::$extMessages))
      return $i18n->__(self::$extMessages[$errorCode]);
    return parent::getMessage($errorCode);
  }

}

?>
