<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Contados sin saldar</title>
		<link rel="stylesheet"  href="css/normalize.css">
	</head>
	<body>

		<?php

			if(isset($_GET['btnGenerarReporte']))
			{
				$boton=$_GET['btnGenerarReporte'];
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
				<a href="ReportePretarjetasNoFacturadas.php"><img src="img/logobodegon.JPG" ></a>
			</div>

		
					<?php $link=mysqli_connect('localhost','root','' , 'bodegon');

								
						$TotalCuentas=0;
						$SaldoTotal=0;
						if($boton=="Generar Reporte")
						{


						

						if($Ruta=="TODAS")
						{
							//$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)  where b.Plazo=0 ";

							$query="select * from clientesTemporal as a inner join facturaTemporal as b on (a.NumeroDePretarjeta=b.NumeroDePretarjeta) where b.NumeroDePretarjeta  not in (select NumeroDePretarjeta from factura )";
						}else
						{
							//$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) where a.Ruta='$Ruta' and b.Plazo=0";	
							$query="select * from  clientesTemporal as a inner join facturaTemporal as b on (a.NumeroDePretarjeta=b.NumeroDePretarjeta) where b.NumeroDePretarjeta  not in (select NumeroDePretarjeta from factura ) and a.Ruta='$Ruta'";
						}
						

						
			

					

						 $resultado=$link->query($query);

					

						echo "<table border='1px' align='center' width='900px'>
								<tr>
									<td>Numero de Pretajrtea</td>
									<td>Nombre</td>
									<td>Fecha Factura</td>
									<td>Monto Factura</td>
									<td>Ruta</td>
								</tr>
								";


							while($renglon=$resultado->fetch_array())
							{
								$NumeroDePretarjeta=$renglon['NumeroDePretarjeta'];
								$NombreCliente=$renglon['NombreCliente'];
								$FechaFactura=$renglon['FechaFactura'];
								$Ruta=$renglon['Ruta'];

								$MontoTotalFactura=$renglon['MontoTotalFactura'];
								

								//$Saldo=ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura, $NotasDeCargoIniciales,$link); 	
								//$SaldoTotal=$SaldoTotal+$Saldo;

								
								

								echo "<tr>
										<td>$NumeroDePretarjeta</td>
										<td>$NombreCliente</td>
										<td>$FechaFactura</td>
										<td>$MontoTotalFactura</td>
										<td>$Ruta</td>
									</tr>
									";

									$TotalCuentas=$TotalCuentas+1;
								
							}

							echo "</table>";
							
							echo "<div align='center'></table>";

						//	echo " <h5>Total: $".$SaldoTotal."</h5>";


							echo " <h5>Total Cuentas: ".$TotalCuentas."</h5></div>";
						}

					?>	


					

				

				<?php 


				


				 function ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoInicial, $NotasDeCargoIniciales,$link)
						{
							$query = "select * from pagos where IdFactura='$IdFactura'";

								//$query = "select * from pagos where IdFactura=047001531";
			
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
								
								 $SaldoInicial=$SaldoInicial+$NotasDeCargoIniciales;

								 if ($SaldoInicial>0) {
		 								
								 	
		 					 		$SaldoDB=$MontoTotalFactura-($SaldoInicial);
		 
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