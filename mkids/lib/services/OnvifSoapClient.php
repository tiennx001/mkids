<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Le Hoang
 * Date: 3/27/13
 * Time: 11:35 PM
 * To change this template use File | Settings | File Templates.
 */
class OnvifSoapClient extends SoapClient {

    private $username;
    private $password;
    private $timestamp;

    /* Generates de WSSecurity header */

    private function wssecurity_header() {

        /* The timestamp. The computer must be on time or the server you are
         * connecting may reject the password digest for security.
         */
        if (!$this->timestamp)
            $this->timestamp = gmdate('Y-m-d\TH:i:s\Z');
        /* A random word. The use of rand() may repeat the word if the server is
         * very loaded.
         * use uniqid, if use mt_rand()
         * $nonce = mt_rand(); 
         * $passdigest = base64_encode(pack('H*', sha1(pack('H*', $nonce) . pack('a*', $this->timestamp) .pack('a*', $this->password))));
         */
        $nonce = uniqid();

        /* This is the right way to create the password digest. Using the
         * password directly may work also, but it's not secure to transmit it
         * without encryption. And anyway, at least with axis+wss4j, the nonce
         * and timestamp are mandatory anyway.
         */
        $passdigest = base64_encode(
                pack('H*', sha1(
                                $nonce . pack('a*', $this->timestamp) .
                                pack('a*', $this->password))));

        $auth = '<wsse:Security SOAP-ENV:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.' .
                'org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
      <wsse:UsernameToken>
          <wsse:Username>' . $this->username . '</wsse:Username>
    <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-' .
                'wss-username-token-profile-1.0#PasswordDigest">' . $passdigest . '</wsse:Password>
    <wsse:Nonce>' . base64_encode($nonce) . '</wsse:Nonce>
    <wsu:Created xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-' .
                '200401-wss-wssecurity-utility-1.0.xsd">' . $this->timestamp . '</wsu:Created>
   </wsse:UsernameToken>
</wsse:Security>
';

        /* XSD_ANYXML (or 147) is the code to add xml directly into a SoapVar.
         * Using other codes such as SOAP_ENC, it's really difficult to set the
         * correct namespace for the variables, so the axis server rejects the
         * xml.
         */
        //http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd
        $authvalues = new SoapVar($auth, XSD_ANYXML);
        $header = new SoapHeader("http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd", "Security", $authvalues,
                        true);

        return $header;
    }

    /* It's necessary to call it if you want to set a different user and
     * password
     */

    public function __setUsernameToken($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    /* It's necessary to call it if you want to set a different user and
     * password
     */

    public function __setUsernameTokenWithTime($username, $password, $timestamp) {
        $this->username = $username;
        $this->password = $password;
        $this->timestamp = $timestamp;
    }

    /* Overwrites the original method adding the security header. As you can
     * see, if you want to add more headers, the method needs to be modifyed
     */

    public function __soapCallOnvif($function_name, array $arguments) {
        parent::__setSoapHeaders($this->wssecurity_header());
        $result = parent::__soapCall($function_name, $arguments);
        return $result;
    }

}