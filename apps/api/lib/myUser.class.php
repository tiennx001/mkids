<?php

class myUser extends sfGuardSecurityUser
{
  public function getGuardUser()
  {
    $vtUser = new VtUser();
    return $vtUser;
  }
}
