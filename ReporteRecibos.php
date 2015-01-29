<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Reporte Recibo</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>
	<body>

		<?php

			if(isset($_GET['txtIdRecibo']))
			{
				$IdRecibo=$_GET['txtIdRecibo'];
			}else
			{
				$IdRecibo='';
			}

		?>

		<div class="container">
				<?php 

					include_once "Menu_Header.html";

				?>
			<div id='formulario'>
				<form name='frmReporteRecibo' method='get' action='ReporteRecibos.php'>
					<table align='center'>
						<tr>
							<td>
								<label>Recibo:</label>
							</td>
							<td>
								<input id='txtIdRecibo' name='txtIdRecibo' type='text' value='<?php echo $IdRecibo ?>' required>
							</td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<input id='btnBuscarRecibo' name='btnBuscarRecibo' type='submit' value='Buscar Recibo' >
							</td>
						</tr>
					</table>
					<table>

					<?php
						
						$link=mysqli_connect('localhost','root','','bodegon');

						$query="select a.IdCliente,a.NombreCliente,b.IdFactura,c.IdPago,c.MontoPago, c.FechaPago,a.Ruta,c.TipoDocumento
								from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)
								inner join pagos as c on (b.IdFactura=c.IdFactura)
								where c.IdPago='$IdRecibo'";

						$resultado=$link->query($query);

						if(mysqli_affected_rows($link)>0)
						{


						echo "<table border='1px' align='center' width='900px'>
								<tr>
									<td>Clave Cliente</td>
									<td>Nombre</td>
									<td>Factura</td>
									<td>Recibo</td>
									<td>Pago</td>
									<td>Fecha</td>
									<td>Ruta</td>
									<td>Tipo de Documento</td>
								</tr>
								";



							while($renglon=$resultado->fetch_array())
							{
								$IdCliente=$renglon['IdCliente'];
								$NombreCliente=$renglon['NombreCliente'];
								$IdFactura=$renglon['IdFactura'];
								$IdRecibo=$renglon['IdPago'];
								$Pago=$renglon['MontoPago'];
								$Fecha=$renglon['FechaPago'];
								$Ruta=$renglon['Ruta'];
								$TipoDocumento=$renglon['TipoDocumento'];
								echo "<tr>
										<td>$IdCliente</td>
										<td>$NombreCliente</td>
										<td>$IdFactura</td>
										<td>$IdRecibo</td>
										<td>$$Pago</td>
										<td>$Fecha</td>
										<td>$Ruta</td>
										<td>$TipoDocumento</td>
									</tr>
									";
							}

							echo "</table>";
						}else
						{
							if($IdRecibo!='')
							{
								echo "No se encontro el recibo";
							}
						}



						
					?>	

				</form>
			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>