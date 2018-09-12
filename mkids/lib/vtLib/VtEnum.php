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
abstract class MenuTypeEnum {
  const BREAKFAST = 0;
  const LUNCH = 1;
  const DINNER = 2;

  public static function getArr() {
    return array(
      self::BREAKFAST => 'Bữa sáng',
      self::LUNCH => 'Bữa trưa',
      self::DINNER => 'Bữa chiều',
    );
  }
}
abstract class StatusEnum {
  const INACTIVE = 0;
  const ACTIVE = 1;

  public static function getArr() {
    return array(
      self::INACTIVE => 'Bị khóa',
      self::ACTIVE => 'Kích hoạt',
    );
  }
}
abstract class ActivityTypeEnum {
  const ATTENDANCE = 0;
  const ABSENCE = 1;
  const PICNIC = 2;
  const MOVEMENT = 3;
  const OPENING = 4;
  const CLOSING = 5;
  const BEGIN = 6;
  const STOP = 7;

  public static function getAttendanceArr() {
    return array(self::ATTENDANCE, self::PICNIC, self::MOVEMENT, self::OPENING, self::CLOSING, self::BEGIN);
  }

  public static function getArr(){
    return array(self::ATTENDANCE, self::ABSENCE, self::PICNIC, self::MOVEMENT, self::OPENING, self::CLOSING, self::BEGIN, self::STOP);
  }
}
abstract class ActivityHealthEnum {
  const SICK = 0;
  const NORMAL = 1;
  const STRONG = 2;

  public static function getArr(){
    return array(self::SICK, self::NORMAL, self::STRONG);
  }
}
abstract class SummaryLevelEnum {
  const POOR = 0;
  const WEAK = 1;
  const NORMAL = 2;
  const PRETTY = 3;
  const GOOD = 4;
  const EXCELLENT = 5;

  public static function getLevelArr() {
    return array(self::POOR, self::WEAK, self::NORMAL, self::PRETTY, self::GOOD, self::EXCELLENT);
  }
}

