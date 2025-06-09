<?php
ob_start();
session_start();
require_once('searchHandler.php');

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search1'];
    $userId = $_SESSION['user_id'];

    $handler = new SearchHandler();
    $response = $handler->searchContact($searchTerm, $userId);

    if ($response['status'] === 'success') {
        $_SESSION['search'] = true;
        $_SESSION['contact_id'] = $response['contact_id'];
        header("Location:index.php");
        exit();
    } else {
        echo "<h2>{$response['message']}</h2>";
    }
}

ob_end_flush();
?>
