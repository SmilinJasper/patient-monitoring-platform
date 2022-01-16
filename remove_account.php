<?php

//Get basic info for deletion
$id = $_GET['id']; // $id is now defined
$account_type = $GET['account_type'];

// Include database file
include "database.php";

//Delete entry of answersheet from MySQL table
removeAccount($conn, $account_type, $id);

function removeAccount($conn, $account_type, $id){

    if($account_type == "doctor") {
        mysqli_query($conn, "DELETE FROM doctor_credentials WHERE id='".$id."'");
        header("Location: admin_dashboard.php");
        return;
    }

    mysqli_query($conn, "DELETE FROM patient_credentials WHERE id='".$id."'");
    header("Location: doctor_dashboard.php");

    //Close connection
    mysqli_close($conn);

}

?>
