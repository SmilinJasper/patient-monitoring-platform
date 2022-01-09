<?php

//Delete pdf and evaluation form
unlink("uploads/{$_GET["name"]}");
unlink("evaluation_forms/{$_GET["name"]}.html");

$id = $_GET['id']; // $id is now defined

// Include database file
include "database.php";

//Delete entry of answersheet from MySQL table
mysqli_query($conn,"DELETE FROM student_exam_results WHERE id='".$id."'");

//Close connection
mysqli_close($conn);

// Redirecting back
header("Location: paper_rejected_info.html");
