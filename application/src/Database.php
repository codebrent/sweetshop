<?php
class Database{
	
	private $host = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "sweetshop";
	
	private $dbConnection;
		
	public function __construct(){
	}
	
	/*
	 * Connets to application database
	 */
	public function getDbConnection(){
		if (!$this->dbConnection){
			$this->dbConnection = mysqli_connect($this->host,$this->username,$this->password,$this->dbname);			
			if (mysqli_connect_errno($this->dbConnection)){
  					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				    die;
  			}
		} 
		return $this->dbConnection;
	}
	
	public function closeDb(){
		if ($this->dbConnection){	
			mysqli_close($con);
			$this->dbConnection = null;
		}
	}
	
	
}