<?php

/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 7/22/14
 * Time: 10:48 AM
 * To change this template use File | Settings | File Templates.
 */
class jsonObject
{

  public function __construct($errorCode, $message, $token = null, $data = null)
  {
    $this->errorCode = $errorCode;
    $this->message = $message;
    if ($token !== null) {
      $this->token = $token;
    }
    if ($data !== null) {
      $this->data = $data;
    }
  }

  public function toJson()
  {
    return json_encode($this);
  }

}