<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Alta Factura</title>
		<link rel="stylesheet"  href="css/normalize.css">
		<link rel="stylesheet"  href="css/estilo.css">

	
	</head>

<?php 

/** 
*
* @Accion para Alta Factura . "AltaFactura.php"
* @versión: 2     @modificado: 20 de Abril del 2015
* @autor: Francis Alonso Gonzalez Zarate
*
*/

	/*----Obtiene la Informacion del cliente----***/	


include("funciones.php");

if(isset($_GET["txtNumeroDePretarjeta"]))
{
	$NumeroDePretarjeta=$_GET["txtNumeroDePretarjeta"];
}else
{
	$NumeroDePretarjeta="";
}

if(isset($_GET["txtNombreCliente"]))
{
	$NombreCliente = $_GET["txtNombreCliente"];	
}else
{
	$NombreCliente="";
}

if(isset($_GET["txtColonia"]))
{
		$Colonia = $_GET["txtColonia"];
}else
{
	$Colonia="";
}
	
if(isset($_GET["txtCalle"])) 
{
		$Calle =$_GET["txtCalle"];
}else
{
	$Calle="";
}
	

if(isset($_GET["txtTelefono"]) )
{
		$Telefono=$_GET["txtTelefono"];
}else
{
	$Telefono="";
}
	

if(isset($_GET['txtCodigoPostal']))
{
		
	$CodigoPostal=$_GET['txtCodigoPostal'];

}else
{
	$CodigoPostal='';
}


if(isset($_GET['txtMunicipio']))
{
	
	$Municipio=$_GET['txtMunicipio'];
	
}else
{
	$Municipio='';
}


if(isset($_GET['txtFechaFactura']))
{
	
	$FechaFactura=$_GET['txtFechaFactura'];
	
}else
{
	$FechaFactura='';
}


if(isset($_GET["txtFechaPrimerPago"]))
{
	$FechaPrimerPago=$_GET["txtFechaPrimerPago"];
}
else
{
	$FechaPrimerPago="";
}



if(isset($_GET['txtFinanciamiento']))
{
	
	$Financiamiento=$_GET['txtFinanciamiento'];
	
}else
{
	$Financiamiento='';
}

if(isset($_GET['txtMontoTotalFactura']))
{
	
	$MontoTotalFactura=$_GET['txtMontoTotalFactura'];
	
}else
{
	$MontoTotalFactura='';
}

if(isset($_GET['txtArticulos']))
{
	
	$Articulos=$_GET['txtArticulos'];
	
}else
{
	$Articulos='';
}

if(isset($_GET['cmbRuta']))
{
	
	$Ruta=$_GET['cmbRuta'];
	
}else
{
	$Ruta='';
}

if(isset($_GET['txtPlazo']))
{
	
	$Plazo=$_GET['txtPlazo'];
	
}else
{
	$Plazo='';
}

if(isset($_GET['txtPagoPuntual']))
{
	
	$PagoPuntual=$_GET['txtPagoPuntual'];
	
}else
{
	$PagoPuntual='';
}


if(isset($_GET['txtPagoNormal']))
{
	
	$PagoNormal=$_GET['txtPagoNormal'];
	
}else
{
	$PagoNormal='';
}


if(isset($_GET["txtObservaciones"]))
{
	$Observaciones=$_GET["txtObservaciones"];
}else
{
	$Observaciones="";
}

if (isset($_GET["txtObservaciones"])) 
{
	$Observaciones=$_GET["txtObservaciones"];
}else
{
	$Observaciones="";
}

if(isset($_GET['txtVendedor']))
{
	
	$Vendedor=$_GET['txtVendedor'];
	
}else
{
	$Vendedor='';
}


if(isset($_GET['txtComision']))
{
	
	
	$Comision=$_GET['txtComision'];
	
}else
{
	$Comision='';
}



	/*-------------------------Obtiene la infomacion del aval-----------------------------------------*/

if(isset($_GET['txtNombreAval']))
{
	
	
	$NombreAval=$_GET['txtNombreAval'];
	
}else
{
	$NombreAval='';
}
	
if(isset($_GET['txtColoniaAval']))
{
	
	$ColoniaAval=$_GET['txtColoniaAval'];
	
}else
{
	$ColoniaAval='';
}


if(isset($_GET['txtCalleAval']))
{
	
	$CalleAval=$_GET['txtCalleAval'];
	
}else
{
	$CalleAval='';
}


if(isset($_GET['txtTelefonoAval']))
{
	$TelefonoAval=$_GET['txtTelefonoAval'];
	
}else
{
	$TelefonoAval='';
}


if(isset($_GET['txtCodigoPostalAval']))
{
	$CodigoPostalAval=$_GET['txtCodigoPostalAval'];
	
}else
{
	$CodigoPostalAval='';
}


if(isset($_GET['txtMunicipioAval']))
{
	$MunicipioAval=$_GET['txtMunicipioAval'];
	
}else
{
	$MunicipioAval='';
}

	
	
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



<script>

window.addEventListener('load', init);
			function init()
			{
				
			}
			


	function vacio(q) {
            for ( i = 0; i < q.length; i++ ) {
                    if ( q.charAt(i) != " " ) {
                            return true
                    }
            }
            return false
    }
     
    //valida que el campo no este vacio y no tenga solo espacios en blanco
    function valida() {
           

    	var pretarjeta = document.getElementById("txtNumeroDePretarjeta");


            if( vacio(pretarjeta.value) == false ) {
             
                   

                      if (confirm("¿Estas seguro que no tiene numero de pretarjeta?") == true) {
				        
				        return true;

				    } else {
				        

				       return false;
				    }

				  }
				   
            } 
           

</script>




	<body>
		<div class="container">
		<?php 
		
			include_once("Menu_Header.html");

		?>	
		<div class="formulario">
		<form name="frmAltaFactura" method="get" action="AltaFacturaAccion.php"  onSubmit="return valida()" >
		<table align="center" >
			<tr>
				<td>
					<label>Clave Cliente</label>
				</td>
				<td>
					<input   name="txtIdCliente" type="text" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Nombre Cliente:</label>
				</td>
				<td>
					<input name="txtNombreCliente" type="text" value="<?php echo $NombreCliente ?>" required> 
				</td>
			</tr>
			<tr>
				<td>
					<label>Colonia:</label>
				</td>
				<td>
					<input name="txtColonia" type="text" value="<?php echo $Colonia ?>" required>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Calle:</label>
				</td>
				<td>
					<input  name="txtCalle" type="text"  value="<?php echo $Calle ?>" required>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Telefono:</label>
				</td>
				<td>
					<input  name="txtTelefono" type="text" value="<?php echo $Telefono ?>" required>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Codigo Postal:</label>
				</td>
				<td>
					<input  name="txtCodigoPostal" type="text" value="<?php echo $CodigoPostal ?>" required>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Municipio:</label>
				</td>
				<td>
					<input name="txtMunicipio" type="text" value="<?php echo $Municipio ?>" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Factura:</label>
				</td>
				<td>
					<input  name="txtFactura" type="text" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Fecha Factura:</label>
				</td>
				<td>
					<input  name="txtFechaFactura" type="date" value="<?php echo $FechaFactura  ?>" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Fecha Primer Pago:</label>
				</td>
				<td>
					<input name="txtFechaPrimerPago" type="date" value="<?php echo $FechaPrimerPago ?>" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Financiamiento:</label>
				</td>
				<td>
					<input name="txtFinanciamiento" type="text" value="<?php echo $Financiamiento ?>" required>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Monto total de la factura:</label>
				</td>
				<td>
					<input name="txtMontoTotalFactura" type="text" value="<?php echo $MontoTotalFactura ?>" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Articulos:</label>
				</td>
				<td>
					<textarea name="txtArticulos" type="textarea" rows="3" cols="50" required><?php echo $Articulos; ?></textarea> 
				</td>	
			</tr>
			<tr>
				<td>
					<label>Ruta:</label>
				</td>
				<td>
							<?php 

								$rutas=ObtenerRutas();

							
							?>
							<select name="cmbRuta" required >
								<option value="<?php echo $Ruta ?>"><?php echo $Ruta ?> </option>";
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
					<input id="txtNumeroDePretarjeta" name="txtNumeroDePretarjeta" type="text" value="<?php echo $NumeroDePretarjeta ?>" >
					<input name="btnAccion" type="submit" value="Buscar Pretarjeta" formnovalidate="formnovalidate">
				</td>
			</tr>
			<tr>
				<td>
					<label>Plazo:</label>
				</td>
				<td>
					<input  name="txtPlazo" type="text" value="<?php echo $Plazo ?>" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Pago Puntual:</label>
				</td>
				<td>
					<input name="txtPagoPuntual" type="text" value="<?php echo $PagoPuntual ?>" required>
				</td>
			</tr>
			<tr>
				<td>
					<label>Pago Normal:</label>
				</td>
				<td>
					<input name="txtPagoNormal" type="text" value="<?php echo $PagoNormal ?>" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Observaciones:</label>
				</td>
				<td>
					<textarea name="txtObservaciones" rows="3" cols="50" ><?php echo $Observaciones ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label>Vendedor:</label>
				</td>
				<td>
					<input name="txtVendedor" type="text" value="<?php echo $Vendedor ?>" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Comision:</label>
				</td>
				<td>
					<input name="txtComision" type="text" value="<?php echo $Comision ?>" requiered>
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
					<input  name="txtNombreAval" type="text" value="<?php echo $NombreAval ?>" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Colonia:</label>
				</td>
				<td>
					<input  name="txtColoniaAval" type="text" value="<?php echo $ColoniaAval ?>" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Calle:</label>
				</td>
				<td>
					<input name="txtCalleAval" type="text" value="<?php echo $CalleAval ?>" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Telefono:</label>
				</td>
				<td>
					<input name="txtTelefonoAval" type="text" value="<?php echo $TelefonoAval ?>" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Codigo Postal:</label>
				</td>
				<td>
					<input name="txtCodigoPostalAval" type="text" value="<?php echo $CodigoPostalAval ?>" requiered>
				</td>
			</tr>
			<tr>
				<td>
					<label>Municipio:</label>
				</td>
				<td>
					<input name="txtMunicipioAval" type="text" value="<?php echo $MunicipioAval ?>" requiered>
				</td>
			</tr>
			<tr>

				<td colspan="2" align="center">
					<input  name="btnAccion" value="Alta" type="submit" onClick="alert("");">
				
				</td>
			</tr>
			</form>	
			</div>
		</table>
		</div>
	</body>
<html>