<?php
class Product {

	private $productId;
	private $categoryId;
	private $name;
	private $description;
	private $stock;
	private $weight;
	private $price;
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

	public function getImageName($size = ""){
		$padded = str_pad($this->productId, 4, "0",STR_PAD_LEFT);
		if ($size=="small"){
			$small="s";
		} else {
			$small = "";
		}
		return "public/img/catalog/".$padded.$small.".jpg";
	}
	
	public function getDescription($size = ""){
		if (!$this->description){
			$query = "SELECT description FROM products WHERE productId='".$this->productId."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->description = $row[0];
		}
		if ($size=="short" && strlen($this->description) > 100){
			return substr($this->description, 0, 100)." ...";
		} else {
			return $this->description;
		}
	}
	
	public function getStock(){
		if (!$this->stock){
			$query = "SELECT stock FROM products WHERE productId='".$this->productId."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->stock = $row[0];
		}
		return $this->stock;
	}
	
	public function getWeight(){
		if (!$this->weight){
			$query = "SELECT weight FROM products WHERE productId='".$this->productId."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->weight = $row[0];
		}
		return $this->weight;
	}

	public function getPrice(){
		if (!$this->price){
			$query = "SELECT price FROM products WHERE productId='".$this->productId."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->price = $row[0];
		}
		return $this->price;
	}		

	public function getCategoryId(){
		if (!$this->categoryId){
			$query = "SELECT categoryId FROM products WHERE productId='".$this->productId."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->categoryId = $row[0];
		}
		return $this->categoryId;
	}
	
	public function getProductId(){
		return $this->productId;
	}
}