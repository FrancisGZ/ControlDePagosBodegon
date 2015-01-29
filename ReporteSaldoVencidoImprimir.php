<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Listado</title>
		<link rel="stylesheet"  href="css/normalize.css">
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

		?>

	
			<div  align='center'>
				<a href="ReporteListado.php"><img src="img/logobodegon.JPG" ></a>
			</div>
			
							

					<?php
						$link=mysqli_connect('localhost','root','' , 'bodegon');

						$TotalCuentas=0;
						$SaldoTotal=0;
						if($boton=="Generar Listado")
						{


						

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
								$SaldoInicial=$renglon['SaldoInicialFactura'];
								$NotasDeCargoIniciales=$renglon['NotasDeCargo'];

								$Saldo=ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoInicial,$NotasDeCargoIniciales, $link); 	
								$SaldoTotal=$SaldoTotal+$Saldo;



								$queryUltimoReciboCapturado=("Select max(FechaPago) as FechaPago from pagos where IdFactura='$IdFactura'");


								$resultadoUltimoReciboCapturado=$link->query($queryUltimoReciboCapturado);

								$renglonUltimoReciboCapturado=$resultadoUltimoReciboCapturado->fetch_assoc();

								$FechaUltimReciboCapturado=$renglonUltimoReciboCapturado['FechaPago'];




								$SaldoPagoPuntual=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$PagoPuntual,$link);

								$SaldoPagoNormal=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$PagoNormal,$link);



					 			$Saldo=ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoInicial,$NotasDeCargoIniciales, $link);

					 			

					 			$Pagos=$MontoTotalFactura-$Saldo;

								$SaldoVencidoPagoPuntual=$SaldoPagoPuntual-$Pagos;
								$SaldoVencidoPagoNormal=$SaldoPagoNormal-$Pagos;

								$VerificarSaldoVencido=VerificarSaldoVencido($SaldoPagoNormal,$Dias);

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

							echo "</table>";

							echo " <div align='center'><h5>Total: $".$SaldoTotal."</h5>";


							echo " <h5>Total Cuentas: ".$TotalCuentas."</h5>";


							//echo "<a href='ExportarExcelListado.php?cmbRuta=$Ruta'>Exportar  a Excel</a></div>";
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

				function ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoInicial, $NotasDeCargoIniciales,$link)
					{
								$query = "select * from pagos where IdFactura='$IdFactura'";
			
								$result = $link -> query($query);

								$pagosAplicados = 0;
								$NotasDeCargo   = 0;

							while($renglon = $result -> fetch_array())
								{
									$pagosAplicados = $pagosAplicados + $renglon['MontoPago'];

									if($renglon['TipoDocumento']=='Nota de Cargo')
									{
										$NotasDeCargo = $NotasDeCargo + $renglon['MontoPago'];
									}
			
								}
								

								 if ($SaldoInicial>0) {
		 								

		 					 		$SaldoDB=$MontoTotalFactura-($SaldoInicial+$NotasDeCargoIniciales);
		 
		 							$Saldo=$MontoTotalFactura-($pagosAplicados+$SaldoDB-$NotasDeCargo);

							    }else
		 						{
		 							 $Saldo=$MontoTotalFactura-$pagosAplicados;
								}

									$result->free();
		
									return $Saldo;
					}

					
				?>

			
	</body>
</html>