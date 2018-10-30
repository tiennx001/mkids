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
  public function preExecute(){
    $this->getResponse()->setContentType('application/json');
    parent::preExecute();
  }
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
        // Fix - Tam thoi - Phu huynh chi co 1 con hoc o truong
        $memberId = $memberIds[0];
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
        $actObj->id = $activity->getTblMember()->getId();
        $actObj->name = $activity->getTblMember()->getName();
        $actObj->imagePath = $activity->getTblMember()->getImagePath();
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

  public function executeUpdateMemberActivity(sfWebRequest $request){
    $data = [];
    $userId = $this->getUser()->getUserId();

    $formValues['member_id'] = $request->getPostParameter('memberId');
    $formValues['type'] = $request->getPostParameter('type');
    $formValues['date'] = $request->getPostParameter('date');
    $formValues['description'] = $request->getPostParameter('description');
    $formValues['status'] = $request->getPostParameter('status');

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(!empty($formValues['member_id']) && !empty($formValues['date'])){
      $activity = TblMemberActivityTable::getInstance()->getActivityByMemberIdAndDate($formValues['member_id'],$formValues['date']);
    }else{
      $activity = null;
    }
    $form = new TblMemberActivityApiForm($activity, ['school_id' => $school['id']]);
    if($formValues['status'] == '')
      $form->useFields(['member_id','date','type','description']);
    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $message = $form->isNew() ? 'Create activity success' : 'Update activity success';
        $form->save();

        $errorCode = 0;
      }catch (Exception $e){
        $errorCode = UserErrorCode::INTERNAL_SERVER_ERROR;
        $message = UserErrorCode::getMessage($errorCode);
        VtHelper::writeLogValue(sprintf('[management][executeUpdateMemberActivity]|ERROR = %s|params:%s', $e->getMessage(),json_encode($formValues)));
      }
    }else{
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $key => $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeUpdateHealthStatus(sfWebRequest $request){
    $data = [];
    $userId = $this->getUser()->getUserId();

    $formValues['member_id'] = $request->getPostParameter('memberId');
    $formValues['date'] = $request->getPostParameter('date');
    $formValues['description'] = $request->getPostParameter('description');
    $formValues['health'] = $request->getPostParameter('health');
    $formValues['height'] = $request->getPostParameter('height');
    $formValues['weight'] = $request->getPostParameter('weight');
    $formValues['status'] = $request->getPostParameter('status');

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(!empty($formValues['member_id']) && !empty($formValues['date'])){
      $activity = TblMemberHealthTable::getInstance()->getHealthByMemberIdAndDate($formValues['member_id'],$formValues['date']);
    }else{
      $activity = null;
    }
    $form = new TblMemberHealthApiForm($activity, ['school_id' => $school['id']]);
    if($formValues['status'] == '')
      $form->useFields(['member_id','date','health','description','height','weight']);
    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $message = $form->isNew() ? 'Create activity success' : 'Update activity success';
        $form->save();
        $errorCode = 0;
      }catch (Exception $e){
        $errorCode = UserErrorCode::INTERNAL_SERVER_ERROR;
        $message = UserErrorCode::getMessage($errorCode);
        VtHelper::writeLogValue(sprintf('[management][executeUpdateHealthStatus]|ERROR = %s|params:%s', $e->getMessage(),json_encode($formValues)));
      }
    }else{
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $key => $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeUpdateAbsenceTicket(sfWebRequest $request){
    $data = [];
    $info = $this->getUser()->getAttribute('userInfo');

    $formValues['member_id'] = $request->getPostParameter('memberId');
    $formValues['date'] = $request->getPostParameter('date');
    $formValues['reason'] = $request->getPostParameter('reason');
    $formValues['status'] = $request->getPostParameter('status');

    $ticket = null;
    $classIds = null;
    if ($info['user_type'] == UserTypeEnum::TEACHER) {
      $classIds = TblUserClassRefTable::getInstance()->getClassIdsByUserId($info['user_id']);
      $ticketId = $request->getPostParameter('id');
      if (!$ticketId) {
        $errorCode = UserErrorCode::MISSING_PARAMETERS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      $ticket = TblAbsenceTicketTable::getInstance()->getActiveTicketById($ticketId);
      if (!$ticket) {
        $errorCode = UserErrorCode::NO_RESULTS;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }
    }

    $memberIds = null;
    if ($info['user_type'] == UserTypeEnum::PARENTS) {
      $memberIds = TblMemberUserRefTable::getInstance()->getMemberIdsByUserId($info['user_id']);
      if(!empty($formValues['member_id']) && !empty($formValues['date'])){
        $ticket = TblAbsenceTicketTable::getInstance()->getTicketByMemberIdAndDate($formValues['member_id'], $formValues['date']);
      }
    }

    $form = new TblAbsenceTicketApiForm($ticket, ['class_ids' => $classIds, 'member_ids' => $memberIds, 'user_info' => $info]);
    if ($formValues['status'] == '') {
      $form->useFields(['member_id', 'date', 'reason']);
    }

    $form->bind($formValues);
    if ($form->isValid()) {
      try {
        $form->save();
        $errorCode = UserErrorCode::SUCCESS;
        $message = UserErrorCode::getMessage($errorCode);
      } catch (Exception $e) {
        $errorCode = UserErrorCode::INTERNAL_SERVER_ERROR;
        $message = UserErrorCode::getMessage($errorCode);
        VtHelper::writeLogValue(sprintf('[management][executeCreateAbsenceTicket]|ERROR = %s|params:%s', $e->getMessage(),json_encode($formValues)));
      }
    } else {
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $key => $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  /**
   * Ham lay danh sach don xin nghi
   *
   * @author Tiennx6
   * @since 28/10/2018
   * @param sfWebRequest $request
   * @return sfView
   */
  public function executeGetAbsenceTicket(sfWebRequest $request)
  {
    $info = $this->getUser()->getAttribute('userInfo');
    VtHelper::writeLogValue('executeGetAbsenceTicket|Acc=' . $info['account'] . '|Starting request with params=' . json_encode($request));

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
        // Fix - Tam thoi - Phu huynh chi co 1 con hoc o truong
        $memberId = $memberIds[0];
      }

      $listTickets = TblAbsenceTicketTable::getInstance()->getAbsenceTicketList($fromDate, $toDate, $memberId, $classIds, $memberIds, $offset, $pageSize);
      if (!$listTickets) {
        $errorCode = defaultErrorCode::NOT_FOUND;
        $message = defaultErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        return $this->renderText($jsonObj->toJson());
      }

      foreach ($listTickets as $ticket) {
        $actObj = new stdClass();
        $actObj->id = $ticket->getId();
        $actObj->member_id = $ticket->getTblMember()->getId();
        $actObj->name = $ticket->getTblMember()->getName();
        $actObj->imagePath = $ticket->getTblMember()->getImagePath();
        $actObj->status= $ticket->getStatus();
        $actObj->reason= $ticket->getReason();
        $actObj->date = $ticket->getDate();
        $data[] = $actObj;
      }

      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    } catch (Exception $e) {
      VtHelper::writeLogValue('executeGetAbsenceTicket|Acc=' . $info['account'] . '|Internal server error=' . $e->getMessage());
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      return $this->renderText($jsonObj->toJson());
    }
  }
}
