<?php

		include("Funciones.php");

	
			if(isset($_GET["txtNumeroDePretarjeta"]))
			{
				$NumeroDePretarjeta=$_GET["txtNumeroDePretarjeta"];
			}
			else
			{
				$NumeroDePretarjeta="";
			}

			if(isset($_GET["txtNombreCliente"]))
			{
				$NombreCliente=$_GET["txtNombreCliente"];
			}
			else{

				$NombreCliente="";
			}

			if(isset($_GET["btnAccion"]))
			{
				$boton=$_GET["btnAccion"];
			}
			else
			{
				$boton="";
			}


			echo $boton; 
			echo $NumeroDePretarjeta;

				if($boton=="Buscar Pretarjeta")
				{

					$queryBuscaPretarjeta="select * from clientesTemporal as a inner join FacturaTemporal as b
												on (a.NumeroDePretarjeta=b.NumeroDePretarjeta)where a.NumeroDePretarjeta='$NumeroDePretarjeta'";

					$renglonCliente=ResultadoQuery($queryBuscaPretarjeta);
				}

				


				if(!is_null($renglonCliente))
				{
					ObtenerDatos($renglonCliente);
				}
				else
				{
					$Mensaje="No Existen el cliente";
					header("location:EstadoDeCuentaPretarjeta.php?txtIdCliente=$IdCliente&txtIdFactura=$IdFactura&Mensaje=$Mensaje");
				}
				
			


			if ($boton=="Buscar por Nombre") 
			{
				header("location:BuscarClientePretarjetaPorNombre.php?txtNombreCliente=$NombreCliente&txtPaginaOrigen=EstadoDeCuentaPretarjeta");

			}	

					function ObtenerDatos($renglonCliente)
				{
					
			
					
					

					$NumeroDePretarjeta=$renglonCliente["NumeroDePretarjeta"];

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
					
					
					
					
					$Plazo=$renglonCliente["Plazo"];



					 header("location:EstadoDeCuentaPretarjeta.php?txtNombreCliente=$NombreCliente&txtNumeroDePretarjeta=$NumeroDePretarjeta&txtFechaFactura=$FechaFactura&txtFechaPrimerPago=$FechaPrimerPago&txtMontoTotalFactura=$MontoTotalFactura&txtPagoNormal=$PagoNormal&txtPagoPuntual=$PagoPuntual&txtNotasDeCargoIniciales=$NotasDeCargoIniciales&txtSaldoInicialFactura=$SaldoInicialFactura&txtPlazo=$Plazo");

				}

?>