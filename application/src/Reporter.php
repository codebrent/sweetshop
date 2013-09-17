<?php
namespace ASA;

class Reporter {

	/**
	 * 
	 * @return string
	 */
	static public function getYear(){
		return date("Y");
	}
	
	/**
	 * 
	 * @return string
	 */
	static public function getSemester(){
		$curDate = date("md");
		if ($curDate < "0701"){
			return "1";
		} else {
			return "2";
		}
	}

	/**
	 * 
	 * @param string $studentID
	 * @return array containing lines in the format (paperID, AssingmentNo, Submitted, TimesSubmitted)
	 */
	static public function getStats($studentID){
		$stats = Array();
		$student = new Student($studentID);
		$papers = $student->getPapers();
		if ($papers){
			foreach($papers as $paper){
				$paperNo = $paper->getPaperID();
				$numA = $paper->getNumberOfAssigments();
				for( $i=0 ; $i<$numA ; $i++ ){
					$totalSubmits = Reporter::getTotalSubmits($paperNo, $i+1, $studentID);
					$submitted = ($totalSubmits == 0) ? "No" : "Yes";
					$statsLine = Array($paperNo, $i+1, $submitted, $totalSubmits);
					$stats[] = $statsLine;	
				}
			}		
		}		
		return $stats;
	}
	
	static private function getTotalSubmits($paperNo,$numA,$studentID){
		$year = Reporter::getYear();
		$semester = Reporter::getSemester();
		//Get contents of directory where current assignments saved
		$ds = DIRECTORY_SEPARATOR;
		$baseDir = __DIR__.$ds."..".$ds."..".$ds."files";
		$saveDir = $baseDir.$ds.$paperNo.$ds.$year.$ds.$semester.$ds.$numA;
		if (file_exists($saveDir)){
			$dirContents = scandir($saveDir);
			$studentItems = array();
			foreach($dirContents as $dirLine){
				if (strpos($dirLine,$studentID) === 0){
					$studentItems[] = $dirLine;
				}	
			}
			return count($studentItems);
		} else {
			return 0;
		}		
	}

	
}