<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vtDeviceController
 *
 * @author vas_ngoctv
 */
class vtDeviceController {
    //put your code here
    public static function AddScopes($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("AddScopes", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }

    public static function CreateDot1XConfiguration($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("CreateDot1XConfiguration", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
  
    public static function DeleteDot1Xconfiguration($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("DeleteDot1Xconfiguration", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function GetDot1Xconfiguration($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetDot1Xconfiguration", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function GetScopes($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetScopes", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
             echo $e;
            die;
        }
    }
    
    public static function GetZeroConfiguration($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetZeroConfiguration", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
             echo $e;
            die;
        }
    }
   
    public static function GetSystemUris($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetSystemUris", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
     
    public static function GetSystemSupportInformation($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetSystemSupportInformation", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            return null;
        }
    }

    public static function GetSystemBackup($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetSystemBackup", array());
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
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function GetAccessPolicy($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetAccessPolicy", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetDeviceInformation($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetDeviceInformation", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetDiscoveryMode($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetDiscoveryMode", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetDNS($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetDNS", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetDot11Capabilities($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetDot11Capabilities", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
//return null;
        }
    }
    
    public static function GetDot1XConfigurations($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetDot1XConfigurations", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetEndpointReference($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetEndpointReference", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
        }
    }
   
    public static function GetNTP($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetNTP", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetRelayOutputs($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetRelayOutputs", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
           echo $e;
            die;
        }
    }
    
    public static function GetRemoteDiscoveryMode($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetRemoteDiscoveryMode", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
        }
    }
    
    public static function GetWsdlUrl($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetWsdlUrl", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetSystemLog($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetSystemLog", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function GetServices($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetServices", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function GetCapabilities($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetCapabilities", array($params));
            echo "<pre />";
            var_dump($result);
            //var_dump($client->__getLastResponse());
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function GetPkcs10Request($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetPkcs10Request", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function GetDot11Status($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetDot11Status", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function RestoreSystem($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("RestoreSystem", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function RemoveScopes($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("RemoveScopes", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function StartFirmwareUpgrade($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("StartFirmwareUpgrade", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function StartSystemRestore($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("StartSystemRestore", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public static function SystemReboot($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SystemReboot", array());
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            return null;
        }
    }
   
    public static function SetSystemFactoryDefault($location, $servicePath, $username, $password, $params) {
        try {
            //Than trong khi su dung ham nay, ham nay se reset camera ve trang thai mac dinh nhu khi xuat xuong
            //Params co 2 gia tri:
            //- Hard se reset phan cung, bao gom cac thong so lien quan toi thiet lap, IP
            //- Soft se reset ca phan cung va phan mem, phan mem o day la Firmware se reset ve phien ban mac dinh cua nha san xuat
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetSystemFactoryDefault", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetRemoteDiscoveryMode($location, $servicePath, $username, $password, $params) {
        try {
            // Indicator of discovery mode: Discoverable, NonDiscoverable.
            //- enum { 'Discoverable', 'NonDiscoverable' }
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetRemoteDiscoveryMode", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetSystemDateAndTime($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetSystemDateAndTime", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetRelayOutputState($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetRelayOutputState", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetRelayOutputSettings($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetRelayOutputSettings", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetNTP($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetNTP", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
   
    public static function SetDiscoveryMode($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetDiscoveryMode", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetAccessPolicy($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetAccessPolicy", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SendAuxiliaryCommand($location, $servicePath, $username, $password, $params) {
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
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function ScanAvailableDot11Networks($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("ScanAvailableDot11Networks", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }

    public static function SetDot1XConfiguration($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetDot1XConfiguration", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetScopes($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetScopes", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
    
    public static function SetZeroConfiguration($location, $servicePath, $username, $password, $params) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("SetZeroConfiguration", array($params));
            echo "<pre />";
            var_dump($result);
            die;
        } catch (Exception $e) {
            echo $e;
            die;
            //return null;
        }
    }
}//End class

?>
