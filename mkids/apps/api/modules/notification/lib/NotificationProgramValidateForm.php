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
    $this->useFields('type', 'content', 'article_id', 'start_time', 'status', 'group_list', 'class_list', 'member_list');
    $i18n = sfContext::getInstance()->getI18N();

    $this->validatorSchema['type'] = new sfValidatorChoice(array(
      'choices' => array_keys(NotificationProgTypeEnum::getArr())
    ));

    $this->validatorSchema['content'] = new sfValidatorString(array(
      'max_length' => 65535
    ), array(
      'max_length' => $i18n->__('?? dài n?i dung t?i ?a %max_length% kı t?')
    ));

    $this->validatorSchema['article_id'] = new sfValidatorDoctrineChoice(array(
      'model' => 'TblArticle',
      'column' => 'id'
    ));

    $this->validatorSchema['start_time'] = new sfValidatorDateTime(array(
      'date_format' => '~(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2}) (?P<hour>\d{2}):(?P<minute>\d{2}):(?P<second>\d{2})~'
    ));

    $this->validatorSchema['status'] = new sfValidatorChoice(array(
      'choices' => array_keys(NotificationProgStatusEnum::getArr())
    ));

    $this->validatorSchema['groupList'] = new sfValidatorDoctrineChoice(array(
      'model' => 'TblGroup',
      'column' => 'id',
      'multiple' => true
    ));

    $this->validatorSchema['classList'] = new sfValidatorDoctrineChoice(array(
      'model' => 'TblClass',
      'column' => 'id',
      'multiple' => true
    ));

    $this->validatorSchema['memberList'] = new sfValidatorDoctrineChoice(array(
      'model' => 'TblMember',
      'column' => 'id',
      'multiple' => true
    ));
  }
}
