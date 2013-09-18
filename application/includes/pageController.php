<?php
if($viewData["screen"] == "logout" && $userID != null){
	session_destroy();
	header("Location: index.php");  //redirect to index.php
	
} else if($viewData["screen"] == "product"){
	$viewData["product"] = new Product($viewData["page"], $dbConnection);
	
} else if($viewData["screen"] == "category"){
	$query = "SELECT * FROM products WHERE categoryId='".$viewData['page']."'";
	$result = mysqli_query($dbConnection, $query);
	$viewData["products"] = array();
	while($row = mysqli_fetch_array($result)){
		$viewData["products"][] = new Product($row["productId"], $dbConnection);
	}

} else if($viewData["screen"] == "register"){
	$viewData["registered"] = null;
	if ($formUsername){ //formdata has been sent. save user details
		$user = new User(null, $dbConnection);
		$user->setUsername($formUsername);
		$user->setPassword($formPassword);
		$user->setFirstName($formFirstName);
		$user->setLastName($formLastName);
		$user->setAddress1($formAddress1);
		$user->setAddress2($formAddress2);
		$user->setSuburb($formSuburb);
		$user->setCity($formCity);
		$user->setEmail($formEmail);
		$user->setPhone($formPhone);
		$result = $user->save();
		if ($result == true){
			$viewData["registered"] = "success";
		} else {
			$viewData["registered"] = "failure";
		}
	}
	
} else {	//'home' or null
	$viewData["screen"] = "home";

}