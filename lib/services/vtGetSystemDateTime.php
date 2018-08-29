<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vtGetSystemDateTime
 *
 * @author vas_tungtd2
 * get system date time from camera device
 */
class vtGetSystemDateTime
{

  /**
   * dong bo thoi gian cua camera
   * @modify hoangbh1
   * @update 04/05/2013
   * @param string $location, $servicePath
   * @param datetime $created
   *
   */
  public static function getDeviceTime($location, $servicePath)
  {
    try {
      $client = new SoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));

      $systemDate = $client->__soapCall("GetSystemDateAndTime", array());
      $arrayDate  = (array)$systemDate;

      $toArrayValue     = $arrayDate["SystemDateAndTime"];
      $arrayUTCDateTime = (array)$toArrayValue;
      $utcDatetimeValue = $arrayUTCDateTime["UTCDateTime"];
      $timeToArrayValue = (array)$utcDatetimeValue;
      $dateToArrayValue = (array)$utcDatetimeValue;
      $toGetDateValue   = (array)$dateToArrayValue["Date"];
      $toGetTimeValue   = (array)$timeToArrayValue["Time"];
      $created          = $toGetDateValue["Year"] . '-' . $toGetDateValue["Month"] . '-' . $toGetDateValue["Day"] . "T" . $toGetTimeValue["Hour"] . ":" . $toGetTimeValue["Minute"] . ":" . $toGetTimeValue["Second"] . "Z";
      return $created;
    } catch (Exception $e) {//hoangbh1 xu ly exception
	    return null;
    }
  }

}

