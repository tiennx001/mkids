<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vtRecordController
 *
 * @author vas_ngoctv
 */
class vtRecordController {
    //put your code here
    public static function CreateRecording($location, $servicePath, $username, $password, $params) {
        try {
            //zoom
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);
            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);
               
            $result = $client->__soapCallOnvif("CreateRecording", array());
            var_dum($result);
            die;
        } catch (Exception $e) {
            echo "<pre />";
            print_r($e);
            die("1");
            return null;
        }
    }
    
    public static function GetRecordings($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetRecordings", array());
           echo "<pre />";
            print_r($result);
            die;
        } catch (Exception $e) {
            echo "<pre />";
            print_r($e);
            die ();
            //return null;
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
            echo $e;
            die;
            //return null;
        }
    }
    
    
     public static function GetAudioOutputConfiguration($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetAudioOutputConfiguration", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
}

?>
