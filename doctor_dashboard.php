<html>

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
        <a class="button back-button" href="staff_dashboard_1.php">Back</a>

        <?php

        include "database.php";

        //Get all info from database table
        $sql = "SELECT * FROM student_exam_results";
        $result = mysqli_query($conn, $sql);

        //Scan directory for uploads
        $files = chdir("uploads");
        array_multisort(array_map('filemtime', ($files = glob("*.{pdf}", GLOB_BRACE))), SORT_DESC, $files);
        $orderedFiles = array_reverse($files);

        ?>

        <br />

        <!--Table with answersheets info-->
        <div class="table-responsive">
            <center>
                <table class="styled-table">
                    <tr>
                        <th>Assignment Id</th>
                        <th>Check Answersheet</th>
                        <th>Is Checked</th>
                        <th>Marks</th>
                        <th>Attendance</th>
                    </tr>
                    <?php

                    //Display all info from database table and link to answersheet
                    $index = 0;
                    while ($row = mysqli_fetch_array($result)) {
                        echo "  
       <tr>  
         <td>" . $row['id'] . "</td>  
         <td><a class='button' href='evaluation_forms/" . $orderedFiles[$index] . ".html'>Check Answersheet</a></td>
         <td>" . $row['is_checked'] . "</td>  
         <td>" . $row['marks'] . "</td>  
         <td>" . $row['attendance'] . "</td>  
       </tr>  
        ";
                        $index++;
                    }

                    // Close connection 
                    mysqli_close($conn);

                    ?>
                </table>
            </center>
        </div>
    </main>
</body>

</html>