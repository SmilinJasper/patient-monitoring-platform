<?php

// Getting uploaded file
$file = $_FILES["file"];

// Uploading in "uplaods" folder
move_uploaded_file($file["tmp_name"], "uploads/" . $file["name"]);

// Include database file
include "database.php";

// Assign values to data in MySQL table 
$is_checked = "No";
$marks = 0;
$attendance = "Present";

// Performing insert query execution 
// here our table name is student_exam_results 
$sql = "INSERT INTO student_exam_results (is_checked,marks,attendance) VALUES ('$is_checked','$marks','$attendance')";

if (mysqli_query($conn, $sql)) {
    echo "<h3>data stored in a database successfully."
        . " Please browse your ftpupload.net php my student"
        . " to view the updated data</h3>";
} else {
    echo "ERROR: Hush! Sorry $sql. "
        . mysqli_error($conn);
}

//Close MySQL Connection
mysqli_close($conn);

// Include database file again
include "database.php";

//Get all info from database table
$sql = "SELECT * FROM student_exam_results";
$result = mysqli_query($conn, $sql);

//Get id of last entry in database
$result = mysqli_query($conn, 'SELECT id FROM student_exam_results ORDER BY id DESC LIMIT 1');

if (mysqli_num_rows($result) > 0) {
    $last_id = mysqli_fetch_row($result);

    //Store last id in variable
    $maxId = $last_id[0];

    // Close connection 
    mysqli_close($conn);

    //HTML Content of Evaluation Page
    $text = "<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <link href='https://fonts.googleapis.com/css?family=Poppins:600&display=swap' rel='stylesheet'>
    <script src='https://kit.fontawesome.com/a81368914c.js'></script>
    <script defer src='../js/update_total_marks.js'></script>
    <script defer src='../js/update_page.js'></script> 
    <link href='../css/style.css' rel='stylesheet'>
    <title>Evaluation Form</title>
</head>

<body>

<nav>
    <form>
        <ul class='nav-bar'>
            <li><button type='submit' formaction='../logout_to_student_login.php'>Student Login</button></li>
            <li><a class='active' href='../staff_login.php'>Staff Login</a></li>
            <li><button type='submit' formaction='../logout_to_admin_login.php'>Admin Login</button></li>
            <li class='nav-item-right'><button type='submit' formaction='../logout_to_staff_login.php'>Logout</button></li>
        </ul>
    </form>
</nav>

<input type='number' name='id' id='id' value ='" . $maxId . "' readonly class='paper-id'>

<main>
<img class='wave' src='../img/wave.png'>

<a class='button back-button' href='staff_dashboard_1.php'>Back</a>

<div class = 'evaluation-page-wrapper'>
<div class='embedded-pdf-container'>
    <embed src='../uploads/{$file["name"]}' width='100%' height='100%' title='answersheet'></embed>
</div>

<div class='evaluation-form-container'>
        <table class='styled-table evaluation-table'>
            <tr>
                <th>Questions</th>
                <th>Out of</th>
                <th>Score</th>
            </tr>
            <tr>
                <td class='question-no'>1</td>
                <td>10</td>
                <td><input type='number' class='section-marks-input' value='0' min='0' max='10'></td>
            </tr>
            <tr>
                <td class='question-no'>2</td>
                <td>10</td>
                <td><input type='number' class='section-marks-input' value='0' min='0' max='10'></td>
            </tr>
            <tr>
                <td class='question-no'>3</td>
                <td>10</td>
                <td><input type='number' class='section-marks-input' value='0' min='0' max='10'></td>
            </tr>
            <tr>
                <td class='question-no'>4</td>
                <td>10</td>
                <td><input type='number' class='section-marks-input' value='0' min='0' max='10'></td>
            </tr>
            <tr>
                <td class='question-no'>5.1</td>
                <td>5</td>
                <td><input type='number' class='section-marks-input' value='0' min='0' max='5'></td>
            </tr>
            <tr>
                <td class='question-no'>5.2</td>
                <td>5</td>
                <td><input type='number' class='section-marks-input' value='0' min='0' max='5'></td>
            </tr>
        </table>
        <div class ='finish-paper-form-container'>
        <form action='../send_marks.php?id=" . $maxId . "' method='POST'>
        <div class='total-marks-container'>
            <label for='total-marks'>    
Total Score (Out of 50):            
</label>
            <input id='total-marks' name='total-marks' type='number' value='0' readonly min='0' max='30' class='total-marks'>
            </div>
            <div class='finalize-paper-buttons-container'>
            <input id='finish-paper' type='submit' value='Finish Paper' class='button'>
            <a href='../delete.php?name=" . $file["name"] . "&id=" . $maxId . "' class='button reject-paper-button'>Reject Paper</a>
        </form>
        </div>
            </div>
            </div>
            </body>
</main>
</html>";

    //Put evaluation form file in folder
    file_put_contents("evaluation_forms/{$file["name"]}.html", $text, FILE_APPEND | LOCK_EX);
}

// Redirecting back
header("Location: " . $_SERVER["HTTP_REFERER"]);
