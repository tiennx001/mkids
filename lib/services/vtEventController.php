<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vtEventController
 *
 * @author vas_ngoctv
 */
class vtEventController {
    //put your code here
     public static function GetEventProperties($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetEventProperties", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
             echo $e;
            die;
        }
    }
    
    public static function GetServiceCapabilities($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetServiceCapabilities", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            print_r($client->__getLastRequest());
            echo $e;
            die;
        }
    }
    
    
}

?>
