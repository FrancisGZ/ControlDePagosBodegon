<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Contados sin saldar</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
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

		<div class="container">
				<?php 

					include_once "Menu_Header.html";
				?>

			<div class="formulario">
				<form name="frmReporteCliente" method="get" action="ReporteContadosSinSaldarImprimir.php">
					<table align="center">
						<tr>
							<td>
								<label>Ruta:</label>
							</td>
							<td>
								<?php $link=mysqli_connect('localhost','root','' , 'bodegon');

								$query="Select * from Rutas";


									?>
									<select name="cmbRuta" required >
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
							<td colspan="2" align="center">
								<input name="btnGenerarReporte" type="submit" value="Generar Reporte" >
							</td>
						</tr>
					</table>
				

					<?php
						
						$TotalCuentas=0;
						$SaldoTotal=0;
						if($boton=="Generar Reporte")
						{


						

						if($Ruta=="TODAS")
						{
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)  where b.Plazo=0 ";
						}else
						{
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) where a.Ruta='$Ruta' and b.Plazo=0";	
						}
						

						
			

					

						 $resultado=$link->query($query);

					

						echo "<table border='1px' align='center' width='900px'>
								<tr>
									<td>Clave Cliente</td>
									<td>Factura</td>
									<td>Nombre</td>
									<td>Fecha Factura</td>
									<td>Saldo</td>
									<td>Ruta</td>
								</tr>
								";


							while($renglon=$resultado->fetch_array())
							{
								$IdCliente=$renglon['IdCliente'];
								$NombreCliente=$renglon['NombreCliente'];
								$IdFactura=$renglon['IdFactura'];
								$FechaFactura=$renglon['FechaFactura'];
								$Ruta=$renglon['Ruta'];

								$MontoTotalFactura=$renglon['MontoTotalFactura'];
								$SaldoInicial=$renglon['SaldoFactura'];
								$NotasDeCargoIniciales=$renglon['NotasDeCargo'];

								$Saldo=ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $NotasDeCargoIniciales,$link); 	
								$SaldoTotal=$SaldoTotal+$Saldo;

								if($Saldo>0)
								{
								

								echo "<tr>
										<td>$IdCliente</td>
										<td>$IdFactura</td>
										<td>$NombreCliente</td>
										<td>$FechaFactura</td>
										<td>$$Saldo</td>
										<td>$Ruta</td>
									</tr>
									";

									$TotalCuentas=$TotalCuentas+1;
								}
							}

							echo "</table>";

							echo " <h5>Total: $".$SaldoTotal."</h5>";


							echo " <h5>Total Cuentas: ".$TotalCuentas."</h5>";
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

				</form>
			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>