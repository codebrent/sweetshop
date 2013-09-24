<?php
class OrderItem {

	private $orderID;
	private $productID;
	private $productName;
	private $quantity;
	private $price;
	private $dbConnection;
	
	public function __construct($orderID, $productID, $dbConnection){
		$this->orderID = $orderID;
		$this->productID = $productID;
		$this->dbConnection = $dbConnection;
	}

	public function save(){
		//check if line already exists		
		$query = "SELECT * FROM orderitems WHERE orderId='".mysqli_real_escape_string($this->dbConnection, $this->orderID);
		$query .= "' AND productId='".mysqli_real_escape_string($this->dbConnection, $this->productID)."'";
		$result = mysqli_query($this->dbConnection, $query);
		if ($result->num_rows > 0){
			//will save items which have been set. Otherwise values are from the database
			$query = "UPDATE orderitems SET `quantity`='".mysqli_real_escape_string($this->dbConnection, $this->getQuantity());
			$query .= "',`price`='".mysqli_real_escape_string($this->dbConnection, $this->getPrice());
			$query .= "' WHERE `orderId`='".mysqli_real_escape_string($this->dbConnection, $this->orderID);
			$query .= "' AND `productId`='".mysqli_real_escape_string($this->dbConnection, $this->getProductId())."'";
		} else { //new order, save new row
			$query = "INSERT INTO orderitems (`orderId`,`productId`,`quantity`,`price`) ";
			$query .= "VALUES ('".mysqli_real_escape_string($this->dbConnection, $this->orderID);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->productID);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->getQuantity());
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->getPrice())."')";
		}
		if (mysqli_query($this->dbConnection, $query)){
			return "success";
		} else {
			return "failure";
		}
	}

	public function delete(){
		$query = "DELETE FROM orderitems WHERE orderId='".mysqli_real_escape_string($this->dbConnection, $this->orderID);
		$query .= "' AND productId='".mysqli_real_escape_string($this->dbConnection, $this->productID)."'";
		return mysqli_query($this->dbConnection, $query);
	}	
	
	public function getProductId(){
		return $this->productID;
	}
	
	public function getProductName(){
		if (!$this->productName){
			$query = "SELECT name FROM products WHERE productId='".mysqli_real_escape_string($this->dbConnection, $this->productID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->productName = $row[0];
		}
		return $this->productName;
	}
	
	public function getQuantity(){
		if ($this->quantity === null){
			$query = "SELECT quantity FROM orderitems WHERE orderId='".mysqli_real_escape_string($this->dbConnection, $this->orderID);
			$query .= "' AND productId='".mysqli_real_escape_string($this->dbConnection, $this->productID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->quantity = $row[0];
		}
		return $this->quantity;
	}

	public function setQuantity($quantity){
		$this->quantity = $quantity;
	}
	
	public function getPrice(){
		if (!$this->price){
			$query = "SELECT price FROM orderitems WHERE orderId='".mysqli_real_escape_string($this->dbConnection, $this->orderID);
			$query .= "' AND productId='".mysqli_real_escape_string($this->dbConnection, $this->productID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->price = $row[0];
		}
		return $this->price;
	}	

	public function setPrice($price){
		$this->price = $price;
	}

		
}