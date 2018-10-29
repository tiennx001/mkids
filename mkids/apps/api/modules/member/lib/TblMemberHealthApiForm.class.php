<?php

/**
 * TblMemberActivity form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TblMemberHealthApiForm extends BaseTblMemberHealthForm
{
  public function configure()
  {
    $this->useFields(['member_id','date','health','description','height','weight','status']);
    $schoolId = $this->getOption('school_id');
    $this->validatorSchema['member_id'] = new sfValidatorDoctrineChoice(array(
      'model' => $this->getRelatedModelName('TblMember'),
      'query' => TblMemberTable::getInstance()->getListMemberQuery($schoolId)->andWhere('status = 1'),
      'required' => true
    ), array(
      'invalid' => 'Học sinh không hợp lệ',
      'required' => 'Mã học sinh không được để trống'
    ));

    $statusArr = ['' => 'status'] + StatusEnum::getArr();
    $this->validatorSchema['status'] = new sfValidatorChoice([
      'choices' => array_keys($statusArr),
      'required' => false
    ],[
      'invalid' => 'Trạng thái không hợp lệ',
      'required' => 'Trạng thái không được để trống'
    ]);

    $this->validatorSchema['date'] = new sfValidatorDate(array(
      'date_format' => '~(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})~',
      'min' => date('Y-m-d'),
      'date_format_error' => 'yyyy-MM-dd'
    ), array(
      'bad_format' => 'Ngày không đúng định dạng (%date_format%)',
      'min' => 'Ngày phải lớn hơn hoặc bằng ngày hiện tại',
      'required' => 'Ngày không được để trống',
      'invalid' => 'Ngày không hợp lệ'
    ));

    $this->validatorSchema['health'] = new sfValidatorChoice(array(
      'choices' => ActivityHealthEnum::getArr(),
      'required' => false
    ), array(
      'invalid' => 'Sức khoẻ không hợp lệ',
      'required' => 'Sức khoẻ không được để trống'
    ));

    $this->validatorSchema['description']->setMessage('max_length','Vui lòng nhập mô tả tối đa %max_length% ký tự');
    $this->validatorSchema['height']->setMessage('invalid','Chiều cao không hợp lệ');
    $this->validatorSchema['weight']->setMessage('invalid','Cân nặng không hợp lệ');
    $this->disableLocalCSRFProtection();
  }
}
