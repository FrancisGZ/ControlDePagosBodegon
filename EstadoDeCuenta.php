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

			if (isset($_GET["txtIdFactura"])) 
			{
				
				$IdFactura=$_GET['txtIdFactura'];
			}else
			{
				
				$IdFactura="";
			}

			if(isset($_GET['txtIdCliente']))
			{
				$IdCliente=$_GET['txtIdCliente'];
			}else
			{
				$IdCliente="";
			}

			if(isset($_GET['txtNombreCliente']))
			{
				$NombreCliente=$_GET['txtNombreCliente'];
			}
			else{

				$NombreCliente="";
			}



			if(isset($_GET["txtNotasDeCargoIniciales"]))
			{
				$NotasDeCargoIniciales=$_GET["txtNotasDeCargoIniciales"];
			}
			else
			{
				$NotasDeCargoIniciales=0;
			}


			if(isset($_GET["txtSaldoInicialFactura"]))
			{
				$SaldoInicialFactura=$_GET["txtSaldoInicialFactura"];
			}
			else
			{
				$SaldoInicialFactura=0;
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
				<form name="frmReporteCliente" method="get" action="EstadoDeCuentaAccion.php">
					<table align='center'>
						<tr>
							<td>
								<label>Factura:</label>
							</td>	
							<td>
								<input name="txtIdFactura" type="text" value="<?php echo $IdFactura ?>">
								<input id="btnAccion" name="btnAccion" type="submit" value="Buscar por Factura">
							</td>
						</tr>
						<tr>
							<td>
								<label>Clave Cliente:</label>
							</td>
							<td>
								<input name='txtIdCliente' type='text' value='<?php echo $IdCliente ?>' >
								<input name='btnAccion' type='submit' value='Buscar por Clave' >
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
						
			

					$TotalPagosNuevos=0;
					$NotasDeCargoNuevas=0;
					
					/*if($boton=="Buscar por Clave")
					{
						$query="select a.IdCliente,a.NombreCliente,b.IdFactura,c.IdPago,c.MontoPago, c.FechaPago,a.Ruta,c.TipoDocumento
							from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)
							inner join pagos as c on (b.IdFactura=c.IdFactura)
							where a.IdCliente=$IdCliente";
					}

					if($boton=="Buscar por Factura")
					{
						
						$query="select a.IdCliente,a.NombreCliente,b.IdFactura,c.IdPago,c.MontoPago, c.FechaPago,a.Ruta,c.TipoDocumento
							from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)
							inner join pagos as c on (b.IdFactura=c.IdFactura)
							where b.IdFactura=$IdFactura";
					}*/

					if(!is_null($IdFactura) and !is_null($IdCliente))
					{
						$query="select a.IdCliente,a.NombreCliente,b.IdFactura,c.IdPago,c.MontoPago, c.FechaPago,a.Ruta,c.TipoDocumento
							from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)
							inner join pagos as c on (b.IdFactura=c.IdFactura)
							where a.IdCliente=$IdCliente";
					}
					

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

									
								
									$TotalPagosNuevos=$TotalPagosNuevos+$Pago;		
								
								if($TipoDocumento=="Nota de Cargo")	
								{
									$NotasDeCargoNuevas=$NotasDeCargoNuevas+$Pago;
								}
								
							}

							echo "</table>";

						}else
							{
						
							echo "</br></br><div align='center'>No hay pagos para el cliente</div>";
						}	


						


								
								

								
								if ($SaldoInicialFactura>0) 
								 {
								 		$PagosIniciales=$MontoTotalFactura-$SaldoInicialFactura;

								 		$SaldoInicialFactura=$SaldoInicialFactura+$NotasDeCargoIniciales;
								 }
								else
								 {
								 	 $PagosIniciales=0;
								 }
		

								$SaldoFinal=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura);
									
								
								/*if($SaldoInicialFactura=="")
								{
									$SaldoInicialFactura=0;
								}*/

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
										Notas de Cargo Iniciales 
									</td>
									<td>
										$$NotasDeCargoIniciales
									</td>
								</tr>
								<tr>
									<td>
										Notas de Cargo Nuevas 
									</td>
									<td>
										$$NotasDeCargoNuevas
									</td>
								</tr>
								<tr>
									<td>
										Pagos Iniciales
									</td>
									<td>
										$$PagosIniciales
									</td>
								</tr>
								<tr>
									<td>
										<label>Pagos Nuevos</label>
									</td>
									<td>
										$$TotalPagosNuevos
									</td>
								</tr>
								<tr>
									<td>
										<label>Saldo inicial</label>
									</td>
									<td>
										$$SaldoInicialFactura
									</td>
								</tr>
								<tr>
									<td>
										<label>Saldo final</label>
									</td>
									<td>
										$$SaldoFinal
									</td>
								</tr>";

								
								$SaldoPagoPuntual=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$PagoPuntual);

								$SaldoPagoNormal=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaPrimerPago,$PagoNormal);

								//echo "<h1>NOTASDECARGO</h1>".($NotasDeCargoIniciales+$NotasDeCargoNuevas);

								//echo "<h1>PAGOS</h1>".($PagosIniciales+$TotalPagosNuevos);
								 $SaldoVencidoPagoPuntual=$SaldoPagoPuntual-($PagosIniciales+$TotalPagosNuevos);//-($NotasDeCargoIniciales+$NotasDeCargoNuevas);
								 $SaldoVencidoPagoNormal=$SaldoPagoNormal-($PagosIniciales+$TotalPagosNuevos);//-($NotasDeCargoIniciales+$NotasDeCargoNuevas);


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







