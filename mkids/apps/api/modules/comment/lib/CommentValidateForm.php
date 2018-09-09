<?php

/**
 * NotificationProgramValidateForm form.
 *
 * @package    xcode
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommentValidateForm extends BaseTblCommentForm
{
  public function configure()
  {
    $this->useFields(array('content'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->validatorSchema['content'] = new sfValidatorString(array(
      'required' => true,
      'max_length' => 1000
    ), array(
      'required' => $i18n->__('Vui lòng nhập nội dung'),
      'max_length' => $i18n->__('Độ tài tối đa %max_length% ký tự')
    ));

    $this->disableCSRFProtection();
  }
}
