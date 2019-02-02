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
			$dbname = "pdx_ia_matt";
		}
		
		//establish the connection with database and server credentials
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		//if there is an error during connection do the following
		if ($conn->connect_error) {
			http_response_code(500);
            echo "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #0d3800; font-weight: bold;'>
			Connection failed: " . $conn->connect_error . "</p>";
			die("Connection failed: " . $conn->connect_error);
		} 
		//if there is no error during connection do the following
		else{
			$sql = "SELECT Username FROM credentials WHERE Username='" . htmlspecialchars($_POST['uname']) . "' AND Password='" . htmlspecialchars($_POST['psw']) . "'";
			
			$result = $conn->query($sql);
			
			//if the input matches the database record do the following
			if ($result){
				if ($result->num_rows>0){
					$row = $result->fetch_assoc();
					echo $row['Username'];
				}
				//if the input does not match the database record do the following
				else {
					echo "Error during login: Username and password do not match, please try again!";
				}
			}
			//if there has been an error during login do the following
			else{
				echo "An error has occured, please refresh the page to try again!";
			}
			http_response_code(200);
		}
		//close the connection
		mysqli_close($conn);
		
	}
	else {
		http_response_code(403);
		echo "Error during login: There was a network problem , please try again later!";
	}
		
?>