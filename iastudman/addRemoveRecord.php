<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if ($_SERVER["HTTP_HOST"]==='localhost') {
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "German_Class";
		} else {
			$servername = "localhost";
			$username = "pdxia";
			$password = "DxtXVa2nWZKvcFKt";
			$dbname = "pdx_ia_studman";
		}

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			http_response_code(500);
			echo "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #0d3800; font-weight: bold;'>
			Connection failed: " . $conn->connect_error . "</p>";
			die("Connection failed: " . $conn->connect_error);
		} 
		
		
		else {
			if ( isset($_POST['removeName'])){
				$sql_remove="DELETE FROM `students` WHERE `Name`='" . htmlspecialchars($_POST['removeName']) . "';";
				$conn->query($sql_remove);
				if($conn->affected_rows>0) echo "<p style='text-align: center; font-size: 130%; color: #0d3800; font-weight: bold;'> 
				Student '" . htmlspecialchars($_POST['removeName']) . "' successfully removed! </p>";		
				else echo "<br> <br> <p style='text-align: center; font-size: 130%; color: #980101; font-weight: bold;'>
				The student '" . htmlspecialchars($_POST["removeName"]) . "' does not exist. Please make sure that the exact inserted name exists. </p>";
			}
			
			else{
				if ( isset($_POST['CourseLevel'])){
					$sql_insert="INSERT INTO `students`(`Name`, `Year`, `SchoolSystem`, `CourseLevel`)
					VALUES ('" . htmlspecialchars($_POST['name']) . "'," . htmlspecialchars($_POST['year']) . ",'" . htmlspecialchars($_POST['SchoolSystem']) . "','" . htmlspecialchars($_POST['CourseLevel']) . "');";
				} 
				else {
					$sql_insert="INSERT INTO `students`(`Name`, `Year`, `SchoolSystem`) 
					VALUES ('" . htmlspecialchars($_POST['name']) . "'," . htmlspecialchars($_POST['year']) . ",'" . htmlspecialchars($_POST['SchoolSystem']) . "');";	
				}
				$result_inserted = $conn->query($sql_insert);
				if($result_inserted) echo "<p style='text-align: center; font-size: 130%; color: #0d3800; font-weight: bold;'> 
				Student '" . htmlspecialchars($_POST['name']) . "' successfully added! </p>";		
				else echo "<p style='text-align: center; font-size: 130%; color: #980101; font-weight: bold;'>
				Something went wrong. Please try again. </p>";
			}
		}
		mysqli_close($conn);
	}
	else {
		http_response_code(403);
		echo "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #980101; font-weight: bold;'>
		There was a problem with your submission, please try again.</p>";
	}
?>