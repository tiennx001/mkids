<?php

/**
 * TblUser form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TblMemberApiForm extends BaseTblMemberForm
{
  public function configure()
  {
    $this->useFields(['name','description','status','birthday','image_path','class_id','tbl_user_list']);
    $this->disableCSRFProtection();
    $schoolId = $this->getOption('school_id');

    $this->validatorSchema['status'] = new sfValidatorChoice([
      'choices' => array_keys(StatusEnum::getArr()),
      'required' => true
    ],[
      'invalid' => 'Trạng thái không hợp lệ',
      'required' => 'Trạng thái không được để trống'
    ]);

    $this->validatorSchema['name']->setMessage('required','Vui lòng nhập tên');
    $this->validatorSchema['name']->setMessage('max_length','Tên quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['name']->setOption('required',true);

    $this->validatorSchema['class_id']->setMessage('required','Lớp không được để trống');
    $this->validatorSchema['class_id']->setMessage('invalid','Lớp không hợp lệ');
    $this->validatorSchema['class_id']->setOption('required',true);

    $this->validatorSchema['tbl_user_list'] = new sfValidatorDoctrineChoice(array(
      'multiple' => true, 'model' => 'TblUser', 'required' => false,
      'query' => TblUserTable::getInstance()->getListParent()
    ));

    $this->validatorSchema['description']->setMessage('max_length','Mô tả quá dài (tối đa %max_length% ký tự)');

    $this->validatorSchema['image_path'] = new sfValidatorBase64Image(array(
      'max_size' => 1024*1024,
      'mime_types' => ['image/jpeg','image/png'],
      'required' => false
    ),[
      'max_size' => 'Ảnh không được quá 1MB',
      'mime_types' => 'Vui lòng upload ảnh định dạng png hoặc jpeg'
    ]);
  }
}
