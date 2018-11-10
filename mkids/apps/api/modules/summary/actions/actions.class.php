<?php

/**
 * summary actions.
 *
 * @package    xcode
 * @subpackage summary
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class summaryActions extends sfActions
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
   * Ham gui nhan xet
   *
   * @author Tiennx6
   * @since 11/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeUpdateSummary(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeUpdateSummary|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $id = $request->getPostParameter('id', null);
    if ($id === null) {
      $isNew = true;
      $summaryRecord = new TblSummary();
    } else {
      $isNew = false;
      $summaryRecord = TblSummaryTable::getInstance()->getSummaryByIdAndUserId(intval($id), $info['user_id']);
      if (!$summaryRecord) {
        $errorCode = UserErrorCode::NO_RESULTS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }
    }
    VtHelper::writeLogValue('executeUpdateSummary|Acc=' . $info['account'] . '|Summary is new=' . $isNew);

    // Parameters
    $memberId = $request->getParameter('memberId');
    $date = $request->getParameter('date');
    $week = $request->getParameter('week');
    $summary = $request->getParameter('summary');
    $learning = $request->getParameter('learning');
    $behavior = $request->getParameter('behavior');
    $attendance = $request->getParameter('attendance');
    $description = $request->getParameter('description');

    $values = array(
      'member_id' => $memberId,
      'date' => $date,
      'week' => $week,
      'summary' => $summary,
      'learning' => $learning,
      'behavior' => $behavior,
      'attendance' => $attendance,
      'description' => $description
    );

    $form = new SummaryValidateForm($summaryRecord);
    $form->bind($values);
    if (!$form->isValid()) {
      VtHelper::writeLogValue('executeUpdateSummary|Acc=' . $info['account'] . '|Request values are not valid');
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
      $summaryRecord->setMemberId($memberId);
      $summaryRecord->setDate($date);
      $summaryRecord->setWeek($week);
      $summaryRecord->setSummary($summary);
      $summaryRecord->setLearning($learning);
      $summaryRecord->setBehavior($behavior);
      $summaryRecord->setAttendance($attendance);
      $summaryRecord->setDescription($description);
      $summaryRecord->setUserId($info['user_id']);
      $summaryRecord->setStatus(true);
      if ($isNew) {
        $summaryRecord->setCreatedAt(date("Y-m-d H:i:s"));
      }
      $summaryRecord->setUpdatedAt(date("Y-m-d H:i:s"));
      $summaryRecord->save();

      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeUpdateSummary|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }

  /**
   * Ham lay lich su nhan xet
   *
   * @author Tiennx6
   * @since 11/09/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeGetSummaryHistory(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeGetSummaryHistory|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

    $page = (int)$request->getPostParameter('page', 1);
    $pageSize = (int)$request->getPostParameter('pageSize', 10);

    if ($page < 1 || $pageSize < 1) {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }

    $memberId = $request->getParameter('memberId');
    $date = $request->getParameter('date');
    $week = $request->getParameter('week');

    $values = array(
      'member_id' => $memberId,
      'date' => $date,
      'week' => $week
    );

    $form = new SummaryValidateForm(array(), array('is_list' => true));
    $form->bind($values);
    if (!$form->isValid()) {
      VtHelper::writeLogValue('executeGetSummaryHistory|Acc=' . $info['account'] . '|Request values are not valid');
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

    $offset = ($page - 1) * $pageSize;
    $data = array();
    try {
      $memberIds = null;
      if ($info['user_type'] == UserTypeEnum::TEACHER) {
        $memberIds = TblUserClassRefTable::getInstance()->getMemberIdsByUserId($info['user_id']);
      } else if ($info['user_type'] == UserTypeEnum::PARENTS) {
        $memberIds = TblMemberUserRefTable::getInstance()->getMemberIdsByUserId($info['user_id']);
        // Fix - Tam thoi - Phu huynh chi co 1 con hoc o truong
        $memberId = $memberIds[0];
      }

      $listSummary = TblSummaryTable::getInstance()->getSummaryList($memberId, $date, $week, $offset, $pageSize, $memberIds);
      if (count($listSummary)) {
        foreach ($listSummary as $summaryRecord) {
          $item = new stdClass();
          $item->id = $summaryRecord->TblMember->id;
          $item->name = $summaryRecord->TblMember->name;
          $item->imagePath = mKidsHelper::getImageFullPath($summaryRecord->TblMember->image_path);
          $item->date = $summaryRecord->date;
          $item->week = $summaryRecord->week;
          $item->summary = $summaryRecord->summary;
          $item->learning = $summaryRecord->learning;
          $item->behavior = $summaryRecord->behavior;
          $item->attendance = $summaryRecord->attendance;
          $item->description = $summaryRecord->description;
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
      VtHelper::writeLogValue('executeGetSummaryHistory|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }
}
