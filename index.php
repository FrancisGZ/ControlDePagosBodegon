<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Pretarjetas sin facturar</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>
	<body>

		

		<div class="container">
				<?php 

// el  front end controller se encarga de configurar la aplicacion
require 'config.php';
require 'db/db.php';
require 'helpers.php';
include_once 'Menu_Header.html';


//library
require 'library/Request.php';
require 'library/Inflector.php';
//llamar al controlador indicado

if(empty($_GET['url']))
{
	$url = "";
}
else
{
	$url = $_GET['url'];
}

$request = new Request($url);

//var_dump($request->getActionMethodName());

$request->execute();

				?>

			
		</div><!--Container-->
	</body>
</html>