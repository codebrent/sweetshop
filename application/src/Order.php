<?php
class Order {

	const GST_RATE = 0.15;
	
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
			if ($this->getUserID()){
				$query = "SELECT orderId FROM orders WHERE userId='".$this->getUserID()."' AND status='Pending'";
				$result = mysqli_query($this->dbConnection, $query);
				if ($result){
					$row = $result->fetch_row();
					$this->orderID = $row[0];
				} else {
					//no cart already in the database. Go ahead an make another one
					//build query
					$query = "INSERT INTO orders (`userId`,`status`) ";
					$query .= "VALUES ('".$this->userId."','Pending')";
					$this->orderID = mysqli_insert_id($dbConnection);
				}
			} else {
				$query = "INSERT INTO orders (`userId`,`status`) ";
				$query .= "VALUES ('".$this->userId."','Pending')";
				$this->orderID = mysqli_insert_id($dbConnection);
			}
		}
		if (mysqli_query($this->dbConnection, $query)){
			return "success";
		} else {
			return "failure";
		}
	}
	
	public function getNumberOfItems(){
		$total = 0;
		foreach($this->getItemList() as $lineItem){
			$total += $lineItem->getQuantity();
		}
		return $total;
	}
	
	public function getTotalCost(){
		$total = 0;
		foreach($this->getItemList() as $lineItem){
			$total += $lineItem->getQuantity()*$lineItem->getPrice();
		}
		return $total;
	}
	
	public function getGST(){
		return $this->getTotalCost()/(1+self::GST_RATE)*self::GST_RATE;	
	}

	public function addItem($productID, $quantity){
		if ($quantity < 1){
			return 0;
		}
		//create a new order item check if it already exists
		$newOrderItem = new OrderItem($this->getOrderID(), $productID, $this->dbConnection);
		//make sure there is enough stock 
		$prevQuantity = $newOrderItem->getQuantity();
		$product = new Product($productID,$this->dbConnection);
		$quantityAvailable = $product->getStock();
		if ($prevQuantity >= $quantityAvailable){
			return 0;
		}
		$totalQuantity = $quantity + $prevQuantity;
		if ($totalQuantity > $quantityAvailable){
			$totalQuantity = $quantityAvailable;
		}
		$newOrderItem->setQuantity($totalQuantity);
		$newOrderItem->setPrice($product->getPrice());
		$newOrderItem->save();
		//refresh the orderitems list
		$this->itemList = null;
		$qtyAdded = $totalQuantity - $prevQuantity;
		return $qtyAdded;
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