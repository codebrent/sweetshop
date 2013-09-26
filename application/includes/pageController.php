<?php
//a screen to display is set by the $viewData["screen"] value.
//pageController does any processing required before the layout displays the screen 
// This is passed to the application by the parameter "s"
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

//update item count for cart button
} else if($viewData["screen"] == "ajxCartNumOfItems"){
	$viewData["type"] = "ajax";

//Ajax search screen
} else if($viewData["screen"] == "ajxSearch"){
	$viewData["type"] = "ajax";
	$catalog = new Catalog($dbConnection);
	$viewData["searchResult"] = $catalog->search($viewData["term"]);

//Ajax search result screen
} else if($viewData["screen"] == "ajxSearchResult"){
	$viewData["type"] = "ajax";
	$catalog = new Catalog($dbConnection);
	$productList = $catalog->search($viewData["page"]);
	$resultArray = array();
	foreach($productList as $productLine){
		$resultArray[] = new Product($productLine["id"],$dbConnection);
	}
	$viewData["products"] = $resultArray; 

//process buy button	
} else if($viewData["screen"] == "ajxBuyItem"){
	$viewData["type"] = "ajax";
	$productID = $viewData["page"];
	if (!$viewData["cart"]){
		$userID = (isset($_SESSION["userID"])) ? $_SESSION["userID"] : null;
		$viewData["cart"] = new Order(null,$dbConnection);
		$viewData["cart"]->setUserID($userID);
		$viewData["cart"]->save();
		$_SESSION["cartID"] = $viewData["cart"]->getOrderID();
	}
	$viewData["addResult"] = $viewData["cart"]->addItem($productID,$viewData["quantity"]);
	$product = new Product($productID,$dbConnection);
	$viewData["quantityAvailable"] = $product->getStock();
	$viewData["product"] = $product;

//Remove item from cart
} else if($viewData["screen"] == "removeItem"){
	$productID = $viewData["page"];
	$orderID = $_SESSION["cartID"];
	$orderItem = new OrderItem($orderID, $productID, $dbConnection);
	$orderItem->delete();
	header("Location: index.php?s=orderview&p=cart");  //redirect back to shopping cart

//confirm order
} else if($viewData["screen"] == "confirmOrder"){
	$viewData["orderID"] = $viewData["cart"]->getorderID();
	$viewData["cart"]->confirmOrder();
	$viewData["cart"] = null;
	$_SESSION["cartID"] = null;

//Single product page	
} else if($viewData["screen"] == "product"){
	$viewData["product"] = new Product($viewData["page"], $dbConnection);

//Category page to display multiple products	
} else if($viewData["screen"] == "category"){
	$query = "SELECT * FROM products WHERE categoryId='".$viewData['page']."'";
	$result = mysqli_query($dbConnection, $query);
	$viewData["products"] = array();
	while($row = mysqli_fetch_array($result)){
		$viewData["products"][] = new Product($row["productId"], $dbConnection);
	}

//view cart or historic orders
} else if($viewData["screen"] == "orderview"){
	if ($viewData["page"] == "cart"){
		if (!$viewData["cart"] && $viewData["user"]){
			//cartID not set but user logged in. See if it can be loaded through userID
			$_SESSION["cartID"] = $viewData["user"]->getCart();
			$viewData["cart"] = new Order($_SESSION["cartID"], $dbConnection);
		}
	} else {
		$viewData["order"] = new Order($viewData["page"], $dbConnection);
	}

//Registration screen	
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

//View user details
} else if($viewData["screen"] == "userview"){

//Edit user details	
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

//show order history	
} else if($viewData["screen"] == "history"){	
	$viewData["orders"] = $viewData["user"]->getOrders();
	
} else {	//'home' or null
	$viewData["screen"] = "home";

}