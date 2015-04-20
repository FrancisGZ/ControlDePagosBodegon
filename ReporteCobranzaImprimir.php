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


			include("Funciones.php");

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
				<a href="ReporteCobranza.php"><img src="img/logobodegon.JPG" ></a>
			</div>


					<table>
						
						<?php
							
							$link=mysqli_connect('localhost', 'root','','bodegon');

							if($Ruta!='Todas')
							{
								
									/*$query="select a.IdCliente,a.NombreCliente,b.IdFactura,sum(c.MontoPago) as Pagos,
									 a.Ruta, b.MontoTotalFactura,b.SaldoInicialFactura 
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where a.Ruta='$Ruta' and  c.fechaPago between '$FechaInicial' and '$FechaFinal'
									and c.TipoDocumento not in ('Cancelacion','Bonificacion','Nota de Cargo') group by b.idfactura
									order by  a.Ruta,a.NombreCliente";*/


									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,
									a.Ruta, b.MontoTotalFactura,b.SaldoInicialFactura 
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									where a.Ruta='$Ruta'
									order by  a.Ruta,a.NombreCliente";




							}
							else{
									/*$query="select a.IdCliente,a.NombreCliente,b.IdFactura,sum(c.MontoPago) as Pagos,
									 a.Ruta, b.MontoTotalFactura,b.SaldoInicialFactura
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									inner join pagos as c on (b.idFactura=c.IdFactura)
									where c.fechaPago between '$FechaInicial' and '$FechaFinal' 
									and c.TipoDocumento not in ('Cancelacion','Bonificacion','Nota de Cargo') group by b.idfactura
									order by  a.Ruta,a.NombreCliente";*/


									$query="select a.IdCliente,a.NombreCliente,b.IdFactura,
									a.Ruta, b.MontoTotalFactura,b.SaldoInicialFactura 
									from clientes as a inner join factura as b on (a.idCliente=b.IdCliente)
									order by  a.Ruta,a.NombreCliente";
								}
							
						
							$resultado=$link->query($query);

							if(mysqli_affected_rows($link)>0)
							{

								echo "<table border='1px' align='center' width='900px'>
									<tr>
										<td>Factura</td>
										<td>Clave cliente</td>
										<td>Nombre</td>
										<td>Pagos</td>
										<td>Saldo</td>
										<td>Ruta</td>
									</tr>
									";

									$TotalPagos=0;
									$SaldosTotales=0;
								while($renglon=$resultado->fetch_array())
								{
									$IdCliente=$renglon["IdCliente"];
									$NombreCliente=$renglon["NombreCliente"];
									$IdFactura=$renglon["IdFactura"];
									//$Pago=$renglon["Pagos"];
									
									$RutaCliente=$renglon["Ruta"];
									
									$MontoTotalFactura=$renglon["MontoTotalFactura"];
									$SaldoInicialFactura=$renglon["SaldoInicialFactura"];
									


									$saldo = Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura );


									 $queryPagos="select sum(MontoPago) as pagos from pagos where fechaPago between 
									 	'2015-01-01' and '2015-02-28' and idFactura='$IdFactura'  and TipoDocumento not in ('Cancelacion','Bonificacion','Nota de Cargo')";

									 $renglonPagos=ResultadoQuery($queryPagos);

									 $Pagos=$renglonPagos['pagos'];



									echo "<tr>
											<td>$IdFactura</td>
											<td>$IdCliente</td>
											<td>$NombreCliente</td>
											<td>$$Pagos</td>	
											<td>$saldo</td>										
											<td>$RutaCliente</td>
										</tr>";

									$TotalPagos=$TotalPagos+$Pagos;
									$SaldosTotales=$SaldosTotales+$saldo;
									$Porcentaje=100*($TotalPagos/$SaldosTotales);
									$Porcentaje=number_format($Porcentaje,2);


								}

								echo "</table>";




									echo "<div align='center'><h5>Total Pagos: $$TotalPagos </h5>
											<h5>Saldos: $$SaldosTotales</h5>
											<h5>Porcentaje: $Porcentaje %</h5>
											";

									

								echo "<a href='ReporteCobranzaExcel.php?cmbRuta=$Ruta&txtFechaInicial=$FechaInicial&txtFechaFinal=$FechaFinal'>Exportar a Excel</a></dvi>";

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