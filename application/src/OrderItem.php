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
		
	public function getProductId(){
		return $this->productID;
	}
	
	public function getProductName(){
		if (!$this->productName){
			$query = "SELECT name FROM products WHERE productId='".$this->productID."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->productName = $row[0];
		}
		return $this->productName;
	}
	
	public function getQuantity(){
		if (!$this->quantity){
			$query = "SELECT quantity FROM orderitems WHERE orderId='".$this->orderID."' AND productId='".$this->productID."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->quantity = $row[0];
		}
		return $this->quantity;
	}

	public function getPrice(){
		if (!$this->price){
			$query = "SELECT price FROM orderitems WHERE orderId='".$this->orderID."' AND productId='".$this->productID."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->price = $row[0];
		}
		return $this->price;
	}	
	

		
}