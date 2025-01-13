<?php
	session_start();
	
	include "dbconn.php";
	
	//Check if POST Request is made
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if (isset($_POST["PID"])) {
			$pID = $_POST["PID"];
			$pID = mysqli_real_escape_string($conn, $pID);
		}
		
		$uID = $_SESSION['UID'];
		
		$year = $_POST["year"];
		$proname = $_POST["proname"];
		$fileno = $_POST["fileno"];
		$filename = $_POST["filename"];
		
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
		
		$category = $_POST["category"];
		$status = $_POST["status"];
		
		//Update into table project
		$updateProject = "UPDATE project
						  SET Year='$year', Name='$proname', FileNo='$fileno', FileName='$filename', Category='$category', Status='$status'
						  WHERE PID='$pID';";
				  
		//Execute Query
		$sendProject = mysqli_query($conn, $updateProject);
		
		//Error handling for update table project
		if (!$sendProject) {
			echo '<script>alert("Failed to Update Data for Table Project");</script>';
			echo '<script>window.location.href="edit.php";</script>';
		}
		
		//Function to check if the row exist or not then decide to insert new row or update the existing row
		function insertOrUpdate($conn, $uID, $pID, $type, $director1, $director2, $engineer1, $engineer2) {
			//Query to check
			$check = "SELECT AID, UID FROM assigned WHERE PID='$pID' AND Type='$type';";
			
			//Save query execution into variable
			$checkResult = mysqli_query($conn, $check);
			
			//Update or Insert based on the result
			if (mysqli_num_rows($checkResult) > 0) {
				//Update if row for the type exist
				$update = "UPDATE assigned
						   SET Director1 = '$director1', Director2='$director2', Engineer1='$engineer1', Engineer2='$engineer2'
						   WHERE PID='$pID' AND Type='$type';";
				
				//Execute Query
				mysqli_query($conn, $update);
			} else {
				//Insert if row for the type not yet exist
				$insert = "INSERT INTO assigned (UID, PID, Type, Director1, Director2, Engineer1, Engineer2)
						   VALUES ('$uID', '$pID', '$type', '$director1', '$director2', '$engineer1', '$engineer2');";
				
				//Execute Query
				$exeinsert = mysqli_query($conn, $insert);
				
				/*if(!$exeinsert){
					echo "UID: ".$uID;
				}*/
			}
		}//End function
		
		/*If checkbox not empty, call function.	If checkbox empty, delete the type.*/
		
		//Electrical
		if (!empty($electrical)) {
			//Not empty, call function
			insertOrUpdate($conn, $uID, $pID, 'Electrical', $elecdirec1, $elecdirec2, $eleceng1, $eleceng2);
		} else if (empty($electrical)) {
			//Empty, delete type
			$deleteElec = "DELETE FROM assigned WHERE PID='$pID' AND Type='Electrical';";
			mysqli_query($conn, $deleteElec);
		}
		
		//Mechanical
		if (!empty($mechanical)) {
			//Not empty, call function
			insertOrUpdate($conn, $uID, $pID, 'Mechanical', $mechdirec1, $mechdirec2, $mecheng1, $mecheng2);
		} else if (empty($mechanical)) {
			//Empty, delete type
			$deleteMech = "DELETE FROM assigned WHERE PID='$pID' AND Type='Mechanical';";
		}
		
		//Other
		if (!empty($other)) {
			//Not empty, call function
			insertOrUpdate($conn, $uID, $pID, 'Other', $otherdirec1, $otherdirec2, $othereng1, $othereng2);
		} else if (empty($other)) {
			//Empty, delete type
			$deleteOther = "DELETE FROM assigned WHERE PID='$pID' AND Type='Other';";
		}
		
		//Error Handling for edit
		if (mysqli_affected_rows($conn) >= 0) {
			echo '<script>alert("Updated Sucessfully.");</script>';
			//echo '<script>history.back();</script>';
			
			if (isset($_SERVER['HTTP_REFERER'])) {
				header("Location: " . $_SERVER['HTTP_REFERER']);
				exit;
			} else {
				echo "No referrer available.";
			}

		} else {
			echo '<script>alert("Failed to Update.");</script>';
			//echo '<script>history.back();</script>';
			
			if (isset($_SERVER['HTTP_REFERER'])) {
				header("Location: " . $_SERVER['HTTP_REFERER']);
				exit;
			} else {
				echo "No referrer available.";
			}
		}
	}
?>