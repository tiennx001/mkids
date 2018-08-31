<?php

/**
 * notification actions.
 *
 * @package    xcode
 * @subpackage notification
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class notificationActions extends sfActions
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
   * Ham them moi/cap nhat chuong trinh thong bao
   *
   * @author Tiennx6
   * @since 30/08/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeUpdateNotificationProgram(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeUpdateNotificationProgram|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $id = $request->getPostParameter('id', null);
    if ($id === null) {
      $isNew = true;
      $notifProg = new TblNotificationProgram();
    } else {
      $isNew = false;
      $notifProg = TblNotificationProgramTable::getInstance()->getProgByUserId(intval($id), $info['user_id']);
      if (!$notifProg) {
        $errorCode = defaultErrorCode::NOT_FOUND;
        $message = defaultErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }
    }
    VtHelper::writeLogValue('executeUpdateNotificationProgram|Acc=' . $info['account'] . '|Program is new=' . $isNew);

    // Parameters
    $type = $request->getParameter('type');
    $content = $request->getParameter('content');
    $articleId = $request->getParameter('articleId');
    $startTime = $request->getParameter('startTime');
    $status = $request->getParameter('status');
    $groupList = $request->getParameter('groupList');
    $classList = $request->getParameter('classList');
    $memberList = $request->getParameter('memberList');

    $groupArr = json_decode($groupList, true);
    $classArr = json_decode($classList, true);
    $memberArr = json_decode($memberList, true);

    $values = array(
      'type' => $type,
      'content' => $content,
      'articleId' => $articleId,
      'startTime' => $startTime,
      'status' => $status,
      'groupList' => $groupArr,
      'classList' => $classArr,
      'memberList' => $memberArr
    );

    $form = new NotificationProgramValidateForm();
    $form->bind($values);
    if (!$form->isValid()) {
      VtHelper::writeLogValue('executeUpdateNotificationProgram|Acc=' . $info['account'] . '|Request values are not valid');
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      if ($form['password']->hasError())
        $message = VtHelper::strip_html_tags($form['password']->getError());
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      $notifProg->setType($type);
      $notifProg->setContent($content);
      $notifProg->setArticleId($articleId);
      $notifProg->setStartTime($startTime);
      $notifProg->setStatus($status);
      if ($isNew) {
        $notifProg->setCreatedAt(date("Y-m-d H:i:s"));
      }
      $notifProg->setUpdatedAt(date("Y-m-d H:i:s"));
      $notifProg->save();

      if (count($groupArr) || count($classArr) || count($memberArr)) {
        if (!$isNew) {
          // Delete old reference
          TblNotificationProgramRefTable::getInstance()->deleteOldData($notifProg->getId());
        }

        $coll = new Doctrine_Collection('TblNotificationProgramRef');
        // Save reference table
        switch ($type) {
          case NotificationProgTypeEnum::TO_GROUP:
            foreach ($groupArr as $groupId) {
              $notifProgRef = new TblNotificationProgramRef();
              $notifProgRef->setProgramId($notifProg->getId());
              $notifProgRef->setGroupId($groupId);
              $coll->add($notifProgRef);
            }
            break;
          case NotificationProgTypeEnum::TO_CLASS:
            foreach ($classArr as $classId) {
              $notifProgRef = new TblNotificationProgramRef();
              $notifProgRef->setProgramId($notifProg->getId());
              $notifProgRef->setClassId($classId);
              $coll->add($notifProgRef);
            }
            break;
          case NotificationProgTypeEnum::TO_MEMBER:
            foreach ($memberArr as $memberId) {
              $notifProgRef = new TblNotificationProgramRef();
              $notifProgRef->setProgramId($notifProg->getId());
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
      VtHelper::writeLogValue('executeUpdateNotificationProgram|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham lay danh sach chuong trinh thong bao
   *
   * @author Tiennx6
   * @since 30/08/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeGetNotificationProgramList(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeGetNotificationProgramList|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $kw = $request->getPostParameter('kw', null);
    $page = $request->getPostParameter('page', 1);
    $pageSize = $request->getPostParameter('page', 10);

    if ($page < 1 || $pageSize < 1) {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $offset = ($page - 1) * $pageSize + 1;
    $listNotificationProgs = TblNotificationProgramTable::getInstance()->getListNotificationProgs($kw, $offset, $pageSize, $info['user_id']);
    if (count($listNotificationProgs)) {
      foreach ($listNotificationProgs as $notificationProg) {

      }
    } else {
      $errorCode = UserErrorCode::NO_RESULTS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeGetNotificationProgramList|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }
}
