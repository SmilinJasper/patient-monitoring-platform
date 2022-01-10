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
        $sql = "SELECT id FROM doctor_credentials WHERE username = ?";

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
        $sql = "INSERT INTO doctor_credentials (username, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: doctor_added.html");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Doctor Registration</title>
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
                <li><button type="submit" formaction="logout_to_student_login.php">Student Login</button></li>
                <li><button type="submit" formaction="logout_to_staff_login.php">Staff Login</button></li>
                <li><a class="active" href="admin_login.php">Admin Login</a></li>
                <li class="nav-item-right"><button type="submit" formaction="logout_to_admin_login.php">Logout</button></li>
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

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="doctor-login-form login-form">

                <h2 class="title">Register Doctor</h2>

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
                        <h5>Username</h5>
                        <input id="input-username" name="username" type="text" class="input input-username">
                    </div>
                </div>

                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input id="input-password" name="password" type="password" class="input input-password">
                    </div>
                </div>

                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Confirm Password</h5>
                        <input id="input-password" name="confirm-password" type="password" class="input input-password">
                    </div>
                </div>

                <div class="input-div">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>    
                    <div class="div">
                        <h5>Name</h5>
                        <input id="input-name" name="name" type="text" class="input input-username" required>
                    </div>
                </div>

                <div class="input-div-checkbox">

                    <div class="i">
                        <i class="fas fa-graduation-cap"></i>
                        <h5>Credentials</h5>
                    </div>

                    <div class="options">

                        <div>
                            <input id="mbbs" name="mbbs" value="MBBS" type="checkbox" required>
                            <label for="mbbs">MBBS</label>
                        </div>
                       
                        <div>
                            <input id="md" name="md" value="MD" type="checkbox">
                            <label for="md">MD</label>
                        </div>

                        <div>
                            <input id="dm" name="dm" value="DM" type="checkbox">
                            <label for="dm">DM</label>
                        </div>

                    </div>
                </div>

                <div class="input-div-experience">
                    
                    <div class="i">
                        <i class="fas fa-briefcase"></i>
                        <h5>Years of Experience</h5>
                    </div>

                    <div class="values">
                        <input id="input-experience-years" name="experience-years" type="number" min="0">
                        <label for="input-experience-years">Years</label>
                        <input id="input-experience-months" name="experience-months" type="number" required max="11" min="0">                    
                        <label for="input-experience-months">Months</label>
                    </div>
                
                </div>
                
                <input id="login" type="submit" class="btn login" value="Create Account">

            </form>

        </div>

        <!--Javascript-->
        <script type="text/javascript" src="js/login_input_animation.js"></script>

</body>

</html>