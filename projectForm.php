<!-- projectForm.php -->
<?php
	session_start();
	
	include "dbconn.php";
	
	//if no UID
	if (!isset($_SESSION['UID'])) {
		header("Location: login.php");
		echo "Invalid ID";
		exit();
	}//FAILED!!
	
	$uID = $_SESSION['UID'];
	
	$year = $_POST ["year"];
	$proname = $_POST ["proname"];
	$fileno = $_POST ["fileno"];
	$filename = $_POST ["filename"];
	
	$electrical = isset($_POST ["elec"]) ? 'Electrical ': '';
	$elecdirec1 = $_POST ["elecdirec1"];
	$elecdirec2 = $_POST ["elecdirec2"];
	$eleceng1 = $_POST ["eleceng1"];
	$eleceng2 = $_POST ["eleceng2"];
	
	$mechanical = isset($_POST ["mech"]) ? 'Mechanical' : '';
	$mechdirec1 = $_POST ["mechdirec1"];
	$mechdirec2 = $_POST ["mechdirec2"];
	$mecheng1 = $_POST ["mecheng1"];
	$mecheng2 = $_POST ["mecheng2"];
	
	$other = isset($_POST ["other"]) ? 'Other' : '';
	$otherdirec1 = $_POST ["otherdirec1"];
	$otherdirec2 = $_POST ["otherdirec2"];
	$othereng1 = $_POST ["othereng1"];
	$othereng2 = $_POST ["othereng2"];
	
	$category = $_POST ["category"];
	$status = $_POST ["status"];
	
	//Query for project
	$sql1 = "INSERT INTO project(Year, Name, FileNo, FileName, Category, Status)
			VALUES('$year', '$proname', '$fileno', '$filename', '$category', '$status')";
	$sendquery1 = mysqli_query ($conn, $sql1);
	
	if(!$sendquery1){
		echo "Data Failed to be inserted into project table: " . mysqli_error($conn);
		exit;
	}
	
	$pID = mysqli_insert_id($conn);
	
	if($electrical !== ''){
		$sql2 = "INSERT INTO assigned(UID, PID, Type, Director1, Director2, Engineer1, Engineer2)
				VALUES('$uID', '$pID', '$electrical', '$elecdirec1', '$elecdirec2', '$eleceng1', '$eleceng2')";
		mysqli_query($conn, $sql2);
	}
	
	if($mechanical !== ''){
		$sql3 = "INSERT INTO assigned(UID, PID, Type, Director1, Director2, Engineer1, Engineer2)
				VALUES('$uID', '$pID', '$mechanical', '$mechdirec1', '$mechdirec2', '$mecheng1', '$mecheng2')";
		mysqli_query($conn, $sql3);
	}
	
	if($other !== ''){
		$sql4 = "INSERT INTO assigned(UID, PID, Type, Director1, Director2, Engineer1, Engineer2)
				VALUES('$uID', '$pID', '$other', '$otherdirec1', '$otherdirec2', '$othereng1', '$othereng2')";
		mysqli_query($conn, $sql4);
	}
	
	echo '<script>window.location.href="index.php";</script>';
	exit;
?>