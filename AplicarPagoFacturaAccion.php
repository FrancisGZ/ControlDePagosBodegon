<?php
	
		include("Funciones.php");

		include("FuncionesParaInsertarDatosEnFactura.php");

		if(isset($_GET['txtIdCliente']))
		{
			$IdCliente = $_GET['txtIdCliente'];	
		}else
		{
			$IdCliente="";
		}

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

		if(isset($_GET['txtIdFactura']))
		{
			$IdFactura=$_GET['txtIdFactura'];
		}else
		{
			$IdFactura="";
		}
		
		
		if(isset($_GET['txtSaldo']))
		{
			$Saldo=$_GET['txtSaldo'];
		}else
		{
			$Saldo="";
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


		if(isset($_GET["txtPagoNormal"]))
		{
			$PagoNormal=$_GET["txtPagoNormal"];

		}else
		{
			$PagoNormal=$_GET["txtPagoNormal"];
		}


		if(isset($_GET["txtPagoPuntual"]))
		{
			$PagoPuntual=$_GET["txtPagoPuntual"];
		}else
		{
			$PagoPuntual=$_GET["txtPagoPuntual"];
		}
		
	
		if(isset($_GET['txtIdPago']))
			{
				$IdPago = $_GET['txtIdPago'];	
			}else
			{
				$IdPago="";
			}


		if(isset($_GET['txtPago']))
			{
				$MontoPago = $_GET['txtPago'];	
			}else
			{
				$MontoPago="";
			}
		

		if(isset($_GET['txtPago']))
			{
				$MontoPago = $_GET['txtPago'];	
			}else
			{
				$MontoPago="";
			}



		if(isset($_GET['txtFechaPago']))
			{
				 $FechaPago = $_GET['txtFechaPago'];	
			}else
			{
				$FechaPago="";
			}


		


		if(isset($_GET['btnAccion']))
			{
				$boton = $_GET['btnAccion'];	
			}else
			{
				$boton="";
			}


		$link = mysqli_connect('localhost', 'root', '', 'bodegon');




		if($boton=="Buscar Cliente")
			{
		
				$resultado=mysqli_query($link,"select * from clientes as a inner join Factura as b on 
				(a.IdCliente=b.IdCliente) where a.IdCliente='$IdCliente'");
		
				$fila=mysqli_fetch_assoc($resultado);

		if(is_null($fila))
			{
				
			header("location:AplicarPagoFactura.php?txtIdCliente=$IdCliente&txtMontoTotalFactura=0&txtSaldo=0&Mensaje=El cliente no existe");
			}
		else{

			$NombreCliente = $fila['NombreCliente']; 
			$IdFactura =$fila['IdFactura'];
			$PagoPuntual=$fila['PagoPuntual'];
			$PagoNormal=$fila['PagoNormal'];
			$MontoTotalFactura=$fila['MontoTotalFactura'];
			$SaldoInicialFactura=$fila['SaldoInicialFactura'];

			
		 $Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura,$link);
		
		 header("location:AplicarPagoFactura.php?txtIdCliente=$IdCliente&txtNombreCliente=$NombreCliente&txtIdFactura=$IdFactura&txtMontoTotalFactura=$MontoTotalFactura&txtSaldo=$Saldo&txtPagoNormal=$PagoNormal&txtPagoPuntual=$PagoPuntual");
	}
	
}


if ($boton=="Buscar Factura") {
		
		$resultado=mysqli_query($link,"select * from clientes as a inner join Factura as b on 
				(a.idCliente=b.idCliente) where b.IdFactura='$IdFactura'");

		$fila=mysqli_fetch_assoc($resultado);

		if(is_null($fila))
			{
				header("location:AplicarPagoFactura.php?txtNocliente=$IdCliente&txtMontoTotalFactura=0&txtSaldo=0&Mensaje=La factura no existe");
			}
			else{
				$NombreCliente = $fila['NombreCliente']; 
			$IdFactura =$fila['IdFactura'];
			$MontoTotalFactura=$fila['MontoTotalFactura'];
			$PagoPuntual=$fila['PagoPuntual'];
			$PagoNormal=$fila['PagoNormal'];
			$SaldoFactura=$fila['SaldoFactura'];
			$IdCliente=$fila['IdCliente'];

		
			$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura,$link);
		
			 
		header("location:AplicarPagoFactura.php?txtIdCliente=$IdCliente&txtNombreCliente=$NombreCliente&txtIdFactura=$IdFactura&txtMontoTotalFactura=$MontoTotalFactura&txtSaldo=$Saldo&txtPagoNormal=$PagoNormal&txtPagoPuntual=$PagoPuntual");
			}
	}




	if($boton=="Buscar Por Nombre")
	{
		header("location:BuscarClientePorNombre.php?txtNombreCliente=$NombreCliente&txtPaginaOrigen=AplicarPago");
	}



	if($boton=="Aplicar Pago")
	{	
		
		
			

			$queryVerificaPago="select * from pagos where IdPago='$IdPago'";

			$existePago=VerificaSiExisteRegistro($queryVerificaPago);
			
			if(!$existePago)
			{
				
				$queryBuscaFactura="select b.SaldoInicialFactura from clientes as a inner join Factura as b on 
				(a.IdCliente=b.IdCliente) where b.IdFactura='$IdFactura'";

				$renglon=ResultadoQuery($queryBuscaFactura);

				if(!is_null($renglon))
				{

					$SaldoInicialFactura=$renglon['SaldoInicialFactura'];
				}else
				{
					$SaldoInicialFactura=0;
				}
			
				
					insertaPagosEnFactura ($IdPago,$IdFactura,$MontoPago,$TipoDocumento,$TipoPago,$FechaPago);
			
				 	$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura);
		
			 		header("location:EstadoDeCuentaAccion.php?txtIdCliente=$IdCliente&btnAccion=Buscar por Clave");

				

			}else
			{
				
				

				header("location:AplicarPagoFactura.php?txtIdCliente=$IdCliente&txtPagoPuntual=$PagoPuntual&txtPagoNormal=$PagoNormal&txtNombreCliente=$NombreCliente&txtIdFactura=$IdFactura&txtMontoTotalFactura=$MontoTotalFactura&txtMontoPago=$MontoPago&txtFechaPago=$FechaPago&txtIdPago=$IdPago&cmbTipoDocumento=$TipoDocumento&cmbTipoPago=$TipoPago&txtSaldo=$Saldo&Mensaje=El folio ya existe");
				
			}
			
		
	}




	function BuscarCliente($IdCliente,$link,$Pago,$FechaPago,$IdPago,$TipoDocumento,$TipoPago)
	{
				$resultado=mysqli_query($link,"select * from clientes as a inner join Factura as b on 
				(a.idCliente=b.idCliente) where a.IdCliente='$IdCliente'");
		
				$fila=mysqli_fetch_assoc($resultado);

		if(is_null($fila))
			{
			header("location:AplicarPagoFactura.php?txtIdCliente=$IdCliente&txtMonto=0&txtSaldo=0&Mensaje=El cliente no existe");
			}
		else{
			$NombreCliente = $fila['NombreCliente']; 
			$IdFactura =$fila['IdFactura'];
			$MontoTotalFactura=$fila['MontoTotalFactura'];
			$SaldoFactura=$fila['SaldoFactura'];
			$PagoPuntual=$fila['PagoPuntual'];
			$PagoNormal=$fila['PagoNormal'];

				$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura,$link);
				
				header("location:AplicarPagoFactura.php?txtIdCliente=$IdCliente&txtPagoPuntual=$PagoPuntual&txtPagoNormal=$PagoNormal&txtNombreCliente=$NombreCliente&txtIdFactura=$IdFactura&txtMontoTotalFactura=$MontoTotalFactura&txtPago=$Pago&txtFechaPago=$FechaPago&txtIdPago=$IdPago&cmbTipoDocumento=$TipoDocumento&cmbTipoPago=$TipoPago&txtSaldo=$Saldo&Mensaje=$El folio ya existe");
			}

	}

	function validarPago($IdPago,$link)
	{

		
		$existePago=mysqli_query($link,"select * from pagos where IdPago='$IdPago'");

		$fila=mysqli_fetch_assoc($existePago);
		
		if(is_null($fila))
			{
				
				return "No existe el pago";
			}else
			{
				
				return "El recibo ya existe";
			}



	}

	/* function Saldo($IdFactura,$MontoTotalFactura,$SaldoFactura, $link)
	{
		$query="select * from pagos where IdFactura='$IdFactura'";
			
								$result =$link->query($query);

								$pagosAplicados =0;
							while($row = $result->fetch_array())
								{
									$pagosAplicados=$pagosAplicados + $row["MontoPago"];
			
								}


								 if ($SaldoFactura>0) {
		 								

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
