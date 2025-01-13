<!-- edit.php-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<!-- Tab Title -->
	<title>Edit - MJCSB Project Inventory</title>

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
	<!-- Page Wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb and right sidebar toggle -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">PROJECTS</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
				<div class="card">
					<div class="card-body">
						<?php
						include "dbconn.php";
						
						if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["PID"])){
							
							$pID = mysqli_real_escape_string($conn, $_POST["PID"]);
							
							$sql = "SELECT
									  p.PID,
									  p.Year,
									  p.Name,
									  p.FileNo,
									  p.FileName,
									  p.Category,
									  p.Status,
									
									  -- Electrical
									  a1.Director1 AS elecDirec1,
									  a1.Director2 AS elecDirec2,
									  a1.Engineer1 AS elecEng1,
									  a1.Engineer2 AS elecEng2,
									  
									  -- Mechanical
									  a2.Director1 AS mechDirec1,
									  a2.Director2 AS mechDirec2,
									  a2.Engineer1 AS mechEng1,
									  a2.Engineer2 AS mechEng2,
									  
									  -- Other
									  a3.Director1 AS otherDirec1,
									  a3.Director2 AS otherDirec2,
									  a3.Engineer1 AS otherEng1,
									  a3.Engineer2 AS otherEng2
									  
									FROM project p
									LEFT JOIN assigned a1 ON p.PID = a1.PID AND a1.Type = 'Electrical'
									LEFT JOIN assigned a2 ON p.PID = a2.PID AND a2.Type = 'Mechanical'
									LEFT JOIN assigned a3 ON p.PID = a3.PID AND a3.Type = 'Other'
									WHERE p.PID = '$pID'";
							
							$sendquery = mysqli_query($conn, $sql);
							
							if (!$sendquery) {
								echo "Error: " . mysqli_error($conn);
							}
							
							if (mysqli_num_rows($sendquery) > 0){
								while($row = mysqli_fetch_assoc($sendquery)){
									//echo "<div>Project Name: " . htmlspecialchars($row["Name"]) . "</div>";
						?>
						
						<form action="edit_process.php" method="POST">
						  <input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
						  
						  <!-- Year -->
						  <div class="form-group-row">
							<label for="year">Year
								<span class="text-required"> *</span>
							</label>
							<div class="col-md-12">
								<input type="number" id="year" name="year" class="required form-control" value="<?php echo $row['Year'];?>" required>
							</div>
						  </div><br>
						  
						  <!-- Project Name -->
						  <div class="form-group-row">
							<label for="proname">Project Name
								<span class="text-required"> *</span>
							</label>
							<div class="col-md-12">
								<input type="text" id="proname" name="proname" class="required form-control" value="<?php echo $row['Name'];?>" required>
							</div>
						  </div><br>
						  
						  <!-- File No -->
						  <div class="form-group-row">
							<label for="fileno">File No
								<span class="text-required"> *</span>
							</label>
							<div class="col-md-12">
								<input type="number" id="fileno" name="fileno" class="required form-control" value="<?php echo $row['FileNo'];?>" required>
							</div>
						  </div><br>
						  
						  <!-- File Name -->
						  <div class="form-group-row">
							<label for="filename">File Name
								<span class="text-required"> *</span>
							</label>
							<div class="col-md-12">
								<input type="text" id="filename" name="filename" class="required form-control" value="<?php echo $row['FileName'];?>" required>
							</div>
						  </div><br>
						  
						  <!-- Assigned Section -->
						  <div class="form-group-row">
							<label class="col=md-12">Assigned To</label>
							
							  <fieldset required>
								<div class="col-md-12">
									<div class="form-check mr-sm-2">
										<input type="checkbox" class="form-check-input" id="elec" name="elec" <?php if ($row['elecDirec1'] || $row['elecDirec2'] || $row['elecEng1'] || $row['elecEng2']) echo 'checked'; ?>>
										<label class="form-check-label mb-0" for="elec">Electrical</label>
										<fieldset class="conditional">
											<div class="form-group-row">
												<div class="col-md-12">
													<input type="text" id="elecdirec1" name="elecdirec1" class="form-control" placeholder="Electrical Dierctor 1" value="<?php echo $row['elecDirec1']; ?>">
													<input type="text" id="elecdirec2" name="elecdirec2" class="form-control" placeholder="Electrical Director 2" value="<?php echo $row['elecDirec2']; ?>">
													<input type="text" id="eleceng1" name="eleceng1" class="form-control" placeholder="Electrical Engineer 1" value="<?php echo $row['elecEng1']; ?>">
													<input type="text" id="eleceng2" name="eleceng2" class="form-control" placeholder="Electrical Engineer 2" value="<?php echo $row['elecEng2']; ?>">
												</div>
											</div>
										</fieldset>
									</div>
									
									<div class="form-check mr-sm-2">
										<input type="checkbox" class="form-check-input" id="mech" name="mech" <?php if ($row['mechDirec1'] || $row['mechDirec2'] || $row['mechEng1'] || $row['mechEng2']) echo 'checked'; ?>>
										<label class="form-check-label mb-0" for="mech">Mechanical</label>
										<fieldset class="conditional">
											<div class="form-group-row">
												<div class="col-md-12">
													<input type="text" id="mechdirec1" name="mechdirec1" class="form-control" placeholder="Mechanical Dierctor 1" value="<?php echo $row['mechDirec1']; ?>">
													<input type="text" id="mechdirec2" name="mechdirec2" class="form-control" placeholder="Mechanical Director 2" value="<?php echo $row['mechDirec2']; ?>">
													<input type="text" id="mecheng1" name="mecheng1" class="form-control" placeholder="Mechanical Engineer 1" value="<?php echo $row['mechEng1']; ?>">
													<input type="text" id="mecheng2" name="mecheng2" class="form-control" placeholder="Mechanical Engineer 2" value="<?php echo $row['mechEng2']; ?>">
												</div>
											</div>
										</fieldset>
									</div>
									
									<div class="form-check mr-sm-2">
										<input type="checkbox" class="form-check-input" id="other" name="other" <?php if ($row['otherDirec1'] || $row['otherDirec2'] || $row['otherEng1'] || $row['otherEng2']) echo 'checked'; ?>>
										<label class="form-check-label mb-0" for="other">Other</label>
										<fieldset class="conditional">
											<div class="form-group-row">
												<div class="col-md-12">
													<input type="text" id="otherdirec1" name="otherdirec1" class="form-control" placeholder="Dierctor 1" value="<?php echo $row['otherDirec1']; ?>">
													<input type="text" id="otherdirec2" name="otherdirec2" class="form-control" placeholder="Director 2" value="<?php echo $row['otherDirec2']; ?>">
													<input type="text" id="othereng1" name="othereng1" class="form-control" placeholder="Engineer 1" value="<?php echo $row['otherEng1']; ?>">
													<input type="text" id="othereng2" name="othereng2" class="form-control" placeholder="Engineer 2" value="<?php echo $row['otherEng2']; ?>">
												</div>
											</div>
										</fieldset>
									</div>
								</div>
							  </fieldset>
						  </div>
						  
						  <!-- Category Section -->
						  <div calss="form-group-row">
							<label class="col-md-3 mt-3">Category
								<span class="text-required"> *</span>
							</label>
							
							<div class="col-md-12">
								<select for="category" name="category" class="required select2 form-select shadow-none" style="width: 100%; height: 36px" required>
									<option><?php echo $row['Category'];?></option>
									
									<optgroup label="Transportation">
										<option value="Road & Highway">Road & Highway</option>
										<option value="Railway">Railway</option>
										<option value="Airport & Seaport">Airport & Seaport</option>
									</optgroup>
									
									<optgroup label="Real Estate">
										<option value="Properties">Properties</option>
										<option value="Housing">Housing</option>
										<option value="Residental">Residental</option>
									</optgroup>
									
									<optgroup label="Healthcare">
										<option value="Hospital">Hospital</option>
										<option value="Clinic">Clinic</option>
									</optgroup>
									
									<optgroup label="Education">
										<option value="School">School</option>
										<option value="Education Centre">Education Centre</option>
									</optgroup>
									
									<option>Other</option>
								</select>
							</div>
						  </div>
						  
						  <!-- Status Section --> 
						  <div class="form-group-row">
							<label class="col-md-3 mt-3">Status
								<span class="text-required"> *</span>
							</label>
							
							<div class="col-md-12">
								<select for="status" name="status" class="required select2 form-select shadow-none" style="width: 100%; height: 36px" required>
									<option><?php echo $row['Status'];?></option>
									
									<option value="Complete">Complete</option>
									<option value="Ongoing">Ongoing</option>
									<option value="KIV">KIV</option>
								</select>
							</div>
						  </div>
						  
						  <!-- * -->
						  <br><label class="col-md-3 mt-3 text-required">(*) Mandatory Field</label>
						  
						  <!-- Submit Button -->
						  <div class="border-top">
							<div class="card-body">
							  <button type="submit" class="btn btn-info">
								Update
							  </button>
							</div>
						  </div>
						<?php
								}
							} else {
								echo '<script>alert("Data Not Found.");</script>';
								echo '<script>window.location.href = "index.php";</script>';
							}
						} else {
							echo "POST Request Failed.";
							echo '<script>alert("Invalid Request.");</script>';
							echo '<script>window.location.href = "index.php";</script>';
						}
						?>
						</form >
					</div>
				</div>
			</div>
			<!-- End Page Content -->
		</div>
		<!-- End Container FLuid -->
	</div>
	<!-- End Page Wrapper -->
</body>
</html>