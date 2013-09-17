<?php
namespace ASA;

class Paper {

	private $paperID;
	private $numberOfAssignments;
	private $dataFile = "data/papers.txt";
	
	public function __construct($paperID){
		$this->paperID = $paperID;
	}

	public function getPaperID(){
		return $this->paperID;
	}
	
	/**
	 * @param string $paperID
	 * @return int Returns number of assignments required for the paper
	 */
	public function getNumberOfAssigments(){
		if($this->numberOfAssignments == null){  //lazy initation of variable to minimise file I/O
			$fileName = dirname(__DIR__).DIRECTORY_SEPARATOR.$this->dataFile;
			$fileHandle = fopen($fileName, "r") or exit("Unable to open papers file");
			$numberOfAssignments = null;
			while(!feof($fileHandle)){
				$line = preg_replace("/\s+/", ' ', fgets($fileHandle)); //gets rid of any newlines
				$lineParts = explode(" ",$line);
				if (isset($lineParts[1])){  //makes sure an extra new line does not cause an error
					$paperID = $lineParts[0];
					$quantity = $lineParts[1];
					if ($paperID == $this->paperID){
						$this->numberOfAssignments = $quantity;
					}
				}
			}
			fclose($fileHandle);
		}
		return $this->numberOfAssignments;
	}
	
}