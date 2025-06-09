<?php
session_start();
require_once('config/config.php');
include('curl.php');

class InsertHandler {

    private $curl;

    public function __construct() {
        $this->curl = new curl_function();
    }

    public function addContact($data) {
        $payload = json_encode([
            "userid" => $_SESSION['user_id'],
            "action" => "addcontact",
            "phoneno" => $data['phoneno'],
            "email" => $data['email'],
            "firstname" => $data['firstname'],
            "lastname" => $data['lastname'],
            "nickname" => $data['nickname'],
            "notes" => $data['notes'],
            "birthday" => $data['birthday'],
            "relationship" => $data['relationship']
        ]);

        $this->curl->setOptions($payload);
        return $this->curl->execute();
    }

    public function addGroup($data) {
        $payload = json_encode([
            "user_id" => $_SESSION['user_id'],
            "action" => "addgroup",
            "group_name" => $data['group_name']
        ]);

        $this->curl->setOptions($payload);
        return $this->curl->execute();
    }

    public function addMember($data) {
        $payload = json_encode([
            "user_id" => $_SESSION['user_id'],
            "action" => "addmember",
            "group_id" => $data['group_id'],
            "contact_id" => $data['contact_id']
        ]);

        $this->curl->setOptions($payload);
        return $this->curl->execute();
    }
}
