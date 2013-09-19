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
	alert('Click1111');
	return false;
}
