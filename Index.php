<?php
 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	require "Config/Autoload.php";
	require "Config/Config.php";

	use Config\Autoload as Autoload;
	use Config\Router 	as Router;
	use Config\Request 	as Request;
		
	Autoload::start();

	session_start();

	require_once(VIEWS_PATH."Header.php");

	Router::Route(new Request());

	require_once(VIEWS_PATH."Footer.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pet Hero</title>
</head>
<body>
	<center>
        <a href="views/login.php">Iniciar Sesion</a><br>
        <a href="views/signup.php">Registrarse</a>
    </center>
</body>
</html>