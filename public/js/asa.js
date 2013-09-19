$(function(){
	$('#inputPaperNo').change(showRadios);
	$('#fileUploadForm').hide();
	$('#fileUploadForm').submit(uploadSubmit);
	$('#registerForm').submit(registerSubmit);
	//EasyLoginCode
	//$('.easyLogin').click(function(){
    //	$buttonText = $(this).html();  
	//  $id = $buttonText.substring(4,12);
	//  $pass = $buttonText.substring(15);
	//  $("input[name='studentID']").val($id);
	//  $("input[name='password']").val($pass);
	//});
});

function showRadios(){
	var sVal = $('#inputPaperNo').val(); 
	var paper = sVal.substring(0,6);	
	var noAssignments = sVal.substring(7);	
	$('#radioDiv').empty();
	$('#fileUploadForm').hide();
	for ( i=1 ; i<=noAssignments ; i++){
		var label = $('<label class="radio">').text(paper + ' : Assignment ' + i);
		var input = $('<input type="radio">').attr({name: 'radio', value: i});
		input.appendTo(label);
		$('#radioDiv').append(label);			
	}
	$('input[name=radio]').change(radioSelect);
	$('#paperNo').val(paper);
}

function radioSelect(obj){
	$('#fileUploadForm').show();
	$('#assignmentNo').val($('input[name=radio]:checked').val());
}

function uploadSubmit(){
	//Get form values
	paperNo = $('#paperNo').val();
	assignmentNo = $('#assignmentNo').val();
	filename = $('input[type=file]').val();
	//get arrays of valid values from data held in slelect options
	var rawData = $("#inputPaperNo>option").map(function() { return $(this).val(); });
	rawData.splice(0, 1); //Get rid of 0 value for blank select option
	//Check PaperNo is valid and also assignment No
	paperFound = 0;
	for (i=0;i<rawData.length;i++){
		if(paperNo == rawData[i].substr(0,6)){
			paperFound = rawData[i].substr(7); //puts number of assignments in the found variable
		}
	}
	if (paperFound == 0){
		$('#jsMessage').html('Please select a valid paper');
		$('#jsMessage').attr('class','alert alert-error');
		return false;

	} else {
		if (assignmentNo > paperFound || assignmentNo < 1){
			$('#jsMessage').html('Please select an assignment number');
			$('#jsMessage').attr('class','alert alert-error');
			return false;
		} 
	}
	
	var validExtensions = ["txt","php","cpp","c","html"];
	var ext = filename.substr( (filename.lastIndexOf('.') +1) );
	ext.toLowerCase(); //Make test case insensitive
	if (ext == "txt" || ext == "php" || ext == "cpp" || ext == "c" || ext == "html"){
		//all OK submit the form
		return true;
	} else {
		$('#jsMessage').html('Please select an file with an extension of .txt, .php, .cpp, .c, or .html');
		$('#jsMessage').attr('class','alert alert-error');
	}
	return false;
}

function registerSubmit(){
	//Reset Messageboxes
	$('#username-req-alert').html('');
	$('#password-req-alert').html('');
	$('#confirm-req-alert').html('');
	$('#email-req-alert').html('');
	$('#firstname-req-alert').html('');
	$('#lastname-req-alert').html('');
	$('#address1-req-alert').html('');
	$('#city-req-alert').html('');
	$('#username-alert').html('');
	$('#password-alert').html('');
	$('#confirm-alert').html('');
	$('#email-alert').html('');
	$('#firstname-alert').html('');
	$('#lastname-alert').html('');
	$('#address1-alert').html('');
	$('#address2-alert').html('');
	$('#suburb-alert').html('');
	$('#city-alert').html('');
	$('#phone-alert').html('');

	//Get form values
	fmUsername = $.trim($('#fmUsername').val());
	fmPassword = $.trim($('#fmPassword').val());
	fmConfirm = $.trim($('#fmConfirm').val());
	fmFirstName = $.trim($('#fmFirstName').val());
	fmLastName = $.trim($('#fmLastName').val());
	fmEmail = $.trim($('#fmEmail').val());
	fmAddress1 = $.trim($('#fmAddress1').val());
	fmAddress2 = $.trim($('#fmAddress2').val());
	fmSuburb = $.trim($('#fmSuburb').val());
	fmCity = $.trim($('#fmCity').val());
	fmPhone = $.trim($('#fmPhone').val());
	
	//Check required fields are complete	
	missingField = false;
	if (!fmUsername){
		$('#username-req-alert').html('<div class="alert alert-error span4">Please enter a username.</div>');	
		missingField = true;
	}	
	if (!fmPassword){
		$('#password-req-alert').html('<div class="alert alert-error span4">Please enter a password.</div>');			
		missingField = true;
	}	
	if (!fmConfirm){
		$('#confirm-req-alert').html('<div class="alert alert-error span4">Please confirm your password.</div>');			
		missingField = true;
	}	
	if (!fmEmail){
		$('#email-req-alert').html('<div class="alert alert-error span4">Please enter an email address.</div>');			
		missingField = true;
	}	
	if (!fmFirstName){
		$('#firstname-req-alert').html('<div class="alert alert-error span4">Please enter your first name</div>');		
		missingField = true;
	}	
	if (!fmLastName){
		$('#lastname-req-alert').html('<div class="alert alert-error span4">Please enter your last name</div>');			
		missingField = true;
	}	
	if (!fmAddress1){
		$('#address1-req-alert').html('<div class="alert alert-error span4">Please enter your address</div>');			
		missingField = true;
	}	
	if (!fmCity){
		$('#city-req-alert').html('<div class="alert alert-error span4">Please enter your city</div>');			
		missingField = true;
	}
	//stop submission if required fields missing	
	if (missingField){
		return false;
	}

	ivUsername = 'The username can only contain letters and numbers. It must not contain a space. It must be at least 6 characters long.';
	ivPassword = 'Your password must not contain a space. It must be at least 6 characters long.';
	ivConfirm = 'Your passwords do not match.';
	ivEmail = 'Your email address does not appear to be valid.';
	ivFirstName = 'Invalid first name: The first name can only contain letters and a space.';
	ivLastName = 'Invalid last name: The last name can only contain letters and a space.';
	ivAddress = 'Invalid address: The address can only contain letters and numbers.';
	ivSuburb = 'Invalid suburb: The suburb can only contain letters and numbers.';
	ivCity = 'Invalid city: The city can only contain letters and numbers.';
	ivPhone = 'Invalid phone number: The phone number can only contain numbers and a space.';
	
	invalidField = false;
	
	//check passwords match
	if (fmPassword != fmConfirm){
		$('#confirm-alert').html('<div class="alert alert-error span4">'+ ivConfirm +'</div>');			
		invalidField = true;
	}
	//check contents of each field is acceptable
	if (!/^[0-9A-Za-z]+$/.test(fmUsername) || fmUsername.length < 6){
		$('#username-alert').html('<div class="alert alert-error span4">'+ ivUsername +'</div>');	
		invalidField = true;
	}
	if (fmPassword.indexOf(' ') !== -1 || fmPassword.length < 6){
		$('#password-alert').html('<div class="alert alert-error span4">'+ ivPassword +'</div>');	
		invalidField = true;
	}
	if (!/\S+@\S+\.\S+/.test(fmEmail)){
		$('#email-alert').html('<div class="alert alert-error span4">'+ ivEmail +'</div>');	
		invalidField = true;
	}
	if (!/^[A-Za-z ]+$/.test(fmFirstName)){
		$('#firstname-alert').html('<div class="alert alert-error span4">'+ ivFirstName +'</div>');	
		invalidField = true;
	}
	if (!/^[A-Za-z ]+$/.test(fmLastName)){
		$('#lastname-alert').html('<div class="alert alert-error span4">'+ ivLastName +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9A-Za-z ]+$/.test(fmAddress1)){
		$('#address1-alert').html('<div class="alert alert-error span4">'+ ivAddress +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9A-Za-z ]+$/.test(fmAddress2)){
		$('#address2-alert').html('<div class="alert alert-error span4">'+ ivAddress +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9A-Za-z ]+$/.test(fmSuburb)){
		$('#suburb-alert').html('<div class="alert alert-error span4">'+ ivSuburb +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9A-Za-z ]+$/.test(fmCity)){
		$('#city-alert').html('<div class="alert alert-error span4">'+ ivCity +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9 ]+$/.test(fmPhone)){
		$('#phone-alert').html('<div class="alert alert-error span4">'+ ivPhone +'</div>');	
		invalidField = true;
	}			
	//stop submission if invalid fields	
	if (invalidField){
		return false;
	}

	return false;
}
