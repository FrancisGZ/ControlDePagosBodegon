<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Cuentas no abonadas</title>
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
				<form name="frmReporteCliente" method="get" action="ReporteCuentasNoAbonadasImprimir.php">
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
								<input  name="btnGenerarReporte" type="submit" value="Generar Reporte" >
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
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) ";

							//$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) where a.IdCliente=047001531";
						}else
						{
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) where a.Ruta='$Ruta' ";	

							
						}
						

						
			

					

						 $resultado=$link->query($query);

					

						echo "<table border='1px' align='center' width='900px'>
								<tr>
									<td>Clave Cliente</td>
									<td>Factura</td>
									<td>Nombre</td>
									<td>Fecha Factura</td>
									<td>Monto Factura</td>
									<td>Saldo</td>
									<td>Ruta</td>
								</tr>
								";


							while($renglon=$resultado->fetch_array())
							{
								$IdCliente=$renglon['IdCliente'];
								$NombreCliente=$renglon['NombreCliente'];
								$IdFactura=$renglon['IdFactura'];
								$Ruta=$renglon['Ruta'];
								$FechaFactura=$renglon['FechaFactura'];
								$MontoTotalFactura=$renglon['MontoTotalFactura'];
								$SaldoInicialFactura=$renglon['SaldoInicialFactura'];
								$NotasDeCargoIniciales=$renglon['NotasDeCargo'];

								 $Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura,$NotasDeCargoIniciales, $link); 	
							

								if($Saldo==$MontoTotalFactura)
								{
								

								echo "<tr>
										<td>$IdCliente</td>
										<td>$IdFactura</td>
										<td>$NombreCliente</td>
										<td>$FechaFactura</td>
										<td>$$MontoTotalFactura</td>
										<td>$$Saldo</td>
										<td>$Ruta</td>
									</tr>
									";

									$TotalCuentas=$TotalCuentas+1;
									$SaldoTotal=$SaldoTotal+$Saldo;
								}
							}

							echo "</table>";

							echo " <h5>Total: $".$SaldoTotal."</h5>";


							echo " <h5>Total Cuentas: ".$TotalCuentas."</h5>";
						}

					?>	


					

				

				<?php 



				 function Saldo($IdFactura,$MontoTotalFactura,$SaldoInicial,$NotasDeCargoIniciales, $link)
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