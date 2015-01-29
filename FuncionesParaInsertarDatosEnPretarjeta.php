<?php

	$link=mysqli_connect("localhost","root","","bodegon");

	function InsertaPagosPretarjeta($IdPago,$NumeroDePretarjeta,$MontoPago,$FechaPago,$TipoDocumento,$TipoPago)
	{
		global $link;
				

			if(!mysqli_query($link, "insert into pagospretarjeta (IdPago,NumeroDePretarjeta,MontoPago,FechaPago,TipoDocumento,TipoPago) 
				values ('$IdPago','$NumeroDePretarjeta','$MontoPago','$FechaPago','$TipoDocumento','$TipoPago')"))

				{
					printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}
	}


?>