<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "German_Class";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			http_response_code(500);
            "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #0d3800; font-weight: bold;'>Connection failed: " . $conn->connect_error . "</p>";
			die("Connection failed: " . $conn->connect_error);
		} 
		else{
			
			$sql = "SELECT * FROM students WHERE";
			if(!empty($_POST['name'])) {
				$sql = $sql . " (name LIKE '" . $_POST['name'] . "%' or name LIKE '% " . $_POST['name'] ."%')";
			}
			
			if(!empty($_POST['year'])){
				if(!empty($_POST['name'])) {
					$sql = $sql . " and";
				}
				$sql = $sql . " year = " . $_POST['year'];
			}
			
			if(!empty($_POST['SchoolSystem'])){
				if(!empty($_POST['name']) || !empty($_POST['year'])) {
					$sql = $sql . " and";
				}
				
				if ($_POST['SchoolSystem']=="Both"){
					$sql = $sql . " (SchoolSystem = 'Hungarian' or SchoolSystem = 'IB')";
				}	
				
				else if ($_POST['SchoolSystem']=="Hungarian System"){
					$sql = $sql . " (SchoolSystem = 'Hungarian')";
				}
				
				else{
					$sql = $sql . " SchoolSystem = '" . $_POST['SchoolSystem'] . "'";
				}
			}
			
			if(!empty($_POST['CourseLevel'])){	
			
				if ($_POST['CourseLevel']=="Both"){
					$sql = $sql . " and (SchoolSystem = 'Hungarian' or SchoolSystem = 'IB')";
				}
				
				else {
					$sql = $sql . " and CourseLevel = '" . $_POST['CourseLevel'] . "'";
				}
			}	
		
		
			$result = $conn->query($sql);
				
			if ( isset($_POST['identifier'])){
				if ($result){
							
					if ($result->num_rows > 0) {
						
						echo '<table class="table" id="myTable">';
						echo	'<tr>';
						echo		'<th> Student Name </th>';
						echo		'<th> Student Year </th>';
						echo		'<th> School System </th>';
						echo		'<th> Course Level </th>';
						echo		'<th colspan="2"> Grades </th>';
						echo		'<th class="notes"> Notes </th>';
						echo	'</tr>';
				
						echo	'<form action="' . $_SERVER['PHP_SELF'] . '" id="tableForm" method="post">';
				
						$counter = 0;
						while($row = $result->fetch_assoc()) { 
							$counter = $counter + 1;
				
							echo '<tr>';
							echo	'<td>';
							echo 		$row["Name"];
							echo 	'</td>';
							echo	'<td>';
							echo 		'<textarea name="editYear_' . $counter . '" rows="1" style="overflow:hidden; width:80%; resize: none; text-align:center; border: 10px solid transparent;">' . $row["Year"] . '</textarea>';
							echo 	'</td>';
							echo	'<td>';
							echo 		'<textarea name="editSchoolSystem_' . $counter . '" rows="1" style="overflow:hidden; width:80%; resize: none; text-align:center; border: 10px solid transparent;">' . $row["SchoolSystem"] . '</textarea>';
							echo	'</td>';
							echo	'<td>'; 
							if ($row['CourseLevel']=="") echo '<textarea name="editCourseLevel_' . $counter . '" rows="1" style="overflow:hidden; width:80%; resize: none; text-align:center; border: 10px solid transparent;">' . "-" . '</textarea>'; 
							else echo '<textarea name="editCourseLevel_' . $counter . '"rows="1" style="overflow:hidden; width:80%; resize: none; text-align:center; border: 10px solid transparent;">' . $row["CourseLevel"] . '</textarea>';
							echo	'</td>';
							echo	'<td class="grades"> <div style="font-weight: bold; color: #1e058b; margin-bottom: 5px" > First Semester </div>'; 
							echo		'<textarea name="gradeA_' . $counter . '" rows="1" style="overflow:hidden; width:80%; resize: none; text-align:center;" placeholder="Insert grade..">' . $row['Grades_A'] . '</textarea>'; 
							echo	'</td>';
							echo	'<td class="grades"> <div style="font-weight: bold; color: #1e058b; margin-bottom: 5px"> Second Semester </div>';
							echo		'<textarea name="gradeB_' . $counter . '" rows="1" style="overflow:hidden; width:80%; resize: none; text-align:center;" placeholder="Insert grade..">' . $row['Grades_B'] . '</textarea>'; 
							echo	'</td>';
							echo	'<td class="notes">';
							echo		'<textarea name="notes_' . $counter . '" rows="5" style="overflow:hidden; width:98%; resize: none; text-align:left;" placeholder="Take notes..">' . $row['Notes'] . '</textarea>';
							echo	'</td>';
							echo '</tr>';
						}
						echo '<input name="name" style="display: none;" value="' . $_POST['name'] . '"></input>';  
						echo '<input name="year" style="display: none;" value="' . $_POST['year'] . '"></input>'; 
						echo '<input name="SchoolSystem" style="display: none;" value="';
						if (isset($_POST['SchoolSystem'])) 
							echo $_POST['SchoolSystem'];
						else
							echo '';
						echo '"></input>';
						echo '<input name="CourseLevel" style="display: none;" value="';
						if (isset($_POST['CourseLevel']))
							echo $_POST['CourseLevel'];
						else
							echo '';	
						echo '"></input>';
						
						echo '</form>';
				
						echo '</table>';
					}
					else {
						echo "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #980101; font-weight: bold;'> Sorry, no matches found! </p>";
					}
				}
			}
			else {
				$counter = 0;
				while($row = $result->fetch_assoc()) { 
					$counter = $counter + 1;
					
					if( $_POST["editYear_" . $counter]!=$row['Year'] ){ 
						$sql_updated = "UPDATE `students` SET `Year`='" . $_POST["editYear_" . $counter] . "' WHERE `Name`='" . $row["Name"] . "'";
						$result_updated = $conn->query($sql_updated);
					}
					if( $_POST["editSchoolSystem_" . $counter]!=$row['SchoolSystem'] ){ 
						$sql_updated = "UPDATE `students` SET `SchoolSystem`='" . $_POST["editSchoolSystem_" . $counter] . "' WHERE `Name`='" . $row["Name"] . "'";
						$result_updated = $conn->query($sql_updated);
					}
					if( $_POST["editCourseLevel_" . $counter]!=$row['CourseLevel'] && $_POST["editCourseLevel_" . $counter]!="-"){
						$sql_updated = "UPDATE `students` SET `CourseLevel`='" . $_POST["editCourseLevel_" . $counter] . "' WHERE `Name`='" . $row["Name"] . "'";
						$result_updated = $conn->query($sql_updated);
					}
					if( $_POST["gradeA_" . $counter]!=$row['Grades_A'] ){ 
						$sql_updated = "UPDATE `students` SET `Grades_A`='" . $_POST["gradeA_" . $counter] . "' WHERE `Name`='" . $row["Name"] . "'";
						$result_updated = $conn->query($sql_updated);
					}
					if ( $_POST["gradeB_" . $counter]!=$row['Grades_B'] ){ 
						$sql_updated = "UPDATE `students` SET `Grades_B`='" . $_POST["gradeB_" . $counter] . "' WHERE `Name`='" . $row["Name"] . "'";
						$result_updated = $conn->query($sql_updated);
					}
					if ( $_POST["notes_" . $counter]!=$row['Notes'] ){ 
						$sql_updated = "UPDATE `students` SET `Notes`='" . $_POST["notes_" . $counter] . "' WHERE `Name`='" . $row["Name"] . "'";
						$result_updated = $conn->query($sql_updated);
					}
				}
			}
					
			http_response_code(200);
		}
		mysqli_close($conn);
	}
	else {
		http_response_code(403);
		echo "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #980101; font-weight: bold;'>There was a problem with your submission, please try again.</p>";
	}
?>