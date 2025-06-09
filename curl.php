<?php
ob_start();
require_once('config/config.php');

class curl_function{
    public $url;
    public $curlStart;

    public function __construct($url = 'http://localhost/contact/server.php') {
        $this->url = $url;
        $this->curlStart = curl_init();
        $db = new dbConnection();
    }
     

    public function setOptions($postLoad) {
        curl_setopt($this->curlStart, CURLOPT_POST, true);
        curl_setopt($this->curlStart, CURLOPT_URL, $this->url);
        curl_setopt($this->curlStart, CURLOPT_POSTFIELDS, $postLoad);
        curl_setopt($this->curlStart, CURLOPT_RETURNTRANSFER, true);
    }

    public function execute() {
        $response = curl_exec($this->curlStart);
        curl_close($this->curlStart);
        return json_decode($response, true);
    }
}

ob_end_flush();
?>