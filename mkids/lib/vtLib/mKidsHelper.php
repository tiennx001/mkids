<?php

/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 7/25/14
 * Time: 4:56 PM
 * To change this template use File | Settings | File Templates.
 */
class mKidsHelper
{

  const MOBILE_SIMPLE = '09x';
  const MOBILE_GLOBAL = '849x';
  const MOBILE_NOTPREFIX = '9x';
  const PHONE_NUMBER_PATTERN = '/^(0|84)+(9\d{8}|1\d{9})$/'; // So dien thoai
  const REGEX_EMAIL = '/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i'; // Email

  public static function getMobileNumber($msisdn, $type = self::MOBILE_SIMPLE, $trim = true)
  {
    if ($trim) {
      $msisdn = trim($msisdn);
    }

    //loai bo so + dau tien doi voi dinh dang +84
    if ($msisdn[0] == '+') {
      $msisdn = substr($msisdn, 1);
    }

    switch ($type) {
      case self::MOBILE_GLOBAL:
        if ($msisdn[0] == '0')
          return '84' . substr($msisdn, 1);
        else if ($msisdn[0] . $msisdn[1] != '84')
          return '84' . $msisdn;
        else
          return $msisdn;
        break;
      case self::MOBILE_SIMPLE:
        if ($msisdn[0] . $msisdn[1] == '84')
          return '0' . substr($msisdn, 2);
        else if ($msisdn[0] != '0')
          return '0' . $msisdn;
        else
          return $msisdn;
        break;
      case self::MOBILE_NOTPREFIX:
        if ($msisdn[0] == '0')
          return substr($msisdn, 1);
        else if ($msisdn[0] . $msisdn[1] == '84')
          return substr($msisdn, 2);
        else
          return $msisdn;
        break;
    }
  }

  /**
   * Kiểm tra số điện thoại theo pattern
   *
   * @param $phone
   * @param $trim
   * @return boolean
   * @created_at 5/13/14 10:41 AM
   *
   */
  public static function isPhoneNumber($number, $trim = true)
  {
    $pattern = self::PHONE_NUMBER_PATTERN;
    if ($trim) {
      $phone = trim($number);
    }
    return preg_match($pattern, $number);
  }

  /**
   * Kiểm tra email theo pattern
   *
   * @param $email
   * @param $trim
   * @return boolean
   * @created_at 5/13/14 10:41 AM
   *
   */
  public static function isEmail($email, $trim = true)
  {
    $pattern = self::REGEX_EMAIL;
    if ($trim) {
      $email = trim($email);
    }
    return preg_match($pattern, $email);
  }

  /**
   * Lay link anh thumbnail<br />
   * Vi du su dung:<br />
   * <img src="<?php VtHelper::getThumbUrl('/medias/huypv/2011/06/15/abc.jpg', 90, 60); ?>" />
   * @param string $source /medias/huypv/2011/06/15/abc.jpg (nam trong thu muc web!)
   * @author huypv
   * @param int $width
   * @param int $height
   * * @param int $type
   * @return string /medias/huypv/2011/06/15/thumbs/abc_90_60.jpg
   */
  public static function getThumbUrl($source, $width = null, $height = null, $type = '')
  {
    switch ($type) {
      case 'app':
        $defaultImage = sfConfig::get('app_app_url_media_default_image');
        break;
      default:
        $defaultImage = sfConfig::get('app_url_media_default_image');
    }

    if ($width == null && $height == null)
      return (is_file(sfConfig::get('sf_web_dir') . $source)) ? $source : $defaultImage;

    if (empty($source)) {
      $source = $defaultImage;
    }
    $mediasDir = sfConfig::get('sf_web_dir');

    $fullPath = $mediasDir . $source;
    $pos = strrpos($source, '/');
    if ($pos !== false) {
      $filename = substr($source, $pos + 1);

      $app = sfContext::getInstance()->getConfiguration()->getApplication();
      switch ($app) {
        default:
          $dir = '/cache/' . substr($source, 1, $pos);
      }
    } else {
      return $defaultImage;
      #return false;
    }

    $pos = strrpos($filename, '.');
    if ($pos !== false) {
      $basename = substr($filename, 0, $pos);
      $extension = substr($filename, $pos + 1);

      if (strtolower($extension) == 'bmp') {
        $fullPath = VtBmpImageConvert::ImageCreateFromBmp(sfConfig::get('sf_web_dir') . $source);
        $extension = 'jpg';
      }
    } else {
      return $defaultImage;
    }

    if ($width == null) {
      $thumbName = $basename . '_auto_' . $height . '.' . $extension;
    } else if ($height == null) {
      $thumbName = $basename . '_' . $width . '_auto.' . $extension;
    } else {
      $thumbName = $basename . '_' . $width . '_' . $height . '.' . $extension;
    }

    $fullThumbPath = $mediasDir . $dir . $thumbName;

    # Neu thumbnail da ton tai roi thi khong can generate
    if (file_exists($fullThumbPath)) {
      return $dir . $thumbName;
    }

    # Neu thumbnail chua ton tai thi su dung plugin de tao ra
    $scale = ($width != null && $height != null) ? false : true;
    $thumbnail = new sfThumbnail($width, $height, $scale, true, 100);
    if (!is_file($fullPath)) {
      return $defaultImage;
    }
    $thumbnail->loadFile($fullPath);

    if (!is_dir($mediasDir . $dir))
      mkdir($mediasDir . $dir, 0777, true);
    $thumbnail->save($fullThumbPath, 'image/jpeg');
    return (file_exists(sfConfig::get('sf_web_dir') . $dir . $thumbName)) ? $dir . $thumbName : $defaultImage;
  }

  // Tiennx6 - Ham chuyen doi base64 sang image
  public static function base64_to_jpeg($base64_string, $output_file)
  {
    try {
      $ifp = fopen($output_file, "wb");
      self::fwrite_stream($ifp, base64_decode($base64_string));
      fclose($ifp);
    } catch (Exception $e) {
      throw new Exception('Cannot write image data to file. Error = ' . $e->getMessage());
    }

    return $output_file;
  }

  // BROKEN function - infinite loop when fwrite() returns 0s
  private static function fwrite_stream($fp, $string)
  {
    for ($written = 0; $written < strlen($string); $written += $fwrite) {
      $fwrite = fwrite($fp, substr($string, $written));
      if ($fwrite === false) {
        return $written;
      }
    }
    return $written;
  }

  /**
   * Them is_follow vao doi tuong nganh hang, nhan hang
   *
   * @author Tiennx6
   * @since 13/08/2014
   * @param $array
   * @param $inArray
   * @param $key
   * @return mixed
   * @return mixed
   */
  public static function addIndexToArray($array, $inArray, $key = 'is_follow')
  {
    $newArr = array();

    if (count($array)) {
      if (count($array) != count($array, COUNT_RECURSIVE)) {
        foreach ($array as $k => $el) {
          if (in_array($el['id'], $inArray))
            $newArr[$k] = $el + array($key => 1);
          else
            $newArr[$k] = $el + array($key => 0);
        }
      } else {
        if (in_array($array['id'], $inArray))
          $newArr = array_merge($array, array($key => 1));
        else
          $newArr = array_merge($array, array($key => 0));
      }
    }

    return $newArr;
  }

  /**
   * Them cac child element vao nhan hang
   *
   * @author Tiennx6
   * @since 13/08/2014
   * @param $array
   * @param $allArray
   * @return mixed
   */
  public static function addBrandsChildElements($array, $allArray)
  {
    $arr = array();
    foreach ($array as $el) {
      $newArr = array();
      foreach ($allArray as $newEl) {
        if ($newEl['cId'] == $el['id'] || $newEl['parentId'] == $el['id']) {
          unset($newEl['parentId'], $newEl['cId']);
          $newArr[] = $newEl;
        }
      }
      unset($el['cId']);
      if (count($newArr)) {
        $mod = self::setParentIsFollow($el, $newArr);
        $arr[] = $mod + array('childs' => $newArr);
      }
    }
    return $arr;
  }

  /**
   * Them cac child element vao nganh hang
   *
   * @author Tiennx6
   * @since 13/08/2014
   * @param $array
   * @param $allArray
   * @return mixed
   */
  public static function addCategoriesChildElements($array, $allArray)
  {
    $arr = array();
    foreach ($array as $el) {
      $newArr = array();
      foreach ($allArray as $newEl) {
        if ($newEl['parent_id'] == $el['id']) {
          unset($newEl['parent_id']);
          $newArr[] = $newEl;
        }
      }
      $arr[] = $el + array('childs' => $newArr);
    }
    return $arr;
  }

  /**
   * Neu da follow cac nhan hang con -> set follow nhan hang cha
   *
   * @author Tiennx6
   * @since 29/10/2014
   */
  private static function setParentIsFollow($parent, $childs)
  {
    $flag = false;
    $parent = $parent + array('is_follow' => 0);
    foreach ($childs as $e) {
      if ($e['is_follow'] == 0) {
        $flag = true;
        break;
      }
    }
    if (!$flag)
      $parent['is_follow'] = 1;
    return $parent;
  }

  /**
   * Xử lý dữ liệu trong đối tượng Campaign
   *
   * @author Tiennx6
   * @created on 28/07/2014
   * @param $avatars
   * @param $userId
   * @param $regAvatars
   * @param $followAvatars
   * @param $imageConfig
   * @param $showShortNumber
   * @return array
   */
  public static function processAvatarObject($avatars, $userId = null, $regAvatars = false, $followAvatars = false, $imageConfig = array(), $showShortNumber = true)
  {
    $dataArr = array();
    // Kiem tra xem avatar da duoc cai dat hoac like hay chua
    if ($userId) {
      if ($regAvatars === false)
        $regAvatars = VtUserAvatarTable::getInstance()->getRegisteredAvatars($userId);

      if ($followAvatars === false)
        $followAvatars = VtAvatarLikeTable::getInstance()->getLikeAvatarIds($userId);

      $avatars = self::addIndexToArray($avatars, $regAvatars, 'is_install');
      $avatars = self::addIndexToArray($avatars, $followAvatars, 'is_like');
    }

    // Kiem tra xem avatar co thuong hay khong
    $bonusAvatars = VtPromotionConfigTable::getInstance()->getBonusAvatars();
    $avatars = self::addIndexToArray($avatars, $bonusAvatars, 'is_bonus');

    $avatarWith = null;
    $avatarHeight = null;
    $brandWith = null;
    $brandHeight = null;
    if (count($imageConfig)) {
      $avatarWith = $imageConfig['avatar_with'];
      $avatarHeight = $imageConfig['avatar_height'];
      $brandWith = $imageConfig['brand_with'];
      $brandHeight = $imageConfig['brand_height'];
    }

    // Neu la mang 2 chieu
    if (count($avatars) != count($avatars, COUNT_RECURSIVE)) {
      foreach ($avatars as $ava) {
        // Duong dan tuyet doi
        if (isset($ava['avatar_url'])) {
          $ava['avatar_url'] = sfConfig::get('app_server_path') . VtHelper::getThumbUrl($ava['avatar_url'], $avatarWith, $avatarHeight);
        }
        if (isset($ava['label_avatar_url'])) {
          $ava['label_avatar_url'] = sfConfig::get('app_server_path') . VtHelper::getThumbUrl($ava['label_avatar_url'], $brandWith, $brandHeight);
        }
        if ($showShortNumber) {
          if (isset($ava['scores'])) {
            $ava['scores'] = VtXCodeHelper::getShortNumber($ava['scores']);
          }
          if (isset($ava['num_install'])) {
            $ava['num_install'] = VtXCodeHelper::getShortNumber($ava['num_install']);
          }
          if (isset($ava['num_view'])) {
            $ava['num_view'] = VtXCodeHelper::getShortNumber($ava['num_view']);
          }
          if (isset($ava['num_like'])) {
            $ava['num_like'] = VtXCodeHelper::getShortNumber($ava['num_like']);
          }
          if (isset($ava['num_comment'])) {
            $ava['num_comment'] = VtXCodeHelper::getShortNumber($ava['num_comment']);
          }
          if (isset($ava['num_share'])) {
            $ava['num_share'] = VtXCodeHelper::getShortNumber($ava['num_share']);
          }
          if (isset($ava['num_show'])) {
            $ava['num_show'] = VtXCodeHelper::getShortNumber($ava['num_show']);
          }
        }

        if (isset($ava['crbt_content'])) {
          $crbtData = explode('|', $ava['crbt_content']);
          if (count($crbtData) >= 2) {
            $ava['has_crbt'] = true;
            $ava['crbt_name'] = isset($crbtData[0]) ? $crbtData[0] : '';
            $ava['crbt_code'] = isset($crbtData[1]) ? $crbtData[1] : '';
            $ava['crbt_file'] = isset($crbtData[2]) ? $crbtData[2] : '';
          }
        }


        $dataArr[] = $ava;
      }
    } else {
      // Duong dan tuyet doi
      if (isset($avatars['avatar_url'])) {
        $avatars['avatar_url'] = sfConfig::get('app_server_path') . VtHelper::getThumbUrl($avatars['avatar_url'], $avatarWith, $avatarHeight);
      }
      if (isset($avatars['label_avatar_url'])) {
        $avatars['label_avatar_url'] = sfConfig::get('app_server_path') . VtHelper::getThumbUrl($avatars['label_avatar_url'], $brandWith, $brandHeight);
      }
      if ($showShortNumber) {
        if (isset($avatars['scores'])) {
          $avatars['scores'] = VtXCodeHelper::getShortNumber($avatars['scores']);
        }
        if (isset($avatars['num_install'])) {
          $avatars['num_install'] = VtXCodeHelper::getShortNumber($avatars['num_install']);
        }
        if (isset($avatars['num_view'])) {
          $avatars['num_view'] = VtXCodeHelper::getShortNumber($avatars['num_view']);
        }
        if (isset($avatars['num_like'])) {
          $avatars['num_like'] = VtXCodeHelper::getShortNumber($avatars['num_like']);
        }
        if (isset($avatars['num_comment'])) {
          $avatars['num_comment'] = VtXCodeHelper::getShortNumber($avatars['num_comment']);
        }
        if (isset($avatars['num_share'])) {
          $avatars['num_share'] = VtXCodeHelper::getShortNumber($avatars['num_share']);
        }
        if (isset($avatars['num_show'])) {
          $avatars['num_show'] = VtXCodeHelper::getShortNumber($avatars['num_show']);
        }
      }

      if (isset($avatars['crbt_content'])) {
        $crbtData = explode('|', $avatars['crbt_content']);
        if (count($crbtData) >= 2) {
          $avatars['has_crbt'] = true;
          $avatars['crbt_name'] = isset($crbtData[0]) ? $crbtData[0] : '';
          $avatars['crbt_code'] = isset($crbtData[1]) ? $crbtData[1] : '';
          $avatars['crbt_file'] = isset($crbtData[2]) ? $crbtData[2] : '';
        }
      }
      $dataArr = $avatars;
    }
    return $dataArr;
  }

  /**
   * Ham tra ve cac thiet lap cua he thong
   * @author NamDT5
   * @created on Apr 21, 2011
   * @param $key - Key hoac 1 mang cac key can lay. Neu = null -> lay tat ca thiet lap he thong
   * @return array hoac string
   */
  public static function getSystemSetting($key = null, $useCache = true, $default = null)
  {
    if ($useCache) {
      $cache = new sfFileCache(array('cache_dir' => sfConfig::get('sf_cache_dir') . '/function'));
      $cache->setOption('lifetime', 86400);
      $fc = new sfFunctionCache($cache);
      $result = $fc->call('IContactHelper::getSystemSetting', array('key' => $key, 'useCache' => false));
      return $result != null ? $result : $default;
    }

    $result = array();
    $query = TblSettingTable::getInstance()->createQuery()->select('name, value');
    $fetchOne = false;

    if (!empty($key)) {
      if (is_array($key)) {
        $query = $query->andWhereIn('name', $key);
      } else if (is_string($key)) {
        $query = $query->andWhere('name = ?', $key);
        $fetchOne = true;
      }
    }

    $pixConfig = $query->fetchArray();

    if (count($pixConfig)) {
// Tra ve gia tri cua 1 config
      if ($fetchOne)
        return $pixConfig[0]['value'];
// Tra ve 1 mang cac config
      foreach ($pixConfig as $config) {
        $result[$config['name']] = $config['value'];
      }
    } else
      return $default;
    return $result;
  }

  /**
   * Ham tra ve hien thi chu so dang ngan gon
   *
   * @author Tiennx6
   * @since 15/09/2014
   * @param $number
   * @return string
   */
  public static function getShortNumber($number)
  {
    $k = floor($number / 1000);
    $m = floor($number / 1000000);
    $b = floor($number / 1000000000);
    if ($k > 0 && $k < 1000) {
      return $k . 'k';
    }
    if ($m > 0 && $m < 1000) {
      return $m . 'm';
    }
    if ($b > 0) {
      return $b . 'b';
    }
    return $number;
  }

  /**
   * Ham generate ma ung dung theo CP ID
   * Neu chon nha cung cap khac ==> generate lai ma ung dung
   * @author HuyNT74
   * @modifier Tiennx6
   * @created on 15/08/2012
   * @param int $newCpId
   * @param int $oldCpId
   * @return string
   */
  public static function generateCodeByCpId($brandId)
  {
    $brandCode = VtBrandTable::getInstance()->getBrandCodeById($brandId);
    $lastestNumber = VtAvatarTable::getInstance()->getLastestCodeByBrandCode($brandCode);

    if ($lastestNumber) {
      // Da co ung dung
      $avatarCodeNumber = $lastestNumber + 1;
      $avatarCode = $brandCode . $avatarCodeNumber;
    } else {
      // Chua co ung dung nao
      $avatarCode = $brandCode . '1';
    }

    return $avatarCode;
  }

  /**
   * Ham tao tai khoan random
   *
   * @author Tiennx6
   * @param $number
   * @param $randomPass
   * @param $type
   * @param $imagePath
   * @param $addBalance
   * @since 05/09/2014
   * @return mixed
   */
  public static function createRandomAccount($number, $randomPass, $type = '', $imagePath = null, $addBalance = false)
  {
    $number = self::getMobileNumber($number, self::MOBILE_GLOBAL);
    // Dang ky tai khoan
    $salt = md5(rand(100000, 999999) . $number);
    $password = sha1($salt . $randomPass);

    try {
      $imgPath = $imagePath ? $imagePath : sfConfig::get('app_default_user_image_url');
      $vtUser = new VtUser();
      $vtUser->setMsisdn($number);
      $vtUser->setImagePath($imgPath);
      $vtUser->setStatus(1);
      $vtUser->setSalt($salt);
      $vtUser->setPassword($password);
      $vtUser->setLastUpdate(date('Y-m-d H:i:s'));
      $vtUser->save();

      // Insert log
      $log = new Log($vtUser->getId(), Log::REGISTER_ACTION, Log::SUCCESS_RESULT, null, null);
      $log->save();

      // Dang ky callbase
      $params = array(
        'msisdn' => VtXCodeHelper::getMobileNumber($number, VtXCodeHelper::MOBILE_NOTPREFIX),
        'reserved' => callbaseService::REGISTER_COMMAND
      );
      $cb = new callbaseService($params);
      $cb->call();

      if ($addBalance) {
        // Cong tien tai khoan
        $provisioning = new ProvisioningUtils();
        $balance = sfConfig::get('app_promotion_balance_to_add', 5000);
        $partyCode = sfConfig::get('app_register_account_party_code');
        $provisioning->addBalance($vtUser->getMsisdn(), $balance, $partyCode, ProvisioningUtils::DEFAULT_ACC_TYPE, ProvisioningUtils::DEFAULT_DAY, $type);
      }

      return $vtUser;
    } catch (Exception $e) {
      return null;
    }
  }


  /**
   * Kiem tra so dien thoai co duoc quyen xem cac avatar chua duoc phe duyet hay khong
   *
   * @author Tiennx6
   * @since 25/11/2014
   * @param $number
   * @return boolean
   */
  public static function isPreviewNumber($number)
  {
    $previewKey = sfConfig::get('app_preview_list_key');
    $phones = self::getSystemSetting($previewKey);
    $phoneArr = explode(';', $phones);
    $inArr1 = in_array(self::getMobileNumber($number, self::MOBILE_GLOBAL), $phoneArr);
    $inArr2 = in_array(self::getMobileNumber($number, self::MOBILE_NOTPREFIX), $phoneArr);
    $inArr3 = in_array(self::getMobileNumber($number, self::MOBILE_SIMPLE), $phoneArr);
    if (is_array($phoneArr)) {
      if ($inArr1 || $inArr2 || $inArr3) {
        return true;
      }
    }
    return false;
  }

  // Convert array to object
  public static function convertArray2Object($array)
  {
    $object = new stdClass();
    foreach ($array as $key => $value) {
      $object->$key = $value;
    }
    return $object;
  }

  public static function addOwnerNameToArray($array, $inArray)
  {
    $resultArr = array();
    $listUser = array();
    if (count($inArray))
      //lay thong tin nguoi tao
      $listUser = VtUserTable::getUserByIds($inArray)->toKeyValueArray('id', 'name');
    foreach ($array as $data) {
      if (in_array($data['owner_id'], array_keys($listUser))) {
        $data['owner_name'] = $listUser[$data['owner_id']] ? $listUser[$data['owner_id']] : "IT'S ME USER";
      } else {
        $data['owner_name'] = "IT'S ME USER";
      }

      $resultArr[] = $data;
    }

    return $resultArr;
  }

  /**
   * Ham tra ve so tuan hien tai tinh tu khi bat dau cuoc thi
   * @author anhbhv
   * @param $date
   * @param string $type
   * @return float
   */
  public static function getWeekEventByDate($date)
  {
    $startDateEvent = '2015-03-28 00:00:00';
    $endDateEvent = ($date > '2015-05-15 23:59:59') ? '2015-05-15 23:59:59' : $date;
    $datetime1 = new DateTime($startDateEvent);
    $datetime2 = new DateTime($endDateEvent);
    $dateRange = $datetime1->diff($datetime2)->format("%a");
    $week = ceil(($dateRange + 1) / 7);
    return (int)$week;
  }

  /**
   * Ham tra ve so thang tinh tu khi bat dau cuoc thi
   * @author anhbhv
   * @param $date
   * @return float
   */
  public static function getMonthEventByDate($date)
  {
    $startDateEvent = '2015-03-28';
    $datetime1 = new DateTime($startDateEvent);
    $datetime2 = new DateTime($date);
    if ($datetime1 <= $datetime2) {
      $monthRange = ($datetime2->format('n') + (12 * ($datetime2->format('Y') - $datetime1->format('Y')))) - $datetime1->format('n');
      $month = ($datetime2->format('j') >= $datetime1->format('j')) ? ($monthRange + 1) : $monthRange;
    } else {
      $month = 0;
    }

    return $month;
  }

  /**
   * @author anhbhv
   * @created on 10/04/2015
   * Ham lay ngay bat dau va ngay ket thuc cua tuan
   * @param $week
   * @return array
   */
  public static function getStarEndDateByWeek($week)
  {
    $start = strtotime('2015-03-28');
    if ($week > 1)
      $start = strtotime("+" . ($week - 1) . " week", $start);
    $end = strtotime("+6 days", $start);
    return array('start' => date('d/m', $start), 'end' => date('d/m', $end));
  }

  public static function getCurrentWeekEventByDate()
  {
    return self::getWeekEventByDate(date('Y-m-d'));
  }

  public static function getCurrentMonthEventByDate()
  {
    return self::getMonthEventByDate(date('Y-m-d'));
  }

  public static function downloadFile($file, $fileName = '')
  {
    $fileName = $fileName ? $fileName : basename($file);
    if (file_exists($file)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . $fileName);
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file));
      readfile($file);
      exit;
    }
    return false;
  }

  public static function displayAuthor($name, $phone, $truncateLength = 20)
  {
    $i18n = sfContext::getInstance()->getI18N();
    if ($name)
      $name = $truncateLength ? VtHelper::truncate($name, $truncateLength) : VtHelper::encodeOutput($name);
    else
      $name = VtHelper::hidePhonenumber(VtXCodeHelper::getMobileNumber($phone, VtXCodeHelper::MOBILE_SIMPLE), 3);
    return $i18n->__('Tác giả: %name%', array('%name%' => $name));
  }

  /**
   * Ham tra ve cho API thong tin cap nhat version app
   *
   * @author Tiennx6
   * @since 04/10/2015
   * @param $appType
   * @param $appVersion
   * @return mixed
   */
  public static function returnAppVersion($appType, $appVersion)
  {
    if (!$appType) {
      $value = TblSettingTable::getInstance()->getKey('VERSION_ANDROID_APP');
      $value = explode('|', $value);
      $res['is_update'] = 0;
      $res['type'] = 0;
      if (is_array($value)) {
        $version = $value[1];
        if ($version > $appVersion) {
          $res['is_update'] = 1;
          $requiredUpdateVer = $value[0];
          if ($requiredUpdateVer > $appVersion) {
            $res['type'] = 1;
          }
        }
      }
    } else {
      $value = TblSettingTable::getInstance()->getKey('VERSION_IOS_APP');
      $value = explode('|', $value);
      $res['is_update'] = 0;
      $res['type'] = 0;
      if (is_array($value)) {
        $version = $value[1];
        if ($version > $appVersion) {
          $res['is_update'] = 1;
          $requiredUpdateVer = $value[0];
          if ($requiredUpdateVer > $appVersion) {
            $res['type'] = 1;
          }
        }
      }
    }
    return $res;
  }

  public static function sendEmail($from, $to, $subject, $body)
  {
    $mailer = sfContext::getInstance()->getMailer();
    $compose = $mailer->compose($from, $to, $subject, $body);
    $result = $mailer->send($compose);
    sfContext::getInstance()->getLogger()->info('Email send -> ' . $result);
  }

  // Ham chuyen doi array sang dang key va chuoi value ngan cach bang ky tu
  public static function toKeyValueDelimiter($array, $key, $value, $delimiter = ';')
  {
    $newArray = array();
    foreach ($array as $e) {
      if (array_key_exists($e[$key], $newArray)) {
        $newArray[$e[$key]] .= $delimiter . $e[$value];
      } else {
        $newArray[$e[$key]] = $e[$value];
      }
    }
    return $newArray;
  }
}