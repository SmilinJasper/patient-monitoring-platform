<?php
// Include config file
require_once "database.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM patient_credentials WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm-password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm-password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO patient_credentials (username, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "Successfully added patient credentials!";                               
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        
        // Save patient profile details in the databse
        $patient_id = mysqli_query($conn, "SELECT max(id) FROM patient_credentials");
        $patient_id = mysqli_fetch_array($patient_id);
        $patient_id = $patient_id[0];
        $patient_name = $_POST["patient-name"];
        $patient_date_of_birth = $_POST["patient-date-of-birth"];
        $patient_age = date_diff(date_create($patient_date_of_birth), date_create("today"))->y;
        $patient_blood_group = $_POST["patient-blood-group"];
        $patient_height = $_POST["patient-height"];
        $patient_weight = $_POST["patient-weight"];
        $patient_contact_number = $_POST["patient-contact-number"];
        $patient_bmi = round($patient_weight/($patient_height*$patient_height)* 703,2);

        // Save doctor profile details in the databse
        $sql = "INSERT INTO patient_profiles (id, name, date_of_birth, age, blood_group, height, weight, bmi, contact_number) VALUES ('$patient_id', '$patient_name', '$patient_date_of_birth', '$patient_age', '$patient_blood_group', '$patient_height', '$patient_weight', '$patient_bmi', '$patient_contact_number')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to login page
            header("location: patient_added.html");
            } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Patient Registration</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
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
                <li><button class="active" type="submit" formaction="logout_to_doctor_login.php">Doctor Login</button></li>
                <li><button type="submit" formaction="logout_to_admin_login.php">Admin Login</button></li>
                <li class="nav-item-right"><button type="submit" formaction="logout_to_doctor_login.php">Logout</button></li>
            </ul>
        </form>
    </nav>

    <!--Background images-->
    <img class="wave" src="img/wave.png">
    <div class="container">
        <div class="img">
            <img src="img/bg.svg">
        </div>

        <div class="login-content">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="student-login-form login-form">

                <h2 class="title">Register Patient</h2>

                <div class="login-error-message">
                    <?php 
                        echo "<p>" . $username_err . "</p>";
                        echo "<p>" . $password_err . "</p>";                  
                        echo "<p>" . $confirm_password_err . "</p>";
                    ?>
                </div>

                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <label for="input-username">
                            <h5>Username</h5>
                        </label>
                        <input id="input-username" name="username" type="text" class="input input-username">
                    </div>
                </div>

                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <label for="input-password">
                            <h5>Password</h5>
                        </label>
                        <input id="input-password" name="password" type="password" class="input input-password">
                    </div>
                </div>

                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <label for="input-password">
                            <h5>Confirm Password</h5>
                        </label>
                        <input id="input-password" name="confirm-password" type="password" class="input input-password">
                    </div>
                </div>

                <div class="input-div">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>    
                    <div class="div">
                        <label for="input-name">
                            <h5>Name</h5>
                        </label>
                        <input id="input-name" name="patient-name" type="text" class="input" required>
                    </div>
                </div>
                
                <div class="input-div input-heading-top">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>    
                    <div class="div">
                        <label for="input-date-of-birth">
                            <h5>Date of Birth</h5>
                        </label>
                        <input id="input-date-of-birth" name="patient-date-of-birth" type="date" class="input" required>
                    </div>
                </div>

                <div class="input-div">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>    
                    <div class="div">
                        <label for="input-blood-group">
                            <h5>Blood Group</h5>
                        </label>
                        <input id="input-blood-group" name="patient-blood-group" type="text" class="input" maxlength="3" required>
                    </div>
                </div>

                <div class="input-div">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>    
                    <div class="div">
                        <label for="input-height">
                            <h5>Height (In CM)</h5>
                        </label>
                        <input id="input-height" name="patient-height" type="number" class="input" min="1" maxlength="3" required>
                    </div>
                </div>

                <div class="input-div">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>    
                    <div class="div">
                        <label for="input-weight">
                            <h5>Weight (In KG)</h5>
                        </label>
                        <input id="input-weight" name="patient-weight" type="number" class="input" min="1" maxlength="3" required>
                    </div>
                </div>

                <div class="input-div">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>    
                    <div class="div">
                        <label for="input-contact-number">
                            <h5>Contact Number</h5>
                        </label>
                        <input id="input-contact-number" name="patient-contact-number" type="text" class="input" maxlength="10" required>
                    </div>
                </div>

                <input id="login" type="submit" class="btn login" value="Create Account">

            </form>

        </div>

        <!--Javascript-->
        <script type="text/javascript" src="js/login_input_animation.js"></script>

</body>

</html>