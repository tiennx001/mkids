<?php

/**
 * NotificationProgramValidateForm form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NotificationProgramValidateForm extends BaseTblNotificationProgramForm
{
  public function configure()
  {
    $this->useFields(array('type', 'name', 'content', 'article_id', 'start_time', 'status', 'tbl_group_list', 'tbl_class_list', 'tbl_member_list'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->widgetSchema['type'] = new sfWidgetFormChoice(array(
      'choices' => NotificationProgTypeEnum::getArr()
    ));
    $this->validatorSchema['type'] = new sfValidatorChoice(array(
      'required' => true,
      'choices' => array_keys(NotificationProgTypeEnum::getArr())
    ), array(
      'required' => $i18n->__('Vui lòng nhập loại chương trình')
    ));

    $this->validatorSchema['name'] = new sfValidatorString(array(
      'required' => true,
      'max_length' => 255
    ), array(
      'required' => $i18n->__('Vui lòng nhập tên chương trình'),
      'max_length' => $i18n->__('Độ tài tối đa %max_length% ký tự')
    ));

    $this->validatorSchema['content'] = new sfValidatorString(array(
      'required' => true,
      'max_length' => 65535
    ), array(
      'required' => $i18n->__('Vui lòng nhập nội dung'),
      'max_length' => $i18n->__('Độ tài tối đa %max_length% ký tự')
    ));

    $this->validatorSchema['article_id'] = new sfValidatorDoctrineChoice(array(
      'model' => 'TblArticle',
      'column' => 'id'
    ));

    $this->validatorSchema['start_time'] = new sfValidatorDateTime(array(
      'required' => true,
      'date_format' => '~(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2}) (?P<hour>\d{2}):(?P<minute>\d{2}):(?P<second>\d{2})~'
    ), array(
      'required' => $i18n->__('Vui lòng nhập ngày tháng')
    ));

    $this->widgetSchema['status'] = new sfWidgetFormChoice(array(
      'choices' => NotificationProgStatusEnum::getArr()
    ));
    $this->validatorSchema['status'] = new sfValidatorChoice(array(
      'required' => true,
      'choices' => array_keys(NotificationProgStatusEnum::getArr())
    ), array(
      'required' => $i18n->__('Vui lòng nhập trạng thái')
    ));

    $this->validatorSchema['tbl_group_list'] = new sfValidatorDoctrineChoice(array(
      'required' => false,
      'model' => 'TblGroup',
      'column' => 'id',
      'multiple' => true
    ));

    $this->validatorSchema['tbl_class_list'] = new sfValidatorDoctrineChoice(array(
      'required' => false,
      'model' => 'TblClass',
      'column' => 'id',
      'multiple' => true
    ));

    $this->validatorSchema['tbl_member_list'] = new sfValidatorDoctrineChoice(array(
      'required' => false,
      'model' => 'TblMember',
      'column' => 'id',
      'multiple' => true
    ));

    $this->disableCSRFProtection();
  }
}
