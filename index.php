<!-- index.php -->
<?php
	session_start();
	
	include "dbconn.php";
	
	//If user already logout
	if (!isset($_SESSION['UID'])) {
		echo "No Login Info!";
		header("Location: login.php");
		exit();
	} else {
		$uID = $_SESSION['UID'];
		$role = $_SESSION['Role'];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<!-- Tab Logo -->
	<link
	  rel="icon"
	  type="image/png"
	  sizes="16x16"
	  href="assets/images/MJC_single_logo.png"
	/>

	<!-- CSS -->
	<link href="dist/css/style.css" rel="stylesheet" />
</head>

<body>
	<!-- Preloader -->
	<div class="preloader">
	  <div class="lds-ripple">
		<div class="lds-pos"></div>
		<div class="lds-pos"></div>
	  </div>
	</div>
	
	<!-- Main wrapper -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
		<!-- Topbar header -->
		<header class="topbar" data-navbarbg="skin5">
			<!-- Navigation -->
			<nav class="navbar top-navbar navbar-expand-md navbar-dark">
				<!-- Logo -->
				<div class="navbar-header" data-logobg="skin5">
					<a class="navbar-brand" href="#" onclick="loadContent('home.php')">
						<!-- Logo icon -->
						<b class="logo-icon ps-2">
							<img
							  src="assets/images/MJC_outline_logo.png"
							  alt="homepage"
							  class="light-logo"
							  width="25"
							/>
						</b>
						<!-- Logo text -->
						<span class="logo-text ms-2">
							<img
							  src="assets/images/MJC_outline_text.png"
							  alt="homepage"
							  class="light-logo"
							  width="175"
							/>
						</span>
					</a>
					
					<!-- Toggle which is visible on mobile only -->
					<a
					  class="nav-toggler waves-effect waves-light d-block d-md-none"
					  href="javascript:void(0)"
					  ><i class="ti-menu ti-close"></i
					></a>
				</div>
				<!-- End Logo -->
				
				<!-- Topbar Navigation -->
				<div
				  class="navbar-collapse collapse"
				  id="navbarSupportedContent"
				  data-navbarbg="skin5"
				>
					<!-- Left side toggle and nav items -->
					<ul class="navbar-nav float-start me-auto">
					  <!-- li class="nav-item d-none d-lg-block">
						<a
						  class="nav-link sidebartoggler waves-effect waves-light"
						  href="javascript:void(0)"
						  data-sidebartype="mini-sidebar"
						  ><i class="mdi mdi-menu-left-outline font-24"></i
						  ></a
						>
					  </li -->
					</ul>
					
					<!-- Right side toggle and nav items -->
					<ul class="navbar-nav float-end">
					  <li class="nav-item d-none d-lg-block">
						<a 
						  class="nav-link sidebartoggler waves-effect waves-light"
						  href="logout.php"
						  data-sidebartype="mini-sidebar"
						  ><i class="mdi mdi-logout font-24"></i
						  ></a
						>
					  </li>
					</ul>
				</div>
				<!-- End Topbar Navigation -->
			</nav>
			<!-- End Navigation -->
		</header>
		<!-- End Topbar Header -->
		
		<!-- Sidebar -->
		<aside class="left-sidebar" data-sidebarbg="skin5">
			<!-- Sidebar scroll-->
			<div class="scroll-sidebar">
				<!-- Sidebar navigation-->
				<nav class="sidebar-nav">
					<ul id="sidebarnav" class="pt-4">
						<!-- Home -->
						<li class="sidebar-item">
							<a
							  class="sidebar-link waves-effect waves-dark sidebar-link"
							  href="#"
							  onclick="loadContent('home.php')"
							  aria-expanded="false"
							  ><i class="mdi mdi-home"></i
							  ><span class="hide-menu">Home</span></a
							>
						</li>
						
						<!-- Category -->
						<li class="sidebar-item">
							<?php if ($role === 'ADMIN'){ ?>
							<a
							  class="sidebar-link has-arrow waves-effect waves-dark"
							  href="javascript:void(0)"
							  aria-expanded="false"
							  ><i class="mdi mdi-view-list"></i
							  ><span class="hide-menu">Category </span></a
							> <?php
							} else if ($role === 'USER'){ ?>
							<a
							  class="sidebar-link waves-effect waves-dark"
							  href="#"
							  onclick="loadContent('category.php?filter=all')"
							  aria-expanded="false"
							  ><i class="mdi mdi-view-list"></i
							  ><span class="hide-menu">Category </span></a
							> <?php
							}
							
							if ($role === 'ADMIN'){ ?>
							<ul aria-expanded="false" class="collapse first-level">
							<?php
							} else if ($role === 'USER'){ ?>
							<ul aria-expanded="false" class="first-level"> <?php
							} ?>
								<!-- List -->
								<li class="sidebar-item">
									<a href="#"
									   onclick="loadContent('category.html')"
									   class="sidebar-link"
									  ><i class="mdi mdi-package-variant"></i
									  ><span class="hide-menu"> List </span></a
									>
								</li>
								<!-- Transportation -->
								<li class="sidebar-item">
									<a href="#"
									   onclick="loadContent('category.php', { category: 'Transportation' })"
									   class="sidebar-link"
									  ><i class="mdi mdi-car"></i
									  ><span class="hide-menu"> Transportation </span></a
									>
								</li>
								<!-- Real Estate -->
								<li class="sidebar-item">
									<a href="#"
									   onclick="loadContent('category.php', { category: 'Real Estate' })"
									   class="sidebar-link"
									  ><i class="mdi mdi-city"></i
									  ><span class="hide-menu"> Real Estate </span></a
									>
								</li>
								<!-- Healthcare -->
								<li class="sidebar-item">
									<a href="#"
									   onclick="loadContent('category.php', { category: 'Healthcare' })"
									   class="sidebar-link"
									  ><i class="mdi mdi-hospital-building"></i
									  ><span class="hide-menu"> Healthcare </span></a
									>
								</li>
								<!-- Education -->
								<li class="sidebar-item">
									<a href="#"
									   onclick="loadContent('category.php', { category: 'Education' })"
									   class="sidebar-link"
									  ><i class="mdi mdi-school"></i
									  ><span class="hide-menu"> Education </span></a
									>
								</li>
								<!-- Other -->
								<li class="sidebar-item">
									<a href="#"
									   onclick="loadContent('category.php', { category: 'Other' })"
									   class="sidebar-link"
									  ><i class="mdi mdi-lan"></i
									  ><span class="hide-menu"> Other </span></a
									>
								</li>
							<?php if ($role === 'ADMIN'){ ?>
							</ul> <?php 
							} else if ($role === 'USER'){ ?>
							</ul> <?php 
							} ?>
						</li>
						
						<?php if ($role === 'ADMIN'){ ?>						
						<!-- New Project -->
						<li class="sidebar-item">
							<a
							  class="sidebar-link waves-effect waves-dark sidebar-link"
							  href="#"
							  onclick="loadContent('projectForm.html')"
							  aria-expanded="false"
							  ><i class="mdi mdi-playlist-plus"></i
							  ><span class="hide-menu">New Project</span></a
							>
						</li>
						
						<!-- New User -->
						<li class="sidebar-item">
							<a
							  class="sidebar-link waves-effect waves-dark sidebar-link"
							  href="#"
							  onclick="loadContent('registerForm.php')"
							  aria-expanded="false"
							  ><i class="mdi mdi-account-plus"></i
							  ><span class="hide-menu">New User</span></a
							>
						</li> <?php
						} ?>
						
						
						<li class="sidebar-item">
							<a
							  class="sidebar-link sidebartoggler waves-effect waves-dark sidebar-link"
							  href="javascript:void(0)"
							  aria-expanded="false"
							  ><i class="mdi mdi-arrow-left-drop-circle"></i
							  ><span class="hide-menu">Collapse</span></a
							>
						</li>
						
					</ul>
				</nav>
				<!-- End Sidebar Navigation -->
			</div>
			<!-- End Sidebar scroll-->
		</aside>
		<!-- End Sidebar -->

		<!-- Page Content -->
		<div class="page-wrapper" id="page-wrapper">
		</div>
		<!-- End Page Content -->

	</div>
	<!-- End Main Wrapper -->
	
	<!-- Jquery -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
	<!-- Table JS -->
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
	<script>
      $("#zero_config").DataTable();
    </script>
</body>
</html>