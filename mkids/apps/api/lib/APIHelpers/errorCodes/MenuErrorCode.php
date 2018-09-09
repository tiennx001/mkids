<?php

class MenuErrorCode extends defaultErrorCode
{
  //danh sách mã lỗi

  const SUCCESS = 0;
  const NO_RESULTS = 1;
  const MISSING_PARAMETERS = 2;
  const DATE_INVALID = 3;
  const DATE_LESS_THAN_NOW = 4;
  const MENU_NOT_EXIST = 5;

  //danh sách message tương ứng
  public static $extMessages = array(
    0 => "Success",
    1 => "No Results",
    2 => "Missing Parameters",
    3 => "Date invalid (please enter format %format%).",
    4 => "The date must be equal or greater than now.",
    5 => "Menu not exist.",
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
