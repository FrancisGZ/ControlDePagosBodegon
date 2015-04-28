<DOCTYPE! html>
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
require "config.php";
require "db/db.php";
require "helpers.php";

include_once "Menu_Header.html";

//llamar al controlador indicado

controller($_GET['url']);

/*
if(empty($_GET['url']))
{
	require "controllers/Index.php";
}
elseif ($_GET['url']=='AltaPretarjeta') 
{
	require "controllers/AltaPretarjetaController.php";
}
else
{
	header("HTTP/1.0 404 Not Found");
	exit("Pagina no encontrada");
}
*/

//var_dump($_GET);
				?>

			<div class="formulario">

			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>