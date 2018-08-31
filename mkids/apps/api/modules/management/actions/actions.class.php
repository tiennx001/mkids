<?php

/**
 * management actions.
 *
 * @package    xcode
 * @subpackage management
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class managementActions extends sfActions
{
  public function preExecute(){
    $this->getResponse()->setContentType('application/json');
    parent::preExecute();
  }

  public function executeGetSchoolInfo(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if($school) {
      $data = [
        'name' => $school['name'],
        'phone' => $school['phone'],
        'email' => $school['email'],
        'website' => $school['website'],
        'address' => $school['address'],
        'description' => $school['description'],
      ];
      $errorCode = 0;
      $message = 'success';
    }else{
      $errorCode = UserErrorCode::NO_RESULTS;
      $message = UserErrorCode::getMessage($errorCode);
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeUpdateSchoolInfo(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $formValues = $request->getPostParameters();

    if(empty($formValues['id'])){
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $school = TblSchoolTable::getInstance()->getActiveSchoolByIdAndUserId($formValues['id'], $userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $form = new TblSchoolApiForm($school);
    $formValues['tbl_user_list'] = [$userId];
    $formValues['status'] = $school->getStatus();
    unset($formValues['token']);
    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $form->save();
        $errorCode = 0;
        $message = 'Update school success';
      }catch (Exception $e){
        $errorCode = UserErrorCode::INTERNAL_SERVER_ERROR;
        $message = UserErrorCode::getMessage($errorCode);
        VtHelper::writeLogValue(sprintf('[management][executeUpdateSchoolInfo]|ERROR = %s|params:%s', $e->getMessage(),json_encode($formValues)));
      }
    }else{
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeGetGroupList(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $listGroup = TblGroupTable::getInstance()->getActiveGroupBySchoolId($school['id']);
    if(!count($listGroup)){
      $errorCode = UserErrorCode::NO_RESULTS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    foreach ($listGroup as $group){
      $data[] = [
        'id' => $group['id'],
        'name' => $group['name'],
        'description' => $group['description'],
      ];
    }

    $errorCode = 0;
    $message = 'success';
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeUpdateGroup(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $formValues = $request->getPostParameters();

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(empty($formValues['id'])){
      //truong hop khong truyen id --> them moi group
      $form = new TblGroupApiForm();
      $formValues['status'] = 1;
    }else{
      //truong hop truyen id --> thuc hien cap nhat group
      //lay thong tin khoi thuoc truong
      $group = TblGroupTable::getInstance()->getActiveGroupByIdAndSchoolId($formValues['id'],$school['id']);
      if(!$group){
        $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
      $form = new TblGroupApiForm($group);
      $formValues['status'] = $group->getStatus();
    }

    $formValues['school_id'] = $school['id'];
    unset($formValues['token']);

    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $message = $form->isNew() ? 'Create group success' : 'Update group success';

        $form->save();
        $errorCode = 0;

      }catch (Exception $e){
        $errorCode = UserErrorCode::INTERNAL_SERVER_ERROR;
        $message = UserErrorCode::getMessage($errorCode);
        VtHelper::writeLogValue(sprintf('[management][executeUpdateGroup]|ERROR = %s|params:%s', $e->getMessage(),json_encode($formValues)));
      }
    }else{
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeGetClassList(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $groupId = trim($request->getPostParameter('groupId'));
    $listClass = TblClassTable::getInstance()->getActiveClassInGroup($groupId,$school['id']);
    if(!count($listClass)){
      $errorCode = UserErrorCode::NO_RESULTS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    foreach ($listClass as $class){
      $data[] = [
        'id' => $class['id'],
        'name' => $class['name'],
        'description' => $class['description'],
        'groupId' => $class['group_id'],
        'groupName' => $class['group_name'],
      ];
    }

    $errorCode = 0;
    $message = 'success';
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  /**
   * Ham cap them moi/ cap nhat lop hoc
   * @param sfWebRequest $request
   * @return sfView
   * @throws sfException
   */
  public function executeUpdateClass(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $formValues = $request->getPostParameters();
    $formValues['group_id'] = trim($formValues['groupId']);

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(empty($formValues['group_id'])){
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(empty($formValues['id'])){
      //truong hop khong truyen id --> them moi group
      $form = new TblClassApiForm();
      $formValues['status'] = 1;
    }else{
      //truong hop truyen id --> thuc hien cap nhat group
      //lay thong tin khoi thuoc truong
      $class = TblClassTable::getInstance()->getActiveClassByIdAndGroupId($formValues['id'],$formValues['group_id'],$school['id']);
      if(!$class){
        $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
      $form = new TblClassApiForm($class);
      $formValues['status'] = $class->getStatus();
    }

    unset($formValues['token']);
    unset($formValues['groupId']);

    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $message = $form->isNew() ? 'Create class success' : 'Update class success';

        $form->save();
        $errorCode = 0;

      }catch (Exception $e){
        $errorCode = UserErrorCode::INTERNAL_SERVER_ERROR;
        $message = UserErrorCode::getMessage($errorCode);
        VtHelper::writeLogValue(sprintf('[management][executeUpdateClass]|ERROR = %s|params:%s', $e->getMessage(),json_encode($formValues)));
      }
    }else{
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeGetTeacherList(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $classId = trim($request->getPostParameter('classId'));
    $keyword = trim($request->getPostParameter('kw'));
    $page = trim(intval($request->getPostParameter('page',1)));
    $pageSize = trim(intval($request->getPostParameter('pageSize',10)));

    $listTeacher = TblUserTable::getInstance()->getListUserByType($school['id'],$classId,UserTypeEnum::TEACHER,$keyword,$page,$pageSize);
    if(!count($listTeacher)){
      $errorCode = UserErrorCode::NO_RESULTS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }
    foreach ($listTeacher as $teacher){
      $temp = [];
      foreach ($teacher['TblClass'] as $class){
        $temp[] = ['id' => $class['id'], 'name' => $class['name']];
      }
      $data[] = [
        'id' => $teacher['id'],
        'name' => $teacher['name'],
        'description' => $teacher['description'],
        'imagePath' => $teacher['image_path'],
        'class' => $temp
      ];
    }

    $errorCode = 0;
    $message = 'success';
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeUpdateTeacher(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $formValues = $request->getPostParameters();
    $formValues['tbl_class_list'] = explode(',',trim($formValues['classId']));
    $formValues['type'] = UserTypeEnum::TEACHER;
    $formValues['image_path'] = !empty($formValues['image']) ? $formValues['image'] : '';

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(empty($formValues['id'])){
      //truong hop khong truyen id --> them moi
      $form = new TblUserApiForm();
      $formValues['status'] = 1;
    }else{
      //truong hop truyen id --> thuc hien cap nhat
      //lay thong tin khoi thuoc truong
      $teacher = TblUserTable::getInstance()->getUserById($formValues['id'],$school['id'],UserTypeEnum::TEACHER);
      if(!$teacher){
        $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
      $form = new TblUserApiForm($teacher);
      $formValues['status'] = $teacher->getStatus();
    }

    unset($formValues['token']);
    unset($formValues['image']);
    unset($formValues['classId']);

    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $message = $form->isNew() ? 'Create teacher success' : 'Update teacher success';
        $form->save();
        $errorCode = 0;
      }catch (Exception $e){
        $errorCode = UserErrorCode::INTERNAL_SERVER_ERROR;
        $message = UserErrorCode::getMessage($errorCode);
        VtHelper::writeLogValue(sprintf('[management][executeUpdateClass]|ERROR = %s|params:%s', $e->getMessage(),json_encode($formValues)));
      }
    }else{
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      foreach ($form as $f) {
        if ($f->hasError()) {
          $message = VtHelper::strip_html_tags($f->getError());
        }
      }
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }
}
