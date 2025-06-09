<?php
session_start();
require_once('config/config.php');
include('curl.php');

class DeleteHandler {

    private $curl;

    public function __construct() {
        $this->curl = new curl_function();
    }

    public function deleteContact($contactId) {
        $payload = json_encode([
            "userid" => $_SESSION['user_id'],
            "action" => "deletecontact",
            "contact_id" => $contactId
        ]);

        $this->curl->setOptions($payload);
        return $this->curl->execute();
    }

    public function deleteGroup($groupId) {
        $payload = json_encode([
            "user_id" => $_SESSION['user_id'],
            "action" => "deletegroup",
            "group_id" => $groupId
        ]);

        $this->curl->setOptions($payload);
        return $this->curl->execute();
    }

    public function removeGroupMember($contactId, $groupId) {
        $payload = json_encode([
            "user_id" => $_SESSION['user_id'],
            "action" => "deletemember",
            "contact_id" => $contactId,
            "group_id" => $groupId
        ]);

        $this->curl->setOptions($payload);
        return $this->curl->execute();
    }
}
