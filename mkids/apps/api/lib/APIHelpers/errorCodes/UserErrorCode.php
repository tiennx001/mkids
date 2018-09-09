<?php

class UserErrorCode extends defaultErrorCode
{
  //danh sách mã lỗi

  const SUCCESS = 0;
  const NO_RESULTS = 1;
  const MISSING_PARAMETERS = 2;
  const INVALID_PARAMETER_VALUE = 3;
  const USER_HAS_NOT_REGISTERED_YET = 4;
  const INVALID_PHONE_NUMBER = 5;
  const INVALID_EMAIL = 6;
  const INVALID_VERIFICATION_CODE = 7;
  const CANNOT_CREATE_TOKEN = 8;
  const ACCOUNT_HAS_BEEN_BLOCKED = 9;
  const HAVE_REACHED_THE_LIMIT = 10;
  const STRING_MAX_LENGTH = 13;
  const NO_MESSAGE = 14;
  const ROLES_CONFIG_ERROR = 15;
  const INVALID_UPLOADED_IMAGE = 16;
  const FILTER_DATE_COULD_NOT_GREATER_THAN_NOW = 17;
  const FROM_DATE_MUST_LESS_THAN_TO_DATE = 18;
  const INVALID_DATE_FORMAT = 19;

  //danh sách message tương ứng
  public static $extMessages = array(
    0 => "Success",
    1 => "No Results",
    2 => "Missing Parameters",
    3 => "Invalid Parameter Value",
    4 => "User Has Not Registered Yet",
    5 => "Invalid Phone Number",
    6 => "Invalid Email",
    7 => "Invalid Verification Code",
    8 => "Cannot create token, please try again",
    9 => "Your account has been blocked for ten minutes",
    10 => "You have reached the limit per hour",
    13 => "Max length is %max_length%",
    14 => "No message available",
    15 => "Roles config error",
    16 => "Invalid uploaded image",
    17 => "Invalid date format",
    18 => "Filter date could not greater than now",
    19 => "From date must less than to date",
  );

  public static function getMessage($errorCode, $replacement = array())
  {
    $i18n = sfContext::getInstance()->getI18N();
    if (array_key_exists($errorCode, self::$extMessages))
      return $i18n->__(self::$extMessages[$errorCode], $replacement);
    return parent::getMessage($errorCode);
  }

}

?>
