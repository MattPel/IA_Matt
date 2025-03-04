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
		
		//establish the connection with database and server credentials
		$conn = new mysqli($servername, $username, $password, $dbname);

		//if there is an error during connection do the following
		if ($conn->connect_error) {
			http_response_code(500);
            "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #0d3800; font-weight: bold;'>Connection failed: " . $conn->connect_error . "</p>";
			die("Connection failed: " . $conn->connect_error);
		} 
		//if there is no error during connection do the following
		else{
			
			//the user's input is first checked in order to form the appropriate query
			$sql = "SELECT * FROM students WHERE";
			$name = htmlspecialchars($_POST['name']);
			$year = htmlspecialchars($_POST['year']);
			if(!empty($name)) {
				$sql = $sql . " (name LIKE '" . $name . "%' or name LIKE '% " . $name ."%')";
			}
			
			if(!empty($year)){
				if(!empty($name)) {
					$sql = $sql . " and";
				}
				$sql = $sql . " year = " . $year;
			}
			
			if(!empty($_POST['SchoolSystem'])){
				$schoolSystem = htmlspecialchars($_POST['SchoolSystem']);
				if(!empty($name) || !empty($year)) {
					$sql = $sql . " and";
				}
				
				if ($schoolSystem=="Both"){
					$sql = $sql . " (SchoolSystem = 'Hungarian' or SchoolSystem = 'IB')";
				}	
				
				else if ($schoolSystem=="Hungarian System"){
					$sql = $sql . " (SchoolSystem = 'Hungarian')";
				}
				
				else{
					$sql = $sql . " SchoolSystem = '" . $schoolSystem . "'";
				}
			}
			
			if(!empty($_POST['CourseLevel'])){	
				$courseLevel = htmlspecialchars($_POST['CourseLevel']);
				if ($courseLevel=="Both"){
					$sql = $sql . " and (SchoolSystem = 'Hungarian' or SchoolSystem = 'IB')";
				}
				
				else {
					$sql = $sql . " and CourseLevel = '" . $courseLevel . "'";
				}
			}	
			
			//query to database
			$result = $conn->query($sql);
				
			//identifier is an invisible input that is used when the searchForm is submitted in order to specify which input has been submitted
			if ( isset($_POST['identifier'])){
				
				//what happens when searchForm is submitted
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
						
						//for each student that matches the search input, a record is shown in the table
						while($row = $result->fetch_assoc()) { 
							$counter = $counter + 1;
				
							//the variable $counter is used to determine the specific student and to know where the changes we make should apply
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
						
						//we pass all the search inputs to the dynamically generated edit form in order to re-execute the search query and edit the appropriate student record
						echo '<input name="name" style="display: none;" value="' . $name . '"></input>';  
						echo '<input name="year" style="display: none;" value="' . $year . '"></input>'; 
						echo '<input name="SchoolSystem" style="display: none;" value="';
						if (isset($schoolSystem)) 
							echo $schoolSystem;
						else
							echo '';
						echo '"></input>';
						echo '<input name="CourseLevel" style="display: none;" value="';
						if (isset($courseLevel))
							echo $courseLevel;
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
				//what happens when (dynamically generated) editForm is submitted
				$counter = 0;
				while($row = $result->fetch_assoc()) { 
					//either editForm or searchForm, results are gonna be displayed in the same order after the search query
					//that's why counter variable now can match the correct changes that have been submitted to the dynamically generated editForm above
					//counter variable here corresponds to the appropriate student records of counter variable at lines 90-115
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
						$sql_updated = "UPDATE `students` SET `Grades_A`='" . htmlspecialchars($_POST["gradeA_" . $counter]) . "' WHERE `Name`='" . $row["Name"] . "'";
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
		//close the connection
		mysqli_close($conn);
	}
	else {
		http_response_code(403);
		echo "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #980101; font-weight: bold;'>There was a problem with your submission, please try again.</p>";
	}
?>