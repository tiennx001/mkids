<?php

/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 7/24/14
 * Time: 10:01 AM
 * To change this template use File | Settings | File Templates.
 */
class TokenSessionFilter
{

  public function execute($filterChain)
  {
    $request = sfContext::getInstance()->getRequest();
    $response = sfContext::getInstance()->getResponse();
    if ($request->isMethod($request::POST)) {
      $token = $request->getPostParameter('token', null);
      // Kiem tra token
      if ($token || $token !== '') {
        $info = TblTokenSessionTable::getInstance()->getInfoByToken(trim($token));
        if (!$info) {
          $errorCode = AuthenticateErrorCode::UNAUTHORIZED;
          $message = AuthenticateErrorCode::getMessage($errorCode);
          $jsonObj = new jsonObject($errorCode, $message);
          $response->setContent($jsonObj->toJson());
          return;
        }
        // Luu lai userInfo da truy xuat
        sfContext::getInstance()->getUser()->setAttribute("userInfo", $info);

        // Check quyen su dung ham
        $roles = sfConfig::get('app_function_roles');
        $module = sfContext::getInstance()->getModuleName();
        $action = sfContext::getInstance()->getActionName();
        foreach ($roles as $confFunction => $roleArr) {
          $splitConfFunc = explode(':', $confFunction);
          if (count($splitConfFunc) != 2 || !is_array($roleArr)) {
            $errorCode = UserErrorCode::ROLES_CONFIG_ERROR;
            $message = UserErrorCode::getMessage($errorCode);
            $jsonObj = new jsonObject($errorCode, $message);
            $response->setContent($jsonObj->toJson());
            return;
          }

          if ($module == $splitConfFunc[0] && $action == $splitConfFunc[1]) {
            $roleEnum = RolesEnum::getArr();
            $userType = isset($roleEnum[$info['user_type']]) ? $roleEnum[$info['user_type']] : null;
            if (!in_array($userType, $roleArr)) {
              $errorCode = defaultErrorCode::FORBIDDEN;
              $message = defaultErrorCode::getMessage($errorCode);
              $jsonObj = new jsonObject($errorCode, $message);
              $response->setContent($jsonObj->toJson());
              return;
            }
          }
        }

        $filterChain->execute();
      } else {
        $errorCode = AuthenticateErrorCode::MISSING_PARAMETERS;
        $message = AuthenticateErrorCode::getMessage($errorCode);
        $jsonObj = new jsonObject($errorCode, $message);
        $response->setContent($jsonObj->toJson());
        return;
      }
    } else {
      $errorCode = defaultErrorCode::METHOD_NOT_ALLOWED;
      $message = defaultErrorCode::getMessage($errorCode);
      $jsonObj = new jsonObject($errorCode, $message);
      $response->setContent($jsonObj->toJson());
      return;
    }
  }

}