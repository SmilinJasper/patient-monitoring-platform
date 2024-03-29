<?php

$docotor_id = $_GET['id'];

?>

<html>

<head>
    <title>Patient Added Successfully</title>
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
        <ul class="nav-bar">
            <li><button type="submit" formaction="logout_to_patient_login.php">Patient Login</button></li>
            <li><button class="active" type="submit" formaction="logout_to_doctor_login.php">Doctor Login</button></li>
            <li><button type="submit" formaction="logout_to_admin_login.php">Admin Login</button></li>
            <li class="nav-item-right"><button type="submit" formaction="logout_to_doctor_login.php">Logout</button>
            </li>
        </ul>
    </nav>

    <!--Background wave image-->
    <img class="wave" src="img/wave.png">

    <!-- Wrapper -->
    <main class="page-wrapper">

        <!--Paper evaluated message-->
        <center>
            <h1 style="color: #4B88E7;">Patient Added Successfully</h1>
            <?php echo "<a href='doctor_dashboard.php?id=" . $docotor_id . "' class='button next-button'>NEXT</a>"; ?>
        </center>

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