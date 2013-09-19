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
	 * @return bool true if saved successfully, else false;
	 */
	public function save(){
		//check all the required fields are populated
		if (!$this->username || !$this->passwordHash || !$this->firstName ||
		    !$this->lastName || !$this->email || !$this->address1 || !$this->city){
			return false;
		}		
		if ($this->userID){ //existing ID, update details
			$query = "UPDATE users SET `userId`='".$this->userID."',`username`='".$this->username."',`password`='".$this->passwordHash."',`firstName`='".$this->firstName;
			$query .= "',`lastName`='".$this->lastName."',`phone`='".$this->phone."',`email`='".$this->email."',`address1`='".$this->address1."',`address2`='".$this->address2;
			$query .= "',`suburb`='".$this->suburb."',`city`='".$this->city."' WHERE ".$this->userID;			
			
		} else { //new user, save new row
			$query = "INSERT INTO users(`username`, `password`, `firstName`, `lastName`, `phone`, `email`, `address1`, `address2`, `suburb`, `city`) ";
			$query .= "VALUES ('".$this->username."','".$this->passwordHash."','".$this->firstName."','".$this->lastName."','".$this->phone."','";
			$query .= $this->email."','".$this->address1."','".$this->address2."','".$this->suburb."','".$this->city."')";
		}
		return mysqli_query($this->dbConnection, $query);
		
	}
	
	/**
	 *
	 * @param string $password
	 * @return bool true is password is correct otherwise false
	 */
	public function logon($password){
		$userPass = md5($password);
		$md5 = $this->getHashedPassword();
		return ($userPass == $md5) ? true : false;
	}
	
	/**
	 * @returns MD5 Hashed password or null if not found
	 */
	private function getHashedPassword(){
		$fileName = dirname(__DIR__).DIRECTORY_SEPARATOR.$this->passwordFile;
		$fileHandle = fopen($fileName, "r") or exit("Unable to open password file");
		$hashedPw = null;
		while(!feof($fileHandle)){
			$lineParts = explode(" ",fgets($fileHandle));
			$studentID = $lineParts[0];
			$md5Hash = $lineParts[1];
			if ($studentID == $this->studentID){
				$hashedPw = preg_replace("/\s+/", '', $md5Hash); //remove all write space and new lines
			}
		}
		fclose($fileHandle);
		return $hashedPw;
	}

	public function setUsername($username){
		$this->username = $username;
	}

	public function getUsername(){
		if (!$this->username){
			$query = "SELECT username FROM users WHERE userId='".$this->userID."'";
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
			$query = "SELECT password FROM users WHERE userId='".$this->userID."'";
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
			$query = "SELECT firstName FROM users WHERE userId='".$this->userID."'";
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
			$query = "SELECT lastName FROM users WHERE userId='".$this->userID."'";
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
			$query = "SELECT address1 FROM users WHERE userId='".$this->userID."'";
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
			$query = "SELECT address2 FROM users WHERE userId='".$this->userID."'";
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
			$query = "SELECT suburb FROM users WHERE userId='".$this->userID."'";
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
			$query = "SELECT city FROM users WHERE userId='".$this->userID."'";
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
			$query = "SELECT email FROM users WHERE userId='".$this->userID."'";
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
			$query = "SELECT phone FROM users WHERE userId='".$this->userID."'";
			$result = mysqli_query($this->dbConnection, $query);
			$row = $result->fetch_row();
			$this->phone = $row[0];
		}
		return $this->phone;
	}

}