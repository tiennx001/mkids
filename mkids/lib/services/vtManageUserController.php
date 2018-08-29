<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManageUserController
 *
 * @author vas_ngoctv
 */
class vtManageUserController {
    //put your code here
    public static function CreateUsers($location, $servicePath, $username, $password,$params) {
        try {
            //dong bo gio thiet bi
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("CreateUsers", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
        }
    }
    
    public static function SetUser($location, $servicePath, $username, $password,$params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetUser", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            var_dump($e); die;
            return null;
        }
    }
    
    public static function GetUsers($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetUsers", array());
            echo "<pre />";
             print_r($client->__getLastRequest());
            var_dump($result);
            //echo htmlentities($client->__getLastResponse());
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function DeleteUsers($location, $servicePath, $username, $password,$params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("DeleteUsers", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetRemoteUser($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetRemoteUser", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
        }
    }
    public static function SetRemoteUser($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetRemoteUser", array($params));
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
