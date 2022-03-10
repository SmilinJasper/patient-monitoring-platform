<?php

include "database.php";

$medicine_is_taken = isset($_POST['medicine-checkmark']) ? $_POST['medicine-checkmark'] : null;
$medicine_id = $_POST['medicine-id'];
$medicine_time = $_POST['medicine-time'];
$patient_id = $_POST['patient-id'];

if($medicine_is_taken == "Taken") {
  $sql = "UPDATE patient_medicines SET $medicine_time = 'Taken' WHERE id = '$medicine_id'";
} else {
  $sql = "UPDATE patient_medicines SET $medicine_time = 'Prescribed' WHERE id = '$medicine_id'";
}

if ($conn->query($sql) === TRUE) {
  echo "Medicine record updated successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "SELECT * FROM patient_profiles WHERE id='$patient_id'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);
$doctor_id = $row['doctor_id'];

$patient_name = $row['name'];

$sql = "SELECT * FROM patient_medicines WHERE id='$medicine_id'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);
$medicine_name = $row['medicine'];

if ($medicine_is_taken){
  $notification_title = "$patient_name has taken $medicine_name";
  $notification_message = "Your patient, $patient_name, has taken their $medicine_time dose of $medicine_name";
}

if (!$medicine_is_taken){
  $notification_title = "$patient_name has marked $medicine_name as not taken";
  $notification_message = "Your patient, $patient_name, has marked their $medicine_time dose of $medicine_name as not taken";
}

$to_user_type ='doctor';

$sql = "INSERT INTO notifications (title, message, to_user_type, user_id) VALUES ('$notification_title', '$notification_message', '$to_user_type', '$doctor_id')";

if ($conn->query($sql) === TRUE) {
  echo "New notification added successfully";
  header("Location: patient_dashboard.php?id=$patient_id");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);