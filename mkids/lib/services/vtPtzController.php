<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vtPtzController
 *
 * @author vas_ngoctv
 */
class vtPtzController
{


  /**
   * dieu khien chuyen dong camera
   * @modify hoangbh1
   * @update 04/05/2013
   * @param string $location, $servicePath, $username, $password
   * @param array $params
   *
   */
  public static function ContinuousMove($location, $servicePath, $username, $password, $params)
  {
    try {
      //dong bo gio thiet bi
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);
      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $client->__soapCallOnvif("ContinuousMove", array($params));

    } catch (Exception $e) {//hoangbh1 xu ly exception
	    $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
	    echo json_encode($arr);
	    throw new sfStopException($e);
    }
  }
  /**
   * dung dieu khien chuyen dong camera
   * @modify hoangbh1
   * @update 04/05/2013
   * @param string $location, $servicePath, $username, $password
   * @param array $params
   *
   */
  public static function Stop($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);
      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("Stop", array($params));

    } catch (Exception $e) {//hoangbh1 xu ly exception
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
	    echo json_encode($arr);
	    throw new sfStopException($e);
    }
  }

  public static function AbsoluteMove($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("AbsoluteMove", array($params));

    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
	    echo json_encode($arr);
	    throw new sfStopException($e);
    }
  }

  public static function CreatePresetTour($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("CreatePresetTour", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetConfiguration($location, $servicePath, $username, $password, $params)
  {
    try {
      //dong bo gio thiet bi
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetConfiguration", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetConfigurationOptions($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetConfigurationOptions", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetConfigurations($location, $servicePath, $username, $password)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetConfigurations", array());
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetNode($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetNode", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetNodes($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetNodes", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetPresets($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetPresets", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetPresetTour($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetPresetTour", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetPresetTourOptions($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetPresetTourOptions", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetPresetTours($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetPresetTours", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetServiceCapabilities($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetServiceCapabilities", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GetStatus($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GetStatus", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GotoHomePosition($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GotoHomePosition", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function GotoPreset($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("GotoPreset", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function ModifyPresetTour($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("ModifyPresetTour", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function OperatePresetTour($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("OperatePresetTour", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function RelativeMove($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("RelativeMove", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function RemovePreset($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("RemovePreset", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function RemovePresetTour($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("RemovePresetTour", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function SendAuxiliaryCommand($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("SendAuxiliaryCommand", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function SetConfiguration($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("SetConfiguration", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function SetHomePosition($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("SetHomePosition", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }

  public static function SetPreset($location, $servicePath, $username, $password, $params)
  {
    try {
      $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

      // authenticate function
      $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
      $client->__setUsernameTokenWithTime($username, $password, $created);

      $result = $client->__soapCallOnvif("SetPreset", array($params));
      echo "<pre />";
      var_dump($result);
      die;
    } catch (Exception $e) {
      $arr = array(
        'errorCode' => 0,
        'message'   => 'Không nhận diện thiết bị'
      );
      echo json_encode($arr);
      throw new sfStopException($e);
    }
  }


}

