<?php
ob_start();
session_start();
require_once('config/config.php');
include('curl.php');


if(isset($_POST['search']))
{
    $search = $_POST['search1'].'%';
    $user_id = $_SESSION['user_id'];
    //echo $search;
    // to search for contacts
    $postLoad = json_encode(["action"=>"searchcontact","search"=>$search,"user_id"=>$user_id]);
        
    $res = new curl_function();
    $res->setOptions($postLoad);
    $response = $res->execute();

    if($response['status']=='success'){
        $_SESSION['search'] = true;
        $_SESSION['contact_id'] = $response['contact_id'];
        Header("Location:user.php");
        exit();
    }else{
       echo "<h2>".$response['message']."</h2>";
    }
}

ob_end_flush();
?>