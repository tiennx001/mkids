<?php

/**
 * article actions.
 *
 * @package    xcode
 * @subpackage article
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articleActions extends sfActions
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
   * Ham them moi/cap nhat bang tin
   *
   * @author Tiennx6
   * @since 05/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeUpdateArticle(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeUpdateArticle|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $id = $request->getPostParameter('id', null);
    if ($id === null) {
      $isNew = true;
      $article = new TblArticle();
    } else {
      $isNew = false;
      $article = TblArticleTable::getInstance()->getArticleByIdAndUserId(intval($id), $info['user_id']);
      if (!$article) {
        $errorCode = defaultErrorCode::NOT_FOUND;
        $message = defaultErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }
    }
    VtHelper::writeLogValue('executeUpdateArticle|Acc=' . $info['account'] . '|Article is new=' . $isNew);

    // Parameters
    $title = $request->getParameter('title');
    $content = $request->getParameter('content');
//    $image = $request->getParameter('image');
    $type = $request->getParameter('type');
    $groupList = $request->getParameter('groupList');
    $classList = $request->getParameter('classList');
    $memberList = $request->getParameter('memberList');

    $groupArr = json_decode($groupList, true);
    $classArr = json_decode($classList, true);
    $memberArr = json_decode($memberList, true);

    $values = array(
      'title' => $title,
      'content' => $content,
//      'image' => $image,
      'type' => $type,
      'tbl_group_list' => $groupArr,
      'tbl_class_list' => $classArr,
      'tbl_member_list' => $memberArr
    );

    $form = new ArticleValidateForm();
    $form->bind($values);
    if (!$form->isValid()) {
      VtHelper::writeLogValue('executeUpdateArticle|Acc=' . $info['account'] . '|Request values are not valid');
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

//    $path = VtHelper::generatePath(sfConfig::get('app_user_image_path', '/uploads/images/article'));
//    $fileName = md5($info['account'] . date('YmdHis')) . '.' . sfConfig::get('app_user_image_ext', 'jpg');
//    $avatarPath = $path . $fileName;
    try {
//      // Convert and upload image
//      mKidsHelper::base64_to_jpeg($image, sfConfig::get('sf_web_dir') . $avatarPath);
//      if (!getimagesize(sfConfig::get('sf_web_dir') . $avatarPath)) {
//        $errorCode = UserErrorCode::INVALID_UPLOADED_IMAGE;
//        $message = UserErrorCode::getMessage($errorCode);
//        $jsonObj = new jsonObject($errorCode, $message);
//        return $this->renderText($jsonObj->toJson());
//      }

      $article->setTitle($title);
      $article->setContent($content);
//      $article->setImagePath($avatarPath);
      $article->setType($type);
      $article->setStatus(true);
      $article->setUserId($info['user_id']);
      if ($isNew) {
        $article->setCreatedAt(date("Y-m-d H:i:s"));
      }
      $article->setUpdatedAt(date("Y-m-d H:i:s"));
      $article->save();

      if (count($groupArr) || count($classArr) || count($memberArr)) {
        if (!$isNew) {
          // Delete old reference
          TblArticleRefTable::getInstance()->deleteOldData($article->getId());
        }

        $coll = new Doctrine_Collection('TblArticleRef');
        // Save reference table
        switch ($type) {
          case NotificationProgTypeEnum::TO_GROUP:
            foreach ($groupArr as $groupId) {
              $notifProgRef = new TblArticleRef();
              $notifProgRef->setArticleId($article->getId());
              $notifProgRef->setGroupId($groupId);
              $coll->add($notifProgRef);
            }
            break;
          case NotificationProgTypeEnum::TO_CLASS:
            foreach ($classArr as $classId) {
              $notifProgRef = new TblArticleRef();
              $notifProgRef->setArticleId($article->getId());
              $notifProgRef->setClassId($classId);
              $coll->add($notifProgRef);
            }
            break;
          case NotificationProgTypeEnum::TO_MEMBER:
            foreach ($memberArr as $memberId) {
              $notifProgRef = new TblArticleRef();
              $notifProgRef->setArticleId($article->getId());
              $notifProgRef->setMemberId($memberId);
              $coll->add($notifProgRef);
            }
            break;
        }
        $coll->save();
      }

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
   * Ham them anh cho ban tin
   *
   * @author Tiennx6
   * @since 05/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeAddArticleImage(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeAddArticleImage|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $articleId = $request->getPostParameter('articleId', null);
    $article = TblArticleTable::getInstance()->getArticleByIdAndUserId(intval($articleId), $info['user_id']);
    if (!$article) {
      $errorCode = defaultErrorCode::NOT_FOUND;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    // Parameters
    $title = $request->getParameter('title');
    $image = $request->getParameter('image');

    $values = array(
      'title' => $title,
      'image' => $image,
    );

    $form = new ArticleValidateForm(array(), array('is_add_image' => true));
    $form->bind($values);
    if (!$form->isValid()) {
      VtHelper::writeLogValue('executeAddArticleImage|Acc=' . $info['account'] . '|Request values are not valid');
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

    $path = VtHelper::generatePath(sfConfig::get('app_article_image_path', '/uploads/images/article'));
    $fileName = md5($info['account'] . date('YmdHis')) . '.' . sfConfig::get('app_conversion_image_extension', 'jpg');
    $avatarPath = $path . $fileName;
    try {
      // Convert and upload image
      mKidsHelper::base64_to_jpeg($image, sfConfig::get('sf_web_dir') . $avatarPath);
      if (!getimagesize(sfConfig::get('sf_web_dir') . $avatarPath)) {
        $errorCode = UserErrorCode::INVALID_UPLOADED_IMAGE;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      $articleImage = new TblArticleImage();
      $articleImage->setTitle($title);
      $articleImage->setImagePath($avatarPath);
      $articleImage->setArticleId($articleId);
      $articleImage->setStatus(true);
      $articleImage->setCreatedAt(date("Y-m-d H:i:s"));
      $articleImage->setUpdatedAt(date("Y-m-d H:i:s"));
      $articleImage->save();

      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeAddArticleImage|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham xoa anh ban tin
   *
   * @author Tiennx6
   * @since 05/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeRemoveArticleImage(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeRemoveArticleImage|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $id = $request->getPostParameter('id', null);
    $image = TblArticleImageTable::getInstance()->getImageByIdAndUserId(intval($id), $info['user_id']);
    if (!$image) {
      VtHelper::writeLogValue('executeRemoveArticle|Acc=' . $info['account'] . '|Article image not found with ID=' . $id);
      $errorCode = defaultErrorCode::NOT_FOUND;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      // Thuc hien cap nhat xoa anh ban tin
      $image->setIsDelete(true);
      $image->setUpdatedAt(date('Y-m-d H:i:s'));
      $image->save();

      VtHelper::writeLogValue('executeRemoveArticleImage|Acc=' . $info['account'] . '|Remove article image success with ID=' . $id);
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeRemoveArticleImage|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham lay danh sach bang tin
   *
   * @author Tiennx6
   * @since 30/08/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeGetArticleList(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeGetArticleList|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $kw = $request->getPostParameter('kw', null);
    $page = (int)$request->getPostParameter('page', 1);
    $pageSize = (int)$request->getPostParameter('pageSize', 10);

    if ($page < 1 || $pageSize < 1) {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $offset = ($page - 1) * $pageSize;
    $data = array();
    try {
      $listArticles = TblArticleTable::getInstance()->getListArticles($kw, $offset, $pageSize, $info['user_id'], $info['user_type']);
      if (count($listArticles)) {
        foreach ($listArticles as $article) {
          $item = new stdClass();
          $item->id = $article->id;
          $item->title = $article->title;
          $item->content = $article->content;
          $item->type = $article->type;
          if ($article->getTblArticleImage() && count($article->getTblArticleImage())) {
            foreach ($article->getTblArticleImage() as $image) {
              $imageObj = new stdClass();
              $imageObj->id = $image->getId();
              $imageObj->title = $image->getTitle();
              $imageObj->imagePath = $image->getImagePath();
              $item->imageList[] = $imageObj;
            }
          }
          if ($article->getTblGroup() && count($article->getTblGroup())) {
            foreach ($article->getTblGroup() as $group) {
              $groupObj = new stdClass();
              $groupObj->id = $group->getId();
              $groupObj->name = $group->getName();
              $item->groupList[] = $groupObj;
            }
          }
          if ($article->getTblClass() && count($article->getTblClass())) {
            foreach ($article->getTblClass() as $class) {
              $classObj = new stdClass();
              $classObj->id = $class->getId();
              $classObj->name = $class->getName();
              $item->classList[] = $classObj;
            }
          }
          if ($article->getTblMember() && count($article->getTblMember())) {
            foreach ($article->getTblMember() as $member) {
              $memberObj = new stdClass();
              $memberObj->id = $member->getId();
              $memberObj->name = $member->getName();
              $memberObj->imagePath = $member->getImagePath();
              $item->memberList[] = $memberObj;
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
      VtHelper::writeLogValue('executeGetArticleList|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham xoa ban tin
   *
   * @author Tiennx6
   * @since 05/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeRemoveArticle(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeRemoveArticle|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $id = $request->getPostParameter('id', null);
    $article = TblArticleTable::getInstance()->getArticleByIdAndUserId(intval($id), $info['user_id']);
    if (!$article) {
      VtHelper::writeLogValue('executeRemoveArticle|Acc=' . $info['account'] . '|Article not found with ID=' . $id);
      $errorCode = defaultErrorCode::NOT_FOUND;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      // Thuc hien cap nhat xoa ban tin
      $article->setIsDelete(true);
      $article->setUpdatedAt(date('Y-m-d H:i:s'));
      $article->save();

      VtHelper::writeLogValue('executeRemoveArticle|Acc=' . $info['account'] . '|Remove article success with ID=' . $id);
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
}
