<!DOCTYPE html>

<html>

	<head>
	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		
		<link href="IA.css?v20" rel="stylesheet" type="text/css"/>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title> BME German students manager </title>
		
		<style>
			body {
				cursor: default;
			}
			
			div#saving {
				position: fixed;
				top: 5px;
				right: 5px;
				color: black;
				text-shadow: 1px 1px 1px #fffffff;
				opacity: 0.7;
			}
		</style>

	</head>

	<body>	
	
		<div id="saving">
			All your changes have been saved!
		</div>
	
		<div id="mySidenav" class="sidenav" style="width: 0px;">
		  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		  <a href="#home" onclick="homeClick(); closeNav()"> Home </a> </br>
		  <a href="#search" onclick="searchClick(); closeNav()"> Search/Edit Students </a> </br> 
		  <a href="#edit" onclick="editClick(); closeNav()"> Add/Remove Students </a> </br>
		</div>
		
		<span style="font-size:32px;cursor:pointer; display:none;" onclick="openNav()" id="mySlidebar"> &#9776; Menu </span>
		
		<div class="container-fluid" id="main">
		
		<h1 id="mytitle"> BME German students manager </h1>
		
		<form action="login.php" id="loginForm" method="post"> <br>
		  <div class="imgcontainer" style="text-align:center;">
			<img src="Welcome_pic.jpg" alt="welcome" class="img-fluid">
		  </div> <br>

		  <div class="container">
			<label for="uname"><b>Username</b></label>
			<input type="text" placeholder="Enter Username" name="uname" autocomplete="off" class="form-control" required>
			
			<br>
			
			<label for="psw"><b>Password</b></label>
			<input type="password" placeholder="Enter Password" name="psw" autocomplete="off" class="form-control" required>
			<br>
			<button type="submit" class="btn btn-primary mb-2" id="myLogin">Login</button>
			<button type="button" class="btn btn-primary mb-2" id="myCancel">Cancel</button>
		  </div> <br>

		  <div class="container">
			<p style="font-style:italic; text-align:right;">If you forgot your password, please contact Matthaios P.</p>
		  </div>
		</form>
		
		<br>
		
		<div id="homeSpace" style="display:none;">
			<p class="mybase">
				Welcome to the "Home" section! 
			</p><br>
			
			<div class="container" style="text-align:center;">
			  <img id="GermanFlag1" class="img-fluid" src="GermanFlag.jpg" alt="image test"style="border-radius: 10%;"/>
			  <br><br><br>
				<div class="popup" onclick="myFunction()"> 
					<p style="color:#0d3800; font-size:130%;"> Click here for further information! </p>
						<span class="popuptext" id="myPopup">
							<p class="mybase" style="font-size:120%; color:#1e058b;"> Here, you will be able to:
								<ul>
									<li style="color:#0d3800;"> Search for any student you currently teach </li>
									<li style="color:#0d3800;"> Make notes on their progress </li>
									<li style="color:#0d3800;"> Give them predicted or recorded grades </li>
									<li style="color:#0d3800;"> Add new or remove graduate students </li>
								</ul>
							</p>
						</span>
				</div>
				<br><p class="mybase" style="color:#1e058b"> Click on the "Menu" on the top left to navigate!</p>
			</div>
			
		</div>
		
		<div id="searcheditSpace" style="display:none;">
		<p class="mybase">
			Welcome to the "Search/Edit students" section! Please input any information to find the students that match it!
		</p>		
			<form id="form1" method="post" action="getstudents.php">	
			
				<div class="form-group">
					
					<div class="col-sm-4">
					
						<label for="name" class="descInput">Search by name:</label>
						<input type="text" class="form-control" id="name" autocomplete="off" placeholder="Enter student name" name="name">
						<span class="error-message-name" id="error-message-nameID" style="color: red; font-style: italic; display:none; margin-left: 1.7%;"> Only letters, full stops and spaces are allowed! </span>
						<small class="form-text" style="margin-left: 1.7%; color: #0d3800;"> Insert first name or first letter of last name </small>
						
						</br>
						
						<label for="year" class="descInput"> Search by year: </label>
						<input type="text" class="form-control" id="year" autocomplete="off" placeholder="Enter student year" name="year">
						<span class="error-message-year" id="error-message-yearID" style="color: red; font-style: italic; display:none; margin-left: 1.7%;"> Only numbers are allowed! </span>
						
						</br>
						
						<label for="SchoolSystem" class="descInput"> Search by school system: </label>
						<select class="form-control" id="schoolSystemSearch" onchange="showDropdown('schoolSystemSearch', 'hiddenOptionSearch')" style="cursor: pointer" name="SchoolSystem">
							<option value="" disabled selected> Select school system </option>
							<option> Hungarian System </option>
							<option> IB </option>
							<option> Both </option>
						</select>
						
						</br>
						
						<div id="hiddenOptionSearch" style="display:none">
							<label for="CourseLevel" class="descInput"> Select IB course level: </label>
							<select class="form-control" style="cursor: pointer; margin-bottom: 5%;" name="CourseLevel">
								<option value="" disabled selected> Select German course level </option>
								<option> HL </option>
								<option> SL </option>
								<option> Both </option>
							</select>
						</div>
						<input name="identifier" value="form_no1" style="display:none">
						<input id="submit" type="submit" name="search" value="Search" class="btn btn-primary mb-2" onclick="showResults(); if (checkAllEmpty()){return true;} else return false;">
						<button type="reset" id="reset" class="btn btn-primary mb-2" onclick="enableSearch(); hideHint('error-message-nameID'); hideHint('error-message-yearID'); makeAroundGreen();
																							closeDropdown('hiddenOptionSearch'); hideResults(); hideSaveChangesButton(); closeSort();"> Reset</button>
					
					</div>
						
				</div>			
						
			</form>
			
			</br>

			</br>
			
			<div id="tableButtonsDiv" style="display:none;">
				<button class="btn btn-primary mb-2" id="sortAlphabeticallyButton" onclick="sortTableAlphabetically()"> Sort alphabetically </button>
			</div>		
			
			<div id="resultsArea" style="display: none;">
				
				<form id="externalForm">	
					
					<div class="table-responsive" id="results">	
					
					
					</div>
				</form>
			
			</div>		
		</div>
		
		<div id="errorLoginArea" style="display:none; text-align: center; font-size: 130%; color: #980101; font-weight: bold;">
		</div>
		
		<div id="addremoveSpace" style="display: none;">
			<p class="mybase">
				Welcome to the "Add/Remove students" section! Here you can add or remove students!
			</p>
			<br> <br> <br>
			<div style="text-align:center;">
				<button class="btn btn-primary mb-2 addButton" style="margin-right:2.5%; font-size:125%;" onclick="showAddRemoveInputs('addInputs', 'removeInputs');"> Add Student </button>
				<button class="btn btn-primary mb-2 removeButton" style="margin-left:2.5%; font-size:125%;" onclick="showAddRemoveInputs('removeInputs', 'addInputs');"> Remove Student </button>
			</div>
			
			<br> <br>
			
			<div class="form-group">					
				<div class="col-sm-5" id="addInputs" style="display:none;">
					<form id="addForm" method="post" action="addRemoveRecord.php">
						<label for="name" class="descInput">Insert name:</label>
						<input id="insertName" type="text" class="form-control" autocomplete="off" placeholder="Enter student name" name="name">
						<span class="error-message-name" id="error-message-nameID2" style="color: red; font-style: italic; display:none; margin-left: 1.7%;"> Only letters, full stops and spaces are allowed! </span>
						
						</br>
						
						<label for="year" class="descInput"> Insert year: </label>
						<input id="insertYear" type="text" class="form-control" autocomplete="off" placeholder="Enter student year" name="year">
						<span class="error-message-year" id="error-message-yearID2" style="color: red; font-style: italic; display:none; margin-left: 1.7%;"> Only numbers are allowed! </span>						
						
						</br>
						
						<label for="SchoolSystem" class="descInput"> Insert school system: </label>
						<select class="form-control" id="insertSchoolSystem" onchange="showDropdown('insertSchoolSystem', 'hiddenOptionInsert')" style="cursor: pointer" name="SchoolSystem">
							<option value="" disabled selected> Select school system </option>
							<option value="Hungarian"> Hungarian System </option>
							<option> IB </option>
						</select>
						
						</br>
						
						<div id="hiddenOptionInsert" style="display:none">
							<label for="CourseLevel" class="descInput"> Insert course level: </label>
							<select id="insertCourseLevel" class="form-control" style="cursor: pointer; margin-bottom: 5%;" name="CourseLevel">
								<option value="" disabled selected> Select German course level </option>
								<option> HL </option>
								<option> SL </option>
							</select>
						</div>
						<input type="submit" value="Add" id="addButton" class="btn btn-primary mb-2 addButton" style="font-size:125%; position:relative; left:1%;">
					</form>
				</div>
				
				<div class="col-sm-5" id="removeInputs" style="display:none">
					<form id="removeForm" method="post" action="addRemoveRecord.php">
						<label for="name" class="descInput">Insert name of student to remove:</label>
						<input id="removeName" type="text" class="form-control" autocomplete="off" placeholder="Enter student name" name="removeName">
						<span class="error-message-name" id="error-message-nameID3" style="color: red; font-style: italic; display:none; margin-left: 1.7%;"> Only letters, full stops and spaces are allowed! </span>
						
						<br>
						
						<input type="submit" value="Remove" id="removeButton" class="btn btn-primary mb-2 removeButton" style="font-size:125%; position:relative; left:1%;">
					</form>
				</div>
			
					<div id="addRemoveArea" style="display:none;">
					</div>
					
			</div>
		

		
		<script>
			
			$("#saving").hide();
			
			//error message handling for search name
			var nameOk = true;
			var yearOk = true;
				
			$("#name").on('input', function (evt) {
                var value = evt.target.value
				
				if (value.length === 0) {
					document.getElementById("error-message-nameID").style.display="none";
					$("#name").removeClass('error');
					nameOk = true;
					tryToEnableSearch();
					return;
				}
				
                if (/^([A-Za-z .]*)$/.test(value)) {
                    document.getElementById("error-message-nameID").style.display="none";
					$("#name").removeClass('error');
					nameOk = true;
					tryToEnableSearch();
                }
				else {
					document.getElementById("error-message-nameID").style.display="block";
					$("#name").addClass('error');
					nameOk = false;
					disableSearch();
				}
            });
			
			//error message handling for search year
			$('#year').on('input', function (evt) {
			  var value = evt.target.value

				if (value.length === 0) {
					document.getElementById("error-message-yearID").style.display="none";
					$("#year").removeClass('error');
					yearOk = true;
					tryToEnableSearch();
					return;
				}
				
				if ($.isNumeric(value)) {
					document.getElementById("error-message-yearID").style.display="none";
					$("#year").removeClass('error');
					yearOk = true;
					tryToEnableSearch();
				}
				
				else{
					document.getElementById("error-message-yearID").style.display="block";
					$("#year").addClass('error');
					yearOk = false;
					disableSearch();
				}
			})
			
			function makeAroundGreen() {
				$("#name").removeClass('error');
				$("#year").removeClass('error');
			}
			
			function disableSearch() {
				$("#submit").attr("disabled", "disabled");
			}
			
			function tryToEnableSearch(){
				if (yearOk && nameOk){
					$("#submit").removeAttr("disabled", "disabled");
				}
			}
			
			$("#saveChangesButton").click(function(){
				$("#invisibleSubmit").click();
			});
			
			if ($('#zeroResults').is(':visible')) {
				$("#saveChangesButton").attr("disabled", "disabled");
			}
			
			// When the user clicks on <div>, open the popup
			function myFunction() {
			  var popup = document.getElementById("myPopup");
			  popup.classList.toggle("show");
			}
			
			//AJAX call gia to form1
			$(function() {
				// Get the form.
				var form = $('#form1');
				
				// Set up an event listener for the contact form.
				$(form).on("submit",function(event) {
					// Stop the browser from submitting the form.
					event.preventDefault();

					// Serialize the form data.
					var formData = $(form).serialize();
					
					// Submit the form using AJAX.
					$.ajax({
						type: 'POST',
						url: $(form).attr('action'),
						data: formData
					}).done(function(response) {

						// Set the message text.
						
						$('#results').html(response);
						
						if (response.indexOf('Sorry, no matches found!') < 0) {
							$('#tableButtonsDiv').attr('style', 'display:block;');
						}
						else {
							$('#tableButtonsDiv').attr('style', 'display:none;');
						}
					}).fail(function(response) {

						$('#resultsArea').html(response);
						
					});
				});
			});
			
			//AJAX call gia to loginForm
			$(function() {
				// Get the form.
				var form = $('#loginForm');
				
				// Set up an event listener for the contact form.
				$(form).on("submit",function(event) {
					// Stop the browser from submitting the form.
					event.preventDefault();

					// Serialize the form data.
					var formData = $(form).serialize();
					
					// Submit the form using AJAX.
					$.ajax({
						type: 'POST',
						url: $(form).attr('action'),
						data: formData
					}).done(function(response) {

						if (response.indexOf('Error during login: ') >= 0) {
							$('#errorLoginArea').css('display', 'block');
							$('#errorLoginArea').html(response);				
						}
						else {
							$('#errorLoginArea').css('display', 'none');
							$('#loginForm').css('display', 'none');
							homeClick();
							$('#mySlidebar').css('display', 'block');	
						}
					}).fail(function(response) {

						$('#errorLoginArea').html(response);
						
					});
				});
			});
			
			function hideHint(hint) {
				document.getElementById(hint).style.display="none";
			}
			
			function showDropdown(schoolSystem, hiddenOption){
				var option = document.getElementById(schoolSystem).value;
				
				if (option == "IB") {
					document.getElementById(hiddenOption).style.display='block';
				}
				
				else {
					document.getElementById(hiddenOption).style.display="none";
					document.getElementById(hiddenOption).getElementsByClassName("form-control")[0].value="";
				}
			}
			
			function closeDropdown(z){
				document.getElementById(z).style.display="none";
			}
			
			function showForm(x){
				document.getElementById("form1").style.display="block";
				document.getElementById("description").innerHTML="Enter " + x;
				document.getElementById("searchInput").name=x;
			}
			
			function changeCursor(){
				document.body.style.cursor = "pointer";
			}
			
			function checkAllEmpty(){
				var input1 = document.getElementById("name").value;
				var input2 = document.getElementById("year").value;
				var input3 = document.getElementById("schoolSystemSearch").value;
				if ( input1 == "" && input2 == "" && input3 == "" )
				{
					alert("Please complete at least one field!");
					return false;
				}
				return true;
			}
			
			function checkAnyEmpty(){
				var input1 = document.getElementById("insertName").value;
				var input2 = document.getElementById("insertYear").value;
				var input3 = document.getElementById("insertSchoolSystem").value;
				if (input3 == "IB") 
					var input4 = document.getElementById("insertCourseLevel").value;
				if ( input1 == "" || input2 == "" || input3 == "" || (input3 == "IB" && input4 == "") )
				{
					alert("Please complete all available fields!");
					return false;
				}
				return true;
			}
			
			function hideResults(){
					document.getElementById("resultsArea").style.display="none";
			}
			
			function showResults(){
					document.getElementById("resultsArea").style.display="block";
			}
			
			function hideSaveChangesButton() {
				document.getElementById("saveChangesButton").style.display="none";
			}
			
			function enableSearch() {
				$("#submit").removeAttr("disabled", "disabled");
			}

			function openNav() {
				document.getElementById("mySidenav").style.width = "250px";
				document.getElementById("main").style.marginLeft = "250px";
				document.body.style.backgroundColor = "#b4bdc4";
			}

			function closeNav() {
				document.getElementById("mySidenav").style.width = "0px";
				document.getElementById("main").style.marginLeft = "0px";
				document.body.style.backgroundColor = "#dfe3e6";
			}
			
			function closeSort() {
				document.getElementById("sortAlphabeticallyButton").style.display="none";
			}
			
			function sortTableAlphabetically() {
				var table, rows, switching, i, x, y, shouldSwitch;
				table = document.getElementById("myTable");
				switching = true;
				rows = table.rows;

				while (switching) {
					switching = false;
					rows = table.rows;
					
					for (i = 1; i < (rows.length - 1); i++) {
						shouldSwitch = false;
						x = rows[i].getElementsByTagName("TD")[0];
						y = rows[i + 1].getElementsByTagName("TD")[0];
					if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
						shouldSwitch = true;
						break;
						}
					}					
					if (shouldSwitch) {
						rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
						switching = true;
					}					
				}
				
			}
			
			//auto-save below
			var timeoutId;
			$('#resultsArea').on('input', 'textarea' , function() {

				clearTimeout(timeoutId);
				timeoutId = setTimeout(function() {
					// Runs 1 second (1000 ms) after the last change    
					saveToDB();
				}, 1000);
			});

			function saveToDB()
			{
				console.log('Saving to the db');
				var form = $('#externalForm');
				
				//alert($('#resultsArea').find('textarea[name="notes_1"]').val());
				
				$.ajax({
					url: "getstudents.php",
					type: "POST",
					data: $(form).serialize(), // serializes the form's elements.
					/*beforeSend: function(xhr) {
						Let them know we are saving
						$('.form-status-holder').html('Saving...');
					},
					success: function(data) {
						var jqObj = jQuery(data); // You can get data returned from your ajax call here. ex. jqObj.find('.returned-data').html()
						// Now show them we saved and when we did
						var d = new Date();
						$('.form-status-holder').html('Saved! Last: ' + d.toLocaleTimeString());
					},*/
				})
				.done(function(response) {
					
					$("#saving").fadeIn("fast", function(){
						$("#saving").fadeOut(4000);						
					});
				});
			}

			// This is just so we don't go anywhere  
			// and still save if you submit the form
			/*$('.contact-form').submit(function(e) {
				saveToDB();
				e.preventDefault();
			});*/
			
			jQuery(document).ready(function() {
				jQuery('.toggle-nav').click(function(e) {
					jQuery(this).toggleClass('active');
					jQuery('.menu ul').toggleClass('active');

					e.preventDefault();
				});
			});
			
			//changing menu screens following
			
			function homeClick(){
				document.getElementById("homeSpace").style.display="block";
				document.getElementById("searcheditSpace").style.display="none";
				document.getElementById("addremoveSpace").style.display="none";
			}
			
			function searchClick(){
				document.getElementById("homeSpace").style.display="none";
				document.getElementById("searcheditSpace").style.display="block";
				document.getElementById("addremoveSpace").style.display="none";
			}
			
			function editClick(){
				document.getElementById("homeSpace").style.display="none";
				document.getElementById("searcheditSpace").style.display="none";
				document.getElementById("addremoveSpace").style.display="block";
			}
			
			var images = new Array ('GermanFlag.jpg', 'SchoolPicture.jpg', 'Acropolis.jpg');
			var index = 1;
			
			function rotateImage()
			{
			  $('#GermanFlag1').fadeOut('fast', function() 
			  {
				$(this).attr('src', images[index]);
				
				$(this).fadeIn('fast', function() 
				{
				  if (index == images.length-1)
				  {
					index = 0;
				  }
				  else
				  {
					index++;
				  }
				});
			  });
			} 
			
			$(document).ready(function()
			{
			  setInterval (rotateImage, 3000);
			});
				
			//AJAX call gia to addForm
			$(function() {
				// Get the form.
				var form = $('#addForm');
				
				// Set up an event listener for the contact form.
				$(form).on("submit",function(event) {
					// Stop the browser from submitting the form.
					event.preventDefault();

					if (checkAnyEmpty()){
						// Serialize the form data.
						var formData = $(form).serialize();
						
						// Submit the form using AJAX.
						$.ajax({
							type: 'POST',
							url: $(form).attr('action'),
							data: formData
						}).done(function(response) {

							// Set the message text.
							
							$('#addRemoveArea').html(response);
							$('#addRemoveArea').attr('style', 'display:block;');
							
						}).fail(function(response) {

							$('#addRemoveArea').html(response);
							$('#addRemoveArea').attr('style', 'display:block;');
							
						});
					}
				});
			});
			
			//error message handling for insert name
			var insertNameOk = true;
			var insertYearOk = true;
				
			$("#insertName").on('input', function (evt) {
                var value = evt.target.value
				
				if (value.length === 0) {
					document.getElementById("error-message-nameID2").style.display="none";
					$("#insertName").removeClass('error');
					insertNameOk = true;
					tryToEnableAdd();
					return;
				}
				
                if (/^([A-Za-z .]*)$/.test(value)) {
                    document.getElementById("error-message-nameID2").style.display="none";
					$("#insertName").removeClass('error');
					insertNameOk = true;
					tryToEnableAdd();
                }
				else {
					document.getElementById("error-message-nameID2").style.display="block";
					$("#insertName").addClass('error');
					insertNameOk = false;
					disableAdd();
				}
            });
						
			//error message handling for insert year
			$('#insertYear').on('input', function (evt) {
			  var value = evt.target.value

				if (value.length === 0) {
					document.getElementById("error-message-yearID2").style.display="none";
					$("#insertYear").removeClass('error');
					insertYearOk = true;
					tryToEnableAdd();
					return;
				}
				
				if ($.isNumeric(value)) {
					document.getElementById("error-message-yearID2").style.display="none";
					$("#insertYear").removeClass('error');
					insertYearOk = true;
					tryToEnableAdd();
				}
				
				else{
					document.getElementById("error-message-yearID2").style.display="block";
					$("#insertYear").addClass('error');
					insertYearOk = false;
					disableAdd();
				}
			})
			
			function disableAdd() {
				$("#addButton").attr("disabled", "disabled");
			}
			
			function tryToEnableAdd(){
				if (insertYearOk && insertNameOk){
					$("#addButton").removeAttr("disabled", "disabled");
				}
			}
			
			//AJAX call gia to removeForm
			$(function() {
				// Get the form.
				var form = $('#removeForm');
				
				// Set up an event listener for the contact form.
				$(form).on("submit",function(event) {
					// Stop the browser from submitting the form.
					event.preventDefault();

					if ($('#removeName').val()!=""){
						// Serialize the form data.
						var formData = $(form).serialize();
						
						// Submit the form using AJAX.
						$.ajax({
							type: 'POST',
							url: $(form).attr('action'),
							data: formData
						}).done(function(response) {

							// Set the message text.
							
							$('#addRemoveArea').html(response);
							$('#addRemoveArea').attr('style', 'display:block;');
							
						}).fail(function(response) {

							$('#addRemoveArea').html(response);
							$('#addRemoveArea').attr('style', 'display:block;');
							
						});
					}
					else {
						alert("Please insert the name of the student to remove!");
					}
				});
			});
			
			function showAddRemoveInputs(addRemoveInputs, removeAddInputs){
				document.getElementById(addRemoveInputs).style.display="block";
				document.getElementById(removeAddInputs).style.display="none";
			}
			
			//error message handling for remove name
			var removeNameOk = true;
				
			$("#removeName").on('input', function (evt) {
                var value = evt.target.value
				
				if (value.length === 0) {
					document.getElementById("error-message-nameID3").style.display="none";
					$("#removeName").removeClass('error');
					removeNameOk = true;
					tryToEnableRemove();
					return;
				}
				
                if (/^([A-Za-z .]*)$/.test(value)) {
                    document.getElementById("error-message-nameID3").style.display="none";
					$("#removeName").removeClass('error');
					removeNameOk = true;
					tryToEnableRemove();
                }
				else {
					document.getElementById("error-message-nameID3").style.display="block";
					$("#removeName").addClass('error');
					removeNameOk = false;
					disableRemove();
				}
            });
			
			function disableRemove() {
				$("#removeButton").attr("disabled", "disabled");
			}
			
			function tryToEnableRemove(){
				if (removeNameOk){
					$("#removeButton").removeAttr("disabled", "disabled");
				}
			}
		</script>
	
	</body>

</html>