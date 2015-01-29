
<DOCTYPE! html>

<html lang="es">
<head>
	<meta charset='utf-8'>
	<title>Aplicacion de Pagos</title>
	<link rel="stylesheet"  href="css/normalize.css">
	<link rel="stylesheet"  href="css/estilo.css">

</head>



<body>

<?php


if(isset($_GET['NumFolio']))
{
	$IdPago = $_GET['NumFolio'];	
}else
{
	$IdPago='';
}


if(isset($_GET['txtNombreCliente']))
{
	$NombreCliente = $_GET['txtNombreCliente'];	
}else
{
	$NombreCliente='';
}

if(isset($_GET['txtFactura']))
{
	$Factura = $_GET['txtFactura'];	
}else
{
	$Factura='';
}


if(isset($_GET['txtMonto']))
{
	$Monto = $_GET['txtMonto'];	
}else
{
	$Monto=0;
}

if(isset($_GET['txtSaldo']))
{
	$Saldo = $_GET['txtSaldo'];	
}else
{
	$Saldo=0;
}

if(isset($_GET['Mensaje']))
{
 	
	?>
	<script>ClienteNoExiste();</script>
	<?php
}

if(isset($_GET['txtDomicilio']))
{
	$Domicilio=$_GET['txtDomicilio'];
}else
{
	$Domicilio='';	
}

					$link=mysqli_connect('localhost','root','','bodegontest') ;



					$query="select * from 
							pagos as a inner join factura as b on (a.IdFactura=b.IdFactura) 
							inner join clientes as c on (b.IdCliente=c.IdCliente)
							where IdPago='$IdPago'";

					


					$resultado=$link->query($query);


					if (!is_null($resultado))
					{

					

					while ($renglon=$resultado->fetch_array()) 
						{
						$NumFolio=$renglon["IdPago"];
						$MontoPago=$renglon["MontoPago"];
						$FechaPago=$renglon["FechaPago"];
						$TipoDocumento=$renglon["TipoDocumento"];
						$TipoPago=$renglon["TipoPago"];
						$Factura=$renglon["IdFactura"];
						$NombreCliente=$renglon["NombreCliente"];
						$IdCliente=$renglon["IdCliente"];
						}

					}
				?>

	<div id="container">
	   <div id="encabezado">
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
	<form method="get" name='frmAplicaPago' action='EditarPagosAccion.php' ;>
	<table border='0px' align='center'>
		<tr>
			<td>
			<label>Recibo:</label>
			</td>
			<td>
			<input id='txtIdRecibo'  name='txtIdRecibo' type="text" value='<?php echo $NumFolio ?>' required >
			</td>
		</tr>
		<tr>
			<td>
				<label>Clave Cliente:</label>
			</td>
			<td>
				<input id='txtNoCliente' name='txtNoCliente' type='text' value='<?php echo $IdCliente?>' required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Nombre del Cliente:</label>
			</td>
			<td>
				<input id='txtNombreCliente' name='txtNombreCliente' type='text' value='<?php echo $NombreCliente ?>' readonly >
			</td>
		</tr>
		<tr>
			<td>
			<label>Factura:</label>
			</td>
			<td>
			<input id='txtFactura' name='txtFactura' type='text' value='<?php echo $Factura ?>' required>
			</td>
		</tr>
		<tr>
			<td>
			<label>Monto Pago:</label>
			</td>
			<td>
			<input id='txtMontoPago' name='txtMontoPago' type='text' value='<?php echo number_format($MontoPago) ?>' required>
			</td>
		</tr>
		<tr>
			<td>
			<label>Fecha Pago:</label>
			</td>
			<td>
			<input id='txtFechaPago' name='txtFechaPago' type='date' value='<?php echo date('Y-m-d', strtotime($FechaPago));  ?>' required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Tipo Documento:</label>
			</td>


			<td>
					<?php 

								$query="Select * from TipoDocumento where PagoDescripcion not in ('$TipoDocumento')"


							?>
							<select id='cmbTipoDocumento' name='cmbTipoDocumento' required>
								<?php	
									if($TipoDocumento!="")
									{
										echo "<option value='$TipoDocumento'>$TipoDocumento</option>";		
									}
								
								
								$resultado=$link->query($query);


								while($renglon=$resultado->fetch_array())
								{
									$Documento=$renglon["PagoDescripcion"];
									echo "<option value='$Documento'>$Documento</option>";
								}
								?>
							</select>
							</td>
		</tr>
		<tr>
			<td>
				<label>Tipo de Pago:</label>
			</td>
			<td>
				<?php
				
				if($TipoPago=="Pago Puntual")
				{
					echo "<select id='cmbTipoPago' name='cmbTipoPago'>
						<option value='Pago Puntual'>Pago Puntual</option>
						<option value='Pago Normal'>Pago Normal</option>
					</select>";
				} 
				elseif ($TipoPago=="Pago Normal") {
					
					echo "<select id='cmbTipoPago' name='cmbTipoPago'>
						<option value='Pago Puntual' >Pago Normal</option>
						<option value='Pago Normal'>Pago Puntual</option>
					</select>";
				}
				
				?>
			</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>
				<input id='btnAccion' name='btnAccion' type='submit' value='Guardar'>
		
				<input id='btnAccion' name='btnAccion' type='submit' value='Borrar'  onclick="return confirm('¿Estas seguro de eliminar el recibo?')">
			
				<input id='btnAccion' name='btnAccion' type='submit' value='Atras'>


			</td>
		</tr>
	</table>
	</form>
</div>  <!--Div Formulario-->
</div><!--Div Container-->
</body>
</html>