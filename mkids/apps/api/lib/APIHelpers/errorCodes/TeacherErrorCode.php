<?php

class TeacherErrorCode extends defaultErrorCode
{
  //danh sách mã lỗi

  const TEACHER_NOT_EXIST = 2;
  const MISSING_PARAMETERS = 3;

  //danh sách message tương ứng
  public static $extMessages = array(
    2 => "Teacher not exist.",
    3 => "Missing Parameters",
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
