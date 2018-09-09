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
    $formValues['tbl_user_list'] = [$userId];
    $formValues['status'] = $request->getPostParameter('status');
    $formValues['id'] = $request->getPostParameter('id');
    $formValues['name'] = $request->getPostParameter('name');
    $formValues['phone'] = $request->getPostParameter('phone');
    $formValues['email'] = $request->getPostParameter('email');
    $formValues['website'] = $request->getPostParameter('website');
    $formValues['address'] = $request->getPostParameter('address');
    $formValues['description'] = $request->getPostParameter('description');

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
        'status' => (int)$group['status'],
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
    $formValues['id'] = $request->getPostParameter('id');
    $formValues['name'] = $request->getPostParameter('name');
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

    if(empty($formValues['id'])){
      //truong hop khong truyen id --> them moi group
      $form = new TblGroupApiForm();
    }else{
      //truong hop truyen id --> thuc hien cap nhat group
      //lay thong tin khoi thuoc truong
      $group = TblGroupTable::getInstance()->getActiveGroupByIdAndSchoolId($formValues['id'],$school['id']);
      if(!$group){
        $errorCode = GroupErrorCode::GROUP_NOT_EXIST;
        $message = GroupErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
      $form = new TblGroupApiForm($group);
    }

    $formValues['school_id'] = $school['id'];

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

  public function executeRemoveGroup(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(!($id = $request->getPostParameter('id'))){
      $errorCode = GroupErrorCode::MISSING_PARAMETERS;
      $message = GroupErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $group = TblGroupTable::getInstance()->getActiveGroupByIdAndSchoolId($id, $school['id']);
    if(!$group){
      $errorCode = GroupErrorCode::GROUP_NOT_EXIST;
      $message = GroupErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $classInGroup = TblClassTable::getInstance()->getClassInGroupQuery($id,$school['id'])->count();
    if($classInGroup){
      $errorCode = GroupErrorCode::GROUP_CANNOT_DELETE_CONTAINING_CLASS;
      $message = GroupErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }
    try {
      $group->setIsDelete(1);
      $group->save();
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveGroup]|userId = %s|params:%s', $userId,json_encode($request->getPostParameters())),'logAction.log');
    }catch (Exception $e){
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveGroup]|ERROR = %s|params:%s', $e->getMessage(),json_encode($request->getPostParameters())));
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
    $formValues['group_id'] = trim($request->getPostParameter('groupId'));
    $formValues['id'] = $request->getPostParameter('id');
    $formValues['name'] = $request->getPostParameter('name');
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

    if(empty($formValues['group_id'])){
      $errorCode = UserErrorCode::MISSING_PARAMETERS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(empty($formValues['id'])){
      //truong hop khong truyen id --> them moi group
      $form = new TblClassApiForm();
    }else{
      //truong hop truyen id --> thuc hien cap nhat group
      //lay thong tin khoi thuoc truong
      $class = TblClassTable::getInstance()->getClassByIdAndGroupId($formValues['id'],$formValues['group_id'],$school['id']);
      if(!$class){
        $errorCode = ClassErrorCode::CLASS_NOT_EXIST;
        $message = ClassErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
      $form = new TblClassApiForm($class);
    }

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

  public function executeRemoveClass(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(!($id = $request->getPostParameter('id'))){
      $errorCode = GroupErrorCode::MISSING_PARAMETERS;
      $message = GroupErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $class = TblClassTable::getInstance()->getClassById($id,$school['id']);
    if(!$class){
      $errorCode = ClassErrorCode::CLASS_NOT_EXIST;
      $message = ClassErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $hasMember = TblClassTable::getInstance()->checkMemberInClass($class);
    if($hasMember){
      $errorCode = ClassErrorCode::CANNOT_DELETE_CLASS;
      $message = ClassErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      $class->setIsDelete(1);
      $class->save();
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveGroup]|userId = %s|params:%s', $userId,json_encode($request->getPostParameters())),'logAction.log');
    }catch (Exception $e){
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveGroup]|ERROR = %s|params:%s', $e->getMessage(),json_encode($request->getPostParameters())));
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
    $formValues['tbl_class_list'] = json_decode(trim($request->getPostParameter('classId')), true);
    $formValues['type'] = UserTypeEnum::TEACHER;
    $formValues['id'] = $request->getPostParameter('id');
    $formValues['image_path'] = $request->getPostParameter('image');
    $formValues['description'] = $request->getPostParameter('description');
    $formValues['password'] = $request->getPostParameter('password');
    $formValues['name'] = $request->getPostParameter('name');
    $formValues['status'] = $request->getPostParameter('status');
    $formValues['msisdn'] = $request->getPostParameter('msisdn');

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
      $form = new TblUserApiForm(null, ['school_id' => $school['id'], 'type' => UserTypeEnum::TEACHER]);
    }else{
      //truong hop truyen id --> thuc hien cap nhat
      //lay thong tin khoi thuoc truong
      $teacher = TblUserTable::getInstance()->getUserById($formValues['id'],$school['id'],UserTypeEnum::TEACHER);
      if(!$teacher){
        $errorCode = TeacherErrorCode::TEACHER_NOT_EXIST;
        $message = TeacherErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
      $form = new TblUserApiForm($teacher, ['school_id' => $school['id'], 'type' => UserTypeEnum::TEACHER]);
    }

    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $message = $form->isNew() ? 'Create teacher success' : 'Update teacher success';
        $oldImage = $form->isNew() ? '' : $form->getObject()->getImagePath();
        $image = $form->getValue('image_path');
        $obj = $form->save();
        if($image){
          $uploadDir = sprintf('/uploads/images/teacher/%s/',$obj->getId());
          VtHelper::uploadBase64Image($image, $uploadDir, $obj, $oldImage);
        }
        $errorCode = 0;
      }catch (Exception $e){
        $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
        $message = defaultErrorCode::getMessage($errorCode);
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

  public function executeRemoveTeacher(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(!($id = $request->getPostParameter('id'))){
      $errorCode = TeacherErrorCode::MISSING_PARAMETERS;
      $message = TeacherErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $teacher = TblUserTable::getInstance()->getUserById($id,$school['id'],UserTypeEnum::TEACHER);
    if(!$teacher){
      $errorCode = TeacherErrorCode::TEACHER_NOT_EXIST;
      $message = TeacherErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      $teacher->setIsDelete(1);
      $teacher->save();
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveTeacher]|userId = %s|params:%s', $userId,json_encode($request->getPostParameters())),'logAction.log');
    }catch (Exception $e){
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveTeacher]|ERROR = %s|params:%s', $e->getMessage(),json_encode($request->getPostParameters())));
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeGetMemberList(sfWebRequest $request)
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

    $listStudent = TblMemberTable::getInstance()->getListMember($school['id'],$classId,$keyword,$page,$pageSize);
    if(!count($listStudent)){
      $errorCode = UserErrorCode::NO_RESULTS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }
    foreach ($listStudent as $student){
      $data[] = [
        'id' => $student['id'],
        'name' => $student['name'],
        'description' => $student['description'],
        'imagePath' => $student['image_path'],
        'classId' => $student['class_id'],
        'className' => $student['TblClass']['name'],
      ];
    }

    $errorCode = 0;
    $message = 'success';
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeUpdateMember(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $formValues['tbl_user_list'] = explode(',',trim($request->getPostParameter('parentId')));
    $formValues['class_id'] = $request->getPostParameter('classId');
    $formValues['image_path'] = $request->getPostParameter('image');
    $formValues['id'] = $request->getPostParameter('id');
    $formValues['name'] = $request->getPostParameter('name');
    $formValues['birthday'] = $request->getPostParameter('birthday');
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

    if(empty($formValues['id'])){
      //truong hop khong truyen id --> them moi
      $form = new TblMemberApiForm(null, ['school_id' => $school['id']]);
    }else{
      //truong hop truyen id --> thuc hien cap nhat
      //lay thong tin hoc sinh
      $student = TblMemberTable::getInstance()->getMemberById($formValues['id'],$school['id']);
      if(!$student){
        $errorCode = MemberErrorCode::STUDENT_NOT_EXIST;
        $message = MemberErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
      $form = new TblMemberApiForm($student, ['school_id' => $school['id']]);
    }

    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $message = $form->isNew() ? 'Create student success' : 'Update student success';
        $oldImage = $form->isNew() ? '' : $form->getObject()->getImagePath();
        $image = $form->getValue('image_path');
        $obj = $form->save();
        if($image){
          $uploadDir = sprintf('/uploads/images/student/%s/',$obj->getId());
          VtHelper::uploadBase64Image($image, $uploadDir, $obj, $oldImage);
        }

        $errorCode = 0;
      }catch (Exception $e){
        $errorCode = UserErrorCode::INTERNAL_SERVER_ERROR;
        $message = UserErrorCode::getMessage($errorCode);
        VtHelper::writeLogValue(sprintf('[management][executeUpdateMember]|ERROR = %s|params:%s', $e->getMessage(),json_encode($formValues)));
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

  public function executeRemoveMember(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(!($id = $request->getPostParameter('id'))){
      $errorCode = MemberErrorCode::MISSING_PARAMETERS;
      $message = MemberErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $member = TblMemberTable::getInstance()->getMemberById($id,$school['id']);
    if(!$member){
      $errorCode = MemberErrorCode::STUDENT_NOT_EXIST;
      $message = MemberErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      $member->setIsDelete(1);
      $member->save();
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveMember]|userId = %s|params:%s', $userId,json_encode($request->getPostParameters())),'logAction.log');
    }catch (Exception $e){
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveMember]|ERROR = %s|params:%s', $e->getMessage(),json_encode($request->getPostParameters())));
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeGetMenuListByDate(sfWebRequest $request)
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

    $date = trim($request->getPostParameter('date'));
    $dateArr = explode('-',$date);
    if(count($dateArr) != 3 || !checkdate($dateArr[1],$dateArr[2],$dateArr[0])){
      $errorCode = MenuErrorCode::DATE_INVALID;
      $message = MenuErrorCode::getMessage($errorCode, ['%format%' => 'yyyy-MM-dd']);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $listMenu = TblMenuTable::getInstance()->getListMenu($school['id'],$date);
    if(!count($listMenu)){
      $errorCode = UserErrorCode::NO_RESULTS;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }
    foreach ($listMenu as $menu){
       $temp = [
        'id' => $menu['id'],
        'title' => $menu['title'],
        'description' => $menu['description'],
        'imagePath' => $menu['image_path'],
      ];

      if(count($menu['TblGroup'])){
        foreach ($menu['TblGroup'] as $group){
          $temp['groups'][] = [
            'id' => $group['id'],
            'name' => $group['name']
          ];
        }
      }

      if(count($menu['TblClass'])){
        foreach ($menu['TblClass'] as $class){
          $temp['classes'][] = [
            'id' => $class['id'],
            'name' => $class['name']
          ];
        }
      }

      if(count($menu['TblMember'])){
        foreach ($menu['TblMember'] as $member){
          $temp['members'][] = [
            'id' => $member['id'],
            'name' => $member['name']
          ];
        }
      }

      $data[] = $temp;
    }

    $errorCode = 0;
    $message = 'success';
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }

  public function executeUpdateMenuByDate(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();
    $formValues['tbl_group_list'] = ($groupId = $request->getPostParameter('groupId')) ? json_decode($groupId, true) : [];
    $formValues['tbl_class_list'] = ($classId = $request->getPostParameter('classId')) ? json_decode($classId, true) : [];
    $formValues['tbl_member_list'] = ($memberId = $request->getPostParameter('memberId')) ? json_decode($memberId, true) : [];
    $formValues['image_path'] = $request->getPostParameter('image');
    $formValues['publish_date'] = $request->getPostParameter('date');
    $formValues['title'] = $request->getPostParameter('title');
    $formValues['description'] = $request->getPostParameter('description');
    $formValues['status'] = $request->getPostParameter('status');
    $formValues['type'] = $request->getPostParameter('type');
    $formValues['id'] = $request->getPostParameter('id');

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
      $form = new TblMenuApiForm(null, ['school_id' => $school['id']]);
      $formValues['school_id'] = $school['id'];
    }else{
      //truong hop truyen id --> thuc hien cap nhat
      //lay thong tin menu
      $menu = TblMenuTable::getInstance()->getMenuByIdAndSchoolId($formValues['id'],$school['id']);
      if(!$menu){
        $errorCode = MenuErrorCode::MENU_NOT_EXIST;
        $message = MenuErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
      $form = new TblMenuApiForm($menu, ['school_id' => $school['id']]);
      $formValues['school_id'] = $menu->getSchoolId();
    }

    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $message = $form->isNew() ? 'Create menu success' : 'Update menu success';
        $oldImage = $form->isNew() ? '' : $form->getObject()->getImagePath();
        $image = $form->getValue('image_path');
        $obj = $form->save();
        if($image){
          $uploadDir = sprintf('/uploads/images/menu/%s/',$obj->getId());
          VtHelper::uploadBase64Image($image, $uploadDir, $obj, $oldImage);
        }
        $errorCode = 0;
      }catch (Exception $e){
        $errorCode = UserErrorCode::INTERNAL_SERVER_ERROR;
        $message = UserErrorCode::getMessage($errorCode);
        VtHelper::writeLogValue(sprintf('[management][executeUpdateMenuByDate]|ERROR = %s|params:%s', $e->getMessage(),json_encode($formValues)));
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

  public function executeRemoveMenu(sfWebRequest $request)
  {
    $data = [];
    $userId = $this->getUser()->getUserId();

    //lay thong tin truong thuoc user dang nhap
    $school = TblSchoolTable::getInstance()->getActiveSchoolByUserId($userId);
    if(!$school){
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    if(!($id = $request->getPostParameter('id'))){
      $errorCode = MenuErrorCode::MISSING_PARAMETERS;
      $message = MemberErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    $menu = TblMenuTable::getInstance()->getMenuByIdAndSchoolId($id,$school['id']);
    if(!$menu){
      $errorCode = MenuErrorCode::MENU_NOT_EXIST;
      $message = MenuErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message, null, $data);
      return $this->renderText($jsonObj->toJson());
    }

    try {
      $menu->setIsDelete(1);
      $menu->save();
      $errorCode = UserErrorCode::SUCCESS;
      $message = UserErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveMenu]|userId = %s|params:%s', $userId,json_encode($request->getPostParameters())),'logAction.log');
    }catch (Exception $e){
      $errorCode = defaultErrorCode::INTERNAL_SERVER_ERROR;
      $message = defaultErrorCode::getMessage($errorCode);
      VtHelper::writeLogValue(sprintf('[management][executeRemoveMenu]|ERROR = %s|params:%s', $e->getMessage(),json_encode($request->getPostParameters())));
    }
    $jsonObj = new jsonObject($errorCode, $message, null, $data);
    return $this->renderText($jsonObj->toJson());
  }
}
