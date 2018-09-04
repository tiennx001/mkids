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
    $formValues = $request->getPostParameters();
    $formValues['tbl_user_list'] = !empty($formValues['parentId']) ? explode(',',trim($formValues['parentId'])) : '';
    $formValues['image_path'] = !empty($formValues['image']) ? $formValues['image'] : '';
    $formValues['class_id'] = !empty($formValues['classId']) ? $formValues['classId'] : '';

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
      $form = new TblMemberApiForm();
      $formValues['status'] = 1;
    }else{
      //truong hop truyen id --> thuc hien cap nhat
      //lay thong tin hoc sinh
      $student = TblMemberTable::getInstance()->getMemberById($formValues['id'],$school['id']);
      if(!$student){
        $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
        $message = UserErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message, null, $data);
        return $this->renderText($jsonObj->toJson());
      }
      $form = new TblMemberApiForm($student);
      $formValues['status'] = $student->getStatus();
    }

    unset($formValues['token']);
    unset($formValues['image']);
    unset($formValues['classId']);
    unset($formValues['parentId']);

    $form->bind($formValues);
    if($form->isValid()) {
      try{
        $message = $form->isNew() ? 'Create student success' : 'Update student success';
        $form->save();
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
      $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
      $message = UserErrorCode::getMessage($errorCode);
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
        $errorCode = UserErrorCode::INVALID_PARAMETER_VALUE;
        $message = UserErrorCode::getMessage($errorCode);
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
        $form->save();
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
}
