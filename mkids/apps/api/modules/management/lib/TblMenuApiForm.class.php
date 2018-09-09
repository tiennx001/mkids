<?php

/**
 * TblUser form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TblMenuApiForm extends BaseTblMenuForm
{
  public function configure()
  {
    $this->useFields(['title','description','status','type','school_id','image_path','publish_date','tbl_group_list','tbl_class_list','tbl_member_list']);
    $this->disableCSRFProtection();
    $schoolId = $this->getOption('school_id');

    $this->validatorSchema['title']->setMessage('required','Vui lòng nhập tiêu đề');
    $this->validatorSchema['title']->setMessage('max_length','Tên quá dài (tối đa %max_length% ký tự)');
    $this->validatorSchema['title']->setOption('required',true);

    $this->validatorSchema['publish_date']->setMessage('required','Lớp không được để trống');
    $this->validatorSchema['publish_date']->setOption('required',true);

    $this->validatorSchema['type'] = new sfValidatorChoice([
      'choices' => array_keys(MenuTypeEnum::getArr()),
      'required' => true
    ],[
      'invalid' => 'Loại thực đơn không hợp lệ',
      'required' => 'Loại thực đơn không được để trống'
    ]);

    $this->validatorSchema['status'] = new sfValidatorChoice([
      'choices' => array_keys(StatusEnum::getArr()),
      'required' => true
    ],[
      'invalid' => 'Trạng thái không hợp lệ',
      'required' => 'Trạng thái không được để trống'
    ]);

    $this->validatorSchema['image_path'] = new sfValidatorBase64Image(array(
      'max_size' => 1024*1024,
      'mime_types' => ['image/jpeg','image/png'],
      'required' => false
    ),[
      'max_size' => 'Ảnh không được quá 1MB',
      'mime_types' => 'Vui lòng upload ảnh định dạng png hoặc jpeg'
    ]);

    $this->validatorSchema['tbl_group_list'] = new sfValidatorDoctrineChoice(array(
      'multiple' => true, 'model' => 'TblGroup', 'required' => false,
      'query' => TblGroupTable::getInstance()->getActGroupBySchoolIdQuery($schoolId)
    ), array(
      'invalid' => 'Nhóm không hợp lệ'
    ));

    $this->validatorSchema['tbl_class_list'] = new sfValidatorDoctrineChoice(array(
      'multiple' => true, 'model' => 'TblClass', 'required' => false,
      'query' => TblClassTable::getInstance()->getClassInGroupQuery(null,$schoolId)
    ), array(
      'invalid' => 'Lớp không hợp lệ'
    ));

    $this->validatorSchema['tbl_member_list'] = new sfValidatorDoctrineChoice(array(
      'multiple' => true, 'model' => 'TblMember', 'required' => false,
      'query' => TblMemberTable::getInstance()->getListMemberQuery($schoolId)
    ), array(
      'invalid' => 'Học sinh không hợp lệ'
    ));

    $this->validatorSchema['description']->setMessage('max_length','Mô tả quá dài (tối đa %max_length% ký tự)');
  }
}
