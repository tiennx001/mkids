<?php

/**
 * TblUser form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TblParentApiForm extends BaseTblUserForm
{
  public function configure()
  {
    $this->useFields(['name','description','status','type','image_path','msisdn','password','email','gender','facebook','address','tbl_member_list','tbl_school_list']);
    $this->disableCSRFProtection();
    $schoolId = $this->getOption('school_id');

    if($this->isNew()){
      $this->validatorSchema['password']->setOption('required',true);
    }
    $this->validatorSchema['name']->setMessage('required','Vui lòng nhập tên');
    $this->validatorSchema['name']->setMessage('max_length','Tên quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['name']->setOption('required',true);

    $this->validatorSchema['msisdn']->setMessage('required','Vui lòng nhập SĐT');
    $this->validatorSchema['msisdn']->setMessage('max_length','SĐT quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['msisdn']->setOption('required',true);

    $this->validatorSchema['gender'] = new sfValidatorChoice([
      'choices' => GenderEnum::getArr(),
      'required' => true
    ],[
      'invalid' => 'Giới tính không hợp lệ',
      'required' => 'Giới tính không được để trống'
    ]);

    $this->validatorSchema['status'] = new sfValidatorChoice([
      'choices' => array_keys(StatusEnum::getArr()),
      'required' => true
    ],[
      'invalid' => 'Trạng thái không hợp lệ',
      'required' => 'Trạng thái không được để trống'
    ]);

    $this->validatorSchema['tbl_member_list'] = new sfValidatorDoctrineChoice(array(
      'multiple' => true, 'model' => 'TblMember', 'required' => true,
      'query' => TblMemberTable::getInstance()->getListMemberQuery($schoolId)
    ), array(
      'invalid' => 'Học sinh không hợp lệ',
      'required' => 'Học sinh không được để trống'
    ));

    $this->validatorSchema['email'] = new sfValidatorEmail(array(
      'max_length' => 255,
      'required' => false
    ), array(
      'invalid' => 'Địa chỉ email không hợp lệ',
      'max_length' => 'Email quá dài (tối đa %max_length% ký tự)'
    ));

    $this->validatorSchema['description']->setMessage('max_length','Mô tả quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['address']->setMessage('max_length','Địa chỉ quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['facebook']->setMessage('max_length','Địa chỉ facebook quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['password']->setMessage('max_length','Mật khẩu quá dài (tối đa %max_length% ký tự)');

    $this->validatorSchema['image_path'] = new sfValidatorBase64Image(array(
      'max_size' => 1024*1024,
      'mime_types' => ['image/jpeg','image/png'],
      'required' => false
    ),[
      'max_size' => 'Ảnh không được quá 1MB',
      'mime_types' => 'Vui lòng upload ảnh định dạng png hoặc jpeg'
    ]);
  }

  public function processValues($values)
  {
    if(!empty($values['password'])){
      if($this->isNew()){
        $values['salt'] = VtHelper::generateSalt();
        $values['password'] = sha1($values['salt'] . $values['password']);
      }else{
        $values['password'] = sha1($this->getObject()->getSalt() . $values['password']);
      }
    }
    if(!empty($values['msisdn']))
      $values['msisdn'] = VtHelper::convertMsisdn($values['msisdn'], VtHelper::MOBILE_GLOBAL);
    return parent::processValues($values); // TODO: Change the autogenerated stub
  }
}
