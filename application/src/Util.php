<?php
class Util{
	
	/*
	 * Trims spaces, cuts to max of 60 characters, and removes any non alphanumeric characters
	 */
	public static function cleanPostText($string){
		$clean = trim($string);
		$clean = substr($clean,0,60);
		$clean = preg_replace("/[^A-Za-z0-9 ]/", "", $clean);
		return $clean;
	}

	/*
	 * Trims spaces, cuts to max of 60 characters, and encodes for sql
	*/
	public static function cleanPostSql($string, $db){
		$clean = trim($string);
		$clean = substr($clean,0,60);
		$clean = mysqli_real_escape_string($db, $string);
		return $clean;
	}

	/*
	 * Trims spaces, cuts to max of 60 characters, and allows only numeric
	*/
	public static function cleanPostNumber($string){
		$clean = trim($string);
		$clean = substr($clean,0,60);
		$clean = preg_replace("/[^0-9]/", "", $clean);
		return $clean;
	}
	
}