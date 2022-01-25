<?php

// Get patient id form url
$patient_id = isset($_GET['id']) ? $_GET['id'] : "";

// Open database connection
include "database.php";

// Get patient name from database
$patient_name = mysqli_query($conn, "SELECT name FROM patient_profiles where id = '$patient_id'");
$patient_name = mysqli_fetch_array($patient_name);
$patient_name = $patient_name[0];

$patient_bmi = mysqli_query($conn, "SELECT bmi FROM patient_profiles where id = '$patient_id'");
$patient_bmi = mysqli_fetch_array($patient_bmi);
$patient_bmi = $patient_bmi[0];

$patient_age = mysqli_query($conn, "SELECT age FROM patient_profiles where id = '$patient_id'");
$patient_age = mysqli_fetch_array($patient_age);
$patient_age = $patient_age[0];

if ($patient_bmi < 16) $bmi_style = "bmi-severely-underweight";
if ($patient_bmi < 17) $bmi_style = "bmi-underweight";
if ($patient_bmi < 18.5) $bmi_style = "bmi-slightly-underweight";
if ($patient_bmi < 25) $bmi_style = "bmi-normal";
if ($patient_bmi < 30) $bmi_style = "bmi-overweight";
if ($patient_bmi < 35) $bmi_style = "bmi-slightly-obese";
if ($patient_bmi < 40) $bmi_style = "bmi-obese";
if ($patient_bmi > 40) $bmi_style = "bmi-morbidly-obese";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Viewing <?php echo $patient_name ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="js/update_page.js"></script>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <!--Navigation bar-->
    <nav>
        <form>
            <ul class="nav-bar">
                <li><button type="submit" formaction="logout_to_patient_login.php">Patient Login</button></li>
                <li><button class="active" type="submit" formaction="logout_to_doctor_login.php">Doctor Login</button>
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
            <h1>Patient Info</h1>
        </header>

        <!--Answersheets info-->
        <div class="answersheets-info-container">

            <header>
                <h1>COMPUTER SCIENCE</h1>
            </header>

            <!-- Display patient info from database -->
            <?php
            $sql = "SELECT * FROM patient_profiles WHERE id = '$patient_id'";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                echo
                "<!--Patient info-->

                        <div class='patient-info-container'>
                            <div class='patient-info'>
                                <p>Name:</p>
                                <p class='patient-info-value'>" . $row['name'] . "</p>
                            </div>

                            <div class='patient-info'>
                                <p>Age:</p>
                                <p class='patient-info-value'>" . $row['age'] . "<p>
                            </div>

                            <div class='patient-info'>
                                <p>Date of Birth:</p>
                                <p class='patient-info-value'>" . $row['date_of_birth'] . "</p>
                            </div>

                            <div class='patient-info'>
                                <p>Blood Group:</p>
                                <p class='patient-info-value'>" . $row['blood_group'] . "</p>
                            </div>

                            <div class='patient-info'>
                                <p>Height:</p>
                                <p class='patient-info-value'>" . $row['height'] . " cm</p>
                            </div>

                            <div class='patient-info'>
                                <p>Weight:</p>
                                <p class='patient-info-value'>" . $row['weight'] . " kg</p>
                            </div>

                            <div class='patient-info'>
                                <p>Contact No:</p>
                                <p class='patient-info-value'>" . $row['contact_number'] . "</p>
                            </div>
                        </div>

                        <!--Paper count info-->
                        <div class='paper-count-container'>
                            <div class='uploaded-paper-count'>
                                <p>Medications Prescribed</p>
                                <p>
                                </p>
                            </div>
                            <div class='checked-paper-count'>
                                <p>BMI</p>
                                <p class='" . $bmi_style . "'>" . $row['bmi'] . "</p>
                            </div>
                        </div>";
            }

            // Close Connection
            mysqli_close($conn);
            ?>

        </div>
    </main>
</body>

</html>