<?php

include "bd.php";



	function InsertaAval ($IdCliente,$NombreAval,$ColoniaAval,$CalleAval,$CodigoPostalAval,$MunicipioAval,$TelefonoAval)
	{
		global $link;

		if(!mysqli_query($link,"insert into Avales (IdCliente,NombreAval,ColoniaAval,CalleAval,CodigoPostalAval,MunicipioAval,TelefonoAval) values
														('$IdCliente','$NombreAval','$ColoniaAval','$CalleAval','$CodigoPostalAval','$MunicipioAval','$TelefonoAval')"))
				{
					printf("Error - SQLSTATE %s.\n", mysqli_errno($link));
				}
	}


?>