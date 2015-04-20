<DOCTYPE! html>
<html lang="es">
<head>
		<meta charset="utf-8" />
		<title>Listado</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<!--<link rel="stylesheet"  href="css/estilo.css">-->
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





		
			<div  align='center'>
				<a href="ReportePagos.php"><img src="img/logobodegon.JPG" ></a>
			</div>


					<table>
						
						<?php
							
							$link=mysqli_connect('localhost', 'root','','bodegon');

							if($Ruta!='Todas')
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

									echo "<div align='center'><h5>Total Pagos: $$TotalPagos </h5>";

									echo "<h5>Total Notas de Cargo: $$TotalNotasDeCargo</h5>";

								echo "<a href='ExportarExcelReportePagos.php?cmbRuta=$Ruta&txtFechaInicial=$FechaInicial&txtFechaFinal=$FechaFinal'>Exportar a Exccel</a></dvi>";

							}else
							{
								if($Ruta!="")
								{
									echo "<div align='center'>No se encontraron pagos</dvi>";
								}
							}

							
						?>

					</table>
			
	</body>
</html>