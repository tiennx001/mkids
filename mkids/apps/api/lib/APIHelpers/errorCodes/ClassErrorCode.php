<?php

class ClassErrorCode extends defaultErrorCode
{
  //danh sách mã lỗi

  const CLASS_NOT_EXIST = 2;
  const MISSING_PARAMETERS = 3;
  const CANNOT_DELETE_CLASS = 4;

  //danh sách message tương ứng
  public static $extMessages = array(
    2 => "Class not exist.",
    3 => "Missing Parameters",
    4 => "Can not delete class containing student or teacher.",
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
