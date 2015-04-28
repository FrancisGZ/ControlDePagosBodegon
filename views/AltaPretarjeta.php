<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Alta Pretarjeta</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">

		<?php 

require "/../db/ruta.php";


/** 
*
* @Formulario Alta Pretarjeta . "AltaPretarjeta.php"
* @versión: 2.0    @modificado: 28 de Abril del 2015
* @autor: Francis Alonso Gonzalez Zarate
*
*/

			if(isset($_GET['Mensaje']))
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
	</head>

	<body>
		<div class="container">
			

		<?php 
		
			include_once("/../Menu_Header.html");

		?>	
		<div class="formulario">
		<form name="frmAltaPretarjeta" method="get" action="AltaPretarjetaAccion.php">
		<table align="center">
			<tr>
				<td>
					<label>Nombre Cliente:</label>
				</td>
				<td>
					<input  name="txtNombreCliente" type="text" required> 
				</td>
			</tr>
			<tr>
				<td>
					<label>Colonia:</label>
				</td>
				<td>
					<input name="txtColonia" type="text" required>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Calle:</label>
				</td>
				<td>
					<input  name="txtCalle" type="text" required>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Telefono:</label>
				</td>
				<td>
					<input name="txtTelefono" type="text">
				</td>	
			</tr>
			<tr>
				<td>
					<label>Codigo Postal:</label>
				</td>
				<td>
					<input name="txtCodigoPostal" type="text" >
				</td>	
			</tr>
			<tr>
				<td>
					<label>Municipio:</label>
				</td>
				<td>
					<input name="txtMunicipio" type="text" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Fecha Factura:</label>
				</td>
				<td>
					<input  name='txtFechaFactura' type='date' value='<?php echo date('Y-m-d', strtotime('today'));  ?>'required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Fecha Primer Pago:</label>
				</td>
				<td>
					<input name="txtFechaPrimerPago" type="date" value="<?php echo date('Y-m-d', strtotime('today')); ?>" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Financiamiento:</label>
				</td>
				<td>
					<input  name="txtFinanciamiento" type="text" required>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Monto total de la factura:</label>
				</td>
				<td>
					<input name="txtMontoTotalFactura" type="text" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Articulos:</label>
				</td>
				<td>
					<textarea name="txtArticulos" type="textarea" rows="3" cols="50" required></textarea>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Ruta:</label>
				</td>
				<td>
							<?php 

							$rutas=obtenerRutas("select IdRuta from Rutas");


							?>
							<select name="cmbRuta" required>
								
								<option value="">Seleccionar ruta</option>";
								<?php

								while($renglon=$rutas->fetch_array())
								{
									echo "<option value='$renglon[IdRuta]'>$renglon[IdRuta]</option>";
								}
								?>
							</select>
				</td>
				</tr>
			<tr>
				<td>
					<label>No. de Pretarjeta:</label>
				</td>
				<td>
					<input name="txtNumeroDePretarjeta" type="text" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Plazo:</label>
				</td>
				<td>
					<input name="txtPlazo" type="text" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Pago Puntual:</label>
				</td>
				<td>
					<input name="txtPagoPuntual" type="text" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Pago Normal:</label>
				</td>
				<td>
					<input name="txtPagoNormal" type="text" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Observaciones:</label>
				</td>
				<td>
					<textarea  name="txtObservaciones" type="textarea"  rows="3" cols="50"  ></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label>Vendedor:</label>
				</td>
				<td>
					<input name="txtVendedor" type="text" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Comision:</label>
				</td>
				<td>
					<input name="txtComision" type="text" requiered>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<h5>-----------------------------------------------  Aval  -----------------------------------------------</h5>
				</td>
			</tr>
			<tr>
				<td>
					<label>Nombre del aval:</label>
				</td>
				<td>
					<input name="txtNombreAval" type="text" >
				</td>
			</tr>
			<tr>
				<td>
					<label>Colonia:</label>
				</td>
				<td>
					<input name="txtColoniaAval" type="text" >
				</td>
			</tr>
			<tr>
				<td>
					<label>Calle:</label>
				</td>
				<td>
					<input name="txtCalleAval" type="text" >
				</td>
			</tr>
			<tr>
				<td>
					<label>Telefono:</label>
				</td>
				<td>
					<input name="txtTelefonoAval" type="text" >
				</td>
			</tr>
			<tr>
				<td>
					<label>Codigo Postal:</label>
				</td>
				<td>
					<input name="txtCodigoPostalAval" type="text" >
				</td>
			</tr>
			<tr>
				<td>
					<label>Municipio:</label>
				</td>
				<td>
					<input name="txtMunicipioAval" type="text" >
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input name="btnAltaFactura" value="Alta" type="submit">
				</td>
			</tr>
			</form>	
			</div>
		</table>
		</div>
	</body>
<html>