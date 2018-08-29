<?php

class myUser extends sfGuardSecurityUser
{
  /**
   * Tra ve ID cua user dang dang nhap
   * @author NamDT5
   * @created on 19/04/2013
   * @return int
   */
  public function getId()
  {
    return $this->getGuardUser()->getId();
  }

  public function setIpAddress($ip) {
    $this->setAttribute('IpAddress', $ip);
  }

  public function getIpAddress() {
    return $this->getAttribute('IpAddress', null);
  }

  public function setUserAgent($userAgent) {
    $this->setAttribute('UserAgent', $userAgent);
  }

  public function getUserAgent() {
    return $this->getAttribute('UserAgent', null);
  }
}
