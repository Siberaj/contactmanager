<?php
ob_start();
session_start();
require_once('config/config.php');
include('curl.php');

//to update contact details
if(isset($_POST['submit_edit_form'])){
    $contactId = $_POST['contact_id'];
    $phoneno = $_POST['phoneno'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $nickname = $_POST['nickname'];
    $notes = $_POST['notes'];
    $birthday = $_POST['birthday'];
    $relationship = $_POST['relationship'];

    $postLoad = json_encode(["userid"=>$_SESSION['user_id'],"action"=>"updatecontact","contactId"=>$contactId,"phoneno"=>$phoneno,"email"=>$email,
                             "firstname"=>$firstname,"lastname"=>$lastname,"nickname"=>$nickname,"notes"=>$notes,"birthday"=>$birthday,"relationship"=>$relationship]);
    
    $res = new curl_function();
    $res->setOptions($postLoad);
    $response = $res->execute();    
    
    if($response['status'] == 'success'){
        $_SESSION['popup'] = 'Contact updated successfully';
        header('Location:user.php');
        exit;
    }
    else{
        echo "<h2>".$response['message']."</h2>";
    }
   
}

// to update group name
if(isset($_POST['update_group'])){
    $groupId = $_POST['group_id'];
    $groupName = $_POST['group_name'];
    // echo $groupId;
    // echo $groupName;
    $postLoad = json_encode(["userid"=>$_SESSION['user_id'],"action"=>"updategroup","groupId"=>$groupId,"groupName"=>$groupName]);
    $res = new curl_function();
    $res->setOptions($postLoad);
    $response = $res->execute();
    
    if($response['status'] == 'success'){
        $_SESSION['popup'] = 'Group updated successfully';
        header('Location:user.php');
        exit;
    }
    else{
        echo "<h2>".$response['message']."</h2>";
    }
}

//to close database connection
ob_end_flush();
?>