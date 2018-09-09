<?php

/**
 * TblSchool form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TblSchoolApiForm extends BaseTblSchoolForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at']);
    $this->disableCSRFProtection();
    $this->validatorSchema['name']->setMessage('required','Vui lòng nhập tên');
    $this->validatorSchema['name']->setMessage('max_length','Tên quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['name']->setOption('required',true);

    $this->validatorSchema['phone']->setMessage('required','Vui lòng nhập số điện thoại');
    $this->validatorSchema['phone']->setMessage('max_length','SĐT quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['phone']->setOption('required',true);

    $this->validatorSchema['email']->setMessage('required','Vui lòng nhập email');
    $this->validatorSchema['email']->setMessage('max_length','Email quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['email']->setOption('required',true);

    $this->validatorSchema['website']->setMessage('max_length','Website quá dài (tối đa %max_length% ký tự)');

    $this->validatorSchema['address']->setMessage('required','Vui lòng nhập địa chỉ');
    $this->validatorSchema['address']->setMessage('max_length','Địa chỉ quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['address']->setOption('required',true);

    $this->validatorSchema['description']->setMessage('max_length','Mô tả quá dài (tối đa %max_length% ký tự)');

    $this->validatorSchema['status'] = new sfValidatorChoice([
      'choices' => array_keys(StatusEnum::getArr()),
      'required' => true
    ],[
      'invalid' => 'Trạng thái không hợp lệ',
      'required' => 'Trạng thái không được để trống'
    ]);

  }
}
