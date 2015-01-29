<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Sale al cobro</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">
	</head>
	<body>

		<?php

			if(isset($_GET['btnGenerarListado']))
			{
				$boton=$_GET['btnGenerarListado'];
			}else
			{
				$boton="";
			}

			if(isset($_GET['cmbDia']))
			{
				$DiaDePago=$_GET['cmbDia'];
			}else
			{
				$DiaDePago="";
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
				<form name="frmReporteCliente" method="get" action="ReporteSaleAlCobroImprimir.php">
					<table align="center">
						<tr>
							<td>
								<label>Dia:</label>
							</td>
							<td>
								<select name="cmbDia" required>
								<?php
									if($DiaDePago!=="")
									{
							
										echo"<option value=$DiaDePago>$DiaDePago</option>";
										//echo"<option value=Todas>Todas</option>";
									}else
									{
										//echo"<option value=Todas>Todas</option>";
									}		


									?>
									<option value="Lunes">Lunes</option>
									<option value="Martes">Martes</option>
									<option value="Miercoles">Miercoles</option>
									<option value="Jueves">Jueves</option>
									<option value="Viernes">Viernes</option>
									<option value="Sabado">Sabado</option>
									<option value="Domingo">Domingo</option>
								</select>
							</td>
						</tr>
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
										echo"<option value=Todas>Todas</option>";
									}else
									{
										echo"<option value=Todas>Todas</option>";
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
								<input id='btnGenerarListado' name='btnGenerarListado' type='submit' value='Generar Listado' >
							</td>
						</tr>
					</table>
				

					<?php
							$TotalCuentas=0;
							$TotalACobrar=0;
							$SaldoTotal=0;

						if($boton=='Generar Listado')
						{


						$link=mysqli_connect('localhost','root','','bodegon');

						if($Ruta=="Todas")
						{
							$query="select *
								from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)
								where b.DiaDePago='$DiaDePago'";

						}
						else
						{
							$query="select *
								from  clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)
								where b.DiaDePago='$DiaDePago' and a.Ruta='$Ruta'";
						}
						

						
			

					

						 $resultado=$link->query($query);

					

						echo "<table border='1px' align='center' width='900px'>
								<tr>
									<td>Clave Cliente</td>
									<td>Factura</td>
									<td>Nombre</td>
									<td>Domiclio</td>
									<td>DiaDePago</td>
									<td>Pago Puntual</td>
									<td>Pago Normal</td>
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
								$IdFactura=$renglon['IdFactura'];
								$Ruta=$renglon['Ruta'];
								$DiaDePago=$renglon['DiaDePago'];
								$PagoPuntual=$renglon['PagoPuntual'];
								$PagoNormal=$renglon['PagoNormal'];
								$MontoTotalFactura=$renglon['MontoTotalFactura'];
								$SaldoFactura=$renglon['SaldoFactura'];
								$Plazo=$renglon['Plazo'];
								$FechaFactura=$renglon['FechaFactura'];
								$Colonia=$renglon['Colonia'];
								$Calle=$renglon['Calle'];
								$NotasDeCargoIniciales=$renglon['NotasDeCargo'];

								$Saldo=ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $NotasDeCargoIniciales,$link); 	
								$SaldoTotal=$SaldoTotal+$Saldo;


					/*---------------- ---------Calcula saldo vencido--------------------------------------- */

						$SaldoPagoPuntual=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$PagoPuntual,$link);

								$SaldoPagoNormal=ObetenerSaldoVencido($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$PagoNormal,$link);



					 			$Saldo=ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoFactura,$NotasDeCargoIniciales, $link);

					 			

					 			$Pagos=$MontoTotalFactura-$Saldo;

								$SaldoVencidoPagoPuntual=$SaldoPagoPuntual-$Pagos;
								$SaldoVencidoPagoNormal=$SaldoPagoNormal-$Pagos;

							/*s$queryPagos=("select sum(MontoPago) as Pagos from Pagos where IdFactura='$IdFactura'");

							$resultadoPagos=$link->query($queryPagos);

							$renglonPagos=$resultadoPagos->fetch_assoc();

							$Pagos=$renglonPagos['Pagos'];

							$queryDocumentos=("select sum(MontoDocumento) as Documentos from Documentos where FechaDocumento<=curdate() and IdFactura='$IdFactura'");					

							$resultadoDocumentos=$link->query($queryDocumentos);

							$renglonDocumentos=$resultadoDocumentos->fetch_assoc();

							$Documentos=$renglonDocumentos['Documentos'];

								if($Pagos>=$Documentos)
					 		{
					 			$SaldoVencido=0;
					 			
					 		}else
					 		{
					 			
					 			if ($SaldoFactura=0) 
					 			{
					 				$PagosIniciales=$MontoTotalFactura-$SaldoFactura;	
					 			}
					 			else
					 			{
					 				$PagosIniciales=0;
					 			}


					 			
					 			$SaldoVencido=$Documentos-$Pagos-$PagosIniciales;

					 		}*/

								if($Saldo>0)
								{
								
									
								echo "<tr>
										<td>$IdCliente</td>
										<td>$IdFactura</td>
										<td>$NombreCliente</td>
										<td>$Colonia $Calle </td>
										<td>$DiaDePago</td>
										<td>$$PagoPuntual</td>
										<td>$$PagoNormal</td>
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
								
								echo 	"<td>$Ruta</td>
									</tr>
									";

									$TotalCuentas=$TotalCuentas+1;
									$TotalACobrar=$TotalACobrar+$PagoPuntual;
								}
							}

							echo "</table>";
							echo "<h5>Total a cobrar: $".$TotalACobrar."<h5>"; 	

						echo " <h5>Total Cuentas: ".$TotalCuentas."</h5>";
						}


					
					?>	


					

				

				<?php 


				/*function ObtieneTotalFacturas($link)
				{
					$query="select count(IdFactura) as totalCuentas from factura ";

					$result=$link->query($query);

					
					while ($renglon=$result->fetch_array()) {
						
						$TotalCuentas=$renglon['totalCuentas'];
					}

					return $TotalCuentas;
				}*/


				/* function Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link)
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
						}*/

					
					
				?>

				</form>
			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>


<?php 



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


				function ObtenerSaldo($IdFactura,$MontoTotalFactura,$SaldoInicial,$NotasDeCargoIniciales,		 $link)
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