<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset='utf-8'>
		<title>Estado de Cuenta</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>
	<body>

		<?php

			include("Funciones.php");

			

			if(isset($_GET["txtNumeroDePretarjeta"]))
			{
				$NumeroDePretarjeta = $_GET["txtNumeroDePretarjeta"];
			}else
			{
				$NumeroDePretarjeta = "";
			}


			if(isset($_GET["txtNombreCliente"]))
			{
				$NombreCliente=$_GET["txtNombreCliente"];
			}
			else{

				$NombreCliente="";
			}



			


			if(isset($_GET["txtMontoTotalFactura"]))
			{
				$MontoTotalFactura=$_GET["txtMontoTotalFactura"];
			}
			else
			{
				$MontoTotalFactura=0;
			}


			if(isset($_GET["txtFechaFactura"]))
			{
				$FechaFactura=$_GET["txtFechaFactura"];
			}
			else
			{
				$FechaFactura="";
			}

			if(isset($_GET["txtFechaPrimerPago"]))
			{
				$FechaPrimerPago=$_GET["txtFechaPrimerPago"];
			}
			else
			{
				$FechaPrimerPago="";
			}


			if(isset($_GET["txtPagoPuntual"]))
			{
				$PagoPuntual=$_GET["txtPagoPuntual"];
			}
			else
			{
				$PagoPuntual=0;
			}


			if(isset($_GET["txtPagoNormal"]))
			{
				$PagoNormal=$_GET["txtPagoNormal"];
			}
			else
			{
				$PagoNormal=0;
			}

			if(isset($_GET["txtPlazo"]))
			{
				$Plazo=$_GET["txtPlazo"];
			}
			else
			{
				$Plazo=0;
			}


			if(isset($_GET["Mensaje"]))
			{
					$Mensaje=$_GET['Mensaje'];

					?>
					<script >
					Mensaje="<?php echo $Mensaje  ?>";
					alert(Mensaje);
				</script>
					<?php
			}


			


		?>

		<div class="container">
				<?php

					include_once("Menu_Header.html");
				?>
			<div class="formulario">
				<form name="frmReporteCliente" method="get" action="EstadoDeCuentaPretarjetaAccion.php">
					<table align="center">
						<tr>
							<td>
								<label>Numero de Pretarjeta:</label>
							</td>
							<td>
								<input name='txtNumeroDePretarjeta' type='text' value='<?php echo $NumeroDePretarjeta ?>' >
								<input name='btnAccion' type='submit' value='Buscar Pretarjeta' >
							</td>
						</tr>
						<tr>
							<td>
								<label>Nombre Cliente:</label>
							</td>	
							<td>
								<input  name='txtNombreCliente' type='text' value='<?php echo $NombreCliente?>' >
								<input  name='btnAccion' type='submit' value='Buscar por Nombre' >
							</td>
						</tr>
					</table>
					

		<?php
						
			

					$TotalPagos=0;
					$NotasDeCargo=0;
					
		

					if(!is_null($NumeroDePretarjeta))
					{
						$query="select a.NumeroDePretarjeta, a.NombreCliente,b.NumeroDePretarjeta,c.IdPago,c.MontoPago, c.FechaPago,a.Ruta,c.TipoDocumento
							from  clientestemporal as a inner join facturatemporal as b on (a.NumeroDePretarjeta=b.NumeroDePretarjeta)
							inner join pagosPretarjeta as c on (b.NumeroDePretarjeta=c.NumeroDePretarjeta)
							where a.NumeroDePretarjeta='$NumeroDePretarjeta'";
					}
					

					$resultado=$link->query($query);

					if(mysqli_affected_rows($link)>0)
						{

							echo "<table border='1px' align='center' width='900px'>
								<tr>
									<td>Numero de Pretarjeta</td>
									<td>Nombre</td>
									<td>Recibo</td>
									<td>Pago</td>
									<td>Fecha</td>
									<td>Ruta</td>
									<td>Tipo de Documento</td>
								</tr>
								";


								

							while($renglon=$resultado->fetch_array())
							{
								$NumeroDePretarjeta=$renglon['NumeroDePretarjeta'];
								$NombreCliente=$renglon['NombreCliente'];
								$IdRecibo=$renglon['IdPago'];
								$Pago=$renglon['MontoPago'];
								$Fecha=$renglon['FechaPago'];
								$Ruta=$renglon['Ruta'];
								$TipoDocumento=$renglon['TipoDocumento'];
						
								echo "<tr>
										<td>$NumeroDePretarjeta</td>
										<td>$NombreCliente</td>
										<td>$IdRecibo</td>
										<td>$$Pago</td>
										<td>$Fecha</td>
										<td>$Ruta</td>
										<td>$TipoDocumento</td>
									</tr>
									";

									
								
									$TotalPagos=$TotalPagos+$Pago;		
								
								if($TipoDocumento=="Nota de Cargo")	
								{
									$NotasDeCargo =$NotasDeCargo +$Pago;
								}
								
									
								
								
							}

							echo "</table>";

						}else
							{
						
							echo "</br></br><div align='center'>No hay pagos para el cliente</div>";
						}	


						


								
								
		
							$Saldo = SaldoPretarjeta($NumeroDePretarjeta,$MontoTotalFactura);
								//$SaldoFinal=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura);
									
								
								

						echo "<table border='1px' align='center' width='500px'>
								<tr>
									<td>
										<label>Fecha Factura</label>
									</td>
									<td>
										$FechaFactura
									</td>
								</tr>
								<tr>
									<td>
										<label>Total Factura</label>
									</td>
									<td>
										$$MontoTotalFactura
									</td>
								</tr>
								<tr>
									<td>
										Notas de Cargo 
									</td>
									<td>
										$$NotasDeCargo 
									</td>
								</tr>
								<tr>
									<td>
										<label>Pagos</label>
									</td>
									<td>
										$$TotalPagos
									</td>
								</tr>
								<tr>
									<td>
										<label>Saldo</label>
									</td>
									<td>
										$$Saldo
									</td>
								</tr>";

								
									$SaldoPagoPuntual = ObetenerSaldoVencidoPretarjeta($NumeroDePretarjeta,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$PagoPuntual);

									$SaldoPagoNormal = ObetenerSaldoVencidoPretarjeta($NumeroDePretarjeta,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$PagoNormal);

								/*$SaldoPagoPuntual=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$PagoPuntual);

								$SaldoPagoNormal=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$PagoNormal);*/

								//echo "<h1>NOTASDECARGO</h1>".($NotasDeCargoIniciales+$NotasDeCargoNuevas);

								//echo "<h1>PAGOS</h1>".($PagosIniciales+$TotalPagosNuevos);
								 $SaldoVencidoPagoPuntual=$SaldoPagoPuntual-($TotalPagos);//-($NotasDeCargoIniciales+$NotasDeCargoNuevas);
								 $SaldoVencidoPagoNormal=$SaldoPagoNormal-($TotalPagos);//-($NotasDeCargoIniciales+$NotasDeCargoNuevas);


					 		 echo "
					 		 		<tr>
					 		 			<td>
					 		 				Saldo Vencido Pago Puntual
					 		 			</td>";

					 		 	if($SaldoVencidoPagoPuntual>0)
					 		 	{
					 		 	echo "<td bgcolor='#FA5882'>
							 		$$SaldoVencidoPagoPuntual
									</td>
									<td>$PagoPuntual</td>
									</tr>";
								}else
								{
								echo "<td>
							 		 	$0
									</td>
									<td>
										$PagoPuntual
									</td>
									</tr>";
								}



								echo "<tr>
					 		 		<td>
					 		 		Saldo Vencido Pago Normal 
					 		 		</td>";

					 		 		if($SaldoVencidoPagoNormal>0)
					 		 		{
					 		 		echo "<td bgcolor='#FA5882'>
							 			 $$SaldoVencidoPagoNormal
										</td>
										<td>
											$PagoNormal
										</td>
										</tr>";
					 		 		}else
					 		 		{
					 		 		echo "<td>
							 			 	$0
										</td>
										<td>
											$PagoNormal
										</td>
									</tr>";
									}

									echo "</table>";

					//}



/*function ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$Pago,$link)
{
	if($Plazo>0)
	{

				/*Verificar datos*/
				/*echo "</br>Fecha PrimerPago ".$FechaPrimerPago;
				echo "</br>Fecha Actual: ".date('Y-m-d', strtotime('today'));
			
				$datetime1 = date_create($FechaPrimerPago);//Fecha de la Factura
				$datetime2 =date_create(date('Y-m-d', strtotime('today')));//Fecha Actual
				$datetime1->add(new DateInterval('P7D'));//Sumas una semana para empezar el conteo de los pagos por semana
				


				$interval = $datetime1->diff($datetime2);
				//$SemanasTranscurridas=floor(($interval->format('%a') / 7));
				$SemanasTranscurridas=floor(($interval->format('%a') / 7));

				
				echo "</br>Semanas transcurridas: ".$SemanasTranscurridas;

				 echo "</br>Semanas limite: ".$LimiteDeSemanas=ceil($Plazo*4.3);

				 //$LimiteDeSemanas=$Plazo*4.3;


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
}*/

			
					?>	


				</form>
			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>







