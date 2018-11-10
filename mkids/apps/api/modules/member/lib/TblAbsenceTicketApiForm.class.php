<?php

/**
 * TblMemberActivity form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TblAbsenceTicketApiForm extends TblAbsenceTicketForm
{
  public function configure()
  {
    $this->useFields(['member_id', 'date', 'reason', 'status']);
    $classIds = $this->getOption('class_ids');
    $memberIds = $this->getOption('member_ids');
    $userInfo = $this->getOption('user_info');
    $this->validatorSchema['member_id'] = new sfValidatorDoctrineChoice(array(
      'model' => $this->getRelatedModelName('TblMember'),
      'query' => TblMemberTable::getInstance()->getMemberByIdsQuery($classIds, $memberIds),
      'required' => $userInfo['user_type'] == UserTypeEnum::TEACHER
    ), array(
      'invalid' => 'Học sinh không hợp lệ',
      'required' => 'Mã học sinh không được để trống'
    ));

    $statusArr = ['' => 'status'] + AbsenceTicketStatusEnum::getArr();
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

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
      'callback' => array($this, 'checkUpdateStatusCredential')
    )));

    $this->validatorSchema['reason']->setMessage('max_length','Vui lòng nhập lý do tối đa %max_length% ký tự');
    $this->disableLocalCSRFProtection();
  }

  public function checkUpdateStatusCredential($validator, $values) {
    $userInfo = $this->getOption('user_info');
    if (isset($values['status']) && $values['status'] && $userInfo['user_type'] == UserTypeEnum::PARENTS) {
      $errSchema = array('status' => new sfValidatorError($validator, sfContext::getInstance()->getI18N()->__('Bạn không có quyền cập nhật trạng thái đơn xin nghỉ')));
      throw new sfValidatorErrorSchema($validator, $errSchema);
    }
    return $values;
  }

  public function processValues($values) {
    $values = parent::processValues($values);
    if ($this->isNew()) {
      $userInfo = $this->getOption('user_info');
      $values['user_id'] = $userInfo['user_id'];
    }
    return $values;
  }
}
