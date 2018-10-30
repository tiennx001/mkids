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
//    $this->forward('default', 'module');
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

    if (!mKidsHelper::isPhoneNumber($number)) {
      $errorCode = UserErrorCode::INVALID_PHONE_NUMBER;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    // Kiem tra mat khau manh
    $form = new PasswordForm();
    $number = mKidsHelper::getMobileNumber($number, mKidsHelper::MOBILE_GLOBAL);
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
        $subject = mKidsHelper::getSystemSetting('EMAIL_GET_OTP_SUBJECT');
        $body = str_replace('%otp%', $optCode, mKidsHelper::getSystemSetting('EMAIL_GET_OTP_BODY'));
        mKidsHelper::sendEmail($myEmail, $email, $subject, $body);
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

    if (!mKidsHelper::isPhoneNumber($number)) {
      $errorCode = UserErrorCode::INVALID_PHONE_NUMBER;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    // Kiem tra mat khau manh
    $form = new PasswordForm();
    $number = mKidsHelper::getMobileNumber($number, mKidsHelper::MOBILE_GLOBAL);
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
            TblUserTable::getInstance()->setUnLockUser($email);
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
            TblUserTable::getInstance()->setUnLockUser($number);
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
  public function executeLogin(sfWebRequest $request)
  {
    if (!$request->isMethod($request::POST)) {
      $errorCode = defaultErrorCode::METHOD_NOT_ALLOWED;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $email = $request->getPostParameter('username', null);
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
            $res = mKidsHelper::returnAppVersion($appType, $appVersion);
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

          // Thuc hien cap nhat registration_ids
          $tokenId = $request->getPostParameter('tokenId', null);
          if ($tokenId && $tokenId != $vtUser->getTokenId()) {
            $vtUser->setTokenId($tokenId);
            $vtUser->save();
          }

          $errorCode = AuthenticateErrorCode::AUTHENTICATE_SUCCESS;
          $message = AuthenticateErrorCode::getMessage($errorCode);
          $jsonObj = new jsonObject($errorCode, $message, $token, null, null, $isUpdate, $updateType);
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

    if (!mKidsHelper::isEmail($email)) {
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
      $subject = mKidsHelper::getSystemSetting('EMAIL_RECEIVE_PASSWORD_SUBJECT');
      $body = str_replace('%password%', $password, mKidsHelper::getSystemSetting('EMAIL_RECEIVE_PASSWORD_BODY'));
      mKidsHelper::sendEmail($myEmail, $email, $subject, $body);

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
        $res = mKidsHelper::returnAppVersion($appType, $appVersion);
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
   * Ham thay doi thong tin nguoi dung
   *
   * @author Tiennx6
   * @since 29/10/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeUpdateUserInfo(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    $vtUser = TblUserTable::getInstance()->getActiveUserById($info['user_id']);
    if (!$vtUser) {
      $errorCode = UserErrorCode::NO_RESULTS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $formValues = array(
      'name' => $request->getPostParameter('name', null),
      'gender' => $request->getPostParameter('gender', null),
      'facebook' => $request->getPostParameter('facebook', null),
      'address' => $request->getPostParameter('address', null),
      'description' => $request->getPostParameter('description', null),
      'image_path' => $request->getPostParameter('image', null),
      'msisdn' => $request->getPostParameter('phone', null)
    );

    $form = new UserInfoForm($vtUser);
    $form->bind($formValues);
    if (!$form->isValid()) {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $widget) {
        if ($widget->hasError()) {
          $message = VtHelper::strip_html_tags($widget->getError());
          break;
        }
      }
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      // Thuc hien cap nhat form
      $form->save();

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
   * Ham lay thong tin nguoi dung
   *
   * @author Tiennx6
   * @since 29/10/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeGetUserInfo(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    $vtUser = TblUserTable::getInstance()->getActiveUserById($info['user_id']);
    if (!$vtUser) {
      $errorCode = UserErrorCode::NO_RESULTS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $obj = new stdClass();
    $obj->name = $vtUser->getName();
    $obj->gender = $vtUser->getGender();
    $obj->facebook = $vtUser->getFacebook();
    $obj->address = $vtUser->getAddress();
    $obj->description = $vtUser->getDescription();
    $obj->imagePath = $vtUser->getImagePath();
    $obj->phone = mKidsHelper::getMobileNumber($vtUser->getMsisdn(), mKidsHelper::MOBILE_SIMPLE);

    $errorCode = UserErrorCode::SUCCESS;
    $message = UserErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message, $obj);
    return $this->renderText($jsonObj->toJson());
  }
}
