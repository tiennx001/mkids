<?php

/**
 * member actions.
 *
 * @package    xcode
 * @subpackage member
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class memberActions extends sfActions
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
   * Ham lay danh sach quan so theo lop
   *
   * @author Tiennx6
   * @since 07/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeGetAttendanceByClass(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeGetAttendanceByClass|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $data = array();
    try {
      $classIds = null;
      if ($info['user_type'] == UserTypeEnum::TEACHER) {
        $classIds = TblClassTable::getInstance()->getClassIdsByUserId($info['user_id']);
      }

      $date = $request->getPostParameter('date', null);
      if (!$date) {
        $errorCode = UserErrorCode::MISSING_PARAMETERS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $errorCode = UserErrorCode::INVALID_DATE_FORMAT;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      if ($date > date('Y-m-d')) {
        $errorCode = UserErrorCode::FILTER_DATE_COULD_NOT_GREATER_THAN_NOW;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      $classId = (int)$request->getPostParameter('classId', null);
      $listActivities = TblMemberActivityTable::getInstance()->getListActivities($classId, $date, $classIds);
      if (!$listActivities) {
        $errorCode = defaultErrorCode::NOT_FOUND;
        $message = defaultErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      if (count($listActivities)) {
        foreach ($listActivities as $activity) {
          $member = TblMemberTable::getInstance()->getActiveMemberById($activity->getMemberId());
          if ($member) {
            $memberObj = new stdClass();
            $memberObj->id = $member->getId();
            $memberObj->name = $member->getName();
            $memberObj->imagePath = $member->getImagePath();
            if (in_array($activity->getType(), ActivityTypeEnum::getAttendanceArr())) {
              $data['attendantMembers'][] = $memberObj;
            } else {
              $data['absentMembers'][] = $memberObj;
            }
          }
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
      VtHelper::writeLogValue('executeGetAttendanceByClass|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham lay lich su nghi hoc/tinh hinh suc khoe ca nhan
   *
   * @author Tiennx6
   * @since 08/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeGetMemberActivity(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeGetMemberActivity|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $memberId = (int)$request->getPostParameter('memberId', null);
    $fromDate = $request->getPostParameter('fromDate');
    $toDate = $request->getPostParameter('toDate');
    $page = (int)$request->getPostParameter('page', 1);
    $pageSize = (int)$request->getPostParameter('pageSize', 10);

    if ($page < 1 || $pageSize < 1) {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if (($fromDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fromDate)) || ($toDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $toDate))) {
      $errorCode = UserErrorCode::INVALID_DATE_FORMAT;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if ($fromDate > date('Y-m-d') || $toDate > date('Y-m-d')) {
      $errorCode = UserErrorCode::FILTER_DATE_COULD_NOT_GREATER_THAN_NOW;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    if ($fromDate > $toDate) {
      $errorCode = UserErrorCode::FROM_DATE_MUST_LESS_THAN_TO_DATE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $offset = ($page - 1) * $pageSize;
    $data = array();
    try {
      $classIds = null;
      if ($info['user_type'] == UserTypeEnum::TEACHER) {
        $classIds = TblUserClassRefTable::getInstance()->getClassIdsByUserId($info['user_id']);
      }

      $memberIds = null;
      if ($info['user_type'] == UserTypeEnum::PARENTS) {
        $memberIds = TblMemberUserRefTable::getInstance()->getMemberIdsByUserId($info['user_id']);
      }

      $listActivities = TblMemberActivityTable::getInstance()->getMemberHistory($fromDate, $toDate, $memberId, $classIds, $memberIds, $offset, $pageSize);
      if (!$listActivities) {
        $errorCode = defaultErrorCode::NOT_FOUND;
        $message = defaultErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      foreach ($listActivities as $activity) {
        $actObj = new stdClass();
        $actObj->id = $activity->getId();
        $actObj->name = $activity->getName();
        $actObj->imagePath = $activity->getImagePath();
        $actObj->type = $activity->getType();
        $actObj->description= $activity->getDescription();
        $actObj->health = $activity->getHealth();
        $actObj->height = $activity->getHeight();
        $actObj->weight = $activity->getWeight();
        $actObj->date = $activity->getDate();
        $data[] = $actObj;
      }

      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeGetMemberActivity|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }
}
