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
    $this->validatorSchema['tbl_user_list']->setMessage('invalid','Phụ huynh không hợp lệ');

    $this->validatorSchema['description']->setMessage('max_length','Mô tả quá dài (tối đa %max_length% ký tự)');
  }
}
