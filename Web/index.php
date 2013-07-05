<?php session_start();

	define('BASE', '');
	define('APPLICATIONS_PATH', '../Applications/');
	
	require_once '../Core/Autoloader.class.php';
	require_once '../Core/Functions.php';
	
	$Autoloader = Autoloader::getInstance();
	
	$Appli = new Core_Application('Front');
	$Appli->run();
	