<?php

/**
 * TblMemberActivity form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TblMemberActivityApiForm extends BaseTblMemberActivityForm
{
  public function configure()
  {
    $this->useFields(['member_id','date','type','description','status']);
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

    $this->validatorSchema['type'] = new sfValidatorChoice(array(
      'choices' => ActivityTypeEnum::getArr(),
      'required' => true
    ), array(
      'invalid' => 'Loại không hợp lệ',
      'required' => 'Loại không được để trống'
    ));

    $this->validatorSchema['description']->setMessage('max_length','Mô tả quá dài (tối đa %max_length% ký tự)');
    $this->disableLocalCSRFProtection();
  }
}
