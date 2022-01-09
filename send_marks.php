<?php

// Include database file
include "database.php";

//Send marks to row with paper's id
$id = $_GET['id'];
$totalMarks = $_REQUEST['total-marks'];
$sql = "UPDATE student_exam_results SET marks =  $totalMarks,
     is_checked ='Yes' WHERE id = $id";

//Redirect to mark updated message if successful
if (mysqli_query($conn, $sql)) {
    header("Location: mark_updated.html");
}

//Close connection
mysqli_close($conn);

?>;