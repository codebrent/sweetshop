<?php
namespace ASA;

class Filer {
	
	private $baseTargetDir;
	private $filename;
	private $tempname;
	private $paperNo;
	private $assignmentNo;
	private $target;
	
	public function __construct($uploadFileName, $uploadTempName, $uploadPaperNo, $uploadAssignmentNo){
		$ds = DIRECTORY_SEPARATOR;
		$this->baseTargetDir = __DIR__.$ds."..".$ds."..".$ds."files"; 
		$this->filename = $uploadFileName;
		$this->tempname = $uploadTempName;
		$this->paperNo = $uploadPaperNo;
		$this->assignmentNo = $uploadAssignmentNo;
	}
	
	/**
	 * Uploads in format files/paper number/year/semester number/assignment number/student id.ext.000 
	 * @return string name of file uploaded if true, null if error
	 */
	public function upload($studentID){
		$ds = DIRECTORY_SEPARATOR;

		$year = Reporter::getYear();
		$semester = Reporter::getSemester();

		try {
			if (!is_uploaded_file($this->tempname)){
				throw new \Exception('$this->tempname is empty');
			}
			$targetDir = $this->baseTargetDir.$ds.$this->paperNo.$ds.$year.$ds.$semester.$ds.$this->assignmentNo;
			if (!file_exists($targetDir)) {
				mkdir($targetDir,0777,true);
			}
			$extension = pathinfo($this->filename, PATHINFO_EXTENSION);
			$fullTarget = $targetDir.$ds.$studentID.'.'.$extension.'.000';
			$extCounter = '1';
			while (file_exists($fullTarget)){
				$extPaddedCounter = str_pad($extCounter, 3, '0', STR_PAD_LEFT);
				$fullTarget = $targetDir.$ds.$studentID.'.'.$extension.'.'.$extPaddedCounter;
				$extCounter++;
			}
			if(!move_uploaded_file($this->tempname,$fullTarget)){
				return null;
			}
			$fn = substr($this->filename, strrpos($this->filename, DIRECTORY_SEPARATOR));
			return $fn;
		} catch (\Exception $e){
			return null;
		}
	}
	
}