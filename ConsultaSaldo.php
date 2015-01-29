
<DOCTYPE! html>

<html lang="es">
<head>
	<meta charset='utf-8'>
	<title>Consulta Clientes</title>
	<link rel="stylesheet"  href="css/normalize.css">
	<link rel="stylesheet"  href="css/estilo.css">
</head>






<body>

<?php

	include("Funciones.php");

//----------------------------------------------------------------------------------------------


if(isset($_GET['txtIdCliente']))
{
	$IdCliente=$_GET['txtIdCliente'];
}else
{
	$IdCliente='';
}


if(isset($_GET['txtIdFactura']))
{
	$IdFactura=$_GET['txtIdFactura'];
}else
{
	$IdFactura='';
}

if(isset($_GET['txtNumeroPretarjeta']))
{
	$NumeroPretarjeta=$_GET['txtNumeroPretarjeta'];
}else
{
	$NumeroPretarjeta='';
}

if(isset($_GET['txtNombreCliente']))
{
	$NombreCliente = $_GET['txtNombreCliente'];	
}else
{
	$NombreCliente='';
}

if(isset($_GET['txtColonia']))
{
		$Colonia = $_GET['txtColonia'];
}else
{
	$Colonia='';
}
	
if(isset($_GET['txtCalle'])) 
{
		$Calle =$_GET['txtCalle'];
}else
{
	$Calle='';
}
	

if(isset($_GET['txtTelefono']) )
{
		$Telefono=$_GET['txtTelefono'];
}else
{
	$Telefono='';
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


if(isset($_GET['txtMontoFactura']))
{
	$MontoFactura=$_GET['txtMontoFactura'];
	
}else
{
	$MontoFactura='';
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

if(isset($_GET['txtRuta']))
{
	
	$Ruta=$_GET['txtRuta'];
	
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

if(isset($_GET['txtSaldo']))
{
	
	
	$Saldo=$_GET['txtSaldo'];
	
}else
{
	$Saldo='';
}


if(isset($_GET['txtSaldoInicialFactura']))
{
	$SaldoInicialFactura=$_GET['txtSaldoInicialFactura'];
}else
{
	$SaldoInicialFactura="";
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
}else
{
	$Mensaje="";
}



if(isset($_GET['txtDiaDePago']))
{
	$DiaDePago=$_GET['txtDiaDePago'];
}else
{
	$DiaDePago="";
}


if(isset($_GET['btnAccion']))
{
	$boton=$_GET['btnAccion'];
}else
{
	$boton="";
}
	

if(isset($_GET['txtConsultaExistosa']))
{
	$consultaExitosa=$_GET['txtConsultaExistosa'];
}
else
{
	$consultaExitosa=0;
}



if(isset($_GET['txtObservaciones']))
{
	$Observaciones=$_GET['txtObservaciones'];
}
else
{
	$Observaciones="";
}

$link=mysqli_connect('localhost','root','','bodegon') ;


if ($boton=="Buscar Cliente") 
		{
		


			

				$resultadoAval=mysqli_query($link,"select * from avales where IdCliente='$IdCliente'");

				$renglonAval=mysqli_fetch_assoc($resultadoAval);
				
				if (is_null($renglonAval)) {
					
						
						$resultado=mysqli_query($link,"select * from clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)  where a.IdCliente='$IdCliente'");					

					 $Aval=0;
				}else
				{
				

					$resultado=mysqli_query($link,"select * from clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) inner join avales as c on (b.IdCliente=c.IdCliente) where a.IdCliente='$IdCliente'");

					 $Aval=1;
				}
				

					

				$Mensaje='El cliente no existe';
			
		}
	
	if($boton=="Buscar Factura")
		{

			

			$resultadoAval=mysqli_query($link,"select * from avales where IdCliente='$IdCliente'");

				$renglonAval=mysqli_fetch_assoc($resultadoAval);
				
				if (is_null($renglonAval)) {
						
						$resultado=mysqli_query($link,"select * from clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)  where b.IdFactura='$IdFactura'");					

						 $Aval=0;
				}else
				{

					$resultado=mysqli_query($link,"select * from clientes as a inner join factura as b on (a.IdCliente=b.IdCliente) inner join avales as c on (b.IdCliente=c.IdCliente) where b.IdFactura='$IdFactura'");

					 $Aval=1;
				}







				$Mensaje='La factura no existe';
		}


	




				if ($consultaExitosa==1)
				{ 
					
				
					
					$renglon=mysqli_fetch_assoc($resultado);
						
					




			 $IdFactura=$renglon['IdFactura'];

			 $IdCliente=$renglon['IdCliente'];

			 $NombreCliente = $renglon['NombreCliente']; 
			//echo "____";
			 $Colonia=$renglon['Colonia'];
			//echo "____";
			 $Calle=$renglon['Calle'];
			//echo "____";
			 $Telefono=$renglon['Telefono'];
			//echo "____";
			 $CodigoPostal=$renglon['CodigoPostal'];
			//echo "____";
			 $Municipio=$renglon['Municipio'];
			//echo "____";
			 $FechaFactura=$renglon['FechaFactura'];
			//echo "____";
			 $Financiamiento=$renglon['Financiamiento'];
			//echo "____";
			 $MontoTotalFactura=$renglon['MontoTotalFactura'];
			//echo "____";
			 $Articulos=$renglon['Articulos'];
			//echo "____";
			 $Ruta=$renglon['Ruta'];
			//echo "____";
			 $Plazo=$renglon['Plazo'];
			//echo "____";
			 $PagoNormal=$renglon['PagoNormal'];
			//echo "____";
			 $PagoPuntual=$renglon['PagoPuntual'];
			//echo "____";
			 $DiaDePago=$renglon['DiaDePago'];
			//
			 $Vendedor=$renglon['Vendedor'];
			  //
			 $Comision=$renglon['Comision'];
			   //
			 $NotasDeCargoIniciales=$renglon['NotasDeCargo'] ;

			  $Observaciones=$renglon['Observaciones'];


			//echo "____";
			/*------------Avales----------*/
			//echo "Aval";
			//echo "____";
			if ($Aval==1) {
				
				
			$NombreAval=$renglon['NombreAval'];
			//echo "____";
			  $ColoniaAval=$renglon['ColoniaAVal'];
			//echo "____";
			 $CalleAval=$renglon['CalleAval'];
			//echo "____";
			 $TelefonoAval=$renglon['TelefonoAval'];
			//echo "____";
			 $CodigoPostalAval=$renglon['CodigoPostalAval'];
			//echo "____";
			 $MunicipioAval=$renglon['MunicipioAval'];


			}
			else
			{
			 $NombreAval="";
			//echo "____";
			 $ColoniaAval="";
			//echo "____";
			 $CalleAval="";
			//echo "____";
			 $TelefonoAval="";
			//echo "____";
			 $CodigoPostalAval="";
			//echo "____";
			 $MunicipioAval="";
			}
			
			 $SaldoInicialFactura=$renglon['SaldoInicialFactura'];

			 $SaldoInicialFactura=$SaldoInicialFactura+$NotasDeCargoIniciales;


			//$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura,$NotasDeCargoIniciales,$link);

						
					$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura );
					

				}




	/* function Saldo($IdFactura,$MontoTotalFactura,$SaldoInicial,$NotasDeCargoIniciales, $link)
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
	}*/








?>

	<div class="container">
	
		<?php 

			include_once("Menu_Header.html");

		?>

	 <div class="formulario">
	<form method="get" name="frmAplicaPago" action="ConsultaSaldoAccion.php">
	<table  align="center">
		<tr>
			<td>
			<label>No. de Cliente:</label>
			</td>
			<td>
			<input  name='txtIdCliente' type="text" value='<?php echo $IdCliente ?>' >
			<input  name='btnAccion' type='submit' value='Buscar Cliente'>
			</td>
		</tr>
		<tr>
			<td>
				<label>Nombre del Cliente:</label>
			</td>
			<td>
				<input name='txtNombreCliente' type='text' value='<?php echo $NombreCliente ?>'  >
			</td>
		</tr>
		<tr>
				<td>
					<label>Colonia:</label>
				</td>
				<td>
					<input  name='txtColonia' type='text' value='<?php echo $Colonia ?>' >
				</td>	
			</tr>
			<tr>
				<td>
					<label>Calle:</label>
				</td>
				<td>
					<input  name='txtCalle' type='text'  value='<?php echo $Calle ?>' >
				</td>	
			</tr>
			<tr>
				<td>
					<label>Telefono:</label>
				</td>
				<td>
					<input  name='txtTelefono' type='text' value='<?php echo $Telefono ?>' >
				</td>	
			</tr>
			<tr>
				<td>
					<label>Codigo Postal:</label>
				</td>
				<td>
					<input  name='txtCodigoPostal' type='text' value='<?php echo $CodigoPostal ?>' >
				</td>	
			</tr>
			<tr>
				<td>
					<label>Municipio:</label>
				</td>
				<td>
					<input  name='txtMunicipio' type='text' value='<?php echo $Municipio ?>' >
				</td>
			</tr>
			<tr>
			<td>
			<label>Factura:</label>
			</td>
			<td>
			<input  name='txtIdFactura' type='text' value='<?php echo $IdFactura ?>' >
			<input  name='btnAccion' type='submit' value='Buscar Factura'>
			</td>
		</tr>
		<tr>
			<td>
				<label>Fecha de la factura:</label>
			</td>
			<td>
				<input  name='txtFechaFactura' type='text' value='<?php echo date('d-m-Y', strtotime($FechaFactura));?>' readonly>
			</td>
		</tr>
			<tr>
				<td>
					<label>Financiamiento:</label>
				</td>
				<td>
					<input  name='txtFinanciamiento' type='number' value='<?php echo $Financiamiento ?>' readonly>
				</td>	
			</tr>
			<tr>
				<td>
					<label>Monto total de la factura:</label>
				</td>
				<td>
					<input  name='txtMontoTotalFactura' type='number' value='<?php echo $MontoTotalFactura ?>' readonly>
					
				<!--	<a href="EditarTotalFactura.php?txtIdFactura=<?php echo $IdFactura?>&txtFechaFactura=<?php echo$FechaFactura ?>&txtPlazo=<?php echo $Plazo ?>&txtMontoTotalFactura=<?php echo$MontoTotalFactura ?>">Editar Total Factura</a>-->
				</td>
			</tr>
			<tr>
				<td>
					<label>Articulos:</label>
				</td>
				<td>
					<textarea  name='txtArticulos' type='textarea' rows="3" cols="50" ><?php echo $Articulos; ?></textarea> 
				</td>	
			</tr>
			<tr>
				<td>
					<label>Observaciones: </label>
				</td>
				<td>
					<textarea anme="txtObservaciones" type="textarea" rows="3" cols="50"><?php echo $Observaciones; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label>Ruta:</label>
				</td>
				<td>
					<input  name='txtRuta' type='text' value='<?php echo $Ruta ?>' readonly>
				</td>
			</tr>
			<tr>
				<td>
					<label>Plazo:</label>
				</td>
				<td>
					<input  name='txtPlazo' type='text' value='<?php echo $Plazo ?>' readonly>
				</td>
			</tr>
			<tr>
				<td>
					<label>Pago Puntual:</label>
				</td>
				<td>
					<input  name='txtPagoPuntual' type='text'value='<?php echo $PagoPuntual ?>' readonly>
				</td>
			</tr>
			<tr>
				<td>
					<label>Pago Normal:</label>
				</td>
				<td>
					<input  name='txtPagoNormal' type='text' value='<?php echo $PagoNormal ?>' readonly>
				</td>
			</tr>
			<tr>
				<td>
					<label>Vendedor:</label>
				</td>
				<td>
					<input  name='txtVendedor' type='text' value='<?php echo $Vendedor ?>' >
				</td>
			</tr>
			<tr>
				<td>
					<label>Comision:</label>
				</td>
				<td>
					<input  name='txtComision' type='text' value='<?php echo $Comision ?>' >
				</td>
			</tr>
		<tr>
			<td>
				<label>Dia de Pago:</label>
			</td>
			<td>
				<input  name='txtDiaDePago' type='text' value='<?php echo $DiaDePago ?>' >
				<a href="EditarDiaDePago.php?txtIdFactura=<?php echo $IdFactura?>&txtDiaDePagoActual=<?php echo$DiaDePago ?>">Editar dia de pago</a>
			</td>
		</tr>
		<tr>
			<td>
				<label>Saldo Factura</label>
			</td>
			<td>
				<?php 

					//$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura);

				?>
				<input name='txtSaldo' type='number' value='<?php echo $Saldo ?>' readonly>
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
					<input  name='txtNombreAval' type='text' value='<?php echo $NombreAval ?>' >
				</td>
			</tr>
			<tr>
				<td>
					<label>Colonia:</label>
				</td>
				<td>
					<input  name='txtColoniaAval' type='text' value='<?php echo $ColoniaAval ?>' >
				</td>
			</tr>
			<tr>
				<td>
					<label>Calle:</label>
				</td>
				<td>
					<input  name='txtCalleAval' type='text' value='<?php echo $CalleAval ?>' >
				</td>
			</tr>
			<tr>
				<td>
					<label>Telefono:</label>
				</td>
				<td>
					<input  name='txtTelefonoAval' type='text' value='<?php echo $TelefonoAval ?>' >
				</td>
			</tr>
			<tr>
				<td>
					<label>Codigo Postal:</label>
				</td>
				<td>
					<input  name='txtCodigoPostalAval' type='text' value='<?php echo $CodigoPostalAval ?>' >
				</td>
			</tr>
			<tr>
				<td>
					<label>Municipio:</label>
				</td>
				<td>
					<input  name='txtMunicipioAval' type='text' value='<?php echo $MunicipioAval ?>' >
				</td>
			</tr>
			<!--<tr>
				<td colspan='2' align='center'>
					<input  name='btnAccion' value='Actualizar Datos' type='submit'>
				
				</td>
			</tr>-->
	</table>

	
				<?php /*

				
						$query="select * from  Factura  as a  inner join 
							pagos as b on (a.IdFactura=b.IdFactura)  where  a.IdFactura='$IdFactura' and a.idCliente='$IdCliente'";

					


					$resultado=$link->query($query);


					if (mysqli_affected_rows($link)>0)
					{

						echo "<table border='1px' align='center'>
							<tr>
							<td>Folio</td>
							<td>Monto</td>
							<td>Fecha de pago</td>
							<td>Tipo de Documento</td>
							<td>Tipo de Pago</td>
							<td></td>
							</tr> " ;

						while ($renglon=$resultado->fetch_array()) 
							{
								$NumFolio=$renglon["IdPago"];
								$Monto=$renglon["MontoPago"];
								$FechaPago=$renglon["FechaPago"];
								$TipoDocumento=$renglon["TipoDocumento"];
								$TipoPago=$renglon["TipoPago"];



								echo "<tr>
								<td>$NumFolio</td>
								<td>$$Monto</td>
								<td>$FechaPago</td>
								<td>$TipoDocumento</td>
								<td>$TipoPago</td>
								<td><a href='EditarPagos.php?NumFolio=$NumFolio'>Editar</a></td>
								</tr>";



						}

						echo "</table>";
					}
					
					*/
					
					
				?>
		
	</form>
</div>  <!--Div Formulario-->
</div><!--Div Container-->
</body>
</html>