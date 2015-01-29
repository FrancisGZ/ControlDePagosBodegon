

<?php
/** 
*
* @Accion para Alta Factura . "AltaFactura.php"
* @versión: 1.1      @modificado: 12 de Octubre del 2014
* @autor: Francis Alonso Gonzalez Zarate
*
*/

	include("funciones.php");

	/*----Obtiene la Informacion del cliente----***/	
	$IdCliente = $_GET['txtIdCliente'];	
	$NumeroDePretarjeta=$_GET['txtNumeroDePretarjeta'];
	$NombreCliente = $_GET['txtNombreCliente'];	
	$Colonia = $_GET['txtColonia'];
	$Calle =$_GET['txtCalle'];
	$Telefono=$_GET['txtTelefono'];
	$CodigoPostal=$_GET['txtCodigoPostal'];
	$Municipio=$_GET['txtMunicipio'];
	$IdFactura = $_GET['txtFactura'];	
	$FechaFactura=$_GET['txtFechaFactura'];
	$FechaPrimerPago=$_GET['txtFechaFactura'];
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


	/*-------------------------Obtiene la infomacion del aval-----------------------------------------*/



	if(isset($_GET["txtNumeroDePretarjeta"]))
	{
		$NumeroDePretarjeta=$_GET["txtNumeroDePretarjeta"];
	}else
	{
		echo $NumeroDePretarjeta=0;
	}


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



	/*------------------------Obtiene el valor del boton pulsado------------------------------------*/

	$boton=$_GET['btnAccion'];


	$link =mysqli_connect('localhost','root','','bodegon');





	


	if($boton=='Alta')
	{



		
		//query para verificar si la factura existe
		$queryVerificaFactura="select * from factura where IdFactura='$IdFactura'";
		$existeFactura=VerificaSiExisteRegistro($queryVerificaFactura);

		//query para verificar si el cliente existe
		$queryVerificaCliente="Select * from clientes where IdCliente='$IdCliente'";
		$existeCliente=VerificaSiExisteRegistro($queryVerificaCliente);

		//if(!is_null($renglonVerificaFactura))
		if($existeFactura) 
		{
			
			$Mensaje="El numero de Factura ya existe";
			header("location:AltaFactura.php?Mensaje=$Mensaje");



		}elseif ($existeCliente) 
		{
			
			$Mensaje="La clave del cliente ya existe";
			header("location:AltaFactura.php?Mensaje=$Mensaje");

		}else
		{
			
				$DiaDePago=ObtenerDiaDeLaSemana($FechaPrimerPago);//Obtiene el dia de pago correspondiente segun su fecha de primer pago

				
				//inserta datos en la tabla clientes
				InsertaCliente($IdCliente,$NombreCliente,$Colonia,$Calle,$Telefono,$CodigoPostal,
								$Municipio,$Ruta);

			


				//Inserta datos en la tabla factura
				InsertaFactura($IdFactura,$IdCliente,$NumeroDePretarjeta,$Financiamiento,$MontoTotalFactura,$FechaFactura,$Plazo,$Articulos,$FechaPrimerPago,$DiaDePago,
																$PagoNormal,$PagoPuntual,$Observaciones,$Vendedor,$Comision);

				

				//Inserta datos en la tabla Aval
				InsertaAval($IdCliente,$NombreAval,$ColoniaAval,$CalleAval,$CodigoPostalAval,$MunicipioAval,$TelefonoAval);


				//Pasar pagos de la pretarjeta a la factura

				InsertaPagosPretarjetaAFactura($NumeroDePretarjeta,$IdFactura);

				//header("location:ConsultaSaldo.php");
			
		}		

		
		


	}

	if($boton=='Buscar Pretarjeta')
	{
		

		$queryPretarjeta="select * from clientestemporal as a inner join facturatemporal as b on (a.NumeroDePretarjeta=b.NumeroDePretarjeta) inner join avalestemporal as c on (b.NumeroDePretarjeta=c.NumeroDePretarjeta) where a.NumeroDePretarjeta=$NumeroDePretarjeta";

		$existePretarjeta=VerificaSiExisteRegistro($queryPretarjeta);

		

		if(!$existePretarjeta)
		{

			$Mensaje="El numero de pretarjeta no existe";
			header("location:AltaFactura.php?Mensaje=$Mensaje");
		}
		else
		{
				$renglon=ResultadoQuery($queryPretarjeta);

				ObtenerDatosYRedireccionar($renglon);
			
			
		}

		
		
	}





		function ObtenerDatosYRedireccionar($renglon)
		{
			
			echo $NumeroDePretarjeta=$renglon['NumeroDePretarjeta'];
			echo "____";
			echo $NombreCliente = $renglon['NombreCliente']; 
			echo "____";
			echo $Colonia=$renglon['Colonia'];
			echo "____";
			echo $Calle=$renglon['Calle'];
			echo "____";
			echo $Telefono=$renglon['Telefono'];
			echo "____";
			echo $CodigoPostal=$renglon['CodigoPostal'];
			echo "____";
			echo $Municipio=$renglon['Municipio'];
			echo "____";
			echo $FechaFactura=$renglon['FechaFactura'];
			echo "____";
			echo $Financiamiento=$renglon['Financiamiento'];
			echo "____";
			echo $MontoTotalFactura=$renglon['MontoTotalFactura'];
			echo "____";
			echo $Articulos=$renglon['Articulos'];
			echo "____";
			echo $Ruta=$renglon['Ruta'];
			echo "____";
			echo $Plazo=$renglon['Plazo'];
			echo "____";
			echo $PagoNormal=$renglon['PagoNormal'];
			echo "____";
			echo $PagoPuntual=$renglon['PagoPuntual'];
			echo "____";
			echo $FechaPrimerPago=$renglon['FechaPrimerPago'];
			echo "____";
			echo $Observaciones=$renglon['Observaciones'];
			echo "____";
			echo $Vendedor=$renglon['Vendedor'];
			echo "____";
			echo $Comision=$renglon['Comision'];
			/*------------Avales----------*/
			echo "Aval";
			echo "____";
			echo $NombreAval=$renglon['NombreAval'];
			echo "____";
			echo $ColoniaAval=$renglon['ColoniaAval'];
			echo "____";
			echo $CalleAval=$renglon['CalleAval'];
			echo "____";
			echo $TelefonoAval=$renglon['TelefonoAval'];
			echo "____";
			echo $CodigoPostalAval=$renglon['CodigoPostalAval'];
			echo "____";
			echo $MunicipioAval=$renglon['MunicipioAval'];

			
			



			header("location:AltaFactura.php?txtNombreCliente=$NombreCliente&txtColonia=$Colonia&txtCalle=$Calle&txtTelefono=$Telefono&txtCodigoPostal=$CodigoPostal&txtMunicipio=$Municipio&txtFechaFactura=$FechaFactura&txtFechaPrimerPago=$FechaPrimerPago&txtFinanciamiento=$Financiamiento&txtMontoTotalFactura=$MontoTotalFactura&txtArticulos=$Articulos&cmbRuta=$Ruta&txtNumeroDePretarjeta=$NumeroDePretarjeta&txtPlazo=$Plazo&txtPagoPuntual=$PagoPuntual&txtPagoNormal=$PagoNormal&txtObservaciones=$Observaciones&txtVendedor=$Vendedor&txtComision=$Comision&txtNombreAval=$NombreAval&txtColoniaAval=$ColoniaAval&txtCalleAval=$CalleAval&txtTelefonoAval=$TelefonoAval&txtCodigoPostalAval=$CodigoPostalAval&txtMunicipioAval=$MunicipioAval");
			
	}


	
	



?>