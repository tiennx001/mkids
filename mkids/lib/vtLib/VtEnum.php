<?php
/**
 * Created by PhpStorm.
 * User: khanhnq16
 * Date: 7/21/14
 * Time: 5:28 PM
 */

abstract class RolesEnum {
  const PRINCIPAL = 0;
  const TEACHER = 1;
  const PARENTS = 2;

  public static function getArr() {
    return array(
      self::PRINCIPAL => 'PRINCIPAL',
      self::TEACHER => 'TEACHER',
      self::PARENTS => 'PARENTS'
    );
  }

}

abstract class NotificationProgTypeEnum {
  const TO_ALL = 0;
  const TO_GROUP = 1;
  const TO_CLASS = 2;
  const TO_MEMBER = 3;

  public static function getArr() {
    return array(
      self::TO_ALL => 'Tất cả',
      self::TO_GROUP => 'Theo khối',
      self::TO_CLASS => 'Theo lớp',
      self::TO_MEMBER => 'Từng cá nhân',
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
      self::WAITING => 'Chờ phê duyệt',
      self::APPROVE => 'Đã phê duyệt',
      self::COMPLETE => 'Đã gửi',
    );
  }
}

abstract class UserTypeEnum {
  const PRINCIPAL = 0;
  const TEACHER = 1;
  const PARENTS = 2;

  public static function getArr() {
    return array(
      self::PRINCIPAL => 'Hiệu trưởng',
      self::TEACHER => 'Giáo viên',
      self::PARENTS => 'Phụ huynh',
    );
  }
}
