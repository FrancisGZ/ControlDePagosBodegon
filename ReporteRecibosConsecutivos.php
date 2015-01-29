<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset='utf-8'>
		<title>Reporte Recibo</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>
	<body>

		<?php

			if(isset($_GET['txtRangoRecibo1']) && isset($_GET['txtRangoRecibo2']))
			{
				 $RangoRecibo1=$_GET['txtRangoRecibo1'];
				 $RangoRecibo2=$_GET['txtRangoRecibo2'];
			}else
			{
				$RangoRecibo1='';
				$RangoRecibo2='';
			}

		?>

		<div class="container">
			<?php 
				include_once "Menu_Header.html";
			?>
			<div class="formulario">
				<form name="frmReporteRecibo" method="get" action="ReporteRecibosConsecutivos.php">
					<table align="center" border="0px">
						<tr>
							<td>
								<label>Rango de recibos:</label>
							</td>
							<td>
								<input name="txtRangoRecibo1" type="text" value='<?php echo $RangoRecibo1 ?>' required>
							</td>

							<td>
								<input name="txtRangoRecibo2" type="text" value='<?php echo $RangoRecibo2 ?>' required>
							</td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2" align="center">
								<input  name="btnBuscarRecibo" type="submit" value="Buscar Recibos" >
							</td>
						</tr>
					</table>
					<table>

					<?php
						
						$link=mysqli_connect('localhost','root','','bodegon');

					

						$query="select a.IdCliente,a.NombreCliente,b.IdFactura,c.IdPago,c.MontoPago, c.FechaPago,a.Ruta,c.TipoDocumento
								from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)
								inner join pagos as c on (b.IdFactura=c.IdFactura)
								where c.IdPago between $RangoRecibo1 and $RangoRecibo2";

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

								 $Contador=$RangoRecibo1;

								$SumatoriaPagos=0;
				
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

						
								$bandera=False;
								while ($bandera==False) {
									
					
									if ($IdRecibo==$Contador)
								{
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

									$bandera=True;
									$SumatoriaPagos=$SumatoriaPagos+$Pago;
								}else
								{
									echo "<tr>
										<td colspan='8' align='center' bgcolor='#FA5882'>Folio: "; echo $Contador. " No encontrado</td>
									</tr>
									";
									
									$bandera=False;
								}
								
								$Contador++;
								
							}

							
								
							}

							$bandera2=False;

							while ($bandera2==False) {

									if($Contador<=$RangoRecibo2)
									{
										echo "<tr>
										<td colspan='8' align='center' bgcolor='FA5882'>Folio: "; echo $Contador. " No encontrado</td>
										</tr>
										";
									
										$bandera=False;
									}
									else
									{
										$bandera2=True;
									}
									 $Contador++;
								}	

						
								echo "<tr>
										<td colspan=9 align='center'>Total: $"; echo $SumatoriaPagos; echo"</td>
									</tr>
								</table>"	;
								
						}/*else
						{
							if($RangoRecibo1!=0 && $RangoRecibo2!=0)
							{
							echo "No se encontraron  recibos";
							}
						}*/
						
					?>	

				</form>
			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>