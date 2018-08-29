<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vtNetworkController
 *
 * @author vas_ngoctv
 */
class vtNetworkController {
    //put your code here
      
    public static function GetNetworkInterfaces($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetNetworkInterfaces", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
   
    public static function GetNetworkProtocols($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetNetworkProtocols", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
 
    public static function GetNetworkDefaultGateway($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetNetworkDefaultGateway", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
 
    public static function SetNetworkInterfaces($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetNetworkInterfaces", array($params));
            echo "<pre />";
            var_dump($result);
            //Reboot system sau khi change IP
            $client->__soapCallOnvif("SystemReboot", array());
            die;
        } catch (Exception $e) {
            return null;
        }
    }
   
    public static function GetDPAddresses($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetDPAddresses", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
  
    public static function GetDynamicDNS($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetDynamicDNS", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetHostname($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetHostname", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetIPAddressFilter($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetIPAddressFilter", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function AddIPAddressFilter($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("AddIPAddressFilter", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetDNS($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetDNS", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetIPAddressFilter($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetIPAddressFilter", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetNetworkProtocols($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetNetworkProtocols", array($params));
            //restart camera
            vtDeviceController::SystemReboot($location, $servicePath, $username, $password);
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
   
    public static function SetNetworkDefaultGateway($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetNetworkDefaultGateway", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetHostnameFromDHCP($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetHostnameFromDHCP", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetHostname($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetHostname", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
 
    public static function SetDynamicDNS($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetDynamicDNS", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetDPAddresses($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetDPAddresses", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function RemoveIPAddressFilter($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("RemoveIPAddressFilter", array($params));
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
