<?php

include "database.php";

//Get required values

$medicine_id = $_POST['medicine-id'];
$redirect_link = $_POST['redirect-link'];

//Delete medicine where medicine id is given medicine id

$sql = "DELETE FROM patient_medicines WHERE id='$medicine_id'";

if ($conn->query($sql) === TRUE) {
  header("location: " . $_SERVER['HTTP_REFERER']);
} else {
  echo "Error deleting record: " . $conn->error;
}

?>

