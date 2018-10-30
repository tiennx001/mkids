<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 8/12/14
 * Time: 10:11 AM
 * To change this template use File | Settings | File Templates.
 */

class UserInfoForm extends TblUserForm
{

  public function configure()
  {
    parent::setup();
    $this->useFields(array('name', 'gender', 'facebook', 'address', 'description', 'image_path', 'msisdn'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->widgetSchema['name'] = new sfWidgetFormInput();
    $this->validatorSchema['name'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true,
      'max_length' => 255
    ), array(
      'max_length' => $i18n->__('Vui lòng nhập họ tên dài tối đa %max_length% ký tự')
    ));

    $genderArr = GenderEnum::getArr();
    $this->widgetSchema['gender'] = new sfWidgetFormChoice(array(
      'choices' => $genderArr
    ));
    $this->validatorSchema['gender'] = new sfValidatorChoice(array(
      'required' => false,
      'choices' => array_keys($genderArr)
    ), array(
      'invalid' => $i18n->__('Nhập sai giá trị giới tính')
    ));

    $this->widgetSchema['facebook'] = new sfWidgetFormInput();
    $this->validatorSchema['facebook'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true,
      'max_length' => 255
    ), array(
      'max_length' => $i18n->__('Vui lòng nhập địa chỉ Facebook tối đa %max_length% ký tự')
    ));

    $this->widgetSchema['address'] = new sfWidgetFormInput();
    $this->validatorSchema['address'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true,
      'max_length' => 255
    ), array(
      'max_length' => $i18n->__('Vui lòng nhập địa chỉ tối đa %max_length% ký tự')
    ));

    $this->widgetSchema['description'] = new sfWidgetFormInputText();
    $this->validatorSchema['description'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true,
      'max_length' => 1023
    ), array(
      'max_length' => $i18n->__('Vui lòng nhập giới thiệu tối đa %max_length% ký tự')
    ));

    $this->widgetSchema['image_path'] = new sfWidgetFormInput();
    $this->validatorSchema['image_path'] = new sfValidatorString(array(
      'required' => false,
      'max_length' => 1048576
    ), array(
      'max_length' => $i18n->__('Độ dài ảnh đại diện tối đa %max_length% ký tự')
    ));

    $this->widgetSchema['msisdn'] = new sfWidgetFormInput();
    $this->validatorSchema['msisdn'] = new sfValidatorRegex(array(
      'required' => false,
      'pattern' => mKidsHelper::PHONE_NUMBER_PATTERN
    ), array(
      'invalid' => $i18n->__('Vui lòng nhập đúng định dạng số điện thoại')
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
      'callback' => array($this, 'doCheckAndUploadImage')
    )));
    $this->disableCSRFProtection();
  }

  public function doCheckAndUploadImage($validator, $values) {
    if (isset($values['image_path']) && $values['image_path']) {
      $path = VtHelper::generatePath(sfConfig::get('app_user_image_path', '/uploads/images/user'));
      $userInfo = $this->getOption('user_info');
      $fileName = md5($userInfo['account'] . date('YmdHis')) . '.' . sfConfig::get('app_conversion_image_extension', 'jpg');
      $avatarPath = $path . $fileName;

      // Convert and upload image
      $fullPath = sfConfig::get('sf_web_dir') . $avatarPath;
      mKidsHelper::base64_to_jpeg($values['image_path'], $fullPath);
      if (!getimagesize($fullPath)) {
        $errSchema = array('image_path' => new sfValidatorError($validator, sfContext::getInstance()->getI18N()->__('Có lỗi xảy ra khi upload ảnh đại diện')));
        throw new sfValidatorErrorSchema($validator, $errSchema);
      }

      // Remove old image
      $oldImagePath = $this->getObject()->getImagePath();
      if ($oldImagePath) {
        $oldFile = sfConfig::get('sf_web_dir') . $oldImagePath;
        if (is_file($oldFile)) {
          unlink($oldFile);
        }
      }

      // Reset image_path value
      $values['image_path'] = $avatarPath;
    }
    return $values;
  }

  public function processValues($values) {
    $values = parent::processValues($values);
    if (isset($values['msisdn']) && $values['msisdn']) {
      // Convert phone to global format
      $values['msisdn'] = mKidsHelper::getMobileNumber($values['msisdn'], mKidsHelper::MOBILE_GLOBAL);
    }
    return $values;
  }
}