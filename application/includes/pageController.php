<?php
namespace ASA;

if($viewData["screen"] == "logout" && $studentID != null){
	session_destroy();
	header("Location: index.php");  //redirect to index.php
	
} else if($viewData["screen"] == "upload" && $studentID != null){
	$student = new Student($studentID);
	$viewData["papers"] = $student->getPapers();
	
} else if($viewData["screen"] == "stats" && $studentID != null){
	$viewData["stats"] = Reporter::getStats($studentID);

} else if($viewData["screen"] == "filesubmit" && $studentID != null){
	$viewData["uploadError"] = $uploadError;
	$filer = new Filer($uploadFileName, $uploadTempName, $uploadPaperNo, $uploadAssignmentNo);
	$viewData["uploadFileName"] = $filer->upload($studentID);
	
} else if($viewData["screen"] == "docs"){
	//do nothing, viewData already set to show docs
	
} else {	//'home' or null
	$viewData["screen"] = "home";
	//check if login form has been submitted
	if(!$formStudentID && $formPassword
			|| $formStudentID && !$formPassword){
			$viewData["formStudentID"] = $formStudentID;
			$viewData["error"] = "please enter your Student ID and Password";
	}
	if($formStudentID && $formPassword){
		$student = new Student($formStudentID);
		if($student->logon($formPassword)){
			$_SESSION["studentID"] = $formStudentID;
			session_write_close();
			header("Location: index.php?s=upload");  //redirect to upload page
		} else {
			$viewData["formStudentID"] = $formStudentID;
			$viewData["error"] = "The Student ID and Password were not valid";
		}
	}
}