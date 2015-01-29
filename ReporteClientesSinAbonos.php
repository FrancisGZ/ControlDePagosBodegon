<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Clientes sin abonos</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>
	<body>

		<?php

			if(isset($_GET['boton']))
			{
				$boton=$_GET['boton'];
			}else
			{
				$boton="";
			}

			if(isset($_GET['cmbRuta']))
			{
				$Ruta=$_GET['cmbRuta'];
			}else
			{
				$Ruta="";
			}
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

		?>

	
			
			<div id='container'>
			<div id='encabezado'>
				<img src="img/logobodegon.JPG">
			</div>
			<nav id="menu">
				<ul>
				<li><a href="AltaPretarjeta.php">Pretarjeta</a></li>	
				<li><a href="AltaFactura.php">Factura</a></li>
				<li><a href="AplicarPago.php">Aplicar Pago</a></li>
	   			<li><a href="ConsultaSaldo.php">Consultar Cliente</a></li>
				<li><a href="#">Reportes</a>
					<ul>	
						<li><a href="ReportePagos.php">Reporte Pagos</a></li>
						<li><a href="EstadoDeCuenta.php">Estado de Cuenta</a></li>
						<li><a href="ReporteRecibosConsecutivos.php">Reporte Recibos</a></li>
						<li><a href="ReporteBonificacionCancelacion.php">Cancelaciones</a></li>
						<li><a href="ReporteContadosSinSaldar.php">Contados Sin Saldar</a></li>
						<li><a href="ReporteListado.php">Listado</a></li>
						<li><a href="ReporteSaleAlCobro.php">Sale al cobro</a></li>
						<li><a href="ReporteCuentasSinAbonos.php">Cuentas sin Abonos </a></li>
						<li><a href="ClientesSinAbonosEnFecha.php">Cuentas Vencidas</a></li>
					</ul>
				</li>
				</ul>
			</nav>
			<div id='formulario'>
				<form name='frmReporteCliente' method='get' action='ClientesSinAbonosEnFechaImprimir.php'>
					<table align='center'>
						<tr>
							<td colspan="2" align='center'><h2>Rango de Fechas sin abonos</h2></td>
						</tr>
						<tr>
							<td>
								<label>Fecha Inicial:</label>
							</td>
							<td>
								<input id='txtFechaInicial' name='txtFechaInicial' type='date' value='<?php echo date('Y-m-d', strtotime($FechaInicial));  ?>' required>
							</td>
						</tr>
						<tr>
							<td>
								<label>Fecha Final:</label>
							</td>
							<td>
								<input id='txtFechaFinal' name='txtFechaFinal' type='date' value='<?php echo date('Y-m-d', strtotime($FechaFinal));  ?>' required>
							</td>
						</tr>
						<tr>
							<td>
								<label>Ruta:</label>
							</td>
							<td>
								<?php 

								$link=mysqli_connect('localhost','root','' , 'bodegon');

								$query="Select * from Rutas";


									?>
									<select id='cmbRuta' name='cmbRuta' required >
									<?php
									if($Ruta!=="")
									{
							
										echo"<option value=$Ruta>$Ruta</option>";
										echo"<option value=TODAS>TODAS</option>";
									}else
									{
										echo"<option value=TODAS>TODAS</option>";
									}		
					
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
							<td colspan='2' align='center'>
								<input id='boton' name='boton' type='submit' value='Generar Listado' >
							</td>
						</tr>
					</table>
							

					<?php



						$link=mysqli_connect('localhost','root','' , 'bodegon');

						$TotalCuentas=0;
						$SaldoTotal=0;
						if($boton=="Generar Listado")
				
						{

/*------------------------------------------Obtener clientes con pagos---------------------------------------------------*/
							

						if($Ruta=="TODAS")
						{
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) order by a.NombreCliente";
						}else
						{
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) where a.Ruta='$Ruta' order by a.NombreCliente";	
						}
						

					

						 $resultado=$link->query($query);

					

						echo "<table border='1px' align='center' width='auto' style='font-size:12px; margin:auto'>
								<tr>
									<td>Clave Cliente</td>
									<td>Factura</td>
									<td>Fecha Factura</td>
									<td>Nombre</td>
									<td>Domicilio</td>
									<td>Ultimo Recibo</td>
									<td>Saldo</td>
									<td>Saldo vencido puntual</td>
									<td>Saldo vencido normal</td>
									<td>Ruta</td>
								</tr>
								";



							while($renglon=$resultado->fetch_array())
							{

								
								$IdCliente=$renglon['IdCliente'];
								$NombreCliente=$renglon['NombreCliente'];
								$FechaFactura=$renglon['FechaFactura'];
								$IdFactura=$renglon['IdFactura'];
								$Ruta=$renglon['Ruta'];
								$Colonia=$renglon['Colonia'];
								$Calle=$renglon['Calle'];
								$Plazo=$renglon['Plazo'];
								$PagoPuntual=$renglon['PagoPuntual'];
								$PagoNormal=$renglon['PagoNormal'];
								$MontoTotalFactura=$renglon['MontoTotalFactura'];
								$SaldoFactura=$renglon['SaldoFactura'];

								$Saldo=ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link); 	
								

								if($Saldo>0)
								{


								$SaldoTotal=$SaldoTotal+$Saldo;


								$queryTotalPagosEnEstaFecha=("Select sum(MontoPago) as TotalPagos from pagos where FechaPago  Between '$FechaInicial' and '$FechaFinal'
																	and	IdFactura='$IdFactura' ");

								$resultadoTotalPagosEnEstaFecha=$link->query($queryTotalPagosEnEstaFecha);

								$renglonTotalPagosEnFecha=$resultadoTotalPagosEnEstaFecha->fetch_assoc();

								$TotalPagosEnEstaFecha=$renglonTotalPagosEnFecha['TotalPagos'];

								if($TotalPagosEnEstaFecha<=0)
								{	

								$queryUltimoReciboCapturado=("Select max(FechaPago) as FechaPago from pagos where IdFactura='$IdFactura'");


								$resultadoUltimoReciboCapturado=$link->query($queryUltimoReciboCapturado);

								$renglonUltimoReciboCapturado=$resultadoUltimoReciboCapturado->fetch_assoc();

								$FechaUltimReciboCapturado=$renglonUltimoReciboCapturado['FechaPago'];




								$SaldoPagoPuntual=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$PagoPuntual,$link);

								$SaldoPagoNormal=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$PagoNormal,$link);



					 			$Saldo=ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link);

					 			

					 			$Pagos=$MontoTotalFactura-$Saldo;

								$SaldoVencidoPagoPuntual=$SaldoPagoPuntual-$Pagos;
								$SaldoVencidoPagoNormal=$SaldoPagoNormal-$Pagos;



								if($Saldo>0)
								{
								

								echo "<tr>
										<td>$IdCliente</td>
										<td>$IdFactura</td>
										<td>$FechaFactura</td>
										<td>$NombreCliente</td>
										<td>$Colonia.$Calle</td>
										<td>$FechaUltimReciboCapturado</td>
										<td>$$Saldo</td>";
								if($SaldoVencidoPagoPuntual>0)
								{
								echo 	"<td>$$SaldoVencidoPagoPuntual</td>";
								}else{
								echo 	"<td>$0</td>";
								}
								if($SaldoVencidoPagoNormal>0)
								{
								echo 	"<td>$$SaldoVencidoPagoNormal</td>";
								}else
								{
								echo 	"<td>$0</td>";
								}	
								
								
								echo	"<td>$Ruta</td>
									</tr>";

									$TotalCuentas=$TotalCuentas+1;
								}
								}
								}	
							}

							echo "</table>";

							echo " <div align='center'><h5>Total: $".$SaldoTotal."</h5>";


							echo " <h5>Total Cuentas: ".$TotalCuentas."</h5>";


							echo "<a href='ExportarExcelListado.php?cmbRuta=$Ruta'>Exportar  a Excel</a></div>";
						}


			

function ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$Pago,$link)
{
	if($Plazo>0)
	{

				/*Verificar datos*/
				/*echo "</br>Fecha Factura: ".$FechaFactura;
				echo "</br>Fecha Actual: ".date('Y-m-d', strtotime('today'));*/
			
				$datetime1 = date_create($FechaFactura);//Fecha de la Factura
				$datetime2 =date_create(date('Y-m-d', strtotime('today')));//Fecha Actual
				$datetime1->add(new DateInterval('P7D'));//Sumas una semana para empezar el conteo de los pagos por semana
				


				$interval = $datetime1->diff($datetime2);
				$SemanasTranscurridas=floor(($interval->format('%a') / 7));

				
				/*echo "</br>Semanas transcurridas: ".$SemanasTranscurridas;

				 echo "</br>Semanas limite: ".$LimiteDeSemanas=ceil($Plazo*4.3);*/

				 
				 $LimiteDeSemanas=ceil($Plazo*4.3);

				 if($LimiteDeSemanas>=$SemanasTranscurridas)
				 {
					$Semanas=$SemanasTranscurridas;
					 
				}
				else{

					$Semanas=$LimiteDeSemanas;
				}

				$SaldoVencido=$Semanas*$Pago;
				return $SaldoVencido;

	}
}

				function ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoInicial, $link)
					{
								$query="select * from pagos where IdFactura='$IdFactura'";
			
								$result =$link->query($query);

								$pagosAplicados =0;
							while($row = $result->fetch_array())
								{
									$pagosAplicados=$pagosAplicados + $row["MontoPago"];
			
								}
								

								 if ($SaldoInicial>0) {
		 								

		 					 		$SaldoDB=$MontoTotalFactura-$SaldoInicial;
		 
		 							$Saldo=$MontoTotalFactura-($pagosAplicados+$SaldoDB);

							    }else
		 						{
		 							 $Saldo=$MontoTotalFactura-$pagosAplicados;
								}

									$result->free();
		
									return $Saldo;
					}

					
				?>

			
				</form>
			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>