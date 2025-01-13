<!-- login.php -->
<?php
    session_start();
    include "dbconn.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        $sql = "SELECT * FROM users WHERE Username = '$username';";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['Password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['UID'] = $row['UID'];
                $_SESSION['Role'] = $row['Role'];
				
				header("Location: index.php");
				exit();
					
                /*if ($row['Role'] === 'ADMIN'){
                    header("Location: index.html");
                    exit();
                } else if ($row['Role'] === 'USER'){
                    header("Location: index.html");
                    exit();
                } else {
                    echo '<script>alert("Error!");</script>';
                }*/
            } else {
                echo '<script>alert("Incorrect Password.");</script>';
            }
        } else {
            echo '<script>alert("Invalid Username.");</script>';
        }
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - MJCSB Project Inventory</title>
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/MJC_single_logo.png" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link href="dist/css/style.css" rel="stylesheet" />
    </head>

    <body class="body-login h-login pt-3">
        <div class="container-login">
            <div id="loginform" class="text-center pt-3 pb-3">
                <img src="assets/images/MJC_logo.png" alt="Logo" style="max-width: 150px;margin-bottom: 20px;">
                <h1>MJCSB Project Inventory</h1>
                <h3>Lost? <a href="https://megajaticonsult.com/">Go To Mega Jati Consult Sdn Bhd</a></h3>

                <form class="form form-login form-horizontal mt-3" action="" method="POST">
                    <div class="form-group-row">
                        <label for="username" class="col-md-3 mt-3">Username</label>
                        <input type="text" name="username" id="username" required>
                    </div>

                    <div>
                        <label for="password" class="col-md-3 mt-3">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div class="card-body">
                        <button type="submit" class="btn btn-login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>