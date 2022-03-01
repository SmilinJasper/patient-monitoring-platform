<?php

// Get patient id mand doctor id form url
$patient_id = isset($_GET['id']) ? $_GET['id'] : "";

// Open database connection
include "database.php";

// Get patient info from database
$patient_name = mysqli_query($conn, "SELECT name FROM patient_profiles where id = '$patient_id'");
$patient_name = mysqli_fetch_array($patient_name);
$patient_name = $patient_name[0];

$patient_bmi = mysqli_query($conn, "SELECT bmi FROM patient_profiles where id = '$patient_id'");
$patient_bmi = mysqli_fetch_array($patient_bmi);
$patient_bmi = $patient_bmi[0];

$patient_age = mysqli_query($conn, "SELECT age FROM patient_profiles where id = '$patient_id'");
$patient_age = mysqli_fetch_array($patient_age);
$patient_age = $patient_age[0];


$total_patient_medications_prescribed = mysqli_query($conn, "SELECT count(*) from patient_medicines where patient_id = '$patient_id'");
$total_patient_medications_prescribed = mysqli_fetch_array($total_patient_medications_prescribed);
$total_patient_medications_prescribed = $total_patient_medications_prescribed[0]; 

if ($patient_bmi < 16) $bmi_style = "bmi-severely-underweight";
if ($patient_bmi < 17) $bmi_style = "bmi-underweight";
if ($patient_bmi < 18.5) $bmi_style = "bmi-slightly-underweight";
if ($patient_bmi < 25) $bmi_style = "bmi-normal";
if ($patient_bmi < 30) $bmi_style = "bmi-overweight";
if ($patient_bmi < 35) $bmi_style = "bmi-slightly-obese";
if ($patient_bmi < 40) $bmi_style = "bmi-obese";
if ($patient_bmi > 40) $bmi_style = "bmi-morbidly-obese";

$doctor_id = mysqli_query($conn, "SELECT doctor_id FROM patient_profiles where id = '$patient_id'");
$doctor_id = mysqli_fetch_array($doctor_id);
$doctor_id = $doctor_id[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $patient_name ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="js/update_page.js"></script>
    <script defer src="js/handle_medicine_checkmark.js"></script>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <!--Navigation bar-->
    <nav>
        <form>
            <ul class="nav-bar">
                <li><button class="active" type="submit" formaction="logout_to_patient_login.php">Patient Login</button></li>
                <li><button type="submit" formaction="logout_to_doctor_login.php">Doctor Login</button>
                </li>
                <li><button type="submit" formaction="logout_to_admin_login.php">Admin Login</button></li>
                <li class="nav-item-right"><button type="submit" formaction="logout_to_doctor_login.php">Logout</button>
                </li>
            </ul>
        </form>
    </nav>

    <!--Background image-->
    <img class="wave" src="img/wave.png">

    <!--Page wrapper-->
    <main class="page-wrapper">

        <!--Dashboard Header-->
        <header class="center">
            <h1>Your Doctor</h1>
        </header>

        <!--Doctor and patient info-->
        <div class="basic-info-container">

            <header>
                <h1>YOUR DOCTOR</h1>
            </header>

            <!-- Display patient info from database -->
            <?php
            $sql = "SELECT * FROM doctor_profiles WHERE id = '$doctor_id'";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                echo
                "<!--Doctor info-->

                        <div class='info-container'>
                            <div>
                                <p>Name:</p>
                                <p class='info-value'>" . $row['name'] . "</p>
                            </div>

                            <div>
                                <p>Credentials:</p>
                                <p class='info-value'>" . $row['credentials'] . "<p>
                            </div>

                            <div>
                                <p>Experience:</p>
                                <p class='info-value'>" . $row['experience'] . "</p>
                            </div>

                        </div>

                        <!--Patient info-->
                        <div class='patient-info-container'>
                            <div class='medications-prescribed-count'>
                                <p>Medications Prescribed</p>
                                <p>
                                    " . $total_patient_medications_prescribed . "
                                </p>
                            </div>
                            <div class='bmi-value'>
                                <p>BMI</p>
                                <p class='" . $bmi_style . "'>" . $patient_bmi . "</p>
                            </div>
                        </div>";
            }

            ?>

        </div>

        <?php

        //Get patient profile info from database table
        $sql = "SELECT * FROM patient_medicines WHERE patient_id = '$patient_id'";
        $result = mysqli_query($conn, $sql);

        ?>

        <br />

        <!--Table with patient's medicines info and edit options-->

        <div class="table-responsive">
        
            <table class="styled-table medicine-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Medicine</th>
                        <th>Morning</th>
                        <th>Afternoon</th>
                        <th>Evening</th>
                        <th>Night</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="medicine-table-body">

                <?php

                //Display all patient info from database

                while ($row = mysqli_fetch_array($result)) {

                    echo "
                    <tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['medicine'] . "</td>
                        <td>
                            <div class='table-icon-container'>
                                <form action='mark_medicine.php' method='POST' id='mark-medicine-form'>"
                                . (($row['morning']) == true
                                ? ($row['morning'] == 'Taken'
                                ? " <label for='medicine-checkmark' id='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-green.png' alt='Taken'>
                                    </label>
                                    <input type='checkbox' id='medicine-checkmark' name='medicine-checkmark' class='medicine-checkmark' value='Taken' checked hidden>"
                                : " <label for='medicine-checkmark' id='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Prescribed'>
                                    </label>
                                    <input type='checkbox' id='medicine-checkmark' name='medicine-checkmark' class='medicine-checkmark' value='Taken' hidden>")
                                : "  <img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>") . "
                                    <input type='number' value='" . $row['id'] . "' id='medicine-id' name='medicine-id' readonly hidden>
                                    <input type='text' value='Morning' id='medicine-time' name='medicine-time' readonly hidden>
                                </form>
                            </div>
                        </td>
    
                        <td>
                            <div class='table-icon-container'>"
                            . (($row['afternoon']) == true
                            ? ($row['afternoon'] == 'Taken'
                            ? "<img class='ui-icon' src='img/check-mark-tick-green.png' alt='Taken'"
                            : "<img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Prescribed'>")
                            : "<img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>")  . "
                            </div>
                        </td>

                        <td>
                            <div class='table-icon-container'>"
                            . (($row['evening']) == true
                            ? ($row['evening'] == 'Taken'
                            ? "<img class='ui-icon' src='img/check-mark-tick-green.png' alt='Taken'"
                            : "<img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Prescribed'>")
                            : "<img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>")  . "
                            </div>
                        </td>

                        <td>
                            <div class='table-icon-container'>"
                            . (($row['night']) == true
                            ? ($row['night'] == 'Taken'
                            ? "<img class='ui-icon' src='img/check-mark-tick-green.png' alt='Taken'"
                            : "<img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Prescribed'>")
                            : "<img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>")  . "
                            </div>
                        </td>
    
                    </tr>
    
                        ";
                }

                ?>

                </tbody>
            </table>
        </div>
            
    </main>
</body>

</html>