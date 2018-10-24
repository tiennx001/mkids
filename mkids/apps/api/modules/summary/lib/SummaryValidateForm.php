<?php

/**
 * NotificationProgramValidateForm form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SummaryValidateForm extends BaseTblSummaryForm
{
  public function configure()
  {
    $this->useFields(array('member_id', 'date', 'week', 'summary', 'learning', 'behavior', 'attendance', 'description'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->validatorSchema['member_id'] = new sfValidatorDoctrineChoice(array(
      'required' => false,
      'model' => 'TblMember',
      'column' => 'id'
    ), array(
      'required' => $i18n->__('Vui lòng nhập thành viên')
    ));

    $isList = $this->getOption('is_list');
    $this->validatorSchema['date'] = new sfValidatorOr(array(new sfValidatorDateTime(array(
        'required' => !$isList,
        'date_format' => '~(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})~',
        'with_time' => false
      )), new sfValidatorNumber(array(
        'required' => $this->isNew() && !$isList,
        'min' => 1,
        'max' => 55
      ))
    ), array(
      'required' => $this->isNew() && !$isList
    ), array(
      'required' => $i18n->__('Vui lòng nhập ngày tháng hoặc tuần lễ'),
      'invalid' => $i18n->__('Vui lòng nhập đúng định dạng ngày tháng, tuần lễ từ 1 đến 55')
    ));

    $this->validatorSchema['summary'] = new sfValidatorChoice(array(
      'required' => $this->isNew() && !$isList,
      'choices' => SummaryLevelEnum::getLevelArr()
    ), array(
      'required' => $i18n->__('Vui lòng nhập tổng kết'),
      'invalid' => $i18n->__('Giá trị tổng kết không chính xác')
    ));

    $this->validatorSchema['learning'] = new sfValidatorChoice(array(
      'required' => !$isList,
      'choices' => SummaryLevelEnum::getLevelArr()
    ), array(
      'required' => $i18n->__('Vui lòng nhập học lực'),
      'invalid' => $i18n->__('Giá trị học lực không chính xác')
    ));

    $this->validatorSchema['behavior'] = new sfValidatorChoice(array(
      'required' => !$isList,
      'choices' => SummaryLevelEnum::getLevelArr()
    ), array(
      'required' => $i18n->__('Vui lòng nhập nề nếp'),
      'invalid' => $i18n->__('Giá trị nề nếp không chính xác')
    ));

    $this->validatorSchema['attendance'] = new sfValidatorChoice(array(
      'required' => !$isList,
      'choices' => SummaryLevelEnum::getLevelArr()
    ), array(
      'required' => $i18n->__('Vui lòng nhập đi học đầy đủ'),
      'invalid' => $i18n->__('Giá trị đi học đầy đủ không chính xác')
    ));

    $this->validatorSchema['description'] = new sfValidatorString(array(
      'required' => !$isList,
      'max_length' => 65535
    ), array(
      'required' => $i18n->__('Vui lòng nhập nhận xét'),
      'max_length' => $i18n->__('Độ dài nhận xét tối đa %max_length% ký tự')
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkDateAndWeek')))
    );

    $this->disableCSRFProtection();
  }

  public function checkDateAndWeek($validator, $values) {
    $date = isset($values['date']) ? $values['date']  : false;
    $week = isset($values['week']) ? $values['week']  : false;
    if ($date || $week) {
      if (!$this->isNew()) {
        $err = new sfValidatorError($validator, sfContext::getInstance()->getI18N()->__('Không được phép sửa ngày tháng hoặc tuần lễ.'));
        throw new sfValidatorErrorSchema($validator, array('date' => $err));
      }

      $isExist = TblSummaryTable::getInstance()->checkDateAndWeekExist($values['member_id'], $date, $week);
      if ($isExist) {
        $err = new sfValidatorError($validator, sfContext::getInstance()->getI18N()->__('Đã nhập đánh giá cho thời gian này.'));
        throw new sfValidatorErrorSchema($validator, array('date' => $err));
      }
    }
    return $values;
  }
}
