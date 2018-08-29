<?php

/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 8/19/14
 * Time: 9:23 AM
 * To change this template use File | Settings | File Templates.
 */
class SMSUtil
{
//  const WSDL = 'http://10.58.52.23:8383/MtService/endpoints/MtRequestService.wsdl';
//  const USER = 'khanhlp';
//  const PASS = 'khanhlp';
  const SMS_SENDER = '5656';
  const SEND_SMSFLASH = 2;
  const SEND_SMSINBOX = 0;

  const REGISTER_SUCCESS = 'SMS_REGISTER_SUCCESS';//'Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - dich vu lan toa hinh anh den trieu trieu nguoi. Cam on!';
  const REGISTER_HAS_REGISTERED = 'SMS_REGISTER_HAS_REGISTERED';//'Quy khach da dang ky su dung dich vu. Cam on!';
  const REGISTER_BRAND_SUCCESS_NEW_USER = 'SMS_REGISTER_BRAND_SUCCESS_NEW_USER';
  const REGISTER_BRAND_SUCCESS = 'SMS_REGISTER_BRAND_SUCCESS';//'Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - nhan hang %brandCode% - dich vu giup lan toa hinh anh den trieu trieu nguoi. Cam on!';
  const REGISTER_BRAND_HAS_REGISTERED = 'SMS_REGISTER_BRAND_HAS_REGISTERED';//'Quy khach da dang ky su dung dich vu theo ma nhan hang %brandCode%. Cam on!';
  const REGISTER_BRAND_NEW_USER_UNREGISTERED_CRBT_SERVICE = 'SMS_REGISTER_BRAND_NEW_USER_UNREGISTERED_CRBT_SERVICE';//Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - nhan hang <ten nhan hang> (Quy khach chua dang ky dich vu nhac cho. De dang ky dich vu nhac cho soan tin DK gui 1221) . Mat khau cua Quy khach la: xxxxxx. Cam on!
  const REGISTER_BRAND_NEW_USER_INSTALL_CRBT_FAIL = 'SMS_REGISTER_BRAND_NEW_USER_INSTALL_CRBT_FAIL';//Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - nhan hang <ten nhan hang> (Khong the dang ky nhac cho quang cao) . Mat khau cua Quy khach la: xxxxxx. Cam on!';
  const REGISTER_BRAND_NEW_USER_INSTALL_CRBT_SUCCESS_AND_FAIL = 'SMS_REGISTER_BRAND_NEW_USER_INSTALL_CRBT_SUCCESS_AND_FAIL';//'Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - nhan hang <ten nhan hang> (Cac ma cai nhac cho thanh cong: %successCodes%; Cac ma cai nhac cho that bai: %failCodes%) . Mat khau cua Quy khach la: xxxxxx. Cam on!';
  const REGISTER_BRAND_NEW_USER_HAS_INSTALL_CRBT = 'SMS_REGISTER_BRAND_NEW_USER_HAS_INSTALL_CRBT';//'Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - nhan hang %brandName% (Khong the dang ky nhac cho quang cao do Nhac cho da co tren bo suu tap). Mat khau cua Quy khach la: %password%. Cam on!';
  const REGISTER_BRAND_UNREGISTERED_CRBT_SERVICE = 'SMS_REGISTER_BRAND_UNREGISTERED_CRBT_SERVICE';//'Chuc mung Quy khach da cai dat thanh cong nhan hang <ten nhan hang> (Quy khach chua dang ky dich vu nhac cho. De dang ky dich vu nhac cho soan tin DK gui 1221). Cam on!';
  const REGISTER_BRAND_INSTALL_CRBT_FAIL = 'SMS_REGISTER_BRAND_INSTALL_CRBT_FAIL';//'Chuc mung Quy khach da cai dat thanh cong nhan hang <ten nhan hang> (Khong the dang ky nhac cho quang cao). Cam on!';
  const REGISTER_BRAND_INSTALL_CRBT_SUCCESS_AND_FAIL = 'SMS_REGISTER_BRAND_INSTALL_CRBT_SUCCESS_AND_FAIL';//'Chuc mung Quy khach da cai dat thanh cong nhan hang <ten nhan hang> (Cac ma cai nhac cho thanh cong: %successCodes%; Cac ma cai nhac cho that bai: %failCodes%). Cam on!';
  const REGISTER_BRAND_HAS_INSTALL_CRBT = 'SMS_REGISTER_BRAND_HAS_INSTALL_CRBT';//'Chuc mung Quy khach da cai dat thanh cong nhan hang %brandName% (Khong the dang ky nhac cho quang cao do Nhac cho da co tren bo suu tap). Cam on!';

  const REGISTER_AVATAR_SUCCESS_NEW_USER = 'SMS_REGISTER_AVATAR_SUCCESS_NEW_USER';
  const REGISTER_AVATAR_SUCCESS = 'SMS_REGISTER_AVATAR_SUCCESS';//'Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - nganh hang %categoryCode% - dich vu giup lan toa hinh anh den trieu trieu nguoi. Cam on!';
  const REGISTER_AVATAR_HAS_REGISTERED = 'SMS_REGISTER_AVATAR_HAS_REGISTERED';//'Quy khach da dang ky su dung dich vu theo ma nganh %categoryCode%. Cam on!';
  const REGISTER_AVATAR_NEW_USER_UNREGISTERED_CRBT_SERVICE = 'SMS_REGISTER_AVATAR_NEW_USER_UNREGISTERED_CRBT_SERVICE';//'Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - avatar <ten avatar> (Quy khach chua dang ky dich vu nhac cho. De dang ky dich vu nhac cho soan tin DK gui 1221) . Mat khau cua Quy khach la: xxxxxx. Cam on!';
  const REGISTER_AVATAR_NEW_USER_INSTALL_CRBT_FAIL = 'SMS_REGISTER_AVATAR_NEW_USER_INSTALL_CRBT_FAIL';//'Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - avatar <ten avatar> (Khong the dang ky nhac cho quang cao) . Mat khau cua Quy khach la: xxxxxx. Cam on!';
  const REGISTER_AVATAR_NEW_USER_INSTALL_CRBT_SUCCESS_AND_FAIL = 'SMS_REGISTER_AVATAR_NEW_USER_INSTALL_CRBT_SUCCESS_AND_FAIL';//'Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - avatar <ten avatar> (Cac ma cai nhac cho thanh cong: %successCodes%; Cac ma cai nhac cho that bai: %failCodes%) . Mat khau cua Quy khach la: xxxxxx. Cam on!';
  const REGISTER_AVATAR_NEW_USER_HAS_INSTALL_CRBT = 'SMS_REGISTER_AVATAR_NEW_USER_HAS_INSTALL_CRBT';//'Chuc mung Quy khach da dang ky thanh cong dich vu ITSME - avatar %avatarName% (Khong the dang ky nhac cho quang cao do Nhac cho da co tren bo suu tap). Mat khau cua Quy khach la: %password%. Cam on!';
  const REGISTER_AVATAR_UNREGISTERED_CRBT_SERVICE = 'SMS_REGISTER_AVATAR_UNREGISTERED_CRBT_SERVICE';//'Chuc mung Quy khach da cai dat thanh cong avatar <ten avatar> (Quy khach chua dang ky dich vu nhac cho. De dang ky dich vu nhac cho soan tin DK gui 1221). Cam on!';
  const REGISTER_AVATAR_INSTALL_CRBT_FAIL = 'SMS_REGISTER_AVATAR_INSTALL_CRBT_FAIL';//'Chuc mung Quy khach da cai dat thanh cong avatar <ten avatar> (Khong the dang ky nhac cho quang cao). Cam on!';
  const REGISTER_AVATAR_INSTALL_CRBT_SUCCESS_AND_FAIL = 'SMS_REGISTER_AVATAR_INSTALL_CRBT_SUCCESS_AND_FAIL';//'Chuc mung Quy khach da cai dat thanh cong avatar <ten avatar> (Cac ma cai nhac cho thanh cong: %successCodes%; Cac ma cai nhac cho that bai: %failCodes%). Cam on!';
  const REGISTER_AVATAR_HAS_INSTALL_CRBT = 'SMS_REGISTER_AVATAR_HAS_INSTALL_CRBT';//'Chuc mung Quy khach da cai dat thanh cong avatar %avatarName% (Khong the dang ky nhac cho quang cao do Nhac cho da co tren bo suu tap). Cam on!';

  const CODE_NOT_EXIST = 'SMS_CODE_NOT_EXIST';//'Ma nhan hang hoac ma nganh hang khong ton tai. De biet danh sach ma nhan hang, soan MAB gui %shortcode%. De biet danh sach nganh hang, soan MAC gui %shortcode%.';
  const UNREGISTER_ALL_SUCCESS = 'SMS_UNREGISTER_ALL_SUCCESS';//'Quy khach da huy dich vu ITSME. De dang ky lai dich vu, soan DK gui %shortcode%';
  const UNREGISTER_ALL_HAS_NOT_REGISTERED = 'SMS_UNREGISTER_ALL_HAS_NOT_REGISTERED';//'Quy khach can phai huy theo tung nganh hang hoac nhan hang cu the. De biet danh sach nganh hang, soan MAC gui %shortcode%. De biet danh sach nhan hang, soan MAB gui %shortcode%';
  const UNREGISTER_BRAND_SUCCESS = 'SMS_UNREGISTER_BRAND_SUCCESS';//'Quy khach da huy hien thi nhan hang %brandCode%. De dang ky lai nganh hang, soan DKB MANHANHANG gui %shortcode%';
  const UNREGISTER_BRAND_HAS_NOT_REGISTERED = 'SMS_UNREGISTER_BRAND_HAS_NOT_REGISTERED';//'Quy khach chua dang ky nhan hang %brandCode%';
  const UNREGISTER_AVATAR_SUCCESS = 'SMS_UNREGISTER_AVATAR_SUCCESS';//'Quy khach da huy hien thi nganh hang %categoryCode%. De dang ky lai nganh hang, soan DKC MANGANH gui %shortcode%';
  const UNREGISTER_AVATAR_HAS_NOT_REGISTERED = 'SMS_UNREGISTER_AVATAR_HAS_NOT_REGISTERED';//'Quy khach chua dang ky nganh hang %categoryCode%';
  const USER_HAS_NOT_REGISTERED_YET = 'SMS_USER_HAS_NOT_REGISTERED_YET';
  const CATEGORY_LIST = 'SMS_CATEGORY_LIST';//'Nganh - ma: %replaceStr%';
  const BRAND_LIST = 'SMS_BRAND_LIST';//'Nhan hang - ma: %replaceStr%';
  const BRAND_HOT_LIST = 'SMS_BRAND_HOT_LIST';
  const AVATAR_HOT_LIST = 'SMS_AVATAR_HOT_LIST';
  const NO_AVATAR_RESULT = 'SMS_NO_AVATAR_RESULT';
  const NO_BRAND_RESULT = 'SMS_NO_BRAND_RESULT';
  const VT_GUIDE = 'SMS_GUIDE';//'%replaceStr%';
  const HAS_RECEIVED_PROMOTION = 'SMS_HAS_RECEIVED_PROMOTION';//'Quy khach khong du dieu kien nhan thuong do da cai dat avatar %brandCode% va duoc huong tang thuong tu truoc. De duoc cong 40d/1 cuoc goi hien thi avatar %brandCode%, kinh moi quy khach truy cap vao ung dung de cai dat';
  const NO_MORE_CARD_NUMBER = 'SMS_NO_MORE_CARD_NUMBER';//'Quy khach khong du dieu kien nhan thuong do so luong qua tang cua nhan hang %brandCode% da dat gioi han. De duoc cong 40d/1 cuoc goi hien thi avatar %brandCode%, kinh moi quy khach truy cap vao ung dung de cai dat';
  const APP_LINK = 'SMS_APP_LINK';//'Quy khach hay truy cap dia chi sau de tai ung dung: %appLink%';
  const LAZADA_EXPIRE_TIME_SMS = 'SMS_LAZADA_EXPIRE_TIME_SMS';//'Voucher tri gia 50.000d cua Lazada co thoi han su dung tu 16/10 den het 22/10/2014. Truy cap http://lazada.vn/viettel de su dung ngay 50.000d trong tai khoan';

  const INVITE_INSTALL_APP = 'SMS_INVITE_INSTALL_APP';//"Quy khach da duoc moi tham gia su dung dich vu ITSME, hay truy cap dia chi sau de nhan ngay HOT app: http://app.itsme.com.vn/download/itsme";
  const INVITE_INSTALL_AVATAR = 'SMS_INVITE_INSTALL_AVATAR';

  const SEND_OTP = 'SMS_SEND_OTP';//"Ma xac nhan cua ban la: %otp%";
  const NEW_PASWORD = 'SMS_NEW_PASWORD';//"Mat khau moi cua ban la: %password%";

  const INSTALL_RBT_SUCCESS = 'SMS_INSTALL_RBT_SUCCESS';//"Ban da tai thanh cong bai nhac cho %rbtName% (Ma so: %rbtCode%). Nhac cho quang cao danh cho doanh nghiep, hoan toan MIEN PHI khi dang ky tren he thong ITSME!";
  const INVALID_SYNTAX = 'SMS_INVALID_SYNTAX';

  // SMS nhac cho
  const UNREGISTERED_CRBT_SERVICE = 'SMS_UNREGISTERED_CRBT_SERVICE';
  const HAS_INSTALL_CRBT = 'SMS_HAS_INSTALL_CRBT';
  const AVATAR_NOT_HAVE_CRBT = 'SMS_AVATAR_NOT_HAVE_CRBT';
  const BRAND_NOT_HAVE_CRBT = 'SMS_BRAND_NOT_HAVE_CRBT';
  const INSTALL_CRBT_SUCCESS_NEW_USER = 'SMS_INSTALL_CRBT_SUCCESS_NEW_USER';
  const INSTALL_CRBT_SUCCESS = 'SMS_INSTALL_CRBT_SUCCESS';
  const INSTALL_CRBT_FAIL = 'SMS_INSTALL_CRBT_FAIL';
  const HAS_INSTALL_CRBT_BY_BRAND = 'SMS_HAS_INSTALL_CRBT_BY_BRAND';
  const INSTALL_CRBT_BY_BRAND_SUCCESS_NEW_USER = 'SMS_INSTALL_CRBT_BY_BRAND_SUCCESS_NEW_USER';
  const INSTALL_CRBT_BY_BRAND_SUCCESS = 'SMS_INSTALL_CRBT_BY_BRAND_SUCCESS';
  const INSTALL_CRBT_BY_BRAND_FAIL = 'SMS_INSTALL_CRBT_BY_BRAND_FAIL';
  const INSTALL_CRBT_SUCCESS_AND_FAIL = 'SMS_INSTALL_CRBT_SUCCESS_AND_FAIL';
  const INSTALL_CRBT_SUCCESS_AND_FAIL_NEW_USER = 'SMS_INSTALL_CRBT_SUCCESS_AND_FAIL_NEW_USER';

  const WEB_INSTALL_AVATAR_SUCCESS = 'SMS_WEB_INSTALL_AVATAR_SUCCESS';

  const ADD_DATA_INVITER_SUCCESS = 'SMS_ADD_DATA_INVITER_SUCCESS';
  const ADD_DATA_UNREGISTERED_3G = 'SMS_ADD_DATA_UNREGISTERED_3G';
  const ADD_DATA_UNDEFINED_PACKAGE = 'SMS_ADD_DATA_UNDEFINED_PACKAGE';
  const ADD_DATA_UNKNOWN_ERROR = 'SMS_ADD_DATA_UNKNOWN_ERROR';
  const ADD_DATA_INVITERS_MISSING = 'SMS_ADD_DATA_INVITERS_MISSING';
  const ADD_DATA_LATER_INVITERS = 'SMS_ADD_DATA_LATER_INVITERS';

  const REGISTER_SUCCESS_PROMOTION = 'SMS_REGISTER_SUCCESS_PROMOTION';
  const REGISTER_SUCCESS_DATA_PROMOTION = 'SMS_REGISTER_SUCCESS_DATA_PROMOTION';

  // Insert MT
  public static function insertMT($sender, $receiver, $content)
  {
    VtHelper::writeLogValue('Begin send insertMT | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
    $params = array(
      'User' => sfConfig::get('app_sms_user'),
      'Password' => sfConfig::get('app_sms_pass'),
      'sender' => $sender,
      'isdn' => VtXCodeHelper::getMobileNumber($receiver, VtXCodeHelper::MOBILE_NOTPREFIX),
      'content' => $content
    );
    try {
      $soapClient = new SoapClient(sfConfig::get('app_sms_wsdl'));
      $res = $soapClient->__soapCall('InsertMt', array($params));
      VtHelper::writeLogValue('send SMS success | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
      return $res->return;
    } catch (Exception $e) {
      VtHelper::writeLogValue('send insertMT fail | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content . ' | error = ' . $e->getMessage());
      return -1;
    }
  }

  // Insert MT
  public static function insertMTFlash($sender, $receiver, $content)
  {
    VtHelper::writeLogValue('Begin send insertMTFlash | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
    $params = array(
      'User' => sfConfig::get('app_sms_user'),
      'Password' => sfConfig::get('app_sms_pass'),
      'sender' => $sender,
      'isdn' => VtXCodeHelper::getMobileNumber($receiver, VtXCodeHelper::MOBILE_NOTPREFIX),
//      'content' => "<![CDATA[" . $content . "]]>",
      'content' => $content,
      'contentType' => self::SEND_SMSFLASH
    );
    try {
      $soapClient = new SoapClient(sfConfig::get('app_sms_wsdl'));
      $res = $soapClient->__soapCall('InsertFlashMt', array($params));
      VtHelper::writeLogValue('send insertMTFlash success | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
      return $res->return;
    } catch (Exception $e) {
      VtHelper::writeLogValue('send insertMTFlash fail | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content . ' | error = ' . $e->getMessage());
      return -1;
    }
  }

  // Insert MT
  public static function insertMTInbox($sender, $receiver, $content)
  {
    VtHelper::writeLogValue('Begin send insertMTInbox | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
    $params = array(
      'User' => sfConfig::get('app_sms_user'),
      'Password' => sfConfig::get('app_sms_pass'),
      'sender' => $sender,
      'isdn' => VtXCodeHelper::getMobileNumber($receiver, VtXCodeHelper::MOBILE_NOTPREFIX),
//      'content' => '<![CDATA[' . $content . ']]>',
      'content' => $content,
      'contentType' => self::SEND_SMSINBOX
    );
    try {
      $soapClient = new SoapClient(sfConfig::get('app_sms_wsdl'));
      $res = $soapClient->__soapCall('InsertFlashMt', array($params));
      VtHelper::writeLogValue('send insertMTInbox success | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
      return $res->return;
    } catch (Exception $e) {
      VtHelper::writeLogValue('send insertMTInbox fail | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content . ' | error = ' . $e->getMessage());
      return -1;
    }
  }

  // Insert MT
  public static function insertMTWithBlacklist($sender, $receiver, $content)
  {
    VtHelper::writeLogValue('Begin send insertMT | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
    if (!VtBlacklistTable::inTextBlacklist($receiver)) {
      $params = array(
        'User' => sfConfig::get('app_sms_user'),
        'Password' => sfConfig::get('app_sms_pass'),
        'sender' => $sender,
        'isdn' => VtXCodeHelper::getMobileNumber($receiver, VtXCodeHelper::MOBILE_NOTPREFIX),
        'content' => $content
      );
      try {
        $soapClient = new SoapClient(sfConfig::get('app_sms_wsdl'));
        $res = $soapClient->__soapCall('InsertMt', array($params));
        VtHelper::writeLogValue('send SMS success | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
        return $res->return;
      } catch (Exception $e) {
        VtHelper::writeLogValue('send insertMT fail | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content . ' | error = ' . $e->getMessage());
        return -1;
      }
    }
    VtHelper::writeLogValue('insertMT fail, receiver is in blacklist | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
  }

  // Insert MT
  public static function insertMTFlashWithBlacklist($sender, $receiver, $content)
  {
    VtHelper::writeLogValue('Begin send insertMTFlash | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
    if (!VtBlacklistTable::inTextBlacklist($receiver)) {
      $params = array(
        'User' => sfConfig::get('app_sms_user'),
        'Password' => sfConfig::get('app_sms_pass'),
        'sender' => $sender,
        'isdn' => VtXCodeHelper::getMobileNumber($receiver, VtXCodeHelper::MOBILE_NOTPREFIX),
//      'content' => "<![CDATA[" . $content . "]]>",
        'content' => $content,
        'contentType' => self::SEND_SMSFLASH
      );
      try {
        $soapClient = new SoapClient(sfConfig::get('app_sms_wsdl'));
        $res = $soapClient->__soapCall('InsertFlashMt', array($params));
        VtHelper::writeLogValue('send insertMTFlash success | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
        return $res->return;
      } catch (Exception $e) {
        VtHelper::writeLogValue('send insertMTFlash fail | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content . ' | error = ' . $e->getMessage());
        return -1;
      }
    }
    VtHelper::writeLogValue('insertMTFlash fail, receiver is in blacklist | sender = ' . $sender . ' | receiver = ' . $receiver . ' | content = ' . $content);
  }
}