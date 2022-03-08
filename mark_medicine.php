<?php

include "database.php";

$medicine_taken = isset($_POST['medicine-checkmark']) ? $_POST['medicine-checkmark'] : null;
$medicine_id = $_POST['medicine-id'];
$medicine_time = $_POST['medicine-time'];
$patient_id = $_POST['patient-id'];

if($medicine_taken == "Taken") {
  $sql = "UPDATE patient_medicines SET $medicine_time = 'Taken' WHERE id = '$medicine_id'";
} else {
  $sql = "UPDATE patient_medicines SET $medicine_time = 'Prescribed' WHERE id = '$medicine_id'";
}

if ($conn->query($sql) === TRUE) {
  header("Location: patient_dashboard.php?id=$patient_id");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

die();

?>