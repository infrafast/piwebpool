<?php
 
class FreeMobile
{
    protected $_url = "https://smsapi.free-mobile.fr/sendmsg";
    protected $_user;
    protected $_key;
 
    protected $_curl;
 
    public function __construct()
    {
        $this->_curl = curl_init();
        curl_setopt($this->_curl, CURLOPT_SSL_VERIFYPEER, false);
    }
 
    public function __destruct()
    {
        curl_close($this->_curl);
    }
 
    /**
     * Envoi un message par SMS.
     * @param string $msg
     * @throws \Exception
     */
    public function send($msg)
    {
        $msg = trim($msg);
        if (!$this->_user || !$this->_key || empty($msg)) {
            throw new \Exception("Un des paramètres obligatoires est manquant", 400);
        }
        curl_setopt($this->_curl, CURLOPT_URL, $this->_url."?user=".$this->_user.
            "&pass=".$this->_key.
            "&msg=".urlencode($msg));
        curl_exec($this->_curl);
        if (200 != $code = curl_getinfo($this->_curl, CURLINFO_HTTP_CODE)) {
            switch ($code) {
                case 400: $message = "missing parameter"; break;
                case 402: $message = "SMS flood"; break;
                case 403: $message = "service not activated or wrong crendetials"; break;
                case 500: $message = "server side issue"; break;
                default: $message = "undefined";
            }
            throw new \Exception($message, $code);
        }
        return $this;
    }
 
    /**
    * @param string $user
    * @return \SMS\FreeMobile
    */
    public function setUser($user)
    {
        $this->_user = $user;
        return $this;
    }
 
    /**
    * @return string
    */
    public function getUser()
    {
        return $this->_user;
    }
 
    /**
    * @param string $key
    * @return \SMS\FreeMobile
    */
    public function setKey($key)
    {
        $this->_key = $key;
        return $this;
    }
 
    /**
    * @return string
    */
    public function getKey()
    {
        return $this->_key;
    }
}