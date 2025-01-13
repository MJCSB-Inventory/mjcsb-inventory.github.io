<!-- registerForm.php -->
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
			echo '<script>window.location.href="registerForm.php";</script>';
		}
	}
?>

<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<!-- Tab Title -->
	<title>New User - MJCSB Project Inventory</title>

	<!-- CSS -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/libs/select2/dist/css/select2.min.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/libs/jquery-minicolors/jquery.minicolors.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/libs/quill/dist/quill.snow.css"
    />
</head>

<body>
	<!-- Page Wrapper -->
	<div class="page-wrapper">
        <!-- Bread crumb and right sidebar toggle -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">New User</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      New User
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
		<!-- End bread crumb and right sidebar toggle -->
		
		<!-- Container Fluid  -->
        <div class="container-fluid">
			<!-- Page Content -->
			<div class="row">
				<!-- Form to Add New User -->
				<div class="card">
					<div class="card-body">
						<!-- h5 class="card-title">Add New Project</h5 -->
					  
						<form action="registerForm.php" method="POST">
						  <!-- Name -->
						  <div class="form-group-row">
							<label for="name">Name
								<span class="text-required"> *</span>
							</label>
							
							<div class="col-md-12">
								<input type="text" id="name" name="name" class="required form-control" required>
							</div>
						  </div><br>
						  
						  <!-- Username -->
						  <div class="form-group-row">
							<label for="username">Username
								<span class="text-required"> *</span>
							</label>
							
							<div class="col-md-12">
								<input type="text" id="username" name="username" class="required form-control" required>
							</div>
						  </div><br>
						  
						  <!-- Password -->
						  <div class="form-group-row">
							<label for="password">Password
								<span class="text-required"> *</span>
							</label>
							
							<div class="col-md-12">
								<input type="password" id="password" name="password" class="required form-control" required>
							</div>
						  </div><br>
						  
						  <!-- Role Section -->
						  <div calss="form-group-row">
							<label class="col-md-3 mt-3">User Role
								<span class="text-required"> *</span>
							</label>
							
							<div class="col-md-12">
								<select for="role" name="role" class="required select2 form-select shadow-none" style="width: 100%; height: 36px" required>
									<option value="USER">USER</option>
									<option value="ADMIN">ADMIN</option>
								</select>
							</div>
						  </div>
						  
						  <!-- Submit Button -->
						  <div class="border-top">
							<div class="card-body text-center">
							  <br><button type="submit" class="btn btn-login">
								Register
							  </button>
							</div>
						  </div>
						<form>
					</div>
				</div>
				<!-- End of Form to Add New User -->
			</div>
			<!-- End Page Content -->
        </div>
		<!-- End Container Fluid -->
		
	</div>
	<!-- End Page Wrapper -->
	
	<!-- This page js -->
    <script src="assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="dist/js/pages/mask/mask.init.js"></script>
    <script src="assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="assets/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
    <script src="assets/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
    <script src="assets/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/libs/quill/dist/quill.min.js"></script>
    <!-- script></script -->
</body>
</html>