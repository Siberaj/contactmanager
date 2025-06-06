<?php
ob_start();
session_start();
require_once('config/config.php');


//to check if user is logged in or not
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

else{
    header('location:user.php');
    exit();
}

//to close database connection
ob_end_flush();
?>