<?php

$id = $_GET['id']; // $id is now defined

// Include database file
include "database.php";

//Delete entry of answersheet from MySQL table
mysqli_query($conn, "DELETE FROM doctor_credentials WHERE id='".$id."'");

//Close connection
mysqli_close($conn);

// Redirecting back
header("Location: admin_dashboard.php");

?>
