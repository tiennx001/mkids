<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vtGetLocation
 *
 * @author vas_ngoctv
 * @modify hoangbh1
 * @update 04/05/2013
 */
class vtGetLocation
{

  /**
   * xac dinh dia chi service cua thiet bi
   * @modify hoangbh1
   * @update 04/05/2013
   * @param string $locationDevice, $servicePath, $username, $password, $type
   * @return string $XAdd
   */

  public static function getOnvifXAddr($locationDevice, $servicePath, $username, $password, $type)
  {
    try {
      //dong bo gio thiet bi
      $created = vtGetSystemDateTime::getDeviceTime($locationDevice, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $locationDevice, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $params = array("Category" => $type);
      $result = $client->__soapCallOnvif("GetCapabilities", array($params));

      $arrCapbilities = (array)$result;
      $toArrayValue = $arrCapbilities["Capabilities"];

      $arrType = (array)$toArrayValue;
      $toArrayType = $arrType[$type];

      $arrValue = (array)$toArrayType;
      $XAdd = $arrValue["XAddr"];

      return $XAdd;
    } catch (Exception $e) {//hoangbh1 xu ly exception
	    $arr = array(
        'errorCode' => 0,
        'message' => 'Không nhận diện thiết bị'
      );
	    echo json_encode($arr);
	    throw new sfStopException($e);
    }
  }
}

