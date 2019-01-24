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