

<DOCTYPE! html>
<html lang="es">
	<head>
		<meta charset='utf-8'>
		<title>Reporte Recibo</title>
		<link rel="stylesheet"  href="css/estilo.css">
	</head>
	<body>

		<?php

			if(isset($_GET['txtIdFactura']) && isset($_GET['txtMontoTotalFactura']) && isset($_GET['txtFechaFactura']) && isset($_GET['txtPlazo']))
			{
				$IdFactura=$_GET['txtIdFactura'];
				$MontoTotalFactura=$_GET['txtMontoTotalFactura'];
				$FechaFactura=$_GET['txtFechaFactura'];
				$Plazo=$_GET['txtPlazo'];

			}else
			{
				$IdFactura='';
				$MontoTotalFactura='';
				$FechaFactura='';
				$Plazo='';
			}

			if(isset($_GET['btnActualizarMontoTotalFactura']))
			{
				$boton=$_GET['btnActualizarMontoTotalFactura'];
			}else
			{
				$boton="";
			}

			
			if(isset($_GET['txtNuevoTotal']))
			{
				$NuevoTotal=$_GET['txtNuevoTotal'];
			}else
			{
				$NuevoTotal="";
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
						<li><a href="ReporteCliente.php">Estado de Cuenta</a></li>
						<li><a href="ReporteRecibosConsecutivos.php">Reporte Recibos</a></li>
						<li><a href="ReporteBonificacionCancelacion.php">Cancelaciones</a></li>
						<li><a href="ReporteContadosSinSaldar.php">Contados Sin Saldar</a></li>
						<li><a href="ReporteListado.php">Listado</a></li>
						<li><a href="ReporteSaleAlCobro.php">Sale al cobro</a></li>
						<li><a href="ReporteCuentasSinAbonos.php">Cuentas sin Abonos </a></li>
					</ul>
				</li>
				</ul>
			</nav>
			<div id='formulario'>
				<form name='frmEditarTotalFactura' method='get' action='EditarTotalFactura.php'>
					<table align='center' border='0px'>
						<tr>
							<td>
								<label>Factura:</label>
							</td>
							<td>
								<input id='txtIdFactura' name='txtIdFactura' type='text' value='<?php echo $IdFactura ?>' required readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label>Fecha Factura:</label>
							</td>
							<td>
								<input id='txtFechaFactura' name='txtFechaFactura' type='text' value='<?php echo $FechaFactura ?>' required readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label>Plazo:</label>
							</td>
							<td>
								<input id='txtPlazo' name='txtPlazo' type='text' value='<?php echo $Plazo ?>' required>
							</td>
						</tr>
						<tr>
							<td>
								<label>Total Actual:</label>
							</td>
							<td>
								<input id='txtMontoTotalFactura' name='txtMontoTotalFactura' type='text' value='<?php echo $MontoTotalFactura ?>' required readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label>Nuevo Total:</label>
							</td>
							<td>
								<input id='txtNuevoTotal' name='txtNuevoTotal' type='text'  required>
							</td>
						</tr>
						<tr>
							<td></td>
							<td colspan='2' align='center'>
								<input id='btnActualizarMontoTotalFactura' name='btnActualizarMontoTotalFactura' type='submit' value='Actualizar Total Factura' >
							</td>
						</tr>
					</table>
					<table>

					<?php
						
						$link=mysqli_connect('localhost','root','','bodegon');
						

						if($boton=='Actualizar Total Factura')
							{			
								if(!mysqli_query($link,"delete from documentos where IdFactura='$IdFactura' "))
								{
								printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
								}


								if(!mysqli_query($link,"update factura set MontoTotalFactura=$NuevoTotal, Plazo=$Plazo where IdFactura='$IdFactura' "))
								{
								printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
								}

									GenerarDocumentos($IdFactura,$Plazo,$NuevoTotal,$FechaFactura,$link);	

									header("Location:ConsultaSaldo.php?Mensaje=Se Actualizo el total de la factura");					
							}




					function GenerarDocumentos($IdFactura,$Plazo,$MontoTotalFactura,$FechaFactura,$link)
					{
					if($Plazo>0)
					{

						echo "<br>";

					echo "Cantidad de pagos semanales: ".$PagosSemanales=$Plazo*4;

					echo "<br>";

					$MontoPagoSemanal=$MontoTotalFactura/$PagosSemanales;			

					echo "Pago semanal: ".number_format($MontoPagoSemanal,2);

					$contador=1;
			
					$FechaPagoSemanal = new DateTime($FechaFactura);
					while($contador<=$PagosSemanales)
					{	
						echo "Semana".$contador;
						echo "<br>";
						echo "Fecha del Pago: "; 
						echo "<br>";

						echo $FechaPagoSemanalString=$FechaPagoSemanal->format('Y-m-d'); 
						echo "<br>";
				

						mysqli_query($link,"insert into documentos (IdFactura,MontoDocumento,FechaDocumento)
							values('$IdFactura','$MontoPagoSemanal','$FechaPagoSemanalString')");

						$FechaPagoSemanal->add(new DateInterval('P7D'));
						
						$contador++;	
				
			}

		}
	}

					?>	

				</form>
			</div><!--formulario-->
		</div><!--Container-->
	</body>
</html>