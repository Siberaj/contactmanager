<?php

ob_start();
require_once('updateHandler.php');

$handler = new UpdateHandler();

// Contact update
if (isset($_POST['submit_edit_form'])) {
    $response = $handler->updateContact($_POST);

    if ($response['status'] === 'success') {
        $_SESSION['popup'] = 'Contact updated successfully';
        header('Location:user.php');
        exit;
    } else {
        echo "<h2>{$response['message']}</h2>";
    }
}

// Group update
if (isset($_POST['update_group'])) {
    $response = $handler->updateGroup($_POST);

    if ($response['status'] === 'success') {
        $_SESSION['popup'] = 'Group updated successfully';
        header('Location:user.php');
        exit;
    } else {
        echo "<h2>{$response['message']}</h2>";
    }
}

ob_end_flush();
?>
