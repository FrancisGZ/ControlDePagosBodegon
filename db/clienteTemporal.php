<?php

include "db.php";


function InsertaClienteTemporal($NumeroDePretarjeta,$NombreCliente,$Colonia,$Calle,$Telefono,$CodigoPostal,
								$Municipio,$Ruta)
	{
		global $link;

		if(!mysqli_query($link,"insert into clientestemporal (NumeroDePretarjeta,NombreCliente,Colonia,Calle,Telefono,CodigoPostal,
								Municipio,Ruta) values
							('$NumeroDePretarjeta','$NombreCliente','$Colonia','$Calle','$Telefono','$CodigoPostal','$Municipio','$Ruta')"))
			{
			 printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
			}
	}

?>