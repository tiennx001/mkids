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
    $this->useFields(array('title', 'content', 'image', 'type', 'status', 'tbl_group_list', 'tbl_class_list', 'tbl_member_list'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->validatorSchema['title'] = new sfValidatorString(array(
      'required' => true,
      'max_length' => 255
    ), array(
      'required' => $i18n->__('Vui lòng nhập tiêu đề'),
      'max_length' => $i18n->__('Độ tài tối đa %max_length% ký tự')
    ));

    $this->validatorSchema['content'] = new sfValidatorString(array(
      'required' => true,
      'max_length' => 65535
    ), array(
      'required' => $i18n->__('Vui lòng nhập nội dung'),
      'max_length' => $i18n->__('Độ tài tối đa %max_length% ký tự')
    ));

    $this->validatorSchema['image'] = new sfValidatorString(array(
    'required' => true,
    'max_length' => 65535
  ), array(
    'required' => $i18n->__('Vui lòng chọn ảnh đại diện'),
    'max_length' => $i18n->__('Độ tài tối đa %max_length% ký tự')
  ));

    $this->widgetSchema['type'] = new sfWidgetFormChoice(array(
      'choices' => NotificationProgTypeEnum::getArr()
    ));
    $this->validatorSchema['type'] = new sfValidatorChoice(array(
      'required' => true,
      'choices' => array_keys(NotificationProgTypeEnum::getArr())
    ), array(
      'required' => $i18n->__('Vui lòng nhập loại chương trình')
    ));

    $this->validatorSchema['article_id'] = new sfValidatorDoctrineChoice(array(
      'model' => 'TblArticle',
      'column' => 'id'
    ));

    $this->widgetSchema['status'] = new sfWidgetFormChoice(array(
      'choices' => StatusEnum::getArr()
    ));
    $this->validatorSchema['status'] = new sfValidatorChoice(array(
      'required' => true,
      'choices' => array_keys(StatusEnum::getArr())
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
