

<?php
/** 
*
* @Accion para Alta Factura . "AltaFactura.php"
* @versión: 1.4     @modificado: 23 de Octubre del 2014
* @autor: Francis Alonso Gonzalez Zarate
*
*/

	/*----Obtiene la Informacion del cliente----***/	
	
	include("funciones.php");

	$NumeroDePretarjeta=$_GET['txtNumeroDePretarjeta'];
	$NombreCliente = $_GET['txtNombreCliente'];	
	$Colonia = $_GET['txtColonia'];
	$Calle =$_GET['txtCalle'];
	$Telefono=$_GET['txtTelefono'];
	$CodigoPostal=$_GET['txtCodigoPostal'];
	$Municipio=$_GET['txtMunicipio'];
	$FechaFactura=$_GET['txtFechaFactura'];
	$FechaPrimerPago=$_GET['txtFechaPrimerPago'];
	$Financiamiento=$_GET['txtFinanciamiento'];
	$MontoTotalFactura=$_GET['txtMontoTotalFactura'];
	$Articulos=$_GET['txtArticulos'];
	$Ruta=$_GET['cmbRuta'];
	$Plazo=$_GET['txtPlazo'];
	$PagoPuntual=$_GET['txtPagoPuntual'];
	$PagoNormal=$_GET['txtPagoNormal'];
	$Observaciones=$_GET['txtObservaciones'];
	$Vendedor=$_GET['txtVendedor'];
	$Comision=$_GET['txtComision'];


	/*----Obtiene la infomacion del aval-----*/
	if(isset($_GET["txtNombreAval"]))
	{
		 $NombreAval=$_GET["txtNombreAval"];
	}else
	{
		 $NombreAval="";
	}





	if(isset($_GET["txtColoniaAval"]))
	{
		$ColoniaAval=$_GET["txtColoniaAval"];
	}else
	{
		 $ColoniaAval="";
	}
	

	if(isset($_GET["txtCalleAval"]))
	{
		$CalleAval=$_GET["txtCalleAval"];	
	}else
	{
		 $CalleAval="";
	}
	
	if(isset($_GET["txtTelefonoAval"]))
	{
		$TelefonoAval=$_GET["txtTelefonoAval"];
	}else
	{
		 $TelefonoAval="";
	}


	if(isset($_GET["txtCodigoPostalAval"]))
	{
		$CodigoPostalAval=$_GET['txtCodigoPostalAval'];
	}else
	{
		 $CodigoPostalAval="";
	}
	

	if(isset($_GET["txtMunicipioAval"]))
	{
		$MunicipioAval=$_GET["txtMunicipioAval"];	
	}else
	{
		 $MunicipioAval="";
	}

	







	

			//Verificar si ya existe la pretarjeta (FacturaTemporal)
			$queryBuscaPretarjeta="select * from facturatemporal where NumeroDePretarjeta='$NumeroDePretarjeta'";			
			$existePretarjeta=VerificaSiExisteRegistro($queryBuscaPretarjeta);

			




			if($existePretarjeta)
			{
					$Mensaje="El numero de pretarjeta ya existe";


				header("location:AltaPretarjeta.php?txtNumeroDePretarjeta=$NumeroDePretarjeta&txtNombreCliente=$NombreCliente&txtColonia=$Colonia&txtCalle=$Calle&txtTelefono=$Telefono&txtCodigoPostal=$CodigoPostal
								&txtMunicipio=$Municipio&cmbRuta=$Ruta&Mensaje=$Mensaje");
			}
			else
			{
		
				InsertaClienteTemporal($NumeroDePretarjeta,$NombreCliente,$Colonia,$Calle,$Telefono,$CodigoPostal,
								$Municipio,$Ruta);

			
				InsertaFacturaTemporal($NumeroDePretarjeta,$Financiamiento,$MontoTotalFactura,$FechaFactura,$Plazo,$FechaPrimerPago,$PagoNormal,$PagoPuntual,$Vendedor,$Observaciones,$Comision,$Articulos);



				InsertaAvalesTemporal($NumeroDePretarjeta,$NombreAval,$ColoniaAval,$CalleAval,$CodigoPostalAval,$MunicipioAval,$TelefonoAval);


				header("location:AltaFactura.php");
			}
	


		
?>
