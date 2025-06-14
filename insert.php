<?php
ob_start();
require_once('insertHandler.php');

$handler = new InsertHandler();

// Add Contact
if (isset($_POST['submit_contact_form'])) {
    $response = $handler->addContact($_POST);

    if ($response['status'] == 'success') {
        $_SESSION['popup'] = $response['message'];
        header('Location:index.php');
        exit;
    } else {
        $_SESSION['popup'] = $response['message'];
        header('Location:index.php');
        exit;
        // echo "<h2>{$response['message']}</h2>";
    }
}

// Add Group
if (isset($_POST['addgv'])) {
    $response = $handler->addGroup($_POST);

    if ($response['status'] == 'success') {
        $_SESSION['popup'] = $response['message'];
        header('Location:index.php');
        exit;
    } else {
         $_SESSION['popup'] = $response['message'];
        header('Location:index.php');
        exit;
        // echo "<h2>{$response['message']}</h2>";
    }
}

// Add Member to Group
if (isset($_POST['add_member'])) {
    $response = $handler->addMember($_POST);

    if ($response['status'] == 'success') {
        $_SESSION['popup'] = $response['message'];
        header('Location:index.php');
        exit;
    } else {
         $_SESSION['popup'] = $response['message'];
        header('Location:index.php');
        exit;
        // echo "<h2>{$response['message']}</h2>";
    }
}

ob_end_flush();
?>

