
<DOCTYPE! html>

<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Aplicacion de Pagos Factura</title>
	<link rel="stylesheet"  href="css/normalize.css">
	<link rel="stylesheet"  href="css/estilo.css">
</head>






<body>

<?php



if(isset($_GET['txtIdCliente']))
{
	$IdCliente = $_GET['txtIdCliente'];	
}else
{
	$IdCliente='';
}


if(isset($_GET['txtNombreCliente']))
{
	$NombreCliente = $_GET['txtNombreCliente'];	
}else
{
	$NombreCliente='';
}

if(isset($_GET['txtIdFactura']))
{
	$IdFactura = $_GET['txtIdFactura'];	
}else
{
	$IdFactura='';
}


if(isset($_GET['txtMontoTotalFactura']))
{
	$MontoTotalFactura = $_GET['txtMontoTotalFactura'];	
}else
{
	$MontoTotalFactura=0;
}

if(isset($_GET['txtSaldo']))
{
	$Saldo = $_GET['txtSaldo'];	
}else
{
	$Saldo=0;
}

if(isset($_GET['txtMontoPago']))
{
	 $Pago = $_GET['txtMontoPago'];	
}else
{
	$Pago=0;
}


if(isset($_GET['txtIdPago']))
{
	$IdPago=$_GET['txtIdPago'];
}else
{
	$IdPago=0;
}


if(isset($_GET['txtFechaPago']))
{
	$FechaPago=$_GET['txtFechaPago'];
}else
{
	$FechaPago=date('Y-m-d', strtotime('today'));;
}


if(isset($_GET['cmbTipoDocumento']))
{
	$TipoDocumento=$_GET['cmbTipoDocumento'];
}else
{
	$TipoDocumento=0;
}


if(isset($_GET['cmbTipoPago']))
{
	$TipoPago=$_GET['cmbTipoPago'];
}else
{
	$TipoPago=0;
}

if(isset($_GET['txtPagoNormal']))
{
	$PagoNormal=$_GET['txtPagoNormal'];
}else
{
	$PagoNormal="";
}

if(isset($_GET['txtPagoPuntual']))
{
	$PagoPuntual=$_GET['txtPagoPuntual'];
}else
{
	$PagoPuntual="";
}



if(isset($_GET['Mensaje']))
{	
	$Mensaje=$_GET['Mensaje'];
	?>
	<script>
	Mensaje="<?php echo $Mensaje; ?>"
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
	<form class="frmConsulta" method="get" name="frmAplicarPago" action="AplicarPagoFacturaAccion.php">
	<table  border="0px" align="center">
		<tr>
			<td>
			<label>No. de Cliente:</label>
			</td>
			<td>
			<input name="txtIdCliente" type="text" value="<?php echo $IdCliente ?>" >
			<input name="btnAccion" type="submit" value="Buscar Cliente" formnovalidate="formnovalidate" >
			</td>
		</tr>
		<tr>
			<td>
				<label>Nombre del Cliente:</label>
			</td>
			<td>
				<input name="txtNombreCliente"  type="text" value="<?php echo $NombreCliente?>" >
				<input name="btnAccion" type="submit" value="Buscar Por Nombre" formnovalidate="formnovalidate">
			</td>
		</tr>
		<tr>
			<td>
			<label>Factura:</label>
			</td>
			<td>
			<input name="txtIdFactura" type="text" value="<?php echo $IdFactura ?>" >
			<input name="btnAccion" type="submit" value="Buscar Factura" formnovalidate="formnovalidate" >
			</td>
		</tr>
		<tr>
			<td>
			<label>Pago Normal:</label>
			</td>
			<td>
			<input name="txtPagoNormal" type="text" value="<?php echo $PagoNormal ?>">
			</td>
		</tr>
		<tr>
			<td>
			<label>Pago Puntual:</label>
			</td>
			<td>
			<input name="txtPagoPuntual" type="text" value="<?php echo $PagoPuntual ?>">
			</td>
		</tr>
		<tr>
			<td>
			<label>Monto Factura:</label>
			</td>
			<td>
			<input name="txtMontoTotalFactura" type="text" value="<?php echo $MontoTotalFactura ?>">
			</td>
		</tr>
		<tr>
			<td>
			<label>Saldo Factura</label>
			</td>
			<td>
			<input name="txtSaldo" type="text" value="<?php echo $Saldo ?>">
			</td>
		</tr>
	</table>
	<table border="1px" align="center" >
		<tr>
			<td>
				<label>Numero de recibo:</label>
			</td>
			<td>
				<input name="txtIdPago" type="text" value="<?php echo $IdPago?>" required>
			</td>
		<tr>
			<td>
				<label>Pago:</label>
			</td>
			<td>
				<input name="txtPago" type="text" value="<?php echo $Pago?>" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Fecha de pago:</label>
			</td>
			<td>
				<input name="txtFechaPago" type="date"  vrequired>
			</td>
		</tr>
		<tr>
			<td>
				<label>Tipo de documento:</label>
			</td>
			<td>
				<?php

					$link=mysqli_connect('localhost','root','','bodegon');

				?>
					<select name="cmbTipoDocumento" required>
						<?php if ($TipoDocumento=="") {
							echo "<option value=''>Selecciona el Tipo de Documento</option>";
						}else
						{	?>
							<option value="<?php echo $TipoDocumento?>"><?php echo $TipoDocumento ?><?php echo "</option>";
						}  	


						?>
						
						<?php

							$query="Select * from TipoDocumento where PagoDescripcion not in ('$TipoDocumento')";


							$resultado=$link->query($query);

							while($renglon=$resultado->fetch_array())
							{
								echo "<option value='$renglon[PagoDescripcion]'>$renglon[PagoDescripcion]</option>";
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
				<select name="cmbTipoPago" >
					
					<?php if ($TipoPago=="") {
							echo "<option value=''>Selecciona el Tipo de Pago</option>";
						}else
						{	?>
							<option value="<?php echo $TipoPago?>"><?php echo $TipoPago ?><?php echo "</option>";
						}  	
						?>
						
						<?php

							$query="Select * from TipoPagos where TipoPagoDescripcion not in ('$TipoPago')";


							$resultado=$link->query($query);

							while($renglon=$resultado->fetch_array())
							{
								echo "<option value='$renglon[TipoPagoDescripcion]'>$renglon[TipoPagoDescripcion]</option>";
							}
						?>
				</select>
			</td>
		</tr>
		<tr><td colspan="2" align="center">
			<input name="btnAccion" type="submit" value="Aplicar Pago">
			</td>
		</tr>
		
	</table>
	</form>
	</div><!--DIV formulario -->
	</div><!--Div Container-->
</body>
</html>