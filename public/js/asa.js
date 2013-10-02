$(function(){
	$('#registerForm').submit(registerSubmit);
	$('#editForm').submit(editSubmit);
	$('#loginForm').submit(loginSubmit);
	$( "#searchBox" ).autocomplete({
		 source:'index.php',
	})
	$( "#searchButton" ).click(searchClick);
});

//Function to submit login page. Verifies fields contain correct information
function loginSubmit(){
	//Reset Messageboxes
	$('#username-req-alert').html('');
	$('#password-req-alert').html('');
	//Get form values
	fmUsername = $.trim($('#fmUsername').val());
	fmPassword = $.trim($('#fmPassword').val());
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
	//stop submission if required fields missing	
	if (missingField){
		return false;
	}
	
}

//Loads search results in main window from AJAX call
function searchClick(){
	//get searchbox value
	term = $('#searchBox').val();
	//Display message while waiting for server response
	$('#mainContainer').html('<h4>Searching....</h4>');
	//send AJAX request containing search term
	$.get( "index.php", { s: "ajxSearchResult", p: term }, function(data){
		$('#mainContainer').html(data);
	});	
}

//AJAX call to add item to shopping cart
function buyMe(product, tb){
	//get quantity
	qty = tb.val();
	//Make sure quantity is valid
	if (qty < 1 || qty > 100 || isNaN(qty)){
		alert("Please enter a quantity between 1 and 100");
	} else {
		//Set button
		bBuy = '#bBuy' + product;
		//Display graphic while AJAX loading
		$(bBuy).html('<img alt="" style="width: 24px; height: 18px;" src="public/img/486.gif">');
		//Send AJAX request
		$.get( "index.php", { s: "ajxBuyItem", p: product, qty: qty }, function(buydata){
			//Display return message
			$('#msgContainer').html(buydata);
			//Update shopping cart in header
			$.get( "index.php", { s: "ajxCartNumOfItems" }, function(cartdata){
				$('#cartHeader').html(cartdata);
				$(bBuy).html('Buy');
			});
		});
	}
}

//Function to submit registration details
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

	//Set response messages
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
	if (!/^[0-9A-Za-z ]+$/.test(fmAddress2) && fmAddress2){
		$('#address2-alert').html('<div class="alert alert-error span4">'+ ivAddress +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9A-Za-z ]+$/.test(fmSuburb) && fmSuburb){
		$('#suburb-alert').html('<div class="alert alert-error span4">'+ ivSuburb +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9A-Za-z ]+$/.test(fmCity)){
		$('#city-alert').html('<div class="alert alert-error span4">'+ ivCity +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9 ]+$/.test(fmPhone) && fmPhone){
		$('#phone-alert').html('<div class="alert alert-error span4">'+ ivPhone +'</div>');	
		invalidField = true;
	}			
	//stop submission if invalid fields	
	if (invalidField){
		return false;
	}

	return true;
}

//Function to submit edited details
function editSubmit(){
	//Reset Messageboxes
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
	if (fmPassword && (fmPassword.indexOf(' ') !== -1 || fmPassword.length < 6)){
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
	if (!/^[0-9A-Za-z ]+$/.test(fmAddress2) && fmAddress2){
		$('#address2-alert').html('<div class="alert alert-error span4">'+ ivAddress +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9A-Za-z ]+$/.test(fmSuburb) && fmSuburb){
		$('#suburb-alert').html('<div class="alert alert-error span4">'+ ivSuburb +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9A-Za-z ]+$/.test(fmCity)){
		$('#city-alert').html('<div class="alert alert-error span4">'+ ivCity +'</div>');	
		invalidField = true;
	}
	if (!/^[0-9 ]+$/.test(fmPhone) && fmPhone){
		$('#phone-alert').html('<div class="alert alert-error span4">'+ ivPhone +'</div>');	
		invalidField = true;
	}			
	//stop submission if invalid fields	
	if (invalidField){
		return false;
	}

	return true;
}

