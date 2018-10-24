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
    $this->useFields(array('content', 'article_id'));
    $i18n = sfContext::getInstance()->getI18N();

    $this->validatorSchema['article_id'] = new sfValidatorPass();

    $this->validatorSchema['content'] = new sfValidatorString(array(
      'required' => true,
      'max_length' => 1000
    ), array(
      'required' => $i18n->__('Vui lòng nhập nội dung'),
      'max_length' => $i18n->__('Độ tài tối đa %max_length% ký tự')
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
      'callback' => array($this, 'doCheckArticleCredentials')
    )));

    $this->disableCSRFProtection();
  }

  public function doCheckArticleCredentials($validator, $values) {
    $i18n = sfContext::getInstance()->getI18N();

    if (isset($values['article_id']) && $values['article_id']) {
      $article = TblArticleTable::getInstance()->find($values['article_id']);
      if (!$article) {
        $err = new sfValidatorError($validator, $i18n->__('Không tồn tại bài viết.'));
        throw new sfValidatorErrorSchema($validator, array('article_id' => $err));
      }

      $check = TblArticleTable::getInstance()->checkArticleCredentials($article->getId(),
        $article->getType(), $this->getOption('user_id'), $this->getOption('user_type'));
      if (!$check) {
        $err = new sfValidatorError($validator, $i18n->__('Bạn không có quyền phản hồi bài viết này.'));
        throw new sfValidatorErrorSchema($validator, array('article_id' => $err));
      }
    }

    if ($this->getOption('parent_id')) {
      $check = TblCommentTable::getInstance()->checkCommentCredentials($this->getOption('parent_id'),
        $this->getOption('user_id'), $this->getOption('user_type'));
      if (!$check) {
        $err = new sfValidatorError($validator, $i18n->__('Bạn không có quyền phản hồi bình luận này.'));
        throw new sfValidatorErrorSchema($validator, array('article_id' => $err));
      }
    }

    return $values;
  }
}
