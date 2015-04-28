<?php


include "db.php";

function VerificaSiExisteFactura()
	{
		global $link;

		$resultado=$link->query("select * from factura where IdFactura='$IdFactura'");

		$renglon=$resultado->fetch_array();

		if(is_null($renglon))
		{
			$existe=false;
		}else
		{
			$existe=true;
		}
		
		return $existe;
	}


function InsertaFactura($IdFactura,$IdCliente,$NumeroDePretarjeta,$Financiamiento,$MontoTotalFactura,$FechaFactura,$Plazo,$Articulos,$PrimerDiaDePago,$DiaDePago,
								$PagoNormal,$PagoPuntual,$Observaciones,$Vendedor,$Comision)
	{
		global $link;

		if(!mysqli_query($link,"insert into factura (IdFactura,IdCliente,NumeroDePretarjeta,Financiamiento,MontoTotalFactura,FechaFactura,Plazo,Articulos,FechaPrimerPago,DiaDePago,
																PagoNormal,PagoPuntual,Observaciones,Vendedor,Comision) 
													values ('$IdFactura','$IdCliente','$NumeroDePretarjeta','$Financiamiento','$MontoTotalFactura','$FechaFactura','$Plazo','$Articulos',
														'$PrimerDiaDePago','$DiaDePago','$PagoNormal','$PagoPuntual','$Observaciones','$Vendedor','$Comision')"))
				{
					printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}
	
	}




?>