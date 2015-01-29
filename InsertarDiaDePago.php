<?php


	$link=mysqli_connect('localhost','root','','bodegon');


	$queryDiaDePago="select IdFactura,FechaPrimerPago,FechaFactura from factura order by FechaPrimerPago";

	$resultadoDiaDePago=$link->query($queryDiaDePago);

	if(mysqli_affected_rows($link)>0)
	{
		while ($renglon=$resultadoDiaDePago->fetch_array())
		 {
			$DiaDePago=$renglon["FechaPrimerPago"];
			$FechaFactura=$renglon["FechaFactura"];
			$IdFactura=$renglon["IdFactura"];

			




			/*PArte de codigo para revisar si hay fecha primer pago capturada*/

					$FechaPrimerPagoCompara=date_create($DiaDePago);

					$fechaDefault=date_create("1900-01-01");
					
					if($FechaPrimerPagoCompara==$fechaDefault)
					{
						$DiaDePago=$FechaFactura;
					}

					echo $DiaDePago."-".$IdFactura;
 /*------------------------------------------------------------------------------*/


		 	$ano=date('Y', strtotime($DiaDePago));
			$mes=date('m', strtotime($DiaDePago));
 			$dia=date('d', strtotime($DiaDePago));	
 			$diaSemana = diaSemana($ano, $mes, $dia);

			if($diaSemana==1)
			{

	 			$DiaDePago="Lunes";
			}

			if($diaSemana==2)
			{

	 			$DiaDePago="Martes";
			}

			if($diaSemana==3)
			{

	 			$DiaDePago="Miercoles";
			}

			if($diaSemana==4)
			{

	 			$DiaDePago="Jueves";
			}

			if($diaSemana==5)
			{

	 			$DiaDePago="Viernes";
			}

			if($diaSemana==6)
			{

	 			$DiaDePago="Sabado";
			}	

			if($diaSemana==0)
			{

				 $DiaDePago="Domingo";
			}

			echo $DiaDePago."</br>";


			mysqli_query($link,"update factura set DiaDePago='$DiaDePago' where IdFactura='$IdFactura'");
		}

	}


function diaSemana($ano,$mes,$dia)
{
    // 0->domingo     | 6->sabado
   
      $dia= date("w",mktime(0, 0, 0, $mes, $dia, $ano));

        return $dia;
}
 





 ?>