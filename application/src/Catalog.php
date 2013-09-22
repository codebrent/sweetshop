<?php
class Catalog {

	private $dbConnection;
	
	public function __construct($dbConnection){
		$this->dbConnection = $dbConnection;
	}
	
	/**
	 * 
	 * @param string $searchString
	 */
	public function search($searchString){
		$query = "SELECT * FROM products WHERE name LIKE '%".$searchString."%' ORDER BY name ASC;";
		$result = mysqli_query($this->dbConnection, $query);
		$returnSet = array();
		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$returnSet[] = array('label' => $row['name'], 'id' => $row['productId']);
			}
		}
		return $returnSet;
	}
}