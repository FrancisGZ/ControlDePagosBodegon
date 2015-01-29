<DOCTYPE! html>
<html lang="es">
<head>
	<meta charset='utf-8'>
	<title>Buscar Cliente por Nombre</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/estilo.css">
</head>

<body>

<?php
	


	$NombreCliente=$_GET['txtNombreCliente'];

	$PaginaOrigen=$_GET['txtPaginaOrigen'];


	$link=mysqli_connect('localhost','root','','bodegon');


	?>

<div class="container">
	
	<?php

		include_once ("Menu_Header.html");
	?>


	<div class="formulario">
	<table align="center" border="1px">
		<tr>
			<td>Nombre Cliente</td>
			<td>Clave Cliente</td>
		</tr>
<?php

	$query="Select * from clientesTemporal as a inner join facturatemporal as b on (a.NumeroDePretarjeta=b.NumeroDePretarjeta)  where a.NombreCliente like '%$NombreCliente%'";


		$resultado=$link->query($query);


		while ($renglon=$resultado->fetch_array()) {
		
			$NombreCliente=$renglon['NombreCliente'];
			$NumeroDePretarjeta=$renglon['NumeroDePretarjeta'];
	



			if($PaginaOrigen=="AplicarPagoPretarjeta")
			{


			echo "<tr>
					<td><a href='AplicarPagoPretarjetaAccion.php?btnAccion=Buscar Pretarjeta&txtNumeroDePretarjeta=$NumeroDePretarjeta'>$NombreCliente</a></td>
					<td>$NumeroDePretarjeta</td>
				</tr>";
			}
			if($PaginaOrigen=="EstadoDeCuentaPretarjeta")
			{
					echo "<tr>
					<td><a href='EstadoDeCuentaPretarjetaAccion.php?btnAccion=Buscar Pretarjeta&txtNumeroDePretarjeta=$NumeroDePretarjeta'>$NombreCliente</a></td>
					<td>$NumeroDePretarjeta</td>
				</tr>";
			}
		}



?>
</div><!--Div Formulario-->
</div><!--Div container-->
</body>
</html>