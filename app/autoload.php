<?php
	//PHP 7 >
	spl_autoload_register(function ($class_name) {
		include_once(__DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class_name . '.class.php');
	});
	
	//Obsoleto
	/*
	function __autoload($classname) {
		include_once(__DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class_name . '.class.php');
	}
	*/
?>