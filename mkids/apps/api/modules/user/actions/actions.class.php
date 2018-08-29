<?php

/**
 * user actions.
 *
 * @package    xcode
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  /**
   * Ham dang ky tai khoan
   *
   * @author Tiennx6
   * @since 27/12/2015
   * @param sfWebRequest $request
   * @return mixed
   */
  public function executeRegister(sfWebRequest $request)
  {
    if (!$request->isMethod($request::POST)) {
      $errorCode = defaultErrorCode::METHOD_NOT_ALLOWED;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $email = $request->getPostParameter('email', null);
    $pass = $request->getPostParameter('password', null);
    $number = $request->getPostParameter('phone_number', null);
    if (!$email || !$number || !$pass) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if (!IContactHelper::isPhoneNumber($number)) {
      $errorCode = UserErrorCode::INVALID_PHONE_NUMBER;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    // Kiem tra mat khau manh
    $form = new PasswordForm();
    $number = IContactHelper::getMobileNumber($number, IContactHelper::MOBILE_GLOBAL);
    $values['email'] = $email;
    $values['msisdn'] = $number;
    $values['password'] = $pass;
    $form->bind($values);
    if ($form->isValid()) {
      // Tao va gui ma xac nhan
      $optCode = mt_rand(100000, 999999);
      try {
        $obj = TblOtpTable::getInstance()->findOneBy('account', $email);
        if (!$obj) {
          $obj = new TblOtp();
          $obj->setAccount($email);
        }
        $obj->setOtp($optCode);
        $obj->setExpiredTime(date('Y-m-d H:i:s', time() + sfConfig::get('app_otp_expired', 3600)));
        $obj->save();
        VtHelper::writeLogValue('Create otp success | Email = ' . $email . ' | number = ' . $number . ' | value = ' . $optCode);
        // Gui email
        $myEmail = sfConfig::get('app_administrator_email');
        $subject = IContactHelper::getSystemSetting('EMAIL_GET_OTP_SUBJECT');
        $body = str_replace('%otp%', $optCode, IContactHelper::getSystemSetting('EMAIL_GET_OTP_BODY'));
        IContactHelper::sendEmail($myEmail, $email, $subject, $body);
      } catch (Exception $e) {
        VtHelper::writeLogValue('Create otp fail | Email = ' . $email . ' | number = ' . $number . ' | value = ' . $optCode . ' | error = ' . $e->getMessage());
        $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
        $message = defaultErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } else {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham xac thuc ma xac nhan
   *
   * @author Tiennx6
   * @since 27/12/2015
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeOtpVerification(sfWebRequest $request)
  {
    if (!$request->isMethod($request::POST)) {
      $errorCode = defaultErrorCode::METHOD_NOT_ALLOWED;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $email = $request->getPostParameter('email', null);
    $number = $request->getPostParameter('phone_number', null);
    $pass = $request->getPostParameter('password', null);
    $otp = $request->getPostParameter('key_code', null);
    $osType = $request->getPostParameter('os_type', 0);
    if (!$email || !$number || !$pass || !$otp) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if (!IContactHelper::isPhoneNumber($number)) {
      $errorCode = UserErrorCode::INVALID_PHONE_NUMBER;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    // Kiem tra mat khau manh
    $form = new PasswordForm();
    $number = IContactHelper::getMobileNumber($number, IContactHelper::MOBILE_GLOBAL);
    $values['email'] = $email;
    $values['msisdn'] = $number;
    $values['password'] = $pass;
    $form->bind($values);
    if ($form->isValid()) {
      $otpObj = TblOtpTable::getInstance()->getOtp($email);
      if ($otpObj) {
        if ($otpObj->checkOtp($otp)) {
          if ($otpObj->getIsLock()) {
            $timeLock = time() - 600;
            if ($otpObj->getLockTime() >= $timeLock) {
              $errorCode = UserErrorCode::ACCOUNT_HAS_BEEN_BLOCKED;
              $message = UserErrorCode::getMessage($errorCode);
              $jsonObj = new jsonObject($errorCode, $message);
              return $this->renderText($jsonObj->toJson());
            }
            // Unlock for user
            TblOtpTable::getInstance()->setUnLockUser($email);
          }

          // Reset VtUserSigninLock
          TblUserSigninLogTable::getInstance()->resetUserSigninLock($number);

          try {
            $form->save();
          } catch (Doctrine_Validator_Exception $e) {
            $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
            $message = defaultErrorCode::getMessage($errorCode);
            $jsonObj = new jsonObject($errorCode, $message);
            return $this->renderText($jsonObj->toJson());
          }

          // Tao token
          $tokenPair = userHelper::generateToken($email, $osType);
          $token = $tokenPair['token'];

          $errorCode = UserErrorCode::SUCCESS;
          $message = UserErrorCode::getMessage($errorCode);
          $jsonObj = new jsonObject($errorCode, $message, $token, array('phone' => $number));
          return $this->renderText($jsonObj->toJson());
        }

        $time_now = time();
        $time_log = $time_now - 3600;
        TblUserSigninLogTable::getInstance()->deleteUserSigninLock($number, $time_log);
        $failed_times = TblUserSigninLogTable::getInstance()->getCountUserSig($number);
        if ($failed_times >= 4) {
          TblOtpTable::getInstance()->updateUserOtpLock($number, $time_now);
          // Reset VtUserSigninLock
          TblUserSigninLogTable::getInstance()->resetUserSigninLock($number);

          $errorCode = UserErrorCode::ACCOUNT_HAS_BEEN_BLOCKED;
          $message = UserErrorCode::getMessage($errorCode);
          $jsonObj = new jsonObject($errorCode, $message);
          return $this->renderText($jsonObj->toJson());
        } else {
          if ($otpObj->getIsLock()) {
            if ($otpObj->getLockTime() >= $time_now - 600) {
              $errorCode = UserErrorCode::ACCOUNT_HAS_BEEN_BLOCKED;
              $message = UserErrorCode::getMessage($errorCode);
              $jsonObj = new jsonObject($errorCode, $message);
              return $this->renderText($jsonObj->toJson());
            }
            // Unlock for user
            TblOtpTable::getInstance()->setUnLockUser($number);
          }

          // Insert vao VtUserSigninLock
          $tblUserSigninLog = new TblUserSigninLog();
          $tblUserSigninLog->setUserName($number);
          $tblUserSigninLog->setCreatedTime($time_now);
          $tblUserSigninLog->save();
        }
      }
    } else {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $errorCode = UserErrorCode::INVALID_VERIFICATION_CODE;
    $message = UserErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message);
    return $this->renderText($jsonObj->toJson());
  }

  /**
   * Ham dang nhap
   *
   * @author Tiennx6
   * @since 27/12/2015
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeSignin(sfWebRequest $request)
  {
    if (!$request->isMethod($request::POST)) {
      $errorCode = defaultErrorCode::METHOD_NOT_ALLOWED;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $email = $request->getPostParameter('email', null);
    $password = $request->getPostParameter('password', null);
    $osType = $request->getPostParameter('os_type', 0);

    if (!$email || !$password) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    // Kiem tra mat khau manh
    $form = new LoginForm();
    $values['email'] = $email;
    $values['password'] = $password;
    $form->bind($values);
    if ($form->isValid()) {
      $vtUser = TblUserTable::getInstance()->getUserByEmail($email);
      if ($vtUser) {
        if ($vtUser->checkPassword($password)) {
          if ($vtUser->getIsLock()) {
            $timeLock = time() - 600;
            if ($vtUser->getLockTime() >= $timeLock) {
              $errorCode = UserErrorCode::ACCOUNT_HAS_BEEN_BLOCKED;
              $message = UserErrorCode::getMessage($errorCode);
              $jsonObj = new jsonObject($errorCode, $message);
              return $this->renderText($jsonObj->toJson());
            }
            // Unlock for user
            TblUserTable::getInstance()->setUnLockUser($email);
          }

          // Reset VtUserSigninLog
          TblUserSigninLogTable::getInstance()->resetUserSigninLock($email);

          // Kiem tra va gui ve thong tin version
          $isUpdate = null;
          $updateType = null;
          $appVersion = $request->getPostParameter('app_version', null);
          $appType = $request->getPostParameter('app_type', null);
          if ($appVersion !== null && $appType !== null) {
            $res = IContactHelper::returnAppVersion($appType, $appVersion);
            if ($res) {
              $isUpdate = $res['is_update'];
              $updateType = $res['type'];
            }
          }

          // Tao token
          $tokenPair = userHelper::generateToken($email, $osType);
          $token = $tokenPair['token'];

          if (!$token) {
            $errorCode = UserErrorCode::CANNOT_CREATE_TOKEN;
            $message = UserErrorCode::getMessage($errorCode);
            $jsonObj = new jsonObject($errorCode, $message);
            return $this->renderText($jsonObj->toJson());
          }

          $errorCode = AuthenticateErrorCode::AUTHENTICATE_SUCCESS;
          $message = AuthenticateErrorCode::getMessage($errorCode);
          $jsonObj = new jsonObject($errorCode, $message, $token, array('phone' => $vtUser['msisdn']), null, $isUpdate, $updateType);
          return $this->renderText($jsonObj->toJson());
        }

        // Neu thong tin khong hop le
        $time_now = time();
        $time_log = $time_now - 3600;
        TblUserSigninLogTable::getInstance()->deleteUserSigninLock($email, $time_log);
        $failed_times = TblUserSigninLogTable::getInstance()->getCountUserSig($email);
        if ($failed_times >= 4) {
          TblUserTable::getInstance()->updateUserLock($email, $time_now);
          // Reset VtUserSigninLog
          TblUserSigninLogTable::getInstance()->resetUserSigninLock($email);

          $errorCode = UserErrorCode::ACCOUNT_HAS_BEEN_BLOCKED;
          $message = UserErrorCode::getMessage($errorCode);
          $jsonObj = new jsonObject($errorCode, $message);
          return $this->renderText($jsonObj->toJson());
        } else {
          if ($vtUser->getIsLock()) {
            if ($vtUser->getLockTime() >= $time_now - 600) {
              $errorCode = UserErrorCode::ACCOUNT_HAS_BEEN_BLOCKED;
              $message = UserErrorCode::getMessage($errorCode);
              $jsonObj = new jsonObject($errorCode, $message);
              return $this->renderText($jsonObj->toJson());
            }
            // Unlock for user
            TblUserTable::getInstance()->setUnLockUser($email);
          }

          // Insert vao VtUserSigninLog
          $tblUserSigninLog = new TblUserSigninLog();
          $tblUserSigninLog->setUserName($email);
          $tblUserSigninLog->setCreatedTime($time_now);
          $tblUserSigninLog->save();
        }
      }
      $errorCode = AuthenticateErrorCode::AUTHENTICATE_FAIL;
      $message = AuthenticateErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } else {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham doi mat khau
   *
   * @author Tiennx6
   * @since 14/08/2014
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeChangePassword(sfWebRequest $request)
  {
    $password = $request->getPostParameter('password', null);
    if (!$password) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $values['password'] = $password;
    $form = new PassValidateForm();
    $form->bind($values);
    if (!$form->isValid()) {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      if ($form['password']->hasError())
        $message = VtHelper::strip_html_tags($form['password']->getError());
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $info = $this->getUser()->getAttribute('userInfo');
    try {
      $vtUser = TblUserTable::getInstance()->findOneBy('id', $info['user_id']);
      TblUserTable::getInstance()->updatePassword($vtUser, $password);
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham lay lai mat khau
   *
   * @author Tiennx6
   * @since 27/12/2015
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeReceivePassword(sfWebRequest $request)
  {
    $email = $request->getPostParameter('email', null);
    if (!$email) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if (!IContactHelper::isEmail($email)) {
      $errorCode = UserErrorCode::INVALID_PHONE_NUMBER;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $password = mt_rand(10000000, 99999999);
    try {
      $vtUser = TblUserTable::getInstance()->findOneBy('email', $email);
      if (!$vtUser) {
        $errorCode = UserErrorCode::USER_HAS_NOT_REGISTERED_YET;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      TblUserTable::getInstance()->updatePassword($vtUser, $password);
      // Gui email
      $myEmail = sfConfig::get('app_administrator_email');
      $subject = IContactHelper::getSystemSetting('EMAIL_RECEIVE_PASSWORD_SUBJECT');
      $body = str_replace('%password%', $password, IContactHelper::getSystemSetting('EMAIL_RECEIVE_PASSWORD_BODY'));
      IContactHelper::sendEmail($myEmail, $email, $subject, $body);

      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham dang xuat
   *
   * @author Tiennx6
   * @since 27/12/2015
   * @param sfWebRequest $request
   * @return mixed
   */
  public function executeSignout(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    try {
      // Xoa session trong DB
      TblTokenSessionTable::getInstance()->deleteSession($info['id']);
      // Xoa session
      $this->getUser()->getAttributeHolder()->clear();
      // Thong bao
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  //Ham dong bo danh ba
  public function executeGetContactSynchronous(sfWebRequest $request)
  {
    VtHelper::writeLogValue('Start to sync contact!!!');
    $data = $request->getPostParameter('phone');
    if (!$data) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $dataArr = explode(';', $data);
    foreach ($dataArr as $value) {
      //chuyen danh sach so dien thoai ve dang 84....
      $phoneArr[] = VtXCodeHelper::getMobileNumber($value, VtXCodeHelper::MOBILE_GLOBAL);
    }

    //thuc hien lay danh sach cac so dien thoai da dang ky dich vu
    $listCurrentUser = VtTokenSessionTable::getListUserByPhoneArr($phoneArr);

    $info = $this->getUser()->getAttribute('userInfo');
    // Xoa cac so khong thuoc danh sach truyen len
    VtContactTable::deleteIfNotInArray($info['user_id'], $phoneArr);
    // Lay danh sach danh ba
    $contactArr = VtContactTable::getContactByUserId($info['user_id']);

    $resultArr = array();
    $addArr = array();
    $checkArr = array();
    foreach ($phoneArr as $e) {
      $newArr = array(
        'phone' => $e,
        'is_install' => 0,
        'is_viettel' => 0,
        'os_type' => 2
      );

      if ($listCurrentUser) {
        $userArr = explode(';', $listCurrentUser->getMsisdn());
        if (in_array($e, $userArr)) {
          $newArr['is_install'] = 1;
        }
      }

      if (VtXCodeHelper::isViettelPhoneNumber($e)) {
        // TH la so Viettel
        $newArr['is_viettel'] = 1;

        // Check os_type va luu vao contact
        if (array_key_exists($e, $contactArr)) {
          if ($contactArr[$e] == 1) {
            $newArr['os_type'] = 1;
          }
        } else {
          if (!in_array($e, $checkArr)) {
            // Luu cac so khong thuoc danh sach truyen len
            $vtContact = new VtContact();
            $vtContact->setUserId($info['user_id']);
            $vtContact->setMsisdn($e);
            $addArr[] = $vtContact;
            $checkArr[] = $e;
          }
        }
      }

      if ($newArr['is_install'] || !$newArr['is_viettel'] || $newArr['os_type'] == 1) {
        $resultArr[] = $newArr;
      }
    }

    if (count($addArr)) {
      // Save DB
      VtContactTable::insertContacts($addArr);
    }

    // Thanh cong
    $data = array('items' => $resultArr);
    $errorCode = UserErrorCode::SUCCESS;
    $message = UserErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  //ham lay so luong notification moi
  public function executeGetNewNotifications(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    //lay last_update cua nguoi dung
    $user = VtUserTable::getUserInfoById($info['user_id']);
    if (!$user) {
      $errorCode = UserErrorCode::NOT_FOUND;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    //Thuc hien lay so luong notification moi
    $newNotification = VtNotificationBoxTable::getNewNotification($info['user_id'], $user->getLastUpdate(), date('Y-m-d H:i:s'));
    $data = array('number' => $newNotification);
    $errorCode = UserErrorCode::SUCCESS;
    $message = UserErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  //ham lay danh sach notification cu nguoi dung
  public function executeGetNotifications(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    $pageId = trim($request->getPostParameter('page_id', 1));
    $pageSize = trim($request->getPostParameter('page_size', 10));

    //lay last_update cua nguoi dung
    $user = VtUserTable::getUserInfoById($info['user_id']);
    if (!$user) {
      $errorCode = UserErrorCode::NOT_FOUND;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if (!preg_match('/^([1-9][0-9]*)$/', $pageId) || !preg_match('/^([1-9][0-9]*)$/', $pageSize)) {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if ($pageId == 1) {
      $dateView = date('Y-m-d H:i:s');
      $newNotification = VtNotificationBoxTable::getNewNotification($info['user_id'], $user->getLastUpdate(), $dateView);
      if ($newNotification) {
        //thuc hien cap nhat last update cho nguoi dung thanh thoi gian hien tai
        $user->setLastUpdate($dateView);
        $user->save();
      }

      //lay danh sach notification
      $listNotification = VtNotificationBoxTable::getListNotification($info['user_id'], $pageSize);
      if ($listNotification) {
        $items = array();
        foreach ($listNotification as $key => $notification) {
          $boldPos = array();
          if ($notification['avatar_name']) {
            if (strpos($notification['content'], $notification['avatar_name']) !== false) {
              $boldPos[] = array(
                'start' => mb_strpos($notification['content'], $notification['avatar_name'], null, 'UTF-8'),
                'length' => mb_strlen($notification['avatar_name'], 'UTF-8')
              );
            }
          }
          if ($notification['sender_phone']) {
            $senderPhone = VtXCodeHelper::getMobileNumber($notification['sender_phone'], VtXCodeHelper::MOBILE_SIMPLE);
            if (strpos($notification['content'], $senderPhone) !== false) {
              $boldPos[] = array(
                'start' => mb_strpos($notification['content'], $senderPhone, null, 'UTF-8'),
                'length' => mb_strlen($senderPhone, 'UTF-8')
              );
            }
          }

          $items[] = array(
            'id' => $notification['id'],
            'description' => $notification['content'],
            'time' => $notification['created_at'],
            'bold_position' => $boldPos,
            'clickable' => $notification['clickable'],
            'avatarId' => $notification['avatar_id'],
          );
        }

        $data = array(
          'number_new' => $newNotification,
          'date_view' => $dateView,
          'items' => $items
        );
      } else {
        $errorCode = UserErrorCode::NO_RESULTS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }
    } else {
      $dateGetNotify = trim($request->getPostParameter('date_get_notification'));
      if (!$dateGetNotify) {
        $errorCode = UserErrorCode::MISSING_PARAMETERS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      $dateTimeRegex = '/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/';
      if (!preg_match($dateTimeRegex, $dateGetNotify)) {
        $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      //lay danh sach notification
      $listNotification = VtNotificationBoxTable::getListNotificationByDate($info['user_id'], $pageId, $pageSize, $dateGetNotify);
      if ($listNotification) {
        $items = array();
        foreach ($listNotification as $key => $notification) {
          $boldPos = array();
          if ($notification['avatar_name']) {
            if (strpos($notification['content'], $notification['avatar_name']) !== false) {
              $boldPos[] = array(
                'start' => mb_strpos($notification['content'], $notification['avatar_name'], null, 'UTF-8'),
                'length' => mb_strlen($notification['avatar_name'], 'UTF-8')
              );
            }
          }
          if ($notification['sender_phone']) {
            $senderPhone = VtXCodeHelper::getMobileNumber($notification['sender_phone'], VtXCodeHelper::MOBILE_SIMPLE);
            if (strpos($notification['content'], $senderPhone) !== false) {
              $boldPos[] = array(
                'start' => mb_strpos($notification['content'], $senderPhone, null, 'UTF-8'),
                'length' => mb_strlen($senderPhone, 'UTF-8')
              );
            }
          }

          $items[] = array(
            'id' => $notification['id'],
            'description' => $notification['content'],
            'time' => $notification['created_at'],
            'bold_position' => $boldPos,
            'clickable' => $notification['clickable'],
            'avatarId' => $notification['avatar_id'],
          );
        }

        $data = array(
          'number_new' => null,
          'date_view' => null,
          'items' => $items
        );
      } else {
        $errorCode = UserErrorCode::NO_RESULTS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }
    }

    $errorCode = CategoryErrorCode::SUCCESS;
    $message = CategoryErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  /**
   * Ham validate token
   *
   * @author Tiennx6
   * @since 29/12/2015
   * @params sfWebRequest $request
   */
  public function executeValidateToken(sfWebRequest $request)
  {
    if (!$request->isMethod($request::POST)) {
      $errorCode = defaultErrorCode::METHOD_NOT_ALLOWED;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $token = $request->getPostParameter('token');
    $osType = $request->getPostParameter('os_type', 0);
    if (!$token) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $info = TblTokenSessionTable::getInstance()->getInfoByTokenNotExpired(trim($token));
    $newToken = null;
    if ($info) {
      if ($info['expired_time'] < date("Y-m-d H:i:s")) {
        $tokenPair = userHelper::generateToken($info['account'], $osType);
        $newToken = $tokenPair['token'];
        $info = TblTokenSessionTable::getInstance()->getInfoByToken(trim($newToken));
        // Luu lai userInfo da truy xuat
        $this->getUser()->setAttribute("userInfo", $info);
      }

      // Kiem tra va gui ve thong tin version
      $isUpdate = null;
      $updateType = null;
      $appVersion = $request->getPostParameter('app_version', null);
      $appType = $request->getPostParameter('app_type', null);
      if ($appVersion !== null && $appType !== null) {
        $res = IContactHelper::returnAppVersion($appType, $appVersion);
        if ($res) {
          $isUpdate = $res['is_update'];
          $updateType = $res['type'];
        }
      }

      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, $newToken, array('phone' => $info['msisdn']), null, $isUpdate, $updateType);
      return $this->renderText($jsonObj->toJson());
    } else {
      $errorCode = UserErrorCode::UNAUTHORIZED;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham cap nhat thong diep
   *
   * @author Tiennx6
   * @since 29/01/2016
   * @params sfWebRequest $request
   */
  public function executeUpdateStatus(sfWebRequest $request)
  {
    $status = trim($request->getPostParameter('status'));
    if (!$status) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if (strlen($status) > 255) {
      $errorCode = UserErrorCode::STRING_MAX_LENGTH;
      $message = UserErrorCode::getMessage($errorCode, array('%max_length%' => 255));
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $info = $this->getUser()->getAttribute('userInfo');
    TblUserTable::getInstance()->updateStatus($info['user_id'], $status);

    $errorCode = UserErrorCode::SUCCESS;
    $message = UserErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message);
    return $this->renderText($jsonObj->toJson());
  }

  /**
   * Ham xoa thong diep
   *
   * @author Tiennx6
   * @since 29/01/2016
   * @params sfWebRequest $request
   */
  public function executeDeleteStatus(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    $result = TblUserTable::getInstance()->deleteStatus($info['user_id']);
    if ($result) {
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } else {
      $errorCode = UserErrorCode::NO_MESSAGE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham nhan thong diep
   *
   * @author Tiennx6
   * @since 29/01/2016
   * @params sfWebRequest $request
   */
  public function executeGetStatus(sfWebRequest $request)
  {
    $number = trim($request->getPostParameter('guest_phone'));
    if ($number) {
      if (!IContactHelper::isPhoneNumber($number)) {
        $errorCode = UserErrorCode::INVALID_PHONE_NUMBER;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }
      $number = IContactHelper::getMobileNumber($number, IContactHelper::MOBILE_GLOBAL);
      $user = TblUserTable::getInstance()->getUserByPhone($number);
    } else {
      $info = $this->getUser()->getAttribute('userInfo');
      $user = TblUserTable::getInstance()->find($info['user_id']);
    }

    if ($user) {
      if ($user['message']) {
        $data = array('status' => $user['message']);
        $errorCode = UserErrorCode::SUCCESS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
    }

    $errorCode = UserErrorCode::NO_RESULTS;
    $message = UserErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message);
    return $this->renderText($jsonObj->toJson());
  }
}
