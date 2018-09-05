<?php

class MenuErrorCode extends defaultErrorCode
{
  //danh sách mã lỗi

  const SUCCESS = 0;
  const NO_RESULTS = 1;
  const DATE_LESS_THAN_NOW = 2;
  const DATE_INVALID = 3;

  //danh sách message tương ứng
  public static $extMessages = array(
    0 => "Success",
    1 => "No Results",
    2 => "The date must be equal or greater than now.",
    3 => "Date invalid (please enter format %format%).",
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
