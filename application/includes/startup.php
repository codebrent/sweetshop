<?php
//Load all the classes
include 'application/src/Category.php';
include 'application/src/Database.php';
include 'application/src/Layout.php';
include 'application/src/Order.php';
include 'application/src/OrderItem.php';
include 'application/src/Product.php';
include 'application/src/User.php';
include 'application/src/Util.php';

$db = new Database();
$dbConnection = $db->getDbConnection();

//Start session and get info
session_start();
if(isset($_SESSION["userID"])){
	$viewData["user"] = new User($_SESSION["userID"], $dbConnection);
} else {
	$viewData["user"] = null; //not logged in
}

if(isset($_SESSION["cartID"])){
	$viewData["cart"] = new Order($_SESSION["cartID"], $dbConnection);
	if ($viewData["user"]){ //make sure userID is saved into cart details
		$viewData["cart"]->setUserID($viewData["user"]->getUserID());
		$viewData["cart"]->save();
	}
} else {
	if($viewData["user"]){
		//cartID not set but user logged in. See if it can be loaded through userID
		$_SESSION["cartID"] = $viewData["user"]->getCart();
		$viewData["cart"] = new Order($_SESSION["cartID"], $dbConnection);
	} else {	
		$viewData["cart"] = null; //no cart set
	}
}





//Get info about the selected screen
$viewData["screen"] = (isset($_GET['s'])) ? Util::cleanPostText($_GET['s']) : null;
$viewData["page"] = (isset($_GET['p'])) ? Util::cleanPostText($_GET['p']) : null;

//Get clean info for user login / registration or update of information
$formUsername = (isset($_POST['username'])) ? Util::cleanPostSql($_POST['username'], $dbConnection) : null;
$formPassword = (isset($_POST['password'])) ? Util::cleanPostSql($_POST['password'], $dbConnection) : null;
$formFirstName = (isset($_POST['firstname'])) ? Util::cleanPostSql($_POST['firstname'], $dbConnection) : null;
$formLastName = (isset($_POST['lastname'])) ? Util::cleanPostSql($_POST['lastname'], $dbConnection) : null;
$formAddress1 = (isset($_POST['address1'])) ? Util::cleanPostSql($_POST['address1'], $dbConnection) : null;
$formAddress2 = (isset($_POST['address2'])) ? Util::cleanPostSql($_POST['address2'], $dbConnection) : null;
$formSuburb = (isset($_POST['suburb'])) ? Util::cleanPostSql($_POST['suburb'], $dbConnection) : null;
$formCity = (isset($_POST['city'])) ? Util::cleanPostSql($_POST['city'], $dbConnection) : null;
$formEmail = (isset($_POST['email'])) ? Util::cleanPostSql($_POST['email'], $dbConnection) : null;
$formPhone = (isset($_POST['phone'])) ? Util::cleanPostSql($_POST['phone'], $dbConnection) : null;

//For Debugging
//var_dump($_REQUEST);