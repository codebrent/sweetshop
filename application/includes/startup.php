<?php
namespace ASA;
//Load all the classes
include 'application/src/Student.php';
include 'application/src/Paper.php';
include 'application/src/Layout.php';
include 'application/src/Filer.php';
include 'application/src/Reporter.php';

//Start session and get info
session_start();
if(isset($_SESSION["studentID"])){
	$studentID = $_SESSION["studentID"];
	$viewData["studentID"] = $studentID;
} else {
	$studentID = null; //not logged in
}
//Get info about the selected screen
$viewData["screen"] = filter_input(INPUT_GET,"s",FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 

//Get clean info for login screen
$formStudentID = filter_input(INPUT_POST,"studentID",FILTER_SANITIZE_NUMBER_INT);
$formPassword = filter_input(INPUT_POST,"password", FILTER_SANITIZE_EMAIL);
//Get file info for upload
$uploadFileName = (isset($_FILES['fname']['name']))? $_FILES['fname']['name'] : null;
$uploadTempName =(isset($_FILES['fname']['tmp_name']))? $_FILES['fname']['tmp_name'] : null;
$uploadError = (isset($_FILES['fname']['error']))? $_FILES['fname']['error'] : null;
$uploadPaperNo = filter_input(INPUT_POST,"paperNo",FILTER_SANITIZE_NUMBER_INT);
$uploadAssignmentNo = filter_input(INPUT_POST,"assignmentNo",FILTER_SANITIZE_NUMBER_INT);
//For Debugging
//var_dump($_REQUEST);