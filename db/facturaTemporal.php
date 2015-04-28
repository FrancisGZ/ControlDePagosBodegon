<?php



	function InsertaFacturaTemporal($NumeroDePretarjeta,$Financiamiento,$MontoTotalFactura,$FechaFactura,$Plazo,$FechaPrimerPago,$PagoNormal,$PagoPuntual,$Vendedor,$Observaciones,$Comision,$Articulos)
	{
		global $link;

		if(!mysqli_query($link,"insert into facturatemporal (NumeroDePretarjeta,Financiamiento,MontoTotalFactura,FechaFactura,Plazo,FechaPrimerPago,PagoNormal,PagoPuntual,Vendedor,Observaciones,Comision,Articulos) 
													values ('$NumeroDePretarjeta','$Financiamiento','$MontoTotalFactura','$FechaFactura','$Plazo','$FechaPrimerPago','$PagoNormal','$PagoPuntual','$Vendedor','$Observaciones','$Comision','$Articulos')"))
				{
				printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}


	}





?>