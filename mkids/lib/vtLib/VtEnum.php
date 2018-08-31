<?php
/**
 * Created by PhpStorm.
 * User: khanhnq16
 * Date: 7/21/14
 * Time: 5:28 PM
 */

abstract class NotificationProgTypeEnum {
  const TO_ALL = 0;
  const TO_GROUP = 1;
  const TO_CLASS = 2;
  const TO_MEMBER = 3;

  public static function getArr() {
    return array(
      self::TO_ALL => 'T?t c?',
      self::TO_GROUP => 'Theo kh?i',
      self::TO_CLASS => 'Theo l?p',
      self::TO_MEMBER => 'T?ng cá nhân',
    );
  }
}

abstract class NotificationProgStatusEnum {
  const DRAFT = 0;
  const WAITING = 1;
  const APPROVE = 2;
  const COMPLETE = 3;

  public static function getArr() {
    return array(
      self::DRAFT => 'Nháp',
      self::WAITING => 'Ch? phê duy?t',
      self::APPROVE => '?ã phê duy?t',
      self::COMPLETE => '?ã g?i',
    );
  }
}
