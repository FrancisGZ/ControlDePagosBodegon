<?php



			/*----Obtiene la Informacion del cliente----***/	
	$IdCliente = $_GET['txtIdCliente'];	
	$IdFactura = $_GET['txtIdFactura'];	
	//$NumeroPretarjeta=$_GET['txtNumeroPretarjeta'];
	$NombreCliente = $_GET['txtNombreCliente'];	
	$Colonia = $_GET['txtColonia'];
	$Calle =$_GET['txtCalle'];
	$Telefono=$_GET['txtTelefono'];
	$CodigoPostal=$_GET['txtCodigoPostal'];
	$Municipio=$_GET['txtMunicipio'];
	
	$FechaFactura=$_GET['txtFechaFactura'];
	$Financiamiento=$_GET['txtFinanciamiento'];
	$MontoTotalFactura=$_GET['txtMontoTotalFactura'];
	$Articulos=$_GET['txtArticulos'];
	$Ruta=$_GET['txtRuta'];
	$Plazo=$_GET['txtPlazo'];
	$PagoPuntual=$_GET['txtPagoPuntual'];
	$PagoNormal=$_GET['txtPagoNormal'];
	$Vendedor=$_GET['txtVendedor'];
	$Comision=$_GET['txtComision'];


	/*-------------------------Obtiene la infomacion del aval-----------------------------------------*/

	$NombreAval=$_GET['txtNombreAval'];
	$ColoniaAval=$_GET['txtColoniaAval'];
	$CalleAval=$_GET['txtCalleAval'];
	$TelefonoAval=$_GET['txtTelefonoAval'];
	$CodigoPostalAval=$_GET['txtCodigoPostalAval'];
	$MunicipioAval=$_GET['txtMunicipioAval'];


	/*------------------------Obtiene el valor del boton pulsado------------------------------------*/

	$boton=$_GET['btnAccion'];




	$link=mysqli_connect('localhost','root','','bodegon');






	/*if($boton=='Actualizar Datos')
	{
		echo "Actualiza Datos";

		if(!mysqli_query($link,"Update clientes set NombreCliente='$NombreCliente',Colonia='$Colonia', Calle='$Calle',Telefono='$Telefono', CodigoPostal='$CodigoPostal', Municipio='$Municipio', Ruta='$Ruta' where IdCliente='$IdCliente'"))
			
		{
			printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
		}

		if(!mysqli_query($link,"Update factura set Financiamiento='$Financiamiento', MontoFactura='$MontoFactura', MontoTotalFactura='$MontoTotalFactura',
									Plazo='$Plazo', Articulos='$Articulos', PagoNormal='$PagoNormal', PagoPuntual='$PagoPuntual', Vendedor='$Vendedor', Comision='$Comision' where IdFactura='$IdFactura'"))
		{
			printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
		}



			$resultadoAval=mysqli_query($link,"select * from avales where IdCliente='$IdCliente'");

				$renglonAval=mysqli_fetch_assoc($resultadoAval);
				
				if (is_null($renglonAval)) {
						
						
						echo "insertar";

						echo $IdCliente;

							if(!mysqli_query($link,"insert into Avales (IdCliente,NombreAval,ColoniaAval,CalleAval,CodigoPostalAval,MunicipioAval,TelefonoAval) values
												('$IdCliente','$NombreAval','$ColoniaAval','$CalleAval','$CodigoPostalAval','$MunicipioAval','$TelefonoAval')"))
							{
								printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
							}




						
				}else
				{

					echo "Actualizar";

					if(!mysqli_query($link,"Update avales set NombreAval='$NombreAval', ColoniaAval='$ColoniaAval', CalleAval='$CalleAval',TelefonoAval='$TelefonoAval',CodigoPostalAval='$CodigoPostalAval', MunicipioAval='$MunicipioAval' where IdCliente='$IdCliente'"))
												
					{
						printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
					}


					
				}



		
		header("location:ConsultaSaldo.php?Mensaje=Se actualizaron los datos");

		$Mensaje='Se actualizaron los datos correctamente';

				
	}*/




	if ($boton=="Buscar Cliente") 
		{
		


			

				$resultadoAval=mysqli_query($link,"select * from avales where IdCliente='$IdCliente'");

				$renglonAval=mysqli_fetch_assoc($resultadoAval);
				
				if (is_null($renglonAval)) {
					echo "Sin Aval";
						
						$resultado=mysqli_query($link,"select * from clientes as a inner join factura as b on (a.IdCliente=b.IdCliente)  where a.IdCliente='$IdCliente'");					

					 $Aval=0;
				}else
				{
					echo "con Aval";

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


		$renglon=mysqli_fetch_assoc($resultado);

		if(is_null($renglon))
		{
			
			header("location:ConsultaSaldo.php?txtIdCliente=$IdCliente&txtIdFactura=$IdFactura&txtMonto=0&txtSaldo=0&Mensaje=$Mensaje&btnAccion=$boton");	
			
			
		}
		else
		{

		
			
				//ObtenerDatos($renglon,$link,$Aval); 

			header("location:ConsultaSaldo.php?txtIdCliente=$IdCliente&txtIdFactura=$IdFactura&txtConsultaExistosa=1&btnAccion=$boton");	
			
		}
		
	

	function ObtenerDatos($renglon,$link,$Aval )
	{
			
			
			
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




			$Saldo=Saldo($IdFactura,$MontoTotalFactura,$SaldoInicialFactura,$NotasDeCargoIniciales,$link);
			

			
			//header("location:ConsultaSaldo.php?txtIdFactura=$IdFactura&txtIdCliente=$IdCliente&txtSaldo=$Saldo&txtNombreCliente=$NombreCliente&txtColonia=$Colonia&txtCalle=$Calle&txtTelefono=$Telefono&txtCodigoPostal=$CodigoPostal&txtMunicipio=$Municipio&txtFechaFactura=$FechaFactura&txtFinanciamiento=$Financiamiento&txtMontoTotalFactura=$MontoTotalFactura&txtArticulos=$Articulos&txtPlazo=$Plazo&txtRuta=$Ruta&txtPagoPuntual=$PagoPuntual&txtPagoNormal=$PagoNormal&txtVendedor=$Vendedor&txtComision=$Comision&txtNombreAval=$NombreAval&txtColoniaAval=$ColoniaAval&txtCalleAval=$CalleAval&txtTelefonoAval=$TelefonoAval&txtCodigoPostalAval=$CodigoPostalAval&txtMunicipioAval=$MunicipioAval&txtDiaDePago=$DiaDePago&txtSaldoInicialFactura=$SaldoInicialFactura");
			

			echo"<script language='javascript'>window.location='ConsultaSaldo.php?txtIdFactura=$IdFactura&txtIdCliente=$IdCliente&txtSaldo=$Saldo&txtNombreCliente=$NombreCliente&txtColonia=$Colonia&txtCalle=$Calle&txtTelefono=$Telefono&txtCodigoPostal=$CodigoPostal&txtMunicipio=$Municipio&txtFechaFactura=$FechaFactura&txtFinanciamiento=$Financiamiento&txtMontoTotalFactura=$MontoTotalFactura&txtArticulos=$Articulos&txtPlazo=$Plazo&txtRuta=$Ruta&txtPagoPuntual=$PagoPuntual&txtPagoNormal=$PagoNormal&txtVendedor=$Vendedor&txtComision=$Comision&txtNombreAval=$NombreAval&txtColoniaAval=$ColoniaAval&txtCalleAval=$CalleAval&txtTelefonoAval=$TelefonoAval&txtCodigoPostalAval=$CodigoPostalAval&txtMunicipioAval=$MunicipioAval&txtDiaDePago=$DiaDePago&txtSaldoInicialFactura=$SaldoInicialFactura'</script>";
	}


	 function Saldo($IdFactura,$MontoTotalFactura,$SaldoInicial,$NotasDeCargoIniciales, $link)
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
	}
?>