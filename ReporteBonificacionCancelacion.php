<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset='utf-8'>
		<title>Reporte</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>

	<body>

		<?php
			if(isset($_GET['txtFechaInicial']))
			{
					
				$FechaInicial=$_GET['txtFechaInicial'];
			}else
			{
				
				$FechaInicial=date('Y-m-d', strtotime('today')); 
			}

			if(isset($_GET['txtFechaFinal']))
			{	
				
				$FechaFinal=$_GET['txtFechaFinal'];
			}else
			{
				
				$FechaFinal=date('Y-m-d', strtotime('today'));
			}

			if(isset($_GET['cmbRuta']))
			{
				$Ruta=$_GET['cmbRuta'];
			}else
			{
				$Ruta='';
			}

			if(isset($_GET['cmbTipoDocumento']))
			{
				$TipoDocumento=$_GET['cmbTipoDocumento'];
			}else
			{
				$TipoDocumento='';
			}			
		?>





		<div class="container">
				<?php

					include_once "Menu_Header.html";
				?>
			<div class="formulario">
				<form method="get" name="frmReportePago" action="ReporteBonificacionCancelacion.php">
					<table align="center">
						<tr>
							<td>	
								<label>Fecha Inicial:</label>
							</td>
							<td>
								<input name="txtFechaInicial" type="date" value="<?php echo date('Y-m-d', strtotime($FechaInicial));  ?>" required>
							</td>	
						</tr>
						<tr>
							<td>
								<label>Fecha Final:</label>
							</td>
							<td>
								<input name="txtFechaFinal" type="date" value="<?php echo date('Y-m-d', strtotime($FechaFinal));  ?>" required>
							</td>
						</tr>
						<tr>
							<td>
								<label>Ruta:</label>
							</td>
							<td>
							<?php $link=mysqli_connect('localhost','root','' , 'bodegon');

								$query="Select * from Rutas where IdRuta not in ('$Ruta')"


							?>
							<select name="cmbRuta" required>
								<?php	
									if($Ruta!="")
									{
										echo "<option value='$Ruta'>$Ruta</option>";		
									}
								
								?>
								<option value="Todas">Todas</option>
								<?php
								$resultado=$link->query($query);


								while($renglon=$resultado->fetch_array())
								{
									echo "<option value='$renglon[IdRuta]'>$renglon[IdRuta]</option>";
								}
								?>
							</select>
							</td>
						</tr>
						<tr>
							<td>
								<label>Tipo:</label>
							</td>
							<td>
								<select  name="cmbTipoDocumento" required>
								<?php
									
										
								
									if($TipoDocumento=='Bonificacion')
									{
										echo "<option value='Bonificacion'>Bonificaciones</option>
											<option value='Cancelacion'>Canceladas</option>";
									}else
									{
										echo "<option value='Cancelacion'>Canceladas</option>
												<option value='Bonificacion'>Bonificaciones</option>";
									}


								?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2"  align="center">
								<input name="btnReporte" type="submit" value="Reporte">
							</td>	
						</tr>
					</table>


					<table>
						
						<?php
							

							if($Ruta!="Todas")
							{
									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,sum(c.MontoPago) as Pagos,
									Max(c.FechaPago) as FechaUltimoPago, a.Ruta, c.IdPago, c.TipoDocumento
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where a.Ruta='$Ruta' and c.TipoDocumento='$TipoDocumento' and c.fechaPago between '$FechaInicial' and '$FechaFinal'
									group by a.idCliente";

							}
							else{
									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,sum(c.MontoPago) as Pagos,
									Max(c.FechaPago) as FechaUltimoPago, a.Ruta, c.IdPago, c.TipoDocumento
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where   c.TipoDocumento='$TipoDocumento' and c.fechaPago between '$FechaInicial' and '$FechaFinal'
									group by a.idCliente ";

								}
							


							$resultado=$link->query($query);


							if(mysqli_affected_rows($link)>0)
							{
								echo "<table border='1px' align='center' width='900px'>
									<tr>
										<td>Clave cliente</td>
										<td>Nombre</td>
										<td>Factura</td>
										<td>Monto</td>
										<td>Fecha </td>
										<td>Recibo</td>
										<td>Ruta</td>
										<td></td>
									</tr>
									";

										$SumatoriaPagos=0;
										
								while($renglon=$resultado->fetch_array())
								{
									$IdCliente=$renglon["IdCliente"];
									$NombreCliente=$renglon["NombreCliente"];
									$IdFactura=$renglon["IdFactura"];
									$Pago=$renglon["Pagos"];
									$FechaUltimoPago=$renglon["FechaUltimoPago"];
									$Ruta=$renglon["Ruta"];
									$Recibo=$renglon["IdPago"];
									$CancelacionBonificacion=$renglon["TipoDocumento"];

									echo "<tr>
											<td>$IdCliente</td>
											<td>$NombreCliente</td>
											<td>$IdFactura</td>
											<td>$Pago</td>
											<td>$FechaUltimoPago</td>
											<td>$Recibo</td>
											<td>$Ruta</td>
											<td>$CancelacionBonificacion</td>
										</tr>";

										$SumatoriaPagos=$SumatoriaPagos+$Pago;
								}

								echo "<tr>
										<td colspan=9 align='center'>Total: $"; echo $SumatoriaPagos; echo"</td>
									</tr>
								</table>"	;
							}else
							{
								if($Ruta!='')
								{
									echo "No existen registros";
								}
							}

							
						?>

					</table>
				</form>
			</div><!--fin de formulario-->
		</div><!--container-->
	</body>
</html>