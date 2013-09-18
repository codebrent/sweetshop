<?php
if($viewData["screen"] == "logout" && $userID != null){
	session_destroy();
	header("Location: index.php");  //redirect to index.php
	
} else if($viewData["screen"] == "product"){

	
} else if($viewData["screen"] == "category"){
	$query = "SELECT * FROM products WHERE categoryId='".$viewData['page']."'";
	$result = mysqli_query($dbConnection, $query);
	$viewData["products"] = array();
	while($row = mysqli_fetch_array($result)){
		$viewData["products"][] = new Product($row["productId"], $dbConnection);
	}

} else if($viewData["screen"] == "user" && $userID != null){

	
} else {	//'home' or null
	$viewData["screen"] = "home";

}