<?php
session_start();
require_once('config/config.php');
include('curl.php');

class SearchHandler {

    private $curl;

    public function __construct() {
        $this->curl = new curl_function();
    }

    public function searchContact($searchTerm, $userId) {
        $payload = json_encode([
            "action" => "searchcontact",
            "search" => $searchTerm . '%',
            "user_id" => $userId
        ]);

        $this->curl->setOptions($payload);
        return $this->curl->execute();
    }
}
