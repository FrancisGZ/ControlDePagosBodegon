<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Cuentas sin abonos</title>
		<link rel="stylesheet"  href="css/estilo.css">
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
				<form name='frmReporteCliente' method='get' action='ReporteSinAbonosEnFechaActual.php'>
					<table align='center'>
						<tr>
							<td>
								<label>Ruta:</label>
							</td>
							<td>
								<?php $link=mysqli_connect('localhost','root','' , 'bodegon');

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
								<input id='btnGenerarReporte' name='btnGenerarReporte' type='submit' value='Generar Reporte' >
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
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) 
							inner join Pagos as c on (b.IdFactura=c.IdFactura) ";
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

								$MontoTotalFactura=$renglon['MontoTotalFactura'];
								$SaldoFactura=$renglon['SaldoFactura'];

								 $Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link); 	
							

								/*if($Saldo>0)
								{*/
								

								echo "<tr>
										<td>$IdCliente</td>
										<td>$IdFactura</td>
										<td>$NombreCliente</td>
										<td>$$Saldo</td>
										<td>$Ruta</td>
									</tr>
									";

									$TotalCuentas=$TotalCuentas+1;
									$SaldoTotal=$SaldoTotal+$Saldo;
								//}
							}

							echo "</table>";

							echo " <h5>Total: $".$SaldoTotal."</h5>";


							echo " <h5>Total Cuentas: ".$TotalCuentas."</h5>";
						}

					?>	


					

				

				<?php 



				 function Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link)
						{
							$query="select * from pagos where IdFactura='$IdFactura'";
			
							$result =$link->query($query);

							$pagosAplicados =0;
							while($row = $result->fetch_array())
							{
							$pagosAplicados=$pagosAplicados + $row["MontoPago"];
			
							}


		 					if ($SaldoFactura>0) 
		 					{
		 	
		 	 					$SaldoDB=$MontoTotalFactura-$SaldoFactura;
		 
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