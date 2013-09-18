<?php
class User {

	private $userID;
	
	public function __construct($userID){
		$this->userID = $userID;
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
	
}