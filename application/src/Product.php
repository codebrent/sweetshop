<?php
class Product {

	private $productId;
	private $name;
	private $dbConnection;
	
	
	public function __construct($productId, $dbConnection){
		$this->productId = $productId;
		$this->dbConnection = $dbConnection;
	}
	
	public function getName(){
		if (!$this->name){
			$query = "SELECT name FROM products WHERE productId='".$this->productId."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->name = $row[0];
		}
		return $this->name;
	}
	
}