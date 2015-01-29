<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Cuentas Vencidas</title>
		<link rel="stylesheet"  href="css/normalize.css">
	</head>
	<body>

		<?php


		include "Funciones.php";

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

			if(isset($_GET["txtFechaSaldoVencido"]))
			{
				$FechaSaldoVencido=$_GET["txtFechaSaldoVencido"];
			}
			else
			{
				$FechaSaldoVencido=date('Y-m-d', strtotime('today'));
			}

		?>

		<!--<div class="container">-->
				
			<div  align='center'>
				<a href="ReporteCuentasVencidas.php"><img src="img/logobodegon.JPG" ></a>
			</div>

					<?php
						
						$TotalCuentas=0;
						$SaldoTotal=0;
						if($boton=="Generar Listado")
						{


						

						if($Ruta=="TODAS")
						{
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) order by a.NombreCliente";
						}else
						{
							$query="select * from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) where a.Ruta='$Ruta'  order by a.NombreCliente";	
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
									<td>Saldo vencido pago puntual</td>
									<td>Saldo vencido pago normal</td>
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
								$SaldoInicialFactura=$renglon['SaldoInicialFactura'];
								$SaldoInicial=$renglon['SaldoInicialFactura'];

								$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura); 
								

								



								$queryUltimoReciboCapturado=("Select max(FechaPago) as FechaPago from pagos where IdFactura='$IdFactura'");


								$resultadoUltimoReciboCapturado=$link->query($queryUltimoReciboCapturado);

								$renglonUltimoReciboCapturado=$resultadoUltimoReciboCapturado->fetch_assoc();

								$FechaUltimReciboCapturado=$renglonUltimoReciboCapturado['FechaPago'];


								


								$SaldoPagoPuntual=ObetenerSaldoVencidoConFecha($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$FechaSaldoVencido,$PagoPuntual);

								$SaldoPagoNormal=ObetenerSaldoVencidoConFecha($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$FechaSaldoVencido,$PagoNormal);



					 			$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura);

					 			

					 			$Pagos=$MontoTotalFactura-$Saldo;

								$SaldoVencidoPagoPuntual=$SaldoPagoPuntual-$Pagos;
								$SaldoVencidoPagoNormal=$SaldoPagoNormal-$Pagos;

							

								if($SaldoVencidoPagoPuntual>0)
								{
								
										 $SaldoPagoPuntual;
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
										$SaldoTotal=$SaldoTotal+$Saldo;
								}
							}

							echo "</table>";

							echo "  <div align='center'><h5>Total: $".$SaldoTotal."</h5>";


							echo " <h5>Total Cuentas: ".$TotalCuentas."</h5></div>";


							//s "<a href='ExportarExcelListado.php?cmbRuta=$Ruta'>Exportar  a Excel</a>";
						}


						
					



					
				?>

			
	</body>
</html>