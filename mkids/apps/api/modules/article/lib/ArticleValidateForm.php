<?php

/**
 * NotificationProgramValidateForm form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ArticleValidateForm extends BaseTblArticleForm
{
  public function configure()
  {
    $this->useFields(array('title', 'content', 'type', 'tbl_group_list', 'tbl_class_list', 'tbl_member_list'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->validatorSchema['title'] = new sfValidatorString(array(
      'required' => true,
      'max_length' => 255
    ), array(
      'required' => $i18n->__('Vui lòng nhập tiêu đề'),
      'max_length' => $i18n->__('Độ dài tiêu đề tối đa %max_length% ký tự')
    ));

    $this->validatorSchema['content'] = new sfValidatorString(array(
      'required' => !$this->getOption('is_add_image'),
      'max_length' => 65535
    ), array(
      'required' => $i18n->__('Vui lòng nhập nội dung'),
      'max_length' => $i18n->__('Độ dài nội dung tối đa %max_length% ký tự')
    ));

    $this->widgetSchema['image'] = new sfWidgetFormInput();
    $this->validatorSchema['image'] = new sfValidatorString(array(
      'required' => $this->getOption('is_add_image'),
      'max_length' => 1048576
    ), array(
      'required' => $i18n->__('Vui lòng chọn ảnh đại diện'),
      'max_length' => $i18n->__('Độ dài ảnh đại diện tối đa %max_length% ký tự')
    ));

    $this->widgetSchema['type'] = new sfWidgetFormChoice(array(
      'choices' => NotificationProgTypeEnum::getArr()
    ));
    $this->validatorSchema['type'] = new sfValidatorChoice(array(
      'required' => !$this->getOption('is_add_image'),
      'choices' => array_keys(NotificationProgTypeEnum::getArr())
    ), array(
      'required' => $i18n->__('Vui lòng nhập loại tin tức')
    ));

    $groupIds = TblGroupTable::getInstance()->getActiveGroupIdsByUserId($this->getOption('user_id'), $this->getOption('user_type'));
    $this->validatorSchema['tbl_group_list'] = new sfValidatorDoctrineChoice(array(
      'required' => $this->getOption('article_type') == ArticleTypeEnum::GROUPS,
      'model' => 'TblGroup',
      'column' => 'id',
      'query' => TblGroupTable::getInstance()->getActiveQuery('a')->andWhereIn('a.id', $groupIds),
      'multiple' => true
    ));

    $classIds = TblClassTable::getInstance()->getActiveClassIdsByUserId($this->getOption('user_id'), $this->getOption('user_type'));
    $this->validatorSchema['tbl_class_list'] = new sfValidatorDoctrineChoice(array(
      'required' => $this->getOption('article_type') == ArticleTypeEnum::CLASSES,
      'model' => 'TblClass',
      'column' => 'id',
      'query' => TblClassTable::getInstance()->getActiveQuery('a')->andWhereIn('a.id', $classIds),
      'multiple' => true
    ));

    $memberIds = TblMemberTable::getInstance()->getActiveMemberIdsByUserId($this->getOption('user_id'), $this->getOption('user_type'));
    $this->validatorSchema['tbl_member_list'] = new sfValidatorDoctrineChoice(array(
      'required' => $this->getOption('article_type') == ArticleTypeEnum::MEMBERS,
      'model' => 'TblMember',
      'column' => 'id',
      'query' => TblMemberTable::getInstance()->getActiveQuery('a')->andWhereIn('a.id', $memberIds),
      'multiple' => true
    ));

    $this->disableCSRFProtection();
  }
}
