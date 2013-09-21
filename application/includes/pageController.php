<?php
if($viewData["screen"] == "logout" && $viewData["user"] != null){
	session_destroy();
	header("Location: index.php");  //redirect to index.php

} else if($viewData["screen"] == "login"){
	if ($viewData["user"]){ //clear the current user
		session_destroy();
		header("Location: index.php?s=login");  //redirect to login
	}
	if ($formUsername){ //formdata has been sent. save user details
		$user = new User(null, $dbConnection);
		$user->setUsername($formUsername);
		if ($user->login($formPassword)){
			$_SESSION["userID"] = $user->getUserID();
			session_write_close();
			header("Location: index.php");  //redirect to index.php
		} else {
			$viewData["fmUsername"] = $formUsername;
			$viewData["loginTry"] = "failure";
		}
	}
	
} else if($viewData["screen"] == "product"){
	$viewData["product"] = new Product($viewData["page"], $dbConnection);
	
} else if($viewData["screen"] == "category"){
	$query = "SELECT * FROM products WHERE categoryId='".$viewData['page']."'";
	$result = mysqli_query($dbConnection, $query);
	$viewData["products"] = array();
	while($row = mysqli_fetch_array($result)){
		$viewData["products"][] = new Product($row["productId"], $dbConnection);
	}

} else if($viewData["screen"] == "orderview"){
	if ($viewData["page"] == "cart"){
		if (!$viewData["cart"] && $viewData["user"]){
			//cartID not set but user logged in. See if it can be loaded through userID
			$_SESSION["cartID"] = $viewData["user"]->getCart();
			$viewData["cart"] = new Order($_SESSION["cartID"], $dbConnection);
		}
		//display shopping cart need to get details
		
		
		
		
	} else {
		//display order by ID
		
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
		$viewData["registered"] = $user->save();
		$viewData["fmUsername"] = $formUsername;
	}

} else if($viewData["screen"] == "userview"){
	
} else if($viewData["screen"] == "useredit"){	
	$viewData["registered"] = null;
	if ($formFirstName){ //formdata has been sent. save user details
		$user = $viewData["user"];
		if ($formPassword){
			$user->setPassword($formPassword);
		}
		$user->setFirstName($formFirstName);
		$user->setLastName($formLastName);
		$user->setAddress1($formAddress1);
		$user->setAddress2($formAddress2);
		$user->setSuburb($formSuburb);
		$user->setCity($formCity);
		$user->setEmail($formEmail);
		$user->setPhone($formPhone);
		$viewData["registered"] = $user->save();
	}
	
} else if($viewData["screen"] == "history"){	
	
} else {	//'home' or null
	$viewData["screen"] = "home";

}