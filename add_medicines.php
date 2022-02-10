<?php

include "database.php";

$patient_id = isset($_POST['patient-id']) ? $_POST['patient-id'] : "";
$doctor_id = isset($_POST['doctor-id']) ? $_POST['doctor-id'] : "";
$medicine_name_input = isset($_POST['medicine-name-input']) ? $_POST['medicine-name-input'] : "";
$to_take_morning = isset($_POST['to-take-morning']) ? $_POST['to-take-morning'] : "";
$to_take_afternoon = isset($_POST['to-take-afternoon']) ? $_POST['to-take-afternoon'] : "";
$to_take_evening = isset($_POST['to-take-evening']) ? $_POST['to-take-evening'] : "";
$to_take_night = isset($_POST['to-take-night']) ? $_POST['to-take-night'] : "";

//Get patient profile info from database table

$sql = "INSERT INTO patient_medicines (patient_id, doctor_id, medicine, morning, afternoon, evening, night) VALUES ('$patient_id', '$doctor_id', '$medicine_name_input', '$to_take_morning', '$to_take_afternoon', '$to_take_evening', '$to_take_night')";

if (mysqli_query($conn, $sql)) {
    echo "Medicines Added";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

header("location: view_patient.php?id=". $patient_id ."&doctor-id=". $doctor_id);

