<?php

		include("Funciones.php");

			if (isset($_GET["txtIdFactura"])) 
			{
				
				$IdFactura=$_GET['txtIdFactura'];
			}else
			{
				
				$IdFactura="";
			}

			if(isset($_GET['txtIdCliente']))
			{
				$IdCliente=$_GET['txtIdCliente'];
			}else
			{
				$IdCliente="";
			}


			if(isset($_GET['txtNombreCliente']))
			{
				$NombreCliente=$_GET['txtNombreCliente'];
			}
			else{

				$NombreCliente="";
			}

			if(isset($_GET['btnAccion']))
			{
				$boton=$_GET['btnAccion'];
			}
			else
			{
				$boton="";
			}



			if($boton=="Buscar por Clave" or $boton=="Buscar por Factura")
			{
				if($boton=="Buscar por Clave")
				{

					$queryBuscaClientePorClave="select * from clientes as a inner join Factura as b
												on (a.IdCliente=b.IdCliente)where a.IdCliente='$IdCliente'";

					$renglonCliente=ResultadoQuery($queryBuscaClientePorClave);
				}

				if ($boton=="Buscar por Factura") 
				{
					$queryBuscarClientePorFactura="select * from clientes as a inner join Factura as b
												on (a.IdCliente=b.IdCliente)where b.IdFactura='$IdFactura'";

					$renglonCliente=ResultadoQuery($queryBuscarClientePorFactura);
				}

				if(!is_null($renglonCliente))
				{
					ObtenerDatos($renglonCliente);
				}
				else
				{
					$Mensaje="No Existen el cliente";
					header("location:EstadoDeCuenta.php?txtIdCliente=$IdCliente&txtIdFactura=$IdFactura&Mensaje=$Mensaje");
				}
				
			}


			if ($boton=="Buscar por Nombre") 
			{
				header("location:BuscarClientePorNombre.php?txtNombreCliente=$NombreCliente&txtPaginaOrigen=EstadoDeCuenta");

			}	

					function ObtenerDatos($renglonCliente)
				{
					
			
					
					$IdFactura=$renglonCliente["IdFactura"];

					$IdCliente=$renglonCliente["IdCliente"];

					$NombreCliente = $renglonCliente["NombreCliente"]; 
					
					//echo "____";
					$FechaFactura=$renglonCliente["FechaFactura"];
					//echo "____";
					$MontoTotalFactura=$renglonCliente["MontoTotalFactura"];
					//echo "____";
					$PagoNormal=$renglonCliente["PagoNormal"];
					//echo "____";
					$PagoPuntual=$renglonCliente["PagoPuntual"];

					$FechaPrimerPago=$renglonCliente["FechaPrimerPago"];

					$FechaPrimerPagoCompara=date_create($FechaPrimerPago);

					$fechaDefault=date_create("1900-01-01");
					
					if($FechaPrimerPagoCompara==$fechaDefault)
					{
						$FechaPrimerPago=$FechaFactura;
					}
					
					
					$NotasDeCargoIniciales=$renglonCliente["NotasDeCargo"] ;


					$SaldoInicialFactura=$renglonCliente["SaldoInicialFactura"];
					
					
					$Plazo=$renglonCliente["Plazo"];



					 header("location:EstadoDeCuenta.php?txtNombreCliente=$NombreCliente&txtIdCliente=$IdCliente&txtIdFactura=$IdFactura&txtFechaFactura=$FechaFactura&txtFechaPrimerPago=$FechaPrimerPago&txtMontoTotalFactura=$MontoTotalFactura&txtPagoNormal=$PagoNormal&txtPagoPuntual=$PagoPuntual&txtNotasDeCargoIniciales=$NotasDeCargoIniciales&txtSaldoInicialFactura=$SaldoInicialFactura&txtPlazo=$Plazo");

				}

?>