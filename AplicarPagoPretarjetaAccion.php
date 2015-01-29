<?php
	

		include("Funciones.php");

		include("FuncionesParaInsertarDatosEnPretarjeta.php");

		include("FuncionesParaInsertarDatosEnFactura.php");

		

		if (isset($_GET['txtNombreCliente'])) 
		{
			$NombreCliente=$_GET['txtNombreCliente'];
		}else
		{
			$NombreCliente="";
		}

		if (isset($_GET['txtMontoTotalFactura'])) 
		{
			$MontoTotalFactura=$_GET['txtMontoTotalFactura'];	
		}else
		{
			$MontoTotalFactura="";
		}

		if(isset($_GET['txtNumeroDePretarjeta']))
		{
			$NumeroDePretarjeta=$_GET['txtNumeroDePretarjeta'];
		}else
		{
			$NumeroDePretarjeta="";
		}
		
		
		

		if(isset($_GET['cmbTipoDocumento']))
		{
			$TipoDocumento=$_GET['cmbTipoDocumento'];
		}else
		{
			$TipoDocumento="";
		}

		if(isset($_GET['cmbTipoPago']))
		{
			$TipoPago=$_GET['cmbTipoPago'];
		}else
		{
			$TipoPago="";
		}


		if(isset($_GET['txtIdPago']))
		{
			$IdPago = $_GET['txtIdPago'];	
		}else
		{
			$IdPago="";
		}



		if(isset($_GET["btnAccion"]))
		{
			 $boton=$_GET["btnAccion"];
		}else
		{
			$boton="";
		}
	

		if(isset($_GET["txtMontoPago"]))
		{
			$MontoPago = $_GET["txtMontoPago"];	
		}else
		{
			$MontoPago="";
		}
		

		
		if (isset($_GET["txtFechaPago"])) 
		{
			$FechaPago=$_GET["txtFechaPago"];

		}else
		{
			$FechaPago="";
		}





		if($boton=="Buscar Cliente")
			{
		
				
				$queryBuscaCliente("select * from clientes as a inner join Factura as b on 
				(a.IdCliente=b.IdCliente) where a.IdCliente='$IdCliente'");
				
				$renglon=ResultadoQuery($queryBuscaCliente);

		if(is_null($renglon))
			{
				
				header("location:AplicarPago.php?txtIdCliente=$IdCliente&txtMontoTotalFactura=0&txtSaldo=0&Mensaje=El cliente no existe");
			}
		else{

			$NombreCliente = $renglon['NombreCliente']; 
			$IdFactura =$renglon['IdFactura'];
			$PagoPuntual=$renglon['PagoPuntual'];
			$PagoNormal=$renglon['PagoNormal'];
			$MontoTotalFactura=$renglon['MontoTotalFactura'];
			$SaldoFactura=$renglon['SaldoFactura'];

			
		 $Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura,$link);
		
		header("location:AplicarPago.php?txtIdCliente=$IdCliente&txtNombreCliente=$NombreCliente&txtIdFactura=$IdFactura&txtMontoTotalFactura=$MontoTotalFactura&txtSaldo=$Saldo&txtPagoNormal=$PagoNormal&txtPagoPuntual=$PagoPuntual");
	}
	
}


if ($boton=="Buscar Pretarjeta") {
		
		

		$queryPretarjeta="select * from clientestemporal as a inner join Facturatemporal as b on 
				(a.NumeroDePretarjeta=b.NumeroDePretarjeta) where b.NumeroDePretarjeta='$NumeroDePretarjeta'";

		$existePretarjeta=VerificaSiExisteRegistro($queryPretarjeta);


		if(!$existePretarjeta)
			{
				$Mensaje="La pretarjeta no existe";
				header("location:AplicarPagoPretarjeta.php?txtMontoTotalFactura=0&txtSaldo=0&Mensaje=$Mensaje");
			}
			else{

				$queryBuscaPretarjeta="select * from clientestemporal as a inner join Facturatemporal as b on 
				(a.NumeroDePretarjeta=b.NumeroDePretarjeta) where b.NumeroDePretarjeta='$NumeroDePretarjeta'";

				$renglon=ResultadoQuery($queryBuscaPretarjeta);

				$NombreCliente = $renglon['NombreCliente']; 
				$MontoTotalFactura=$renglon['MontoTotalFactura'];
				$PagoPuntual=$renglon['PagoPuntual'];
				$PagoNormal=$renglon['PagoNormal'];
			
				$Saldo=SaldoPretarjeta($NumeroDePretarjeta,$MontoTotalFactura);
		
			 
		header("location:AplicarPagoPretarjeta.php?txtNombreCliente=$NombreCliente&txtNumeroDePretarjeta=$NumeroDePretarjeta&txtMontoTotalFactura=$MontoTotalFactura&txtSaldo=$Saldo&txtPagoNormal=$PagoNormal&txtPagoPuntual=$PagoPuntual");
			}
	}




	if($boton=="Buscar Por Nombre")
	{
		header("location:BuscarClientePorNombre.php?txtNombreCliente=$NombreCliente&txtPaginaOrigen=AplicarPago");
	}



	if($boton=="Aplicar Pago")
	{	
		

		$queryVerificaFactura="select * from factura where NumeroDePretarjeta='$NumeroDePretarjeta'";

		$existeFactura=VerificaSiExisteRegistro($queryVerificaFactura);

		if(!$existeFactura)
		{

			echo "factura";
				$queryVerificaPago="select * from pagos where IdPago='$IdPago'";

				$existePago=VerificaSiExisteRegistro($queryVerificaPago);
				
				if(!$existePago)
				{
					
					
					InsertaPagosPretarjeta($IdPago,$NumeroDePretarjeta,$MontoPago,$FechaPago,$TipoDocumento,$TipoPago);

					insertaPagosEnFactura($IdPago,'PRETARJETA',$MontoPago,$TipoDocumento,$TipoPago,$FechaPago);

					$Mensaje="Se aplico el pago";
			
					header("location:AplicarPagoPretarjeta.php?NumeroDePretarjeta=$NumeroDePretarjeta&Mensaje=$Mensaje");

					

				}else
				{
					$Mensaje="Ya existe el numero de recibo";
					header("location:AplicarPagoPretarjeta.php?Mensaje=$Mensaje");


					
				}
		}else
		{
			$Mensaje="La pretarjeta ya fue facturada";
			header("location:AplicarPagoPretarjeta.php?Mensaje=$Mensaje");
		}		
		
	}



	
?>
