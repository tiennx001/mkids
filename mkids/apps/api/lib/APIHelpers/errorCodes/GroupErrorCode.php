<?php

class GroupErrorCode extends defaultErrorCode
{
  //danh sách mã lỗi

  const GROUP_NOT_EXIST = 2;
  const MISSING_PARAMETERS = 3;
  const GROUP_CANNOT_DELETE_CONTAINING_CLASS = 4;

  //danh sách message tương ứng
  public static $extMessages = array(
    2 => "Group not exist.",
    3 => "Missing Parameters",
    4 => "Can not delete group containing class.",
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
