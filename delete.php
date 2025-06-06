<?php
ob_start();
session_start();
include('curl.php');
//to delete contact
if(isset($_POST['deletecontact'])){

    $contact_id = $_POST['contact_id'];
    $postLoad = json_encode(["userid"=>$_SESSION['user_id'],"action"=>"deletecontact","contact_id"=>$contact_id]);

    $res = new curl_function();
    $res->setOptions($postLoad);
    $response = $res->execute();

    if($response['status'] == 'success'){
        $_SESSION['popup'] = 'Contact deleted successfully';
        header('Location:user.php');
        exit;
    }
    else{
        echo "<h2>".$response['message']."</h2>";
    }
}

// to delete group
if(isset($_POST['deletegroup'])){
    $group_id = $_POST['group_id'];
    $postLoad = json_encode(["user_id"=>$_SESSION['user_id'],"action"=>"deletegroup","group_id"=>$group_id]);

    $res = new curl_function();
    $res->setOptions($postLoad);
    $response = $res->execute();
    echo "<h2>".$response."hii</h2>";
    if($response['status'] == 'success'){
        $_SESSION['popup'] = 'Group deleted successfully';
        header('Location:user.php');
        exit;
    }
    else{
        echo "<h2>".$response['message']."</h2>";
    }
}

//to remove member in a group
if(isset($_POST['deletegroupmember'])){
    $contact_id = $_POST['contact_id'];
    $group_id = $_POST['group_id'];
    $postLoad = json_encode(["user_id"=>$_SESSION['user_id'],"action"=>"deletemember","contact_id"=>$contact_id,"group_id"=>$group_id]);

    $res = new curl_function();
    $res->setOptions($postLoad);
    $response = $res->execute();
    
    if($response['status'] == 'success'){
        $_SESSION['popup'] = 'Member removed successfully';
        header('Location:user.php');
        exit;
    }
    else{
        echo "<h2>".$response['message']."</h2>";
    }
}

ob_end_flush();
?>