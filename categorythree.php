<?php
include "dbconn.php";
											
if (isset($_POST["PID"])){
	$pID = $_POST["PID"];
	
	$pID = mysqli_real_escape_string($conn, $pID);
	
	$sqlDelete = "DELETE FROM project
				  WHERE PID = '$pID'";
	
	$sendqueryDelete = mysqli_query($conn, $sqlDelete) or die("Delete failed");
	
	if ($sendqueryDelete){
		echo '<script>alert("Data Deleted Successfully.");</script>';
		echo '<script>history.back();</script>';
	} else {
		echo '<script>alert("Failed to Delete Data.");</script>';
		echo '<script>history.back();</script>';
	}
}

// Fetch data based on filter (default is 'all')
$filter = $_GET['filter'] ?? 'all';

// Prepare the query based on the filter
if ($filter === 'all') {
    $query = "SELECT
				p.PID,
				p.Year,
				p.Name,
				CONCAT(p.FileNo, ' : ', p.FileName) AS File,
				  
				-- Electrical
				GROUP_CONCAT(CASE
				WHEN a.Type = 'Electrical' THEN CONCAT(
				  'Directors: ',
				  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
				  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
				  '<br> Engineers: ',
				  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
				  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
				)
				END) AS Electrical,
				  
				-- Mechanical
				GROUP_CONCAT(CASE
				WHEN a.Type = 'Mechanical' THEN CONCAT(
				  'Directors: ',
				  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
				  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
				  '<br> Engineers: ',
				  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
				  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
				)
				END) AS Mechanical,
				  
				-- Other
				GROUP_CONCAT(CASE
				WHEN a.Type = 'Other' THEN CONCAT(
				  'Directors: ',
				  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
				  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
				  '<br> Engineers: ',
				  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
				  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
				)
				END) AS Other,
				
				p.Category, p.Status
				
			  FROM project p
			  LEFT JOIN assigned a ON p.PID = a.PID
			  GROUP BY p.PID
			  ORDER BY p.Year DESC";
} else {
    $query = "SELECT
				p.PID,
				p.Year,
				p.Name,
				CONCAT(p.FileNo, ' : ', p.FileName) AS File,
				  
				-- Electrical
				GROUP_CONCAT(CASE
				WHEN a.Type = 'Electrical' THEN CONCAT(
				  'Directors: ',
				  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
				  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
				  '<br> Engineers: ',
				  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
				  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
				)
				END) AS Electrical,
				  
				-- Mechanical
				GROUP_CONCAT(CASE
				WHEN a.Type = 'Mechanical' THEN CONCAT(
				  'Directors: ',
				  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
				  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
				  '<br> Engineers: ',
				  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
				  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
				)
				END) AS Mechanical,
				  
				-- Other
				GROUP_CONCAT(CASE
				WHEN a.Type = 'Other' THEN CONCAT(
				  'Directors: ',
				  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
				  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
				  '<br> Engineers: ',
				  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
				  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
				)
				END) AS Other,
				
				p.Category, p.Status
				
			  FROM project p
			  LEFT JOIN assigned a ON p.PID = a.PID
			  WHERE p.Category = ?
			  GROUP BY p.PID
			  ORDER BY p.Year DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $filter);
    $stmt->execute();
    $result = $stmt->get_result();
} 
?>

<body>
	<!-- Page Wrapper  -->
	<div class="page-wrapper">
		<!-- Bread crumb and right sidebar toggle -->
		<div class="page-breadcrumb">
		  <div class="row">
			<div class="col-12 d-flex no-block align-items-center">
			  <h4 class="page-title">Category</h4>
			  <div class="ms-auto text-end">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">
					  Category
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
				<div class="col-12">
					<div class="card">
						<!-- Tab Navigation -->
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a
								  class="nav-link active"
								  data-bs-toggle="tab"
								  href="#all"
								  role="tab"
								  ><span class="hidden-sm-up"></span>
								  <span class="hidden-xs-down">All</span></a
								>
							</li>
							<li class="nav-item">
								<a
								  class="nav-link"
								  data-bs-toggle="tab"
								  href="#transportation"
								  role="tab"
								  ><span class="hidden-sm-up"></span>
								  <span class="hidden-xs-down">Transportation</span></a
								>
							</li>
							<li class="nav-item">
								<a
								  class="nav-link"
								  data-bs-toggle="tab"
								  href="#realestate"
								  role="tab"
								  ><span class="hidden-sm-up"></span>
								  <span class="hidden-xs-down">Real Estate</span></a
								>
							</li>
							<li class="nav-item">
								<a
								  class="nav-link"
								  data-bs-toggle="tab"
								  href="#healthcare"
								  role="tab"
								  ><span class="hidden-sm-up"></span>
								  <span class="hidden-xs-down">Healthcare</span></a
								>
							</li>
							<li class="nav-item">
								<a
								  class="nav-link"
								  data-bs-toggle="tab"
								  href="#education"
								  role="tab"
								  ><span class="hidden-sm-up"></span>
								  <span class="hidden-xs-down">Education</span></a
								>
							</li>
							<li class="nav-item">
								<a
								  class="nav-link"
								  data-bs-toggle="tab"
								  href="#other"
								  role="tab"
								  ><span class="hidden-sm-up"></span>
								  <span class="hidden-xs-down">Other</span></a
								>
							</li>
						</ul>
						<!-- End Tab Navigation -->
						
						<!-- Tab Content -->
						<div class="tab-content tabcontent-border">
							<!-- All -->
							<div class="tab-pane active" id="all" role="tabpanel">
								<div class="p-20">
									<div class="card-body">
										<div class="table-responsive">
											<?php
											include "dbconn.php";
											
											if (isset($_POST["PID"])){
												$pID = $_POST["PID"];
												
												$pID = mysqli_real_escape_string($conn, $pID);
												
												$sqlDelete = "DELETE FROM project
															  WHERE PID = '$pID'";
												
												$sendqueryDelete = mysqli_query($conn, $sqlDelete) or die("Delete failed");
												
												if ($sendqueryDelete){
													echo '<script>alert("Data Deleted Successfully.");</script>';
													echo '<script>history.back();</script>';
												} else {
													echo '<script>alert("Failed to Delete Data.");</script>';
													echo '<script>history.back();</script>';
												}
											}
											
											$sqlSelect = "SELECT
															p.PID,
															p.Year,
															p.Name,
															CONCAT(p.FileNo, ' : ', p.FileName) AS File,
															  
															-- Electrical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Electrical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Electrical,
															  
															-- Mechanical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Mechanical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Mechanical,
															  
															-- Other
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Other' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Other,
															
															p.Category, p.Status
															
														  FROM project p
														  LEFT JOIN assigned a ON p.PID = a.PID
														  GROUP BY p.PID
														  ORDER BY p.Year DESC";

											
											$sendquerySelect = mysqli_query($conn, $sqlSelect);
											
											if(mysqli_num_rows($sendquerySelect) > 0)
											{
											?>
											
											<table id="zero_config" class="table table-striped table-bordered">
												<thead class="position-sticky top-0">
													<tr>
													  <th>YEAR</th>
													  <th>PROJECT NAME</th>
													  <th>FILE</th>
													  <th>ELECTRICAL</th>
													  <th>MECHANICAL</th>
													  <th>OTHER</th>
													  <th>CATEGORY</th>
													  <th>STATUS</th>
													  <th>ACTION</th>
													</tr>
												</thead>
												  
												<tbody>
													<?php
													while($row = mysqli_fetch_assoc($sendquerySelect))
													{
													?>
													<tr>
													  <td><?php echo $row['Year'];?></td>
													  <td><?php echo $row['Name'];?></td>
													  <td><?php echo $row['File'];?></td>
													  <td><?php echo $row['Electrical'] ?: 'None';?></td>
													  <td><?php echo $row['Mechanical'] ?: 'None';?></td>
													  <td><?php echo $row['Other'] ?: 'None';?></td>
													  <td><?php echo $row['Category'];?></td>
													  <td><?php echo $row['Status'];?></td>
													  <td class="text-center">
														<form action="edit.php" method="POST">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-blue text-white">
																<i class="mdi mdi-table-edit"></i>
															</button>
														</form>
														
														<form action="home.php" method="POST" onsubmit="return confirm('Delete this project?');">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-danger">
																<i class="mdi mdi-delete"></i>
															</button>
														</form>
													  </td>
													</tr>
													<?php
													}
													?>
												</tbody>
											</table>
											<?php
											}
											else {
											?>
												<div class="text-center">
													<h5>No Data Found.<h5>
												</div>
											<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Transportation -->
							<div class="tab-pane p-20" id="transportation" role="tabpanel">
								<div class="p-20">
									<div class="card-body">
										<div class="table-responsive">
											<?php
											include "dbconn.php";
											
											if (isset($_POST["PID"])){
												$pID = $_POST["PID"];
												
												$pID = mysqli_real_escape_string($conn, $pID);
												
												$sqlDelete = "DELETE FROM project
															  WHERE PID = '$pID'";
												
												$sendqueryDelete = mysqli_query($conn, $sqlDelete) or die("Delete failed");
												
												if ($sendqueryDelete){
													echo '<script>alert("Data Deleted Successfully.");</script>';
													echo '<script>history.back();</script>';
												} else {
													echo '<script>alert("Failed to Delete Data.");</script>';
													echo '<script>history.back();</script>';
												}
											}
											
											$sqlSelect = "SELECT
															p.PID,
															p.Year,
															p.Name,
															CONCAT(p.FileNo, ' : ', p.FileName) AS File,
															  
															-- Electrical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Electrical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Electrical,
															  
															-- Mechanical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Mechanical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Mechanical,
															  
															-- Other
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Other' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Other,
															
															p.Category, p.Status
															
														  FROM project p
														  LEFT JOIN assigned a ON p.PID = a.PID
														  WHERE p.Category IN ('Road', 'Highway', 'Railway', 'Airport', 'Seaport')
														  GROUP BY p.PID
														  ORDER BY p.Year DESC";

											
											$sendquerySelect = mysqli_query($conn, $sqlSelect);
											
											if(mysqli_num_rows($sendquerySelect) > 0)
											{
											?>
											
											<table id="zero_config" class="table table-striped table-bordered">
												<thead class="position-sticky top-0">
													<tr>
													  <th>YEAR</th>
													  <th>PROJECT NAME</th>
													  <th>FILE</th>
													  <th>ELECTRICAL</th>
													  <th>MECHANICAL</th>
													  <th>OTHER</th>
													  <th>CATEGORY</th>
													  <th>STATUS</th>
													  <th>ACTION</th>
													</tr>
												</thead>
												  
												<tbody>
													<?php
													while($row = mysqli_fetch_assoc($sendquerySelect))
													{
													?>
													<tr>
													  <td><?php echo $row['Year'];?></td>
													  <td><?php echo $row['Name'];?></td>
													  <td><?php echo $row['File'];?></td>
													  <td><?php echo $row['Electrical'] ?: 'None';?></td>
													  <td><?php echo $row['Mechanical'] ?: 'None';?></td>
													  <td><?php echo $row['Other'] ?: 'None';?></td>
													  <td><?php echo $row['Category'];?></td>
													  <td><?php echo $row['Status'];?></td>
													  <td class="text-center">
														<form action="edit.php" method="POST">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-blue text-white">
																<i class="mdi mdi-table-edit"></i>
															</button>
														</form>
														
														<form action="home.php" method="POST" onsubmit="return confirm('Delete this project?');">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-danger">
																<i class="mdi mdi-delete"></i>
															</button>
														</form>
													  </td>
													</tr>
													<?php
													}
													?>
												</tbody>
											</table>
											<?php
											}
											else {
											?>
												<div class="text-center">
													<h5>No Data Found.<h5>
												</div>
											<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Real Estate -->
							<div class="tab-pane p-20" id="realestate" role="tabpanel">
								<div class="p-20">
									<div class="card-body">
										<div class="table-responsive">
											<?php
											include "dbconn.php";
											
											if (isset($_POST["PID"])){
												$pID = $_POST["PID"];
												
												$pID = mysqli_real_escape_string($conn, $pID);
												
												$sqlDelete = "DELETE FROM project
															  WHERE PID = '$pID'";
												
												$sendqueryDelete = mysqli_query($conn, $sqlDelete) or die("Delete failed");
												
												if ($sendqueryDelete){
													echo '<script>alert("Data Deleted Successfully.");</script>';
													echo '<script>history.back();</script>';
												} else {
													echo '<script>alert("Failed to Delete Data.");</script>';
													echo '<script>history.back();</script>';
												}
											}
											
											$sqlSelect = "SELECT
															p.PID,
															p.Year,
															p.Name,
															CONCAT(p.FileNo, ' : ', p.FileName) AS File,
															  
															-- Electrical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Electrical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Electrical,
															  
															-- Mechanical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Mechanical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Mechanical,
															  
															-- Other
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Other' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Other,
															
															p.Category, p.Status
															
														  FROM project p
														  LEFT JOIN assigned a ON p.PID = a.PID
														  WHERE p.Category IN ('Properties', 'Housing', 'Residental')
														  GROUP BY p.PID
														  ORDER BY p.Year DESC";

											
											$sendquerySelect = mysqli_query($conn, $sqlSelect);
											
											if(mysqli_num_rows($sendquerySelect) > 0)
											{
											?>
											
											<table id="zero_config" class="table table-striped table-bordered">
												<thead class="position-sticky top-0">
													<tr>
													  <th>YEAR</th>
													  <th>PROJECT NAME</th>
													  <th>FILE</th>
													  <th>ELECTRICAL</th>
													  <th>MECHANICAL</th>
													  <th>OTHER</th>
													  <th>CATEGORY</th>
													  <th>STATUS</th>
													  <th>ACTION</th>
													</tr>
												</thead>
												  
												<tbody>
													<?php
													while($row = mysqli_fetch_assoc($sendquerySelect))
													{
													?>
													<tr>
													  <td><?php echo $row['Year'];?></td>
													  <td><?php echo $row['Name'];?></td>
													  <td><?php echo $row['File'];?></td>
													  <td><?php echo $row['Electrical'] ?: 'None';?></td>
													  <td><?php echo $row['Mechanical'] ?: 'None';?></td>
													  <td><?php echo $row['Other'] ?: 'None';?></td>
													  <td><?php echo $row['Category'];?></td>
													  <td><?php echo $row['Status'];?></td>
													  <td class="text-center">
														<form action="edit.php" method="POST">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-blue text-white">
																<i class="mdi mdi-table-edit"></i>
															</button>
														</form>
														
														<form action="home.php" method="POST" onsubmit="return confirm('Delete this project?');">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-danger">
																<i class="mdi mdi-delete"></i>
															</button>
														</form>
													  </td>
													</tr>
													<?php
													}
													?>
												</tbody>
											</table>
											<?php
											}
											else {
											?>
												<div class="text-center">
													<h5>No Data Found.<h5>
												</div>
											<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
							
							
							<!-- Healthcare -->
							<div class="tab-pane p-20" id="healthcare" role="tabpanel">
								<div class="p-20">
									<div class="card-body">
										<div class="table-responsive">
											<?php
											include "dbconn.php";
											
											if (isset($_POST["PID"])){
												$pID = $_POST["PID"];
												
												$pID = mysqli_real_escape_string($conn, $pID);
												
												$sqlDelete = "DELETE FROM project
															  WHERE PID = '$pID'";
												
												$sendqueryDelete = mysqli_query($conn, $sqlDelete) or die("Delete failed");
												
												if ($sendqueryDelete){
													echo '<script>alert("Data Deleted Successfully.");</script>';
													echo '<script>history.back();</script>';
												} else {
													echo '<script>alert("Failed to Delete Data.");</script>';
													echo '<script>history.back();</script>';
												}
											}
											
											$sqlSelect = "SELECT
															p.PID,
															p.Year,
															p.Name,
															CONCAT(p.FileNo, ' : ', p.FileName) AS File,
															  
															-- Electrical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Electrical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Electrical,
															  
															-- Mechanical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Mechanical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Mechanical,
															  
															-- Other
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Other' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Other,
															
															p.Category, p.Status
															
														  FROM project p
														  LEFT JOIN assigned a ON p.PID = a.PID
														  WHERE p.Category IN ('Hospital', 'Clinical')
														  GROUP BY p.PID
														  ORDER BY p.Year DESC";

											
											$sendquerySelect = mysqli_query($conn, $sqlSelect);
											
											if(mysqli_num_rows($sendquerySelect) > 0)
											{
											?>
											
											<table id="zero_config" class="table table-striped table-bordered">
												<thead class="position-sticky top-0">
													<tr>
													  <th>YEAR</th>
													  <th>PROJECT NAME</th>
													  <th>FILE</th>
													  <th>ELECTRICAL</th>
													  <th>MECHANICAL</th>
													  <th>OTHER</th>
													  <th>CATEGORY</th>
													  <th>STATUS</th>
													  <th>ACTION</th>
													</tr>
												</thead>
												  
												<tbody>
													<?php
													while($row = mysqli_fetch_assoc($sendquerySelect))
													{
													?>
													<tr>
													  <td><?php echo $row['Year'];?></td>
													  <td><?php echo $row['Name'];?></td>
													  <td><?php echo $row['File'];?></td>
													  <td><?php echo $row['Electrical'] ?: 'None';?></td>
													  <td><?php echo $row['Mechanical'] ?: 'None';?></td>
													  <td><?php echo $row['Other'] ?: 'None';?></td>
													  <td><?php echo $row['Category'];?></td>
													  <td><?php echo $row['Status'];?></td>
													  <td class="text-center">
														<form action="edit.php" method="POST">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-blue text-white">
																<i class="mdi mdi-table-edit"></i>
															</button>
														</form>
														
														<form action="home.php" method="POST" onsubmit="return confirm('Delete this project?');">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-danger">
																<i class="mdi mdi-delete"></i>
															</button>
														</form>
													  </td>
													</tr>
													<?php
													}
													?>
												</tbody>
											</table>
											<?php
											}
											else {
											?>
												<div class="text-center">
													<h5>No Data Found.<h5>
												</div>
											<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Education -->
							<div class="tab-pane p-20" id="education" role="tabpanel">
								<div class="p-20">
									<div class="card-body">
										<div class="table-responsive">
											<?php
											include "dbconn.php";
											
											if (isset($_POST["PID"])){
												$pID = $_POST["PID"];
												
												$pID = mysqli_real_escape_string($conn, $pID);
												
												$sqlDelete = "DELETE FROM project
															  WHERE PID = '$pID'";
												
												$sendqueryDelete = mysqli_query($conn, $sqlDelete) or die("Delete failed");
												
												if ($sendqueryDelete){
													echo '<script>alert("Data Deleted Successfully.");</script>';
													echo '<script>history.back();</script>';
												} else {
													echo '<script>alert("Failed to Delete Data.");</script>';
													echo '<script>history.back();</script>';
												}
											}
											
											$sqlSelect = "SELECT
															p.PID,
															p.Year,
															p.Name,
															CONCAT(p.FileNo, ' : ', p.FileName) AS File,
															  
															-- Electrical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Electrical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Electrical,
															  
															-- Mechanical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Mechanical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Mechanical,
															  
															-- Other
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Other' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Other,
															
															p.Category, p.Status
															
														  FROM project p
														  LEFT JOIN assigned a ON p.PID = a.PID
														  WHERE p.Category IN ('School', 'Education Centre')
														  GROUP BY p.PID
														  ORDER BY p.Year DESC";

											
											$sendquerySelect = mysqli_query($conn, $sqlSelect);
											
											if(mysqli_num_rows($sendquerySelect) > 0)
											{
											?>
											
											<table id="zero_config" class="table table-striped table-bordered">
												<thead class="position-sticky top-0">
													<tr>
													  <th>YEAR</th>
													  <th>PROJECT NAME</th>
													  <th>FILE</th>
													  <th>ELECTRICAL</th>
													  <th>MECHANICAL</th>
													  <th>OTHER</th>
													  <th>CATEGORY</th>
													  <th>STATUS</th>
													  <th>ACTION</th>
													</tr>
												</thead>
												  
												<tbody>
													<?php
													while($row = mysqli_fetch_assoc($sendquerySelect))
													{
													?>
													<tr>
													  <td><?php echo $row['Year'];?></td>
													  <td><?php echo $row['Name'];?></td>
													  <td><?php echo $row['File'];?></td>
													  <td><?php echo $row['Electrical'] ?: 'None';?></td>
													  <td><?php echo $row['Mechanical'] ?: 'None';?></td>
													  <td><?php echo $row['Other'] ?: 'None';?></td>
													  <td><?php echo $row['Category'];?></td>
													  <td><?php echo $row['Status'];?></td>
													  <td class="text-center">
														<form action="edit.php" method="POST">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-blue text-white">
																<i class="mdi mdi-table-edit"></i>
															</button>
														</form>
														
														<form action="home.php" method="POST" onsubmit="return confirm('Delete this project?');">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-danger">
																<i class="mdi mdi-delete"></i>
															</button>
														</form>
													  </td>
													</tr>
													<?php
													}
													?>
												</tbody>
											</table>
											<?php
											}
											else {
											?>
												<div class="text-center">
													<h5>No Data Found.<h5>
												</div>
											<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Other -->
							<div class="tab-pane p-20" id="other" role="tabpanel">
								<div class="p-20">
									<div class="card-body">
										<div class="table-responsive">
											<?php
											include "dbconn.php";
											
											if (isset($_POST["PID"])){
												$pID = $_POST["PID"];
												
												$pID = mysqli_real_escape_string($conn, $pID);
												
												$sqlDelete = "DELETE FROM project
															  WHERE PID = '$pID'";
												
												$sendqueryDelete = mysqli_query($conn, $sqlDelete) or die("Delete failed");
												
												if ($sendqueryDelete){
													echo '<script>alert("Data Deleted Successfully.");</script>';
													echo '<script>history.back();</script>';
												} else {
													echo '<script>alert("Failed to Delete Data.");</script>';
													echo '<script>history.back();</script>';
												}
											}
											
											$sqlSelect = "SELECT
															p.PID,
															p.Year,
															p.Name,
															CONCAT(p.FileNo, ' : ', p.FileName) AS File,
															  
															-- Electrical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Electrical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Electrical,
															  
															-- Mechanical
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Mechanical' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Mechanical,
															  
															-- Other
															GROUP_CONCAT(CASE
															WHEN a.Type = 'Other' THEN CONCAT(
															  'Directors: ',
															  IF(a.Director1 IS NOT NULL AND a.Director1 != '', a.Director1, 'None'),
															  IF(a.Director2 IS NOT NULL AND a.Director2 != '', CONCAT(' | ', a.Director2), ''),
															  '<br> Engineers: ',
															  IF(a.Engineer1 IS NOT NULL AND a.Engineer1 != '', a.Engineer1, 'None'),
															  IF(a.Engineer2 IS NOT NULL AND a.Engineer2 != '', CONCAT(' | ', a.Engineer2), '')
															)
															END) AS Other,
															
															p.Category, p.Status
															
														  FROM project p
														  LEFT JOIN assigned a ON p.PID = a.PID
														  WHERE p.Category IN ('Other')
														  GROUP BY p.PID
														  ORDER BY p.Year DESC";

											
											$sendquerySelect = mysqli_query($conn, $sqlSelect);
											
											if(mysqli_num_rows($sendquerySelect) > 0)
											{
											?>
											
											<table id="zero_config" class="table table-striped table-bordered">
												<thead class="position-sticky top-0">
													<tr>
													  <th>YEAR</th>
													  <th>PROJECT NAME</th>
													  <th>FILE</th>
													  <th>ELECTRICAL</th>
													  <th>MECHANICAL</th>
													  <th>OTHER</th>
													  <th>CATEGORY</th>
													  <th>STATUS</th>
													  <th>ACTION</th>
													</tr>
												</thead>
												  
												<tbody>
													<?php
													while($row = mysqli_fetch_assoc($sendquerySelect))
													{
													?>
													<tr>
													  <td><?php echo $row['Year'];?></td>
													  <td><?php echo $row['Name'];?></td>
													  <td><?php echo $row['File'];?></td>
													  <td><?php echo $row['Electrical'] ?: 'None';?></td>
													  <td><?php echo $row['Mechanical'] ?: 'None';?></td>
													  <td><?php echo $row['Other'] ?: 'None';?></td>
													  <td><?php echo $row['Category'];?></td>
													  <td><?php echo $row['Status'];?></td>
													  <td class="text-center">
														<form action="edit.php" method="POST">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-blue text-white">
																<i class="mdi mdi-table-edit"></i>
															</button>
														</form>
														
														<form action="home.php" method="POST" onsubmit="return confirm('Delete this project?');">
															<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
															<button type="submit" class="btn btn-danger">
																<i class="mdi mdi-delete"></i>
															</button>
														</form>
													  </td>
													</tr>
													<?php
													}
													?>
												</tbody>
											</table>
											<?php
											}
											else {
											?>
												<div class="text-center">
													<h5>No Data Found.<h5>
												</div>
											<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Tab Content -->
					</div>
				</div>
			</div>
			<!-- End Page Content -->
		</div>
		<!-- End Container Fluid -->
	</div>
	<!-- End Page Wrapper
	<!-- This page js -->
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script>
      $("#zero_config").DataTable();
    </script>
</body>