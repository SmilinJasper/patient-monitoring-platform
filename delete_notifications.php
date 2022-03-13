<?php

session_start();

include "database.php";

foreach ($_SESSION['notification_ids'] as $id) {

    $sql = "DELETE FROM notifications WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Medicine deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

}

$_SESSION['notification_ids'] = array();

?>