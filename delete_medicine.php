<?php

// Get patient id of session

session_start();
$patient_id = $_SESSION['id'];

// Include database connection

include "database.php";

//Get required values

$medicine_id = $_POST['medicine-id'];

// Add notification data to database

$medicine_name = mysqli_query($conn, "SELECT medicine FROM patient_medicines where id = '$medicine_id'");
$medicine_name = mysqli_fetch_array($medicine_name);
$medicine_name = $medicine_name[0];

$notification_title = "$medicine_name has been removed from your prescription!";
$notification_message = "Your doctor has removed " . $medicine_name . " from your prescription.";
$to_user_type ='patient';
  
$sql = "INSERT INTO notifications (title, message, to_user_type, patient_id) VALUES ('$notification_title', '$notification_message', '$to_user_type', '$patient_id')";

if ($conn->query($sql) === TRUE) {
  echo "New notification added successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
  
//Delete medicine where medicine id is given medicine id

$sql = "DELETE FROM patient_medicines WHERE id='$medicine_id'";

if ($conn->query($sql) === TRUE) {
  echo "Medicine deleted successfully";
  header("location: " . $_SERVER['HTTP_REFERER']);
} else {
  echo "Error deleting record: " . $conn->error;
}

// CLose the connection

mysqli_close($conn);

?>

