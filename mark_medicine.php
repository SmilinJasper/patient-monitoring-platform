<?php

include "database.php";

$medicine_taken = isset($_POST['medicine-checkmark']) ? $_POST['medicine-checkmark'] : null;
$medicine_id = $_POST['medicine-id'];
$medicine_time = $_POST['medicine-time'];

if($medicine_taken == "Taken"){
  $sql = "UPDATE patient_medicines SET $medicine_time = 'Taken' WHERE id = '$medicine_id'";
} else {
  $sql = "UPDATE patient_medicines SET $medicine_time = 'Prescribed' WHERE id = '$medicine_id'";
}

if (mysqli_query($conn, $sql)) {
  header("location: " . $_SERVER['HTTP_REFERER']);
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
  
?>