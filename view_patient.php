<?php

// Get patient id and doctor id form url
$patient_id = isset($_GET['id']) ? $_GET['id'] : "";
$doctor_id = isset($_GET['doctor-id']) ? $_GET['doctor-id'] : "";

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Viewing <?php echo $patient_name ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="js/update_page.js"></script>
    <script defer src="js/add_medicine.js"></script>
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

        <!--Patient info-->
        <div class="basic-info-container">

            <header>
                <h1>YOUR PATIENT</h1>
            </header>

            <!-- Display patient info from database -->
            <?php
            $sql = "SELECT * FROM patient_profiles WHERE id = '$patient_id'";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                echo
                "<!--Patient info-->

                        <div class='info-container'>
                            <div>
                                <p>Name:</p>
                                <p class='info-value'>" . $row['name'] . "</p>
                            </div>

                            <div>
                                <p>Age:</p>
                                <p class='info-value'>" . $row['age'] . "<p>
                            </div>

                            <div>
                                <p>Date of Birth:</p>
                                <p class='info-value'>" . $row['date_of_birth'] . "</p>
                            </div>

                            <div>
                                <p>Blood Group:</p>
                                <p class='info-value'>" . $row['blood_group'] . "</p>
                            </div>

                            <div>
                                <p>Height:</p>
                                <p class='info-value'>" . $row['height'] . " cm</p>
                            </div>

                            <div>
                                <p>Weight:</p>
                                <p class='info-value'>" . $row['weight'] . " kg</p>
                            </div>

                            <div>
                                <p>Contact No:</p>
                                <a href=tel:" . $row['contact_number'] . "<p class='info-value'>" . $row['contact_number'] . "</a>
                                </p>
                            </div>
                        </div>

                        <!--Extra patient info-->
                        <div class='patient-info-container'>
                            <div class='medications-prescribed-count'>
                                <p>Medications Prescribed</p>
                                <p>
                                    " . $total_patient_medications_prescribed . "
                                </p>
                            </div>
                            <div class='bmi-value'>
                                <p>BMI</p>
                                <p class='" . $bmi_style . "'>" . $row['bmi'] . "</p>
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

        <form method="POST" action="add_medicines.php" class="patient-medicine-info-container">

            <div class="table-responsive medicine-table-container">
            
                <table class="styled-table">
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
                                        <div class='table-icon-container'>"
                                        . (($row['morning']) == true
                                        ? ($row['morning'] == 'Taken'
                                        ? "<img class='ui-icon' src='img/check-mark-tick-green.png' alt='Prescribed'"
                                        : "<img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Not prescribed'>")
                                        : "<img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>")  . "
                                        </div>
                                    </td>
                
                                    <td>
                                        <div class='table-icon-container'>"
                                        . (($row['afternoon']) == true
                                        ? ($row['afternoon'] == 'Taken'
                                        ? "<img class='ui-icon' src='img/check-mark-tick-green.png' alt='Prescribed'"
                                        : "<img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Not prescribed'>")
                                        : "<img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>")  . "
                                        </div>
                                    </td>

                                    <td>
                                        <div class='table-icon-container'>"
                                        . (($row['evening']) == true
                                        ? ($row['evening'] == 'Taken'
                                        ? "<img class='ui-icon' src='img/check-mark-tick-green.png' alt='Prescribed'"
                                        : "<img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Not prescribed'>")
                                        : "<img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>")  . "
                                        </div>
                                    </td>

                                    <td>
                                        <div class='table-icon-container'>"
                                        . (($row['night']) == true
                                        ? ($row['night'] == 'Taken'
                                        ? "<img class='ui-icon' src='img/check-mark-tick-green.png' alt='Prescribed'"
                                        : "<img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Not prescribed'>")
                                        : "<img class='ui-icon' src='img/check-mark-wrong.png' alt='Not prescribed'>")  . "
                                        </div>
                                    </td>
                
                                    <td>

                                        <div class='table-icon-container'>
                                            <form action='delete_medicine.php' method='POST'>

                                                <input type='number' value='". $row['id'] ."' id='medicine-id' name='medicine-id' readonly hidden>
                                                
                                                <input type='image' class='ui-icon-big' src='img/bin-icon.png'>
                                                
                                            </form>
                                        </div>

                                    </td>

                                </tr>
                
                            ";
                    }

                    ?>

                        <!-- Template for adding new medicines -->
                        <template id="new-medicine-row-template">

                            <?php 
                            
                             //Get the next medicine id from database
                             $sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'patient_medicines' AND table_schema = DATABASE( )";
                             $result = mysqli_query($conn, $sql);
                             $row = mysqli_fetch_array($result);
                             $new_medicine_id = $row['AUTO_INCREMENT'];
                            
                             // Close Connection
                             mysqli_close($conn);

                            ?>
                            <tr>

                                <td>
                                    <?php echo "$new_medicine_id"; ?>
                                </td>

                                <td>
                                    <div class="table-icon-container">
                                        <input type="text" id="new-medicine-input" name="new-medicine-input" required>
                                    </div>
                                </td>

                                <td>
                                    <div class="table-icon-container"> 
                                        <input type="checkbox" name="to-take-morning" id="to-take-morning" value="Prescribed" class="ui-icon">
                                    </div>
                                </td>

                                <td>
                                    <div class="table-icon-container">
                                        <input type="checkbox" name="to-take-afternoon" id="to-take-afternoon" value="Prescribed" class="ui-icon">
                                    </div>
                                </td>

                                <td>
                                    <div class="table-icon-container">
                                        <input type="checkbox" name="to-take-evening" id="to-take-evening" value="Prescribed" class="ui-icon">
                                    </div>
                                </td>

                                <td>
                                    <div class="table-icon-container">
                                        <input type="checkbox" name="to-take-night" id="to-take-night" value="Prescribed" class="ui-icon">
                                    </div>
                                </td>

                                <td></td>
                                
                            </tr>
                        </template>

                    </tbody>
                </table>
            </div>
                
                <div class="add-medicine-form">
                   
                    <input type='image' id="add-medicine-button" class='ui-icon-big' src='img/plus-button.png' alt='Add medicine'/>
                   
                    <input type='image' id="submit-medicine-list-button" class='ui-icon-big' src='img/check-mark-tick-green.png' alt='Submit medicines list'/>

                    <?php echo "<input type='number' value='" . $patient_id ."' id='patient-id' name='patient-id' hidden readonly>"  ?>

                    <?php echo "<input type='number' value='" . $doctor_id ."' id='doctor-id' name='doctor-id' hidden readonly>"  ?>

                </div>

        </form>  
            
    </main>
</body>

</html>