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

// Handling medicine checkmark updations
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $medicine_taken = isset($_POST['medicine-checkmark']) ? $_POST['medicine-checkmark'] : null;
    $medicine_id = $_POST['medicine-id'];
    $medicine_time = $_POST['medicine-time'];
    $patient_id = $_POST['patient-id'];

    if ($medicine_taken == "Taken") {
        $sql = "UPDATE patient_medicines SET $medicine_time = 'Taken' WHERE id = '$medicine_id'";
    } else {
        $sql = "UPDATE patient_medicines SET $medicine_time = 'Prescribed' WHERE id = '$medicine_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            window.location.href = 'patient_dashboard.php?id=$patient_id';
            </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src='js/notify.js'></script>
    <script defer src='js/view_doctor_schedule.js'></script>
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

                            <div>
                                <p>Tests Taken:</p>
                                <p class='info-value'>" . $row['tests_taken'] . "</p>
                            </div>

                            <div>
                                <p>Contact No:</p>
                                <a class='contact-number info-value' href=tel:" . $row['contact_number'] . ">" . $row['contact_number'] . "</a>
                            </div>

                            <div id='view-schedule-container'>
                                <button id='view-schedule-button' class='view-schedule-button'>View Schedule</button>
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
                                
                                <form action='mark_medicine.php' method='POST' class='mark-medicine-form'>"

                            . (($row['morning']) == true
                                ? ($row['morning'] == 'Taken'
                                    ? " <label for='medicine-checkmark-morning-" . $row['id'] . "' class='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-green.png' alt='Taken'>
                                    </label>

                                    <input type='checkbox' id='medicine-checkmark-morning-" . $row['id'] . "' name='medicine-checkmark' class='medicine-checkmark' value='Taken' checked hidden>"

                                    : " <label for='medicine-checkmark-morning-" . $row['id'] . "' class='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Prescribed'>
                                    </label>

                                    <input type='checkbox' id='medicine-checkmark-morning-" . $row['id'] . "' name='medicine-checkmark' class='medicine-checkmark' value='Taken' hidden>")

                                : "  <img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>") . "

                                    <input type='number' value='" . $row['id'] . "' class='medicine-id' name='medicine-id' readonly hidden>
                                    <input type='text' value='Morning' class='medicine-time' name='medicine-time' readonly hidden>
                                    <input type='number' value='" . $patient_id . "' class='patient-id' name='patient-id' readonly checked hidden>
                                    
                                </form>

                            </div>

                        </td>
    
                        <td>
                            
                            <div class='table-icon-container'>
                                
                                <form action='mark_medicine.php' method='POST' class='mark-medicine-form'>"

                            . (($row['afternoon']) == true
                                ? ($row['afternoon'] == 'Taken'
                                    ? " <label for='medicine-checkmark-afternoon-" . $row['id'] . "' class='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-green.png' alt='Taken'>
                                    </label>

                                    <input type='checkbox' id='medicine-checkmark-afternoon-" . $row['id'] . "' name='medicine-checkmark' class='medicine-checkmark' value='Taken' checked hidden>"

                                    : " <label for='medicine-checkmark-afternoon-" . $row['id'] . "' class='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Prescribed'>
                                    </label>

                                    <input type='checkbox' id='medicine-checkmark-afternoon-" . $row['id'] . "' name='medicine-checkmark' class='medicine-checkmark' value='Taken' hidden>")

                                : "  <img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>") . "

                                    <input type='number' value='" . $row['id'] . "' class='medicine-id' name='medicine-id' readonly hidden>
                                    <input type='text' value='Afternoon' class='medicine-time' name='medicine-time' readonly hidden>
                                    <input type='number' value='" . $patient_id . "' class='patient-id' name='patient-id' readonly checked hidden>
                            
                                </form>

                            </div>

                        </td>

                        <td>
                            
                            <div class='table-icon-container'>
                                
                                <form action='mark_medicine.php' method='POST' class='mark-medicine-form'>"

                            . (($row['evening']) == true
                                ? ($row['evening'] == 'Taken'
                                    ? " <label for='medicine-checkmark-evening-" . $row['id'] . "' class='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-green.png' alt='Taken'>
                                    </label>

                                    <input type='checkbox' id='medicine-checkmark-evening-" . $row['id'] . "' name='medicine-checkmark' class='medicine-checkmark' value='Taken' checked hidden>"

                                    : " <label for='medicine-checkmark-evening-" . $row['id'] . "' class='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Prescribed'>
                                    </label>

                                    <input type='checkbox' id='medicine-checkmark-evening-" . $row['id'] . "' name='medicine-checkmark' class='medicine-checkmark' value='Taken' hidden>")

                                : "  <img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>") . "

                                    <input type='number' value='" . $row['id'] . "' class='medicine-id' name='medicine-id' readonly hidden>
                                    <input type='text' value='Evening' class='medicine-time' name='medicine-time' readonly hidden>
                                    <input type='number' value='" . $patient_id . "' class='patient-id' name='patient-id' readonly checked hidden>
                            
                                </form>

                            </div>

                        </td>

                        <td>
                            
                            <div class='table-icon-container'>
                                
                                <form action='mark_medicine.php' method='POST' class='mark-medicine-form'>"

                            . (($row['night']) == true
                                ? ($row['night'] == 'Taken'
                                    ? " <label for='medicine-checkmark-night-" . $row['id'] . "' class='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-green.png' alt='Taken'>
                                    </label>

                                    <input type='checkbox' id='medicine-checkmark-night-" . $row['id'] . "' name='medicine-checkmark' class='medicine-checkmark' value='Taken' checked hidden>"

                                    : " <label for='medicine-checkmark-night-" . $row['id'] . "' class='medicine-checkmark-label'>
                                        <img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Prescribed'>
                                    </label>

                                    <input type='checkbox' id='medicine-checkmark-night-" . $row['id'] . "' name='medicine-checkmark' class='medicine-checkmark' value='Taken' hidden>")

                                : "  <img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>") . "

                                    <input type='number' value='" . $row['id'] . "' class='medicine-id' name='medicine-id' readonly hidden>
                                    <input type='text' value='Night' class='medicine-time' name='medicine-time' readonly hidden>
                                    <input type='number' value='" . $patient_id . "' class='patient-id' name='patient-id' readonly checked hidden>
                            
                                </form>

                            </div>

                        </td>
    
                    </tr>
    
                        ";
                    }

                    mysqli_close($conn);

                    ?>

                </tbody>
            </table>
        </div>

        <div id="schedule-modal" class="schedule-modal">
            <div id="schedule-modal-content" class="basic-info-container info-container schedule-modal-content" tabindex="-1">
                <header>
                    <h1>DOCTOR'S SCHEDULE</h1>
                </header>
                <div>
                    <p>9:00 - 9:30 AM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
                <div>
                    <p>9:30 - 10:00 AM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
                <div>
                    <p>10:00 -10:30 AM:</p>
                    <p class='info-value free-time-slot'>Free</p>
                </div>
                <div>
                    <p>10:30 - 11:00 AM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
                <div>
                    <p>11:00 - 11:30 AM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
                <div>
                    <p>11:30 - 12:00 PM:</p>
                    <p class='info-value free-time-slot'>Free</p>
                </div>
                <div>
                    <p>12:00 - 12:30 PM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
                <div>
                    <p>12:30 - 1:00 PM:</p>
                    <p class='info-value free-time-slot'>Free</p>
                </div>
            
                <div>
                    <p>1:00 - 1:30 PM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
                <div>
                    <p>1:30 - 2:00 PM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
            
                <div>
                    <p>2:00 - 2:30 PM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
                <div>
                    <p>2:30 - 3:00 PM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
            
                <div>
                    <p>3:00 - 3:30 PM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
                <div>
                    <p>3:30 - 4:00 PM:</p>
                    <p class='info-value free-time-slot'>Free</p>
                </div>
            
                <div>
                    <p>4:00 - 4:30 PM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
                <div>
                    <p>4:30 - 5:00 PM:</p>
                    <p class='info-value'>Occupied</p>
                </div>
            </div>
        </div>
        
    </main>

    <!-- Footer -->

    <footer>

        <div>

            <h1>OUR LOCATION</h1>
            <div id="map"></div>

        </div>

        <div>

            <h1>Contact Us</h1>

            <p>
                <i class="fas fa-phone"></i>
                <span>+91-123-456-7890</span>
            </p>

            <p>
                <i class="fas fa-envelope"></i>
                <span>1-8, 9th cross street,
                    <br>Coimbatore,
                    <br>Tamilnadu - 123456
                </span>
            </p>

            </div=>

    </footer>

</body>

</html>