<?php
	include "dbconn.php";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = $_POST["name"];
		//$email = $_POST["email"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$role = $_POST["role"];
		
		$name = mysqli_real_escape_string($conn, $name);
		//$email = mysqli_real_escape_string($conn, $email);
		$username = mysqli_real_escape_string($conn, $username);
		$password = mysqli_real_escape_string($conn, $password);
		
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);
		
		$sql = "INSERT INTO users (Name, Username, Password, Role)
				VALUES ('$name', '$username', '$hashed_password', '$role');";
				
		$sendquery = mysqli_query($conn, $sql);
		
		if ($sendquery) {
			echo '<script>alert("Registration Success.");</script>';
			echo '<script>window.location.href="login.php";</script>';
		} else {
			echo '<script>alert("Registration Failed.");</script>';
			echo '<script>window.location.href="register.php";</script>';
		}
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Register - MJCSB Project Inventory</title>
		<link rel="icon" type="image/png" sizes="16x16" href="assets/images/MJC_single_logo.png" />
		<!-- Link to External Google Font -->
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="dist/css/style.css" rel="stylesheet" />
	</head>
	
	<body class="body-login h-login pt-3">
		<div class="container-login">
			<div>
				<div id="loginform" class="text-center pt-3 pb-3">
					<img src="assets/images/MJC_logo.png" alt="Logo" style="max-width: 150px;margin-bottom: 20px;">
					<h1>MJCSB Project Inventory</h1>
					<h3>Lost? <a href="https://megajaticonsult.com/">Go To Mega Jati Consult Sdn Bhd</a></h3>
					
					<form class="form form-login form-horizontal mt-3" action="" method="POST">
						<div class="form-group-row">
							<label for="name" class="col-md-3 mt-3">Name</label>
							<input type="text" name="name" id="name" required>
						</div>
						
						<!-- div class="form-group-row">
							<label for="email" class="col-md-3 mt-3">Email</label>
							<input type="text" name="email" id="email" required>
						</div -->
						
						<div class="form-group-row">
							<label for="username" class="col-md-3 mt-3">Username</label>
							<input type="text" name="username" id="username" required>
						</div>
						
						<div class="form-group-row">
							<label for="password" class="col-md-3 mt-3">Password</label>
							<input type="password" name="password" id="password" required>
						</div>
						
						<div class="form-group-row">
							<label for="role" class="col-md-3 mt-3">User Role</label>
							
							<select for="role" name="role" class="select2 form-select shadow-none input-group-text">
								<option value="User">User</option>
								<option value="Admin">Admin</option>
							</select>
						</div>
						
						<div class="card-body">
							<button type="submit" class="btn btn-login">Register</button>
						</div>
					</form>
					
					<h3>Already a User? <a href="login.php">Login</a></h3>
				</div>
			</div>
		</div>
	</body>
</html>
