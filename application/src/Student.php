<?php
namespace ASA;

use ASA\Paper;


class Student {

	private $studentID;
	private $papers;
	private $passwordFile = "data/auth.txt";
	private $enrolmentFile = "data/enrolments.txt";
	
	public function __construct($studentID){
		$this->studentID = $studentID;
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
	 * @return array of Papers student is enrolled in. returns null if not found.
	 */
	public function getPapers(){
		if($this->papers == null){  //lazy initation of variable to minimise file I/O
			$fileName = dirname(__DIR__).DIRECTORY_SEPARATOR.$this->enrolmentFile;
			$fileHandle = fopen($fileName, "r") or exit("Unable to open enrolment file");
			$papers = null;
			while(!feof($fileHandle)){
				$lineParts = explode(" ",fgets($fileHandle));
				$studentID = array_shift($lineParts); //move first item off array which is the student ID. Just leaves list of papers in the array
				if ($studentID == $this->studentID && sizeof($lineParts) > 0){
					$this->papers = array();
					foreach($lineParts as $paperNumber){
						$cleanPaperNumber = preg_replace("/\s+/", '', $paperNumber); //remove all write space and new lines
						$this->papers[] = new Paper($cleanPaperNumber);
					}
				}
			}
			fclose($fileHandle);
		}
		return $this->papers;
		
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