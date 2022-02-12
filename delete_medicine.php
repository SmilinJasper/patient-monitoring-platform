<?php

include "database.php";

//Get required ids

$medicine_id = $_POST['medicine-id'];

//Delete medicine where medicine id is given medicine id

$sql = "DELETE FROM patient_medicines WHERE id='$medicine_id'";

if ($conn->query($sql) === TRUE) {
    header("location: ");
} else {
  echo "Error deleting record: " . $conn->error;
}

?>

