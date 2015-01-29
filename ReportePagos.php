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

			
		?>





		<div class="container">
			<?php
				include_once "Menu_Header.html"
			?>
			<div class="formulario">
				<form method="get" name="frmReportePago" action="ReportePagosImprimir.php">
					<table align="center">
						<tr>
							<td>	
								<label>Fecha Inicial:</label>
							</td>
							<td>
								<input  name="txtFechaInicial" type="date" value="<?php echo date('Y-m-d', strtotime($FechaInicial));  ?>" required>
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
							<?php

							
							 $link=mysqli_connect('localhost','root','' , 'bodegon');

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
							<td colspan="2"  align="center">
								<input name="btnReporte" type="submit" value="Reporte">
							</td>	
						</tr>
					</table>


					<table>
						
						<?php
							


							if($Ruta!="Todas")
							{
									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,c.MontoPago as Pagos,
									c.FechaPago as FechaUltimoPago, a.Ruta, c.IdPago, c.TipoPago, c.TipoDocumento
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where a.Ruta='$Ruta' and  c.fechaPago between '$FechaInicial' and '$FechaFinal'
									and c.TipoDocumento not in ('Cancelacion','Bonificacion')
									order by a.NombreCliente";

							}
							else{
									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,c.MontoPago as Pagos,
									c.FechaPago as FechaUltimoPago, a.Ruta, c.IdPago, c.TipoPago,c.TipoDocumento
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where c.fechaPago between '$FechaInicial' and '$FechaFinal' 
									and c.TipoDocumento not in ('Cancelacion','Bonificacion')
									order by a.NombreCliente";
								}
							
						
							$resultado=$link->query($query);

							if(mysqli_affected_rows($link)>0)
							{

								echo "<table border='1px' align='center' width='900px'>
									<tr>
										<td>Clave cliente</td>
										<td>Nombre</td>
										<td>Factura</td>
										<td>Pagos</td>
										<td>Notas de Cargo</td>
										<td>Tipo Documento</td>
										<td>Fecha Pago</td>
										<td>Recibo</td>
										<td>Ruta</td>
									</tr>
									";

									$TotalPagos=0;
									$TotalNotasDeCargo=0;
								while($renglon=$resultado->fetch_array())
								{
									$IdCliente=$renglon["IdCliente"];
									$NombreCliente=$renglon["NombreCliente"];
									$IdFactura=$renglon["IdFactura"];
									$Pago=$renglon["Pagos"];
									$FechaUltimoPago=$renglon["FechaUltimoPago"];
									$RutaCliente=$renglon["Ruta"];
									$Recibo=$renglon["IdPago"];
									$TipoPago=$renglon["TipoPago"];
									$TipoDocumento=$renglon["TipoDocumento"];


										

									echo "<tr>
											<td>$IdCliente</td>
											<td>$NombreCliente</td>
											<td>$IdFactura</td>";

										if($TipoDocumento=="Pago")
										{
											$TotalPagos=$TotalPagos+$Pago;
											echo"<td>$$Pago</td>
												 <td></td>";	
										}

										if($TipoDocumento=="Nota de Cargo")
										{
											$TotalNotasDeCargo=$TotalNotasDeCargo+$Pago;
											echo"<td></td>
												<td>$$Pago</td>";
										}
										
									echo"	<td>$TipoDocumento</td>
											<td>$FechaUltimoPago</td>
											<td>$Recibo</td>
											<td>$RutaCliente</td>
										</tr>";

									

								}

								echo "</table>";

									echo "<h5>Total Pagos: $$TotalPagos </h5>";

									echo "<h5>Total Notas de Cargo: $$TotalNotasDeCargo</h5>";

								echo "<a href='ExportarExcelReportePagos.php?cmbRuta=$Ruta&txtFechaInicial=$FechaInicial&txtFechaFinal=$FechaFinal'>Exportar a Exccel</a>";

							}else
							{
								if($Ruta!="")
								{
									echo "No se encontraron pagos";
								}
							}

							
						?>

					</table>
				</form>
			</div><!--fin de formulario-->
		</div><!--container-->
	</body>
</html>