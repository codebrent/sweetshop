<?php
namespace ASA;

class Layout{
	
	private $layoutFile = "templates/layout/layout.phtml";
	private $viewData;
	
	public function __construct($viewData){
		$this->viewData = $viewData;
	}
	
	public function display(){
		$fileName = dirname(__DIR__).DIRECTORY_SEPARATOR.$this->layoutFile;
		
		//import the template file
		ob_start();
		require $fileName;
		$page = ob_get_contents();
		ob_clean();
		
		echo $page;
	}
	
}