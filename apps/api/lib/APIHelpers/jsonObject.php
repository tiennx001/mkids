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

  public function __construct($errorCode, $message, $token = null, $data = null, $additional_phone = null, $is_update = null, $type = null)
  {
    $this->errorCode = $errorCode;
    $this->message = $message;
    if ($token !== null) {
      $this->token = $token;
    }
    if ($data !== null) {
      $this->data = $data;
    }
    if ($additional_phone !== null) {
      $this->additional_phone = $additional_phone;
    }
    if ($is_update !== null) {
      $this->is_update = $is_update;
    }
    if ($type !== null) {
      $this->type = $type;
    }
  }

  public function toJson()
  {
    return json_encode($this);
  }

}