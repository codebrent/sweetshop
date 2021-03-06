<?php
class User {

	private $userID;
	private $username;
	private $passwordHash;
	private $firstName;
	private $lastName;
	private $email;
	private $address1;
	private $address2;
	private $suburb;
	private $city;
	private $phone;
	private $dbConnection;
	
	public function __construct($userID, $dbConnection){
		$this->userID = $userID;
		$this->dbConnection = $dbConnection;
	}

	
	/**
	 * @return string either success, failure, or userexists
	 */
	public function save(){
		if ($this->userID){ //existing ID, update details
			//will save items which have been set. Otherwise values are from the database
			$query = "UPDATE users SET `userId`='".mysqli_real_escape_string($this->dbConnection, $this->getUserID());
			$query .= "',`username`='".mysqli_real_escape_string($this->dbConnection, $this->getUsername());
			$query .= "',`password`='".mysqli_real_escape_string($this->dbConnection, $this->getPassword());
			$query .= "',`firstName`='".mysqli_real_escape_string($this->dbConnection, $this->getFirstName());
			$query .= "',`lastName`='".mysqli_real_escape_string($this->dbConnection, $this->getLastName());
			$query .= "',`phone`='".mysqli_real_escape_string($this->dbConnection, $this->getPhone());
			$query .= "',`email`='".mysqli_real_escape_string($this->dbConnection, $this->getEmail());
			$query .= "',`address1`='".mysqli_real_escape_string($this->dbConnection, $this->getAddress1());
			$query .= "',`address2`='".mysqli_real_escape_string($this->dbConnection, $this->getAddress2());
			$query .= "',`suburb`='".mysqli_real_escape_string($this->dbConnection, $this->getSuburb());
			$query .= "',`city`='".mysqli_real_escape_string($this->dbConnection, $this->getCity());
			$query .= "' WHERE `userId`='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";		
			
		} else { //new user, save new row
			//check username does not already exist
			if ($this->getUserID()){
				return "userexists";
			}
			//build query
			$query = "INSERT INTO users(`username`, `password`, `firstName`, `lastName`, `phone`, `email`, `address1`, `address2`, `suburb`, `city`) ";
			$query .= "VALUES ('".mysqli_real_escape_string($this->dbConnection, $this->username);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->passwordHash);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->firstName);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->lastName);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->phone);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->email);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->address1);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->address2);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->suburb);
			$query .= "','".mysqli_real_escape_string($this->dbConnection, $this->city)."')";
		}
		if (mysqli_query($this->dbConnection, $query)){
			return "success";
		} else {
			return "failure";
		}
	}
	
	/**
	 *
	 * @return bool true is password is correct otherwise false
	 */
	public function login($password){
		$this->getUserID(); //load userID from username
		$pw = $this->getPassword(); //load user password
		return ($pw == md5($password)) ? true : false;
	}
	
	
	public function getCart(){
		$query = "SELECT orderId FROM orders WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->getUserID())."' AND status='Pending'";
		$result = mysqli_query($this->dbConnection, $query);
		$row = $result->fetch_row();
		return $row[0];
	}
	
	public function getOrders(){
		$orders = array();
		$query = "SELECT orderId FROM orders WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->getUserID())."' AND (status='Ordered' OR status='Delivered') ORDER BY orderId DESC;";
		$result = mysqli_query($this->dbConnection, $query);
		while ($row = $result->fetch_assoc()) {
			$orders[] = new Order($row["orderId"], $this->dbConnection);
		}
		return $orders;
	}
	
	public function getUserID(){
		if (!$this->userID){
			$query = "SELECT userId FROM users WHERE username='".mysqli_real_escape_string($this->dbConnection, $this->username)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->userID = $row[0];
		}
		return $this->userID;
	}
	
	public function setUsername($username){
		$this->username = $username;
	}

	public function getUsername(){
		if (!$this->username){
			$query = "SELECT username FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->username = $row[0];
		}
		return $this->username;
	}
	
	public function setPassword($password){
		$this->passwordHash = md5($password);
	}

	public function getPassword(){
		if (!$this->passwordHash){
			$query = "SELECT password FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->passwordHash = $row[0];
		}
		return $this->passwordHash;
	}
	
	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}

	public function getFirstName(){
		if (!$this->firstName){
			$query = "SELECT firstName FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->firstName = $row[0];
		}
		return $this->firstName;
	}
		
	public function setLastName($lastName){
		$this->lastName = $lastName;
	}

	public function getLastName(){
		if (!$this->lastName){
			$query = "SELECT lastName FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->lastName = $row[0];
		}
		return $this->lastName;
	}	
	
	public function setAddress1($address1){
		$this->address1 = $address1;
	}

	public function getAddress1(){
		if (!$this->address1){
			$query = "SELECT address1 FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->address1 = $row[0];
		}
		return $this->address1;
	}
	
	public function setAddress2($address2){
		$this->address2 = $address2;
	}

	public function getAddress2(){
		if (!$this->address2){
			$query = "SELECT address2 FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->address2 = $row[0];
		}
		return $this->address2;
	}
	
	public function setSuburb($suburb){
		$this->suburb = $suburb;
	}

	public function getSuburb(){
		if (!$this->suburb){
			$query = "SELECT suburb FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->suburb = $row[0];
		}
		return $this->suburb;
	}

	public function setCity($city){
		$this->city = $city;
	}
	
	public function getCity(){
		if (!$this->city){
			$query = "SELECT city FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->city = $row[0];
		}
		return $this->city;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getEmail(){
		if (!$this->email){
			$query = "SELECT email FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->email = $row[0];
		}
		return $this->email;
	}
	
	public function setPhone($phone){
		$this->phone = $phone;
	}

	public function getPhone(){
		if (!$this->phone){
			$query = "SELECT phone FROM users WHERE userId='".mysqli_real_escape_string($this->dbConnection, $this->userID)."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->phone = $row[0];
		}
		return $this->phone;
	}

}