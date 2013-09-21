<?php
class Order {

	private $orderID;
	private $userID;
	private $deliveryDate;
	private $status;
	private $itemList;
	private $dbConnection;
	
	public function __construct($orderID, $dbConnection){
		$this->orderID = $orderID;
		$this->dbConnection = $dbConnection;
		$this->getItemList();
	}

	public function save(){
		if ($this->orderID){ //existing ID, update details
			//will save items which have been set. Otherwise values are from the database
			$query = "UPDATE orders SET `orderId`='".$this->getOrderID()."',`userId`='".$this->getUserID()."',`deliveryDate`='".$this->getDeliveryDate();
			$query .= "',`status`='".$this->getStatus()."' WHERE `orderId`='".$this->getOrderID()."'";
				
		} else { //new order, save new row
			//check no other pending orders assigned to user name

			//build query
			$query = "INSERT INTO users(`username`, `password`, `firstName`, `lastName`, `phone`, `email`, `address1`, `address2`, `suburb`, `city`) ";
			$query .= "VALUES ('".$this->username."','".$this->passwordHash."','".$this->firstName."','".$this->lastName."','".$this->phone."','";
			$query .= $this->email."','".$this->address1."','".$this->address2."','".$this->suburb."','".$this->city."')";
		}
		if (mysqli_query($this->dbConnection, $query)){
			return "success";
		} else {
			return "failure";
		}
	}
	
	public function getNumberOfItems(){
		return count($this->getItemList());
	}

	public function addItem(){
	
	}
	
	public function removeItem(){
	
	}
	
	public function processOrder(){
	
	}
	
	public function deliverOrder(){
	
	}
	
	public function getOrderID(){
		return $this->orderID;
	}
	
	public function getUserID(){
		if (!$this->userID){
			$query = "SELECT userId FROM orders WHERE orderId='".$this->orderID."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->userID = $row[0];
		}
		return $this->userID;
	}
	
	public function setUserID($userID){
		$this->userID = $userID; 
	}
	
	public function getDeliveryDate(){
		if (!$this->deliveryDate){
			$query = "SELECT deliveryDate FROM orders WHERE orderId='".$this->orderID."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->deliveryDate = $row[0];
		}
		return $this->deliveryDate;
	}

	public function getStatus(){
		if (!$this->status){
			$query = "SELECT status FROM orders WHERE orderId='".$this->orderID."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->status = $row[0];
		}
		return $this->status;
	}
		
	public function getItemList(){
		if (!$this->itemList){
			$list = array();
			$query = "SELECT * FROM orderitems WHERE orderId='".$this->orderID."'";
			$result = mysqli_query($this->dbConnection, $query);
			while ($row = $result->fetch_assoc()) {
				$list[] = new OrderItem($row["orderId"], $row["productId"], $this->dbConnection);
			}
			$this->itemList = $list;
		}
		return $this->itemList;
	}	
	
}