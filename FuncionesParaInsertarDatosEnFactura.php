<?php

	
	$link=mysqli_connect("localhost","root","","Bodegon");
	

	function insertaPagosEnFactura ($IdPago,$IdFactura,$MontoPago,$TipoDocumento,$TipoPago,$FechaPago)
	{
		global $link;

			if(!mysqli_query($link, "insert into pagos (IdPago,IdFactura,MontoPago,TipoDocumento,TipoPago,FechaPago) 
				values ('$IdPago','$IdFactura','$MontoPago','$TipoDocumento','$TipoPago','$FechaPago')"))

				{
					printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}
	}

?>