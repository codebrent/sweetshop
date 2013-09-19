<?php
//Load all the classes
include 'application/src/Category.php';
include 'application/src/Database.php';
include 'application/src/Layout.php';
include 'application/src/Product.php';
include 'application/src/User.php';
include 'application/src/Util.php';

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

$viewData["screen"] = (isset($_GET['s'])) ? Util::cleanPostText($_GET['s']) : null;
$viewData["page"] = (isset($_GET['p'])) ? Util::cleanPostText($_GET['p']) : null;

//Get clean info for user login / registration or update of information
$formUsername = (isset($_POST['username'])) ? Util::cleanPostText($_POST['username']) : null;
$formPassword = (isset($_POST['password'])) ? Util::cleanPostText($_POST['password']) : null;
$formFirstName = (isset($_POST['firstname'])) ? Util::cleanPostText($_POST['firstname']) : null;
$formLastName = (isset($_POST['lastname'])) ? Util::cleanPostText($_POST['lastname']) : null;
$formAddress1 = (isset($_POST['address1'])) ? Util::cleanPostText($_POST['address1']) : null;
$formAddress2 = (isset($_POST['address2'])) ? Util::cleanPostText($_POST['address2']) : null;
$formSuburb = (isset($_POST['suburb'])) ? Util::cleanPostText($_POST['suburb']) : null;
$formCity = (isset($_POST['city'])) ? Util::cleanPostText($_POST['city']) : null;
$formEmail = (isset($_POST['email'])) ? Util::cleanPostText($_POST['email']) : null;
$formPhone = (isset($_POST['phone'])) ? Util::cleanPostText($_POST['phone']) : null;

//For Debugging
//var_dump($_REQUEST);