<?php

// Include database file
include "database.php";

//Get total no.of uploaded papers
$result = mysqli_query($conn, "SELECT count(1) FROM student_exam_results");
$row = mysqli_fetch_array($result);

$total = $row[0];

//Get no.of checked papers
$result = mysqli_query($conn, "SELECT count(*) from student_exam_results where is_checked='Yes'");
$row = mysqli_fetch_array($result);

$checked = $row[0];

//Close connection
mysqli_close($conn);

//Get no.of remaining papers
$remaining = $total - $checked;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Staff Dashboard</title>
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
                <li><button type="submit" formaction="logout_to_student_login.php">Student Login</button></li>
                <li><a class="active" href="staff_login.php">Staff Login</a></li>
                <li><button type="submit" formaction="logout_to_admin_login.php">Admin Login</button></li>
                <li class="nav-item-right"><button type="submit" formaction="logout_to_staff_login.php">Logout</button></li>
            </ul>
        </form>
    </nav>

    <!--Background image-->
    <img class="wave" src="img/wave.png">

    <!--Page wrapper-->
    <main class="page-wrapper">

        <!--Dashboard Header-->
        <header class="center">
            <h1>DASHBOARD</h1>
        </header>

        <!--Answersheets info-->
        <div class="answersheets-info-container">
            <header>
                <h1>COMPUTER SCIENCE</h1>
            </header>

            <!--Course info-->
            <div class="course-info-container">
                <div class="course-info">
                    <label>
                        Course:
                    </label>
                    <input type="text" name="dummy1" value="B.Sc" readonly />
                </div>
                <div class="course-info">
                    <label>
                        Specialization:
                    </label>
                    <input type="text" name="dummy2" value="-" readonly />
                </div>
            </div>

            <!--Paper count info-->
            <div class="paper-count-container">
                <div class="uploaded-paper-count">
                    <p>Uploaded</p>
                    <p><?php echo $total; ?></p>
                </div>
                <div class="checked-paper-count">
                    <p>Checked</p>
                    <p><?php echo $checked; ?></p>
                </div>
                <div class="remaining-paper-count">
                    <p>Remaining</p>
                    <p><?php echo $remaining; ?></p>
                </div>
            </div>

            <!--Check papers button-->
            <div class="check-papers-button">
                <a href="staff_dashboard_2.php" class="button">Check Papers</a>
            </div>
        </div>

    </main>
</body>

</html>