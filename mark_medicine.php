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

$sql = "SELECT doctor_id FROM patient_profiles WHERE id='$patient_id'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);
$doctor_id = $row['doctor_id'];

$to_user_type ='doctor';

$sql = "INSERT INTO notifications VALUES('$notification_title', '$notification_message', '$to_user_type', '$doctor_id')";

die();

?>