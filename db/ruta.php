<?php



function obtenerRutas()	
{
		global $link;
		// $link =mysqli_connect('localhost','root','','programabodegon');

		$resultado=$link->query("select IdRuta from Rutas");

	

		return $resultado;
}

?>