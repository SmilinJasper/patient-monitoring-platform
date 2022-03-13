<?php

// Start session to be able to access session variables

session_start();

// Include database connection

include "database.php";

// Delete all notifications

foreach ($_SESSION['notification_ids'] as $id) {

    $sql = "DELETE FROM notifications WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Medicine deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

}

// Empty the notification ids array

$_SESSION['notification_ids'] = array();

?>