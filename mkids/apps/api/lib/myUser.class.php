<?php

class myUser extends sfGuardSecurityUser
{
  public function getGuardUser()
  {
    $vtUser = new VtUser();
    return $vtUser;
  }

  public function getUserId(){
    $userInfo = $this->getAttribute('userInfo');
    return $userInfo ? $userInfo->getUserId() : null;
  }
}
