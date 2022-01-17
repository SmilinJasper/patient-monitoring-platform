<html>

    <head>
        <title>Doctor Dashboard</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a81368914c.js"></script>
        <script src="js/update_page.js"></script>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta content="utf-8" http-equiv="encoding">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <!--Navigation bar-->
    <nav>
        <form>
            <ul class="nav-bar">
                <li><button type="submit" formaction="logout_to_patient_login.php">Patient Login</button></li>
                <li><button class="active" type="submit" formaction="logout_to_doctor_login.php">Doctor Login</button></li>
                <li><button type="submit" formaction="logout_to_admin_login.php">Admin Login</button></li>
                <li class="nav-item-right"><button type="submit" formaction="logout_to_doctor_login.php">Logout</button></li>
            </ul>
        </form>
    </nav>

    <body>
        <!--Background image-->
        <img class="wave" src="img/wave.png">

        <!--Page wrapper-->
        <main class="page-wrapper">

            <!--Dashboard Header-->
            <header class="center">
                <h1>DASHBOARD</h1>
            </header>

            <!--Back button-->
            <!-- <a class="button back-button" href="staff_dashboard_1.php">Back</a> -->

            <?php

            include "database.php";

            //Get patient profile info from database table
            $sql = "SELECT * FROM patient_profiles";
            $result = mysqli_query($conn, $sql);

            ?>

            <br />

            <!--Table with answersheets info-->
            <div class="table-responsive">
                    <table class="styled-table">
                        <tr>
                            <th>Patient Id</th>
                            <th>Patient Name</th>
                            <th>View Patient</th>
                            <th>Remove Patient</th>
                        </tr>
                        
                        <?php

                            //Display all info from database table and link to answersheet
                            $index = 0;
                            while ($row = mysqli_fetch_array($result)) {
                                echo "  
                            <tr>  
                                <td>" . $row['id'] . "</td>  
                                <td>" . $row['name'] . "</td>
                                <td><a class='button'>View Patient</a></td>  
                                <td><a class='button remove-account-button' href='remove_account.php?account_type=patient&id=" . $row['id'] . "'>Remove</a></td>  
                            </tr>  
                            ";
                            $index++;
                            }

                            // Close connection 
                            mysqli_close($conn);

                        ?>

                    </table>
                    <a class="button add-patient-button" href="patient_registration_form.php">Add Patient</a>
            </div>
        </main>
    </body>

</html>