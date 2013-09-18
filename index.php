<?php 
$viewData = array(); //All application data is passed to the view through $viewData.

include 'application/includes/startup.php'; //loads all the classes, starts a session, parses all variables and sets screen.
include 'application/includes/pageController.php'; //loads required information into viewData.

$layout = new Layout($viewData);
$layout->display();

?>