<?php
ob_start();
session_start();
require_once('DeleteHandler.php');

$handler = new DeleteHandler();

// Delete contact
if (isset($_POST['deletecontact'])) {
    $response = $handler->deleteContact($_POST['contact_id']);

    if ($response['status'] === 'success') {
        $_SESSION['popup'] = 'Contact deleted successfully';
        header('Location:user.php');
        exit;
    } else {
        echo "<h2>{$response['message']}</h2>";
    }
}

// Delete group
if (isset($_POST['deletegroup'])) {
    $response = $handler->deleteGroup($_POST['group_id']);

    if ($response['status'] === 'success') {
        $_SESSION['popup'] = 'Group deleted successfully';
        header('Location:user.php');
        exit;
    } else {
        echo "<h2>{$response['message']}</h2>";
    }
}

// Remove group member
if (isset($_POST['deletegroupmember'])) {
    $response = $handler->removeGroupMember($_POST['contact_id'], $_POST['group_id']);

    if ($response['status'] === 'success') {
        $_SESSION['popup'] = 'Member removed successfully';
        header('Location:user.php');
        exit;
    } else {
        echo "<h2>{$response['message']}</h2>";
    }
}

ob_end_flush();

?>