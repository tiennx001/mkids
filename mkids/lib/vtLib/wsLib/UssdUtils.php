<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tiennx6
 * Date: 9/16/14
 * Time: 10:14 AM
 * To change this template use File | Settings | File Templates.
 */

class UssdUtils
{
  const WSDL = 'http://10.58.52.4:8669/axis2/services/USSDActivator?wsdl';
  const USER = 'ussd';
  const PASS = 'ussd@1609';

  public function  __construct($msisdn, $message) {

  }

  // send USSD
  public static function sendUssd($msisdn, $message)
  {
    VtHelper::writeLogValue('begin call soap client');
    $params = array(
      'username' => self::USER,
      'password' => self::PASS,
      'msisdn' => VtXCodeHelper::getMobileNumber($msisdn, VtXCodeHelper::MOBILE_GLOBAL),
      'message' => $message
    );
    try {
      $soapClient = new SoapClient(self::WSDL, array(
        'location' => self::WSDL
      ));
      $res = $soapClient->__soapCall('sendUSSD', array($params));
      VtHelper::writeLogValue('Send ussd success');
      return $res->return;
    } catch (Exception $e) {
      VtHelper::writeLogValue('Send ussd fail | error: '. $e->getMessage());
      return -1;
    }
  }

}