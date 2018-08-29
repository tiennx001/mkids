<?php

/**
 * contact actions.
 *
 * @package    xcode
 * @subpackage contact
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contactActions extends sfActions
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
   * Ham cap nhat danh ba
   *
   * @param sfRequest $request
   */
  public function executeUpdateContacts(sfWebRequest $request)
  {
    $data = $request->getPostParameter('data');
    if (!$data) {
      $errorCode = ContactErrorCode::MISSING_PARAMETERS;
      $message = ContactErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $phoneList = explode(';', $data);
    $newList = array();
    foreach ($phoneList as $phone) {
      $newList[] = IContactHelper::getMobileNumber($phone, IContactHelper::MOBILE_GLOBAL);
    }
    $dataList = TblSubPhoneTable::getInstance()->getSubByMainList($newList);
    $items = array();
    if (count($dataList)) {
      $subList = IContactHelper::toKeyValueDelimiter($dataList, 'msisdn', 'sub_msisdn');
      foreach ($subList as $key => $data) {
        $items[] = array(
          'main_phone' => $key,
          'additional_phone' => $data
        );
      }
    }

    $errorCode = ContactErrorCode::SUCCESS;
    $message = ContactErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message, null, array('items' => $items));
    return $this->renderText($jsonObj->toJson());
  }

  /**
   * Ham them so dien thoai phu
   *
   * @param sfRequest $request
   */
  public function executeUpdateAdditionalPhone(sfWebRequest $request)
  {
    $number = $request->getPostParameter('phone');
    if (!$number) {
      $errorCode = ContactErrorCode::MISSING_PARAMETERS;
      $message = ContactErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if (!IContactHelper::isPhoneNumber($number)) {
      $errorCode = UserErrorCode::INVALID_PHONE_NUMBER;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $userInfo = $this->getUser()->getAttribute('userInfo');
    $number = IContactHelper::getMobileNumber($number, IContactHelper::MOBILE_GLOBAL);
    if ($number == $userInfo['msisdn']) {
      $errorCode = ContactErrorCode::IDENTICAL_PHONE_NUMBER;
      $message = ContactErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if (TblSubPhoneTable::getInstance()->checkMsisdnExist($number)) {
      $errorCode = ContactErrorCode::ADDITIONAL_PHONE_NUMBER_EXIST;
      $message = ContactErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $tblSubPhone = new TblSubPhone();
    $tblSubPhone->setUserId($userInfo['user_id']);
    $tblSubPhone->setMsisdn($userInfo['msisdn']);
    $tblSubPhone->setSubMsisdn($number);
    $tblSubPhone->setStatus(true);
    $tblSubPhone->save();

    $errorCode = ContactErrorCode::SUCCESS;
    $message = ContactErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message, null, null, $number);
    return $this->renderText($jsonObj->toJson());
  }

  /**
   * Ham lay danh sach so dien thoai phu
   *
   * @param sfRequest $request
   */
  public function executeGetAdditionalPhones(sfWebRequest $request)
  {
    $userInfo = $this->getUser()->getAttribute('userInfo');

    $result = TblSubPhoneTable::getInstance()->getSubByMain($userInfo['msisdn']);
    $data = $result['subList'];
    if ($data) {
      $errorCode = ContactErrorCode::SUCCESS;
      $message = ContactErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $errorCode = ContactErrorCode::NO_RESULTS;
    $message = ContactErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message);
    return $this->renderText($jsonObj->toJson());
  }

  /**
   * Ham lay danh sach so dien thoai phu
   *
   * @param sfRequest $request
   */
  public function executeDeleteAdditionalPhone(sfWebRequest $request)
  {
    $number = $request->getPostParameter('phone');
    if (!$number) {
      $errorCode = ContactErrorCode::MISSING_PARAMETERS;
      $message = ContactErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $number = IContactHelper::getMobileNumber($number, IContactHelper::MOBILE_GLOBAL);
    $userInfo = $this->getUser()->getAttribute('userInfo');
    $result = TblSubPhoneTable::getInstance()->deleteSubPhone($number, $userInfo['user_id']);
    if ($result) {
      $errorCode = ContactErrorCode::SUCCESS;
      $message = ContactErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $errorCode = ContactErrorCode::INVALID_PARAMETER_VALUE;
    $message = ContactErrorCode::getMessage($errorCode);
    $jsonObj = new jsonObject($errorCode, $message);
    return $this->renderText($jsonObj->toJson());
  }
}
