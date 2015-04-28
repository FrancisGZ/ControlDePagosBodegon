<?php

include "db.php";

function VerificaSiExisteCliente()
	{
		global $link;

		$resultado=$link->query("Select * from clientes where IdCliente='$IdCliente");

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


	function InsertaCliente($IdCliente,$NombreCliente,$Colonia,$Calle,$Telefono,$CodigoPostal,
								$Municipio,$Ruta)
	{

			global $link;

			if(!mysqli_query($link,"insert into Clientes (IdCliente,NombreCliente,Colonia,Calle,Telefono,CodigoPostal,
								Municipio,Ruta) values
							('$IdCliente','$NombreCliente','$Colonia','$Calle','$Telefono','$CodigoPostal','$Municipio','$Ruta')"))
				{
					printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}

	}


?>