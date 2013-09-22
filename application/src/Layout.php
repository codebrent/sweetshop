<?php
class Layout{
	
	private $layoutFile = "templates/layout/layout.phtml";
	private $ajaxFile = "templates/layout/ajax.phtml";
	private $viewData;
	
	public function __construct($viewData){
		$this->viewData = $viewData;
	}
	
	public function display(){
		$type = (isset($this->viewData["type"])) ? $this->viewData["type"] : null;
		if ($type == "ajax"){
			$fileName = dirname(__DIR__).DIRECTORY_SEPARATOR.$this->ajaxFile;
		} else {
			$fileName = dirname(__DIR__).DIRECTORY_SEPARATOR.$this->layoutFile;
		}
		//import the template file
		ob_start();
		require $fileName;
		$page = ob_get_contents();
		ob_clean();
		
		echo $page;
	}
	
}