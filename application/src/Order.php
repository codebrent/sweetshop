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
			$query = "UPDATE orders SET `orderId`='".mysqli_real_escape_string($this->dbConnection, $this->getOrderID());
			$query .= "',`userId`='".mysqli_real_escape_string($this->dbConnection, $this->getUserID());
			$query .= "',`deliveryDate`='".mysqli_real_escape_string($this->dbConnection, $this->getDeliveryDate());
			$query .= "',`status`='".mysqli_real_escape_string($this->dbConnection, $this->getStatus());
			$query .= "' WHERE `orderId`='".mysqli_real_escape_string($this->dbConnection, $this->getOrderID())."'";
			return (mysqli_query($this->dbConnection, $query)) ? $this->getOrderID() : "failure";
		} else { //new order, save new row. Only carts are created. Other orders are updated from carts.
			//check if there is a userID, or if a guest.
			if ($this->getUserID()){
				$query = "SELECT orderId FROM orders WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->getUserID())."' AND status='Pending'";
				$result = mysqli_query($this->dbConnection, $query);
				if ($result->num_rows > 0){
					$row = $result->fetch_row();
					$this->orderID = $row[0];
					return $this->orderID;
				} else {
					//no cart already in the database. Go ahead an make another one
					//build query
					$query = "INSERT INTO orders (`userId`,`status`) VALUES ('".mysqli_real_escape_string($this->dbConnection, $this->userID)."','Pending')";
					if (mysqli_query($this->dbConnection, $query)){
						$this->orderID = mysqli_insert_id($this->dbConnection);
						return $this->orderID;	
					} else {
						return "failure";
					}
				}
			} else {
				$query = "INSERT INTO orders (`status`) VALUES ('Pending')";
				if (mysqli_query($this->dbConnection, $query)){
					$this->orderID = mysqli_insert_id($this->dbConnection);
					return $this->orderID;	
				} else {
					return "failure";
				}
			}
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
	
	public function confirmOrder(){
		//reduce stock holding
		foreach($this->getItemList() as $line){
			$product = new Product($line->getProductId(),$this->dbConnection);
			$product->removeStock($line->getQuantity());
		}
		//change status to Ordered
		$this->setStatus("Ordered");
		$this->save();			
	}
	
	public function getOrderID(){
		return $this->orderID;
	}
	
	public function getUserID(){
		if (!$this->userID){
			$query = "SELECT userId FROM orders WHERE orderId='".mysqli_real_escape_string($this->dbConnection, $this->orderID)."'";
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
			$query = "SELECT deliveryDate FROM orders WHERE orderId='".mysqli_real_escape_string($this->dbConnection, $this->orderID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->deliveryDate = $row[0];
		}
		return $this->deliveryDate;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		if (!$this->status){
			$query = "SELECT status FROM orders WHERE orderId='".mysqli_real_escape_string($this->dbConnection, $this->orderID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->status = $row[0];
		}
		return $this->status;
	}
		
	public function getItemList(){
		if (!$this->itemList){
			$list = array();
			$query = "SELECT * FROM orderitems WHERE orderId='".mysqli_real_escape_string($this->dbConnection, $this->orderID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			while ($row = $result->fetch_assoc()) {
				$list[] = new OrderItem($row["orderId"], $row["productId"], $this->dbConnection);
			}
			$this->itemList = $list;
		}
		return $this->itemList;
	}	
	
}