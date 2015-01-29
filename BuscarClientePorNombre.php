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
			<td>Factura</td>
		</tr>
<?php

	$query="Select * from clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)  where a.NombreCliente like '%$NombreCliente%'";


		$resultado=$link->query($query);


		while ($renglon=$resultado->fetch_array()) {
		
			$NombreCliente=$renglon['NombreCliente'];
			$IdCliente=$renglon['IdCliente'];
			$IdFactura=$renglon['IdFactura'];



			if($PaginaOrigen=="AplicarPago")
			{


			echo "<tr>
					<td><a href='AplicarPagoFacturaAccion.php?btnAccion=Buscar Factura&txtIdFactura=$IdFactura'>$NombreCliente</a></td>
					<td>$IdCliente</td>
					<td>$IdFactura</td>
				</tr>";
			}
			if($PaginaOrigen=="EstadoDeCuenta")
			{
					echo "<tr>
					<td><a href='EstadoDeCuentaAccion.php?btnAccion=Buscar por Clave&txtIdCliente=$IdCliente&txtNombreCliente=$NombreCliente&txtIdFactura=$IdFactura'>$NombreCliente</a></td>
					<td>$IdCliente</td>
					<td>$IdFactura</td>
				</tr>";
			}
		}



?>
</div><!--Div Formulario-->
</div><!--Div container-->
</body>
</html>