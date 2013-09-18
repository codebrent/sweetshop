<?php
//Load all the classes
include 'application/src/Category.php';
include 'application/src/Database.php';
include 'application/src/Layout.php';
include 'application/src/Product.php';
include 'application/src/User.php';

$db = new Database();
$dbConnection = $db->getDbConnection();

//Start session and get info
session_start();
if(isset($_SESSION["userID"])){
	$userID = $_SESSION["userID"];
	$viewData["userID"] = $userID;
} else {
	$userID = null; //not logged in
}
//Get info about the selected screen
$viewData["screen"] = filter_input(INPUT_GET,"s",FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$viewData["page"] = filter_input(INPUT_GET,"p",FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 

//Get clean info for user login / registration or update of information
$formUsername = filter_input(INPUT_POST,"username",FILTER_SANITIZE_EMAIL);
$formPassword = filter_input(INPUT_POST,"password",FILTER_SANITIZE_EMAIL);
$formFirstName = filter_input(INPUT_POST,"firstname",FILTER_SANITIZE_EMAIL);
$formLastName = filter_input(INPUT_POST,"lastname",FILTER_SANITIZE_EMAIL);
$formAddress1 = filter_input(INPUT_POST,"address1",FILTER_SANITIZE_EMAIL);
$formAddress2 = filter_input(INPUT_POST,"address2",FILTER_SANITIZE_EMAIL);
$formSuburb = filter_input(INPUT_POST,"suburb",FILTER_SANITIZE_EMAIL);
$formCity = filter_input(INPUT_POST,"city",FILTER_SANITIZE_EMAIL);
$formEmail = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
$formPhone = filter_input(INPUT_POST,"phone",FILTER_SANITIZE_EMAIL);

//For Debugging
//var_dump($_REQUEST);