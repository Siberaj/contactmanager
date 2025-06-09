<?php
session_start();
require_once('config/config.php');
include('curl.php');

class UpdateHandler {

    private $curl;

    public function __construct() {
        $this->curl = new curl_function();
    }

    public function updateContact($data) {
        $payload = json_encode([
            "userid" => $_SESSION['user_id'],
            "action" => "updatecontact",
            "contactId" => $data['contact_id'],
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

    public function updateGroup($data) {
        $payload = json_encode([
            "userid" => $_SESSION['user_id'],
            "action" => "updategroup",
            "groupId" => $data['group_id'],
            "groupName" => $data['group_name']
        ]);

        $this->curl->setOptions($payload);
        return $this->curl->execute();
    }
}
