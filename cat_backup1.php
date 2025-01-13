<!-- category.php-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<!-- Tab Title -->
	<title>Category - MJCSB Project Inventory</title>

	<!-- CSS -->
	<link
      rel="stylesheet"
      type="text/css"
      href="assets/extra-libs/multicheck/multicheck.css"
    />
    <link
      href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
      rel="stylesheet"
    />
</head>

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
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
						<div class="card-body">
							<?php include "dbconn.php";
							
							if ($_SERVER["REQUEST_METHOD"] == "POST") :
								if (isset($_POST['category'])) :
									$mainCategories = ['Transportation', 'Real Estate', 'Healthcare', 'Education', 'Other'];
									// Mapping of main categories to dropdown items
									$subCategories = [
										"Transportation" => ["Road & Highway", "Railway", "Airport & Seaport"],
										"Real Estate" => ["Properties", "Housing", "Residental"],
										"Healthcare" => ["Hospital", "Clinic"],
										"Education" => ["School", "Education Centre"],
										"Other" => ["Other"]
									];
									
									$mainCategory = mysqli_real_escape_string($conn, $_POST['category']);
									$subCategory = $subCategories[$mainCategory]; ?>
									
									<!-- Tab Navigation -->
									<ul class="nav nav-tabs" role="tablist"> <?php 
										foreach ($subCategory as $index => $subCat) :
											$activeClass = $index === 0 ? 'active' : '';
											$tabID = strtolower(str_replace([' ', '&'], ['-', 'and'], $subCat)); ?>
											
											<li class="nav-item">
												<a
												  class="nav-link <?php echo $activeClass; ?>"
												  data-bs-toggle="tab"
												  href="#<?php echo $tabID; ?>"
												  role="tab">
													<span class="hidden-sm-up"></span>
													<span class="hidden-xs-down"><?php echo $subCat; ?></span>
												</a>
											</li><?php
										endforeach; ?>
									</ul>
									
									<!-- Tab Content -->
									<div class="tab-content tabcontent-border"> <?php
										foreach ($subCategory as $index => $subCat) :
											$activeClass = $index === 0 ? 'active' : '';
											$tabID = strtolower(str_replace([' ', '&'], ['-', 'and'], $subCat)); ?>
											
											<!-- Tab Pane -->
											<div
											  class="tab-pane <?php echo $activeClass; ?>"
											  id="<?php echo $tabID; ?>" 
											  role="tabpanel"
											> 
												<div class="p-20">
													<div class="card body" style="padding: 20px 5px;">
														<div class="table-responsive">
															<table id="zero_config" class="table table-striped table-bordered"> <?php
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
																			  WHERE p.Category = '$subCat'
																			  GROUP BY p.PID
																			  ORDER BY p.Year DESC";
																
																$result = mysqli_query($conn, $sqlSelect);
																
																if (mysqli_num_rows($result) > 0) : ?>
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
																		<?php while ($row = mysqli_fetch_assoc($result)) : ?>
																			<tr>
																				<td><?php echo $row['Year'];?></td>
																				<td><?php echo $row['Name'];?></td>
																				<td><?php echo $row['File'];?></td>
																				<td><?php echo $row['Electrical'] ?: 'None';?></td>
																				<td><?php echo $row['Mechanical'] ?: 'None';?></td>
																				<td><?php echo $row['Other'] ?: 'None';?></td>
																				<td><?php echo $row['Category'];?></td>
																				<td class="text-center <?php
																					  if ($row['Status'] == 'Complete'){
																						echo 'text-success';
																					  } else if($row['Status'] == 'Ongoing'){
																						echo 'text-warning';
																					  }else if($row['Status'] == 'KIV'){
																						echo 'text-danger';
																					  } ?>"
																				  ><?php echo $row['Status'];?>
																				</td>
																				<td class="text-center">
																					<button type="button" value="<?php echo $row['PID'];?>" class="btn btn-blue text-white" onclick="loadContent('edit.php', { PID: '<?php echo $row['PID']; ?>' })">
																						<i class="mdi mdi-table-edit"></i>
																					</button>

																					<form action="home.php" method="POST" onsubmit="return confirm('Delete this project?');">
																						<input type="hidden" name="PID" value="<?php echo $row['PID'];?>">
																						<button type="submit" class="btn btn-danger">
																							<i class="mdi mdi-delete"></i>
																						</button>
																					</form>
																				</td>
																			</tr> <?php 
																		endwhile; ?>
																	</tbody> <?php
																else : ?>
																	<div class="text-center">
																		<h3>No Data Found.<h3>
																	</div> <?php
																endif; ?>
															</table>
														</div>
													</div>
												</div>
											</div> 
											<!-- End Tab Pane --> <?php
										endforeach; ?>
									</div>
									<!-- End Tab Content --> <?php
								else : ?>
									<div class="text-center">
										<h5>Category Post Error.<h5>
									</div> <?php
								endif;
							else : ?>
								<div class="text-center">
									<h5>Post Request Error.<h5>
								</div> <?php
							endif; ?>
						</div>
					</div>
				</div>
			</div>
			<!-- End Page Content -->
		</div>
		<!-- End Container Fluid -->
	</div>
	<!-- End Page Wrapper
	<!-- No JS -->
</body>
</html>