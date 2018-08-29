<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vtVideoController
 *
 * @author vas_ngoctv
 */
class vtVideoController {
    //put your code here
    public static function GetVideoSources($location, $servicePath, $username, $password) {
        try {
            $created = vtGetSystemDateTime::getDeviceTime($location, $servicePath);

            // authenticate function
            $client = new OnvifSoapClient($servicePath, array('location' => $location, 'uri' => "", 'soap_version' => SOAP_1_2, 'encoding' => "UTF-8", 'trace' => 1, 'connection_timeout' => 120));
            $client->__setUsernameTokenWithTime($username, $password, $created);

            $result = $client->__soapCallOnvif("GetVideoSources", array());
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
