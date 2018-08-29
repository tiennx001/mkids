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