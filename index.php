<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: patient_dashboard.php");
    exit;
}

// Include database file
require_once "database.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $login_err = $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $login_err = $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM patient_credentials WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["user_type"] = "patient";

                            // Redirect user to welcome page
                            header("location: patient_dashboard.php?id=" . $_SESSION['id']);
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
    <title>Patient Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script defer type="text/javascript" src="js/login_input_animation.js"></script>
    <script defer src="js/location.js"></script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <!--Navigation bar-->
    <nav>
        <ul class="nav-bar">
            <li><a class="active" href="index.php">Patient Login</a></li>
            <li><a href="doctor_login.php">Doctor Login</a></li>
            <li><a href="admin_login.php">Admin Login</a></li>
        </ul>
    </nav>

    <!--Background images-->
    <img class="wave" src="img/wave.png">

    <main class="container">

        <div class="img">
            <img src="img/bg.svg">
        </div>

        <!--Login form-->
        <div class="login-content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="staff-login-form login-form">
                <img src="img/avatar.svg">

                <h2 class="title">Welcome</h2>

                <div class="login-error-message">
                    <p><?php echo $login_err ?></p>
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

                <a href="#">Forgot Password?</a>

                <input id="login" type="submit" class="btn login" value="login">

                <a href="patient_dashboard.php?id='99999'" class="btn login guest-login">Login as Guest</a>
            </form>

        </div>

    </main>

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