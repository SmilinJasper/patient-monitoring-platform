<?php

include "database.php";

$patient_id = isset($_POST['patient-id']) ? $_POST['patient-id'] : "";
$doctor_id = isset($_POST['doctor-id']) ? $_POST['doctor-id'] : "";
$new_medicine_input = isset($_POST['new-medicine-input']) ? $_POST['new-medicine-input'] : "";
$to_take_morning = isset($_POST['to-take-morning']) ? $_POST['to-take-morning'] : "";
$to_take_afternoon = isset($_POST['to-take-afternoon']) ? $_POST['to-take-afternoon'] : "";
$to_take_evening = isset($_POST['to-take-evening']) ? $_POST['to-take-evening'] : "";
$to_take_night = isset($_POST['to-take-night']) ? $_POST['to-take-night'] : "";

//Get patient profile info from database table

$sql = "INSERT INTO patient_medicines (patient_id, doctor_id, medicine, morning, afternoon, evening, night) VALUES ('$patient_id', '$doctor_id', '$new_medicine_input', '$to_take_morning', '$to_take_afternoon', '$to_take_evening', '$to_take_night')";

if (mysqli_query($conn, $sql)) {
    echo "Medicines Added";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Add notification data to databse

$prescription_times = array();

if ($to_take_morning == "Prescribed") array_push($prescription_times, "Morning");
if ($to_take_afternoon == "Prescribed") array_push($prescription_times, "Afternoon");
if ($to_take_evening == "Prescribed") array_push($prescription_times, "Evening");
if ($to_take_night == "Prescribed") array_push($prescription_times, "Night");

$notification_title = "Your doctor has prescribed you " . $new_medicine_input . "!";

$notification_message = "You have been prescribed " . $new_medicine_input . " for " . implode(", ", $prescription_times) . ".";
  
$to_user_type ='patient';
  
$sql = "INSERT INTO notifications (title, message, to_user_type, patient_id) VALUES ('$notification_title', '$notification_message', '$to_user_type', '$patient_id')";

if ($conn->query($sql) === TRUE) {
  echo "New notification added successfully";
  header("location: view_patient.php?id=". $patient_id ."&doctor-id=". $doctor_id);
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
  
// CLose the connection
  
mysqli_close($conn);