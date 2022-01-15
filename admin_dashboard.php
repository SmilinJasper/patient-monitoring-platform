<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="js/update_page.js"></script>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="upload-form-body">

    <!--Navigation bar-->
    <nav>
        <form>
            <ul class="nav-bar">
                <li><button type="submit" formaction="logout_to_patient_login.php">Patient Login</button></li>
                <li><button type="submit" formaction="logout_to_doctor_login.php">Doctor Login</button></li>
                <li><button class="active" type="submit" formaction="logout_to_admin_login.php">Admin Login</button></li>
                <li class="nav-item-right"><button type="submit" formaction="logout_to_admin_login.php">Logout</button></li>
            </ul>
        </form>
    </nav>

    <!--Background image-->
    <img class="wave" src="img/wave.png">

    <!--Page wrapper-->
    <main class="page-wrapper">

        <section class="add-user">
            <a class="button button__add-user" href="patient_registration_form.php">Add New Patient</a>
            <a class="button button__add-user" href="doctor_registration_form.php">Add New Doctor</a>
        </section>

        <?php

        // Include database file
        include "database.php";

        //Get all info from database table
        $sql = "SELECT * FROM doctor_profiles";
        $result = mysqli_query($conn, $sql);

        ?>

        <!--Table with doctor profiles info-->
        <br />
        <div class="table-responsive">
            <center>
                <table class="styled-table">
                    <tr>
                        <th>Doctor Id</th>
                        <th>Name</th>
                        <th>Credentials</th>
                        <th>Experience</th>
                        <th>Remove Account</th>
                    </tr>
                    <?php

        //Display all info from doctor profiles table
        $index = 0;
        while ($row = mysqli_fetch_array($result)) {
        echo "  
       <tr>  
         <td>" . $row['id'] . "</td>  
         <td>" . $row['name'] . "</td>  
         <td>" . $row['credentials'] . "</td>  
         <td>" . $row['experience'] . "</td>
         <td class='remove-account-cell'>
            <a class='button remove-account-button' href='delete.php?id=" . $row['id'] . "'>Remove</a>
        </td>      
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