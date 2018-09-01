<?php

/**
 * TblClass form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TblClassApiForm extends BaseTblClassForm
{
  public function configure()
  {
    $this->useFields(['name','description','group_id','status']);
    $this->disableCSRFProtection();

    $this->validatorSchema['name']->setMessage('required','Vui lòng nhập tên');
    $this->validatorSchema['name']->setMessage('max_length','Tên quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['name']->setOption('required',true);

    $this->validatorSchema['group_id']->setOption('required',true);
    $this->validatorSchema['group_id']->setMessage('required','Khối không được để trống');
    $this->validatorSchema['group_id']->setMessage('invalid','Khối không hợp lệ');

    $this->validatorSchema['description']->setMessage('max_length','Mô tả quá dài (tối đa %max_length% ký tự)');
  }
}
