<?php

//Get basic info for deletion
$id = $_GET['id']; // $id is now defined
$account_type = $_GET['account_type'];

// Include database file
include "database.php";

//Delete entry of answersheet from MySQL table
removeAccount($conn, $account_type, $id);

function removeAccount($conn, $account_type, $id)
{

    if ($account_type == "doctor") {

        $sql = "DELETE FROM doctor_credentials WHERE id='" . $id . "'";

        if (mysqli_query($conn, $sql)) {
            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        //Close connection
        mysqli_close($conn);

        return;
    } else {

        $sql =  "DELETE FROM patient_credentials WHERE id='" . $id . "'";

        if (mysqli_query($conn, $sql)) {
            // Redirect to doctor dashboard
            header("Location: ".$_SERVER['HTTP_REFERER']);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        //Close connection
        mysqli_close($conn);
        
    }
}
