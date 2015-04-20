<?php
/** 
*
* @Accion para Alta Factura . "AltaFactura.php"
* @versión: 1.12     @modificado: 30 de Octubre del 2015
* @autor: Francis Alonso Gonzalez Zarate
*
*/

$link =mysqli_connect('localhost','root','','programabodegon');


function ResultadoQuery($query)
	{
		global $link;
		

		$resultado=$link->query($query);

		$renglon=$resultado->fetch_array();

		return $renglon;
	}


function ObtenerResultados($query)
	{
		global $link;
		

		$resultado=$link->query($query);

	

		return $resultado;
	}


function ObtenerRutas()	
{
	global $link;
		

		$resultado=$link->query("select IdRuta from Rutas");

	

		return $resultado;
}

	function VerificaSiExisteRegistro($query)
	{
		global $link;

		$resultado=$link->query($query);

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

?>