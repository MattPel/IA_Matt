<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "German_Class";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			http_response_code(500);
            echo "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #0d3800; font-weight: bold;'>Connection failed: " . $conn->connect_error . "</p>";
			die("Connection failed: " . $conn->connect_error);
		} 
		else{
			$sql = "SELECT Username FROM credentials WHERE Username='" . $_POST['uname'] . "' AND Password='" . $_POST['psw'] . "'";
			
			$result = $conn->query($sql);
			
			if ($result){
				if ($result->num_rows>0){
					$row = $result->fetch_assoc();
					echo $row['Username'];
				}
				else {
					echo "Error during login: Username and password do not match, please try again!";
				}
			}
			else{
				echo "Error during login: An error has occured, please refresh the page to try again!";
			}
			http_response_code(200);
		}
		mysqli_close($conn);
		
	}
	else {
		http_response_code(403);
		echo "Error during login: There was a problem with your submission, please try again!";
	}
		
?>