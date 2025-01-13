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
								  class="nav-link <?php $filter === 'all' ? 'active' : ''?>"
								  data-bs-toggle="tab"
								  href="#all"
								  role="tab"
								  ><span class="hidden-sm-up"></span>
								  <span class="hidden-xs-down">All</span></a
								>
							</li>
							<li class="nav-item">
								<a
								  class="nav-link <?= $filter === 'transportation' ? 'active' : '' ?>"
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
							<div class="tab-pane active" id="<?php $filter ?>" role="tabpanel">
								<div class="p-20">
									<div class="card-body">
										<div class="table-responsive">
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
													//Fetch and display data
													if ($filter === 'all'){
														$result = $conn->query($query);
													}
													if ($result->num_rows > 0){
														while ($row = $result->fetch_assoc()){
															echo "<tr>";
															  echo "<td>" . $row['Year'] . "</td>";
															  echo "<td>" . $row['Name'] . "</td>";
															  echo "<td>" . $row['File'] . "</td>";
															  echo "<td>" . $row['Electrical'] ?: 'None' . "</td>";
															  echo "<td>" . $row['Mechanical'] ?: 'None' . "</td>";
															  echo "<td>" . $row['Other'] ?: 'None' . "</td>";
															  echo "<td>" . $row['Category'] . "</td>";
															  echo "<td>" . $row['Status'] . "</td>";
																	
															  /*echo "<td>"
																<div class="text-center">
																	<form action="edit.php" method="POST">
																		<input type="hidden" name="PID" value=" . $row['PID'] . ">
																		<button type="submit" class="btn btn-blue text-white">
																			<i class="mdi mdi-table-edit"></i>
																		</button>
																	</form>
																	
																	<form action="home.php" method="POST" onsubmit="return confirm('Delete this project?');">
																		<input type="hidden" name="PID" value=" . $row['PID'] . ">
																		<button type="submit" class="btn btn-danger">
																			<i class="mdi mdi-delete"></i>
																		</button>
																	</form>
																</div>
															  "</td>";*/
															echo "</tr>";
															
														}
													} else {
														echo "No Data Found.";
													}
													?>
												</tbody>
											</table>
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