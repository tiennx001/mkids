<?php

/**
 * comment actions.
 *
 * @package    xcode
 * @subpackage comment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class commentActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
//    $this->forward('default', 'module');
  }

  /**
   * Ham tao binh luan
   *
   * @author Tiennx6
   * @since 06/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeCreateComment(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeCreateComment|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $content = $request->getPostParameter('content', null);
    $articleId = $request->getPostParameter('articleId', null);
    VtHelper::writeLogValue('executeCreateComment|Acc=' . $info['account'] . '|Comment with content=' . $content . ', articleId=' . $articleId);
    $values = array(
      'content' => $content,
      'article_id' => $articleId
    );
    $form = new CommentValidateForm(array(), array(
      'user_id' => $info['user_id'],
      'user_type' => $info['user_type']
    ));
    $form->bind($values);
    if (!$form->isValid()) {
      VtHelper::writeLogValue('executeCreateComment|Acc=' . $info['account'] . '|Request values are not valid');
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $widget) {
        if ($widget->hasError()) {
          $message = VtHelper::strip_html_tags($widget->getError());
        }
      }
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      // Save comment to DB
      $comment = new TblComment();
      $comment->setContent($content);
      $comment->setStatus(true);
      $comment->setUserId($info['user_id']);
      $comment->setArticleId($articleId);
      $comment->setCreatedAt(date("Y-m-d H:i:s"));
      $comment->setUpdatedAt(date("Y-m-d H:i:s"));
      $comment->save();

      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeUpdateArticle|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham tra loi binh luan
   *
   * @author Tiennx6
   * @since 06/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeReplyComment(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeReplyComment|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $id = $request->getPostParameter('id', null);
    if ($id === null) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $comment = TblCommentTable::getInstance()->getCommentById(intval($id));
    if (!$comment) {
      $errorCode = defaultErrorCode::NOT_FOUND;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $content = $request->getPostParameter('content', null);
    if ($content === null) {
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
    VtHelper::writeLogValue('executeReplyComment|Acc=' . $info['account'] . '|Reply comment with ID=' . $id . ', content=' . $content);

    $values = array(
      'content' => $content
    );

    $form = new CommentValidateForm(array(), array(
      'parent_id' => $id,
      'user_id' => $info['user_id'],
      'user_type' => $info['user_type']
    ));
    $form->bind($values);
    if (!$form->isValid()) {
      VtHelper::writeLogValue('executeReplyComment|Acc=' . $info['account'] . '|Request values are not valid');
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $widget) {
        if ($widget->hasError()) {
          $message = VtHelper::strip_html_tags($widget->getError());
        }
      }
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      // Save comment to DB
      $replyComment = new TblComment();
      $replyComment->setContent($content);
      $replyComment->setStatus(true);
      $replyComment->setParentId($comment->getId());
      $replyComment->setUserId($info['user_id']);
      $replyComment->setCreatedAt(date("Y-m-d H:i:s"));
      $replyComment->setUpdatedAt(date("Y-m-d H:i:s"));
      $replyComment->save();

      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeReplyComment|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham lay danh sach binh luan
   *
   * @author Tiennx6
   * @since 30/08/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeGetCommentList(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeGetCommentList|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $kw = $request->getPostParameter('kw', null);
    $page = (int)$request->getPostParameter('page', 1);
    $pageSize = (int)$request->getPostParameter('pageSize', 10);
    $articleId = (int)$request->getPostParameter('articleId', null);

    if ($page < 1 || $pageSize < 1) {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if ($articleId) {
      $article = TblArticleTable::getInstance()->getArticleById($articleId);
      if (!$article) {
        $errorCode = UserErrorCode::NO_RESULTS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      // Kiem tra quyen bai viet
      $check = TblArticleTable::getInstance()->checkArticleCredentials($articleId, $article->getType(),
        $info['user_id'], $info['user_type']);
      if (!$check) {
        $errorCode = UserErrorCode::FORBIDDEN;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }
    }

    $offset = ($page - 1) * $pageSize;
    $data = array();
    try {
      // Kiem tra quyen chung
      $schoolIds = TblSchoolTable::getInstance()->getActiveSchoolIdsByUserId($info['user_id'], $info['user_type']);
      $listComments = TblCommentTable::getInstance()->getListComments($kw, $offset, $pageSize, $articleId, $schoolIds);
      if (count($listComments)) {
        foreach ($listComments as $comment) {
          $item = new stdClass();
          $item->id = $comment->id;
          $item->content = $comment->content;
          $tblUser = $comment->TblUser;
          if ($tblUser) {
            $userObj = new stdClass();
            $userObj->id = $tblUser->getId();
            $userObj->name = $tblUser->getName();
            $userObj->imagePath = $tblUser->getImagePath();
            $item->user = $userObj;
          }
          $item->commentTime = $comment->created_at;
          // Get reply comment list
          $replyList = TblCommentTable::getInstance()->getCommentListByParentId($comment->getId());
          if (count($replyList)) {
            foreach ($replyList as $replyComment) {
              $replyItem = new stdClass();
              $replyItem->id = $replyComment->id;
              $replyItem->content = $replyComment->content;
              $replyUser = $replyComment->TblUser;
              if ($replyUser) {
                $replyUserObj = new stdClass();
                $replyUserObj->id = $replyUser->getId();
                $replyUserObj->name = $replyUser->getName();
                $replyUserObj->imagePath = $replyUser->getImagePath();
                $replyItem->replyUser = $replyUserObj;
              }
              $replyItem->replyTime = $replyComment->created_at;
              $item->replyList[] = $replyItem;
            }
          }
          $data[] = $item;
        }
        $errorCode = UserErrorCode::SUCCESS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      } else {
        $errorCode = UserErrorCode::NO_RESULTS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeGetCommentList|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham xoa binh luan
   *
   * @author Tiennx6
   * @since 05/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeRemoveComment(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeRemoveComment|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $id = $request->getPostParameter('id', null);
    $comment = TblCommentTable::getInstance()->getCommentByIdAndUserId(intval($id), $info['user_id'], $info['user_type']);
    if (!$comment) {
      VtHelper::writeLogValue('executeRemoveComment|Acc=' . $info['account'] . '|Comment not found with ID=' . $id);
      $errorCode = defaultErrorCode::NOT_FOUND;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      // Thuc hien cap nhat xoa ban tin
      $comment->setIsDelete(true);
      $comment->setUpdatedAt(date('Y-m-d H:i:s'));
      $comment->save();

      VtHelper::writeLogValue('executeRemoveComment|Acc=' . $info['account'] . '|Remove comment success with ID=' . $id);
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeRemoveComment|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }
}
