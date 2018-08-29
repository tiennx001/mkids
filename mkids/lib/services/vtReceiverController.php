<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vtReceiverController
 *
 * @author vas_ngoctv
 */
class vtReceiverController {
    //put your code here
     public static function CreateReceiver($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("CreateReceiver", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            //echo($e);
            var_dump($e);
            die;
            //return null;
        }
    }
    
     public static function GetReceivers($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetReceivers", array());
            echo "<pre />";
            print_r($result);
            die;
        } catch (Exception $e) {
           echo $e;
            die ();
            //return null;
        }
    }
     public static function ConfigureReceiver($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("ConfigureReceiver", array());
           echo "<pre />";
            print_r($result);
            die;
        } catch (Exception $e) {
            echo "-------request-------";
            var_dump($client->__getLastRequest());
            echo "<br />". "--------REsponse-";
            var_dump($client->__getLastResponse());
            die ("2");
            //return null;
        }
    }
    
    
}

?>
