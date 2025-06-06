<?php
    ob_start();
    session_start();
    require_once('config/config.php');
    include('curl.php');

    //to insert contact details into db
    if(isset($_POST['submit_contact_form'])){
        $phoneno = $_POST['phoneno'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $nickname = $_POST['nickname'];
        $notes = $_POST['notes'];
        $birthday = $_POST['birthday'];
        $relationship = $_POST['relationship'];

        $postLoad = json_encode(["userid"=>$_SESSION['user_id'],"action"=>"addcontact","phoneno"=>$phoneno,"email"=>$email,
                    "firstname"=>$firstname,"lastname"=>$lastname,"nickname"=>$nickname,"notes"=>$notes,"birthday"=>$birthday,"relationship"=>$relationship]);
        
        $res = new curl_function();
        $res->setOptions($postLoad);
        $response = $res->execute();
       
        // echo "<h2>".$response."</h2>";
        if($response['status'] == 'success'){
            $_SESSION['popup'] = 'Contact added successfully';
            header('Location:user.php');
            exit;
        }
        else{
            echo "<h2>".$response['message']."</h2>";
        }
                
    }



    //to add group to db
    if(isset($_POST['addgv']))
    {
        $group_name = $_POST['group_name'];
        $postLoad = json_encode(["user_id"=>$_SESSION['user_id'],"action"=>"addgroup","group_name"=>$group_name]);
        
        $res = new curl_function();
        $res->setOptions($postLoad);
        $response = $res->execute();

        if($response['status'] == 'success'){
            $_SESSION['popup'] = 'Group created successfully';
            header('Location:user.php');
            exit;
        }
        else{
            echo "<h2>".$response['message']."</h2>";
        }
    }

    
    // to insert members into groups
    if (isset($_POST['add_member'])) {
        $contact_id = $_POST['contact_id'];
        $group_id = $_POST['group_id'];

        $postLoad = json_encode(["user_id"=>$_SESSION['user_id'],"action"=>"addmember","group_id"=>$group_id,"contact_id"=>$contact_id]);
        
        $res = new curl_function();
        $res->setOptions($postLoad);
        $response = $res->execute();

        // echo "<h2>".$response."</h2>";
        if($response['status'] == 'success'){
            $_SESSION['popup'] = 'Member added successfully';
            header('Location:user.php');
            exit;
        }
        else{
            echo "<h2>".$response['message']."</h2>";
        }
        
    }
    
    
ob_end_flush();
?>